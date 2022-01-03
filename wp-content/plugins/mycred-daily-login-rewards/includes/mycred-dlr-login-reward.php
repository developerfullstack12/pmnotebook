<?php
if( !class_exists( 'myCRED_DLR_Login_Reward' ) ):
class myCRED_DLR_Login_Reward
{

    private static $_instance;

    private $user_id;

    private $calender_id;

    public static function get_instance()
    {
        if (self::$_instance == null)
            self::$_instance = new self();

        return self::$_instance;
    }

    public function __construct()
    {
        add_action( 'wp_login', array( $this, 'login_user' ), 10, 2 );

        add_action( 'wp_footer', array( $this, 'show_popup' ) );

        add_shortcode( 'mycred_rewards_calendar', array( $this, 'render_mycred_rewards_calendar' ) );
    }

    public function login_user( $user_name, $user )
    {
        $this->user_id = $user->ID;

        $calenders = mycred_dlr_get_calendars();

        foreach( $calenders as $key => $calender )
        {
            $current_date = date( 'd-m-Y' );

            $current_time = strtotime( $current_date );

            $this->calender_id = $calender->ID;

            $day = 0;

            $last_reward = $this->get_user_last_reward( $this->user_id, $this->calender_id );

            if( $last_reward )
                $day = $last_reward['day'] + 1;

            $day_id = $this->get_next_earning( $this->calender_id, $day )[0]->ID;

            $next_earning = mycred_get_post_meta( $day_id, 'mycred_dlr_day', true );
            
            $has_earned_today = $this->has_user_earned_by_date( $current_date, $this->user_id, $this->calender_id );
            
            $earned_reward_by_date = $this->get_reward_by_date( $current_date, $this->user_id, $this->calender_id );

            $yesterday_date = date( 'd-m-Y', strtotime( "-1 days" ) );
                
            $earned_yesterday = $this->has_user_earned_by_date( $yesterday_date, $this->user_id, $this->calender_id );

            $earned_calenders = $this->get_earned_calenders( $this->user_id ) ? $this->get_earned_calenders( $this->user_id ) : array();;

            //Progress should reset, if admin set to restart, And if user has last reward but missed yesterday
            if( 
                $this->is_setting_enable( $this->calender_id, 'penalty' ) 
                &&
                mycred_dlr_get_setting( $this->calender_id, 'rewards_penalty' ) == 'restart' 
                && 
                !$earned_yesterday 
                &&
                $last_reward
                &&
                !$has_earned_today
            )
            {
                $earned_days = mycred_dlr_get_user_earned_days( $this->user_id, $this->calender_id );

                $earned_days = array_reverse( $earned_days );

                //Unreward Earnings
                foreach( $earned_days as $date => $day )
                {
                    $unreward_day_id = $day['day_id'];

                    $unreward_reward_type = mycred_dlr_get_day_setting( $unreward_day_id, 'rewardType');

                    $unreward_label = mycred_dlr_get_day_setting( $unreward_day_id, 'label');

                    //If gained nothing, continue
                    if( $unreward_reward_type == 'none' )
                        continue;

                    //If gained points, Unreward Points
                    if( $unreward_reward_type == 'points' )
                    {
                        $unreward_pt = mycred_dlr_get_day_setting( $unreward_day_id, 'pointType');

                        $unreward_p_amount = mycred_dlr_get_day_setting( $unreward_day_id, 'pointAmount');

                        $users_current_balance = mycred_display_users_balance( $this->user_id, $unreward_pt );

                        if( $users_current_balance < $unreward_p_amount && !( $users_current_balance <= 0 ) )
                            $unreward_p_amount = $users_current_balance;
                        if( $users_current_balance <= 0 )
                            continue;

                        mycred_add(
                            'daily_login_reward_missed_day',
                            $this->user_id,
                            -1 * $unreward_p_amount,
                            "{$unreward_label} (Missed day)",
                            $unreward_day_id,
                            '',
                            $unreward_pt
                        );

                        continue;
                    }

                    //If earned badge, Unreward Badge
                    if( $unreward_reward_type == 'badge' )
                    {
                        $unreward_badge_id = mycred_dlr_get_day_setting( $unreward_day_id, 'badgeID');
                        
                        $badge = mycred_get_badge( $unreward_badge_id );

                        $badge->divest( $this->user_id );
                        
                        continue;
                    }

                    //If earned rank, Unaward rank
                    if( $unreward_reward_type == 'rank' )
                    {
                        $current_rank_id = mycred_dlr_get_day_setting( $unreward_day_id, 'rankID');

                        $rank_pt = mycred_dlr_get_rank_pt( $current_rank_id );

                        $ranks = mycred_get_ranks( 'publish', '-1', 'DESC', $rank_pt );

                        $unreward_rank_id = '';

                        foreach( $ranks as $key => $value )
                        {
                            if( $current_rank_id == $value->post_id )
                                break;
                                
                            $unreward_rank_id = $value->post_id;                            
                        }

                        mycred_save_users_rank( $this->user_id, $unreward_rank_id, $rank_pt );
                        
                        continue;
                    }
                        
                }

                mycred_delete_user_meta( $this->user_id, "mycred_dlr_calender_{$this->calender_id}" );

                continue;
            }
            
            //Check start && end date, If event not started yet or ended
            if( 
                $this->is_setting_enable( $this->calender_id, 'limited_time' ) 
                &&
                ( strtotime( mycred_dlr_get_setting( $this->calender_id, 'start_date' ) )  > $current_time 
                || 
                strtotime( mycred_dlr_get_setting( $this->calender_id, 'end_date' ) ) < $current_time ) 
            )
            continue;

            //If not repeatable
            if( !$this->is_setting_enable( $this->calender_id, 'repeatable' ) )
            {
                if( array_key_exists( $this->calender_id, $earned_calenders ) )
                    continue;
            }

            //If repeatable but limited
            if( $this->is_setting_enable( $this->calender_id, 'repeatable' ) )
            {
                $limit = (int)mycred_dlr_get_setting( $this->calender_id, 'repeatable_limit' );
                
                if( $limit != 0 && array_key_exists( $this->calender_id, $earned_calenders ) && $earned_calenders[$this->calender_id] >= $limit )
                    continue;
            }

            //Other calenders should be completed, In order to earn current calender
            if( $this->is_setting_enable( $this->calender_id, 'complete_calender' ) )
            {
                $req_calenders = mycred_dlr_get_setting( $this->calender_id, 'complete_calenders' );

                if( !empty( $req_calenders ) )
                {
                    foreach( $req_calenders as $req_calender )
                    {
                        if( !in_array( $req_calender, $earned_calenders ) )
                            break;
                    }
                    continue;
                }
            }

            //If user has earned this day.
            if( $has_earned_today )
                continue;

            //If user successfully earned the calender
            if ( !$next_earning )
            {
                $this->update_user_calenders( $this->user_id, $this->calender_id );

                mycred_delete_user_meta( $this->user_id, "mycred_dlr_calender_{$this->calender_id}" );

                continue;
            }

            //If reward type is set to none, Continue
            if( $next_earning->rewardType == 'none' )
            {
                $this->update_user_calender_days( $this->user_id, $this->calender_id, $day_id, $day );
                mycred_dlr_set_transient( $this->user_id, $this->calender_id, $day_id );
                continue;
            }

            //Add points
            if( $next_earning->rewardType == 'points' )
            {
                mycred_add(
                    'daily_login_reward',
                    $this->user_id,
                    $next_earning->pointAmount,
                    $next_earning->label,
                    $day_id,
                    '',
                    $next_earning->pointType
                );
                $this->update_user_calender_days( $this->user_id, $this->calender_id, $day_id, $day );
                mycred_dlr_set_transient( $this->user_id, $this->calender_id, $day_id );
                continue;
            }

            //Assign Badge
            if( $next_earning->rewardType == 'badge' )
            {
                mycred_assign_badge_to_user( $this->user_id, $next_earning->badgeID );
                $this->update_user_calender_days( $this->user_id, $this->calender_id, $day_id, $day );
                mycred_dlr_set_transient( $this->user_id, $this->calender_id, $day_id );
                continue;
            }

            //Assign Rank
            if( $next_earning->rewardType == 'rank' )
            {
                if( class_exists( 'myCRED_Ranks_Module' ) && mycred_manual_ranks() )
                {
                    $rank_pt = mycred_dlr_get_rank_pt( $next_earning->rankID );
                    mycred_save_users_rank( $this->user_id, $next_earning->rankID, $rank_pt );
                    $this->update_user_calender_days( $this->user_id, $this->calender_id, $day_id, $day );
                    mycred_dlr_set_transient( $this->user_id, $this->calender_id, $day_id );
                }
                continue;
            }

            //If already earned
            if( empty( $next_earning ) )
                continue;

        }
    }

    public function show_popup()
    {
        $user_id = get_current_user_id();

        $transients = get_transient( "mycred_dlr_{$user_id}" );

        if( !$transients )
            return;

        foreach( $transients as $calender_id => $value )
        {
            $calender_days = mycred_dlr_get_days_by_calendar( $calender_id );
    
            $columns = mycred_dlr_get_setting( $calender_id, 'rewards_columns' );
    
            $earned_day = $transients[$calender_id];
    
            $earned_days = mycred_dlr_get_user_earned_days( $user_id, $calender_id );
    
            $earned_day_ids = array();
    
            foreach( $earned_days as $day )
                $earned_day_ids[] = $day['day_id'];
    
            $img_size = mycred_dlr_get_setting( $calender_id, 'image_size') ? mycred_dlr_get_setting( $calender_id, 'image_size') : 100;
            
            $completed_img = mycred_dlr_get_setting( $calender_id, 'completed_image');
            
            $counter = 1;
    
            ?>
            <div class="mycred-dlr-popup" id="mycred-dlr-popup-<?php echo $calender_id; ?>">

            <div><?php echo '<h2>' . get_the_title( $calender_id ) . '</h2>' ?></div>
                <!-- row <div> -->
                <div class="row">
                    <?php
                    foreach( $calender_days as $key => $day )
                    {
                        echo "<div><h2> ". __( $day->post_title, 'mycred-dlrewards' ) . "</h2></div>";
                        $label = mycred_dlr_get_day_setting( $day->ID, 'label' ) ? mycred_dlr_get_day_setting( $day->ID, 'label' ) : '';;
    
                        $thumbnail = mycred_dlr_get_day_thumbnail( $day->ID );
    
                        echo "<div class='item'>";
                        
                            echo "<h5>" . __( "Day {$day->menu_order}", 'mycred-dlrewards' ) . "</h5>";
    
                            //Day Image
                            echo "<div style='background-image: url({$thumbnail}); width: {$img_size}px; height: {$img_size}px;background-repeat: no-repeat;background-size: cover;margin: 0 auto;'>";
                            if( in_array( $day->ID, $earned_day_ids ) )
                            {
                                if( $completed_img )
                                {
                                    $complete_url = wp_get_attachment_url( $completed_img );
                                    if( $complete_url )
                                        echo "<img src='{$complete_url}' width='{$img_size}px' />";
                                }
                            }
                            echo "</div>";
    
                            echo '<p>' . sprintf( __( '%s', 'mycred-dlrewards' ), $label ) . '</p>';
    
                        echo'</div>';
    
                        //row </div>
                        if( $counter == $columns )
                        {
                            echo '<div></div>';
                            echo '</div><div class="row">';
                            $counter = 0;
                        }
                        
                        $counter++;
                    }
                    ?>
                </div>
                <span class="dashicons dashicons-no-alt" id="mycred-dlr-close-popup"></span>
            </div>
    
            <?php
        }

        delete_transient( "mycred_dlr_{$user_id}" );
    }

    public function is_setting_enable( $post_id, $key )
    {
        return mycred_dlr_get_setting( $post_id, $key ) == '' ? false : true;
    }

    public function get_next_earning( $calender_id = '', $current_day )
    {
        $calender_id = empty( $calender_id ) ? $this->calender_id : $calender_id;

        $args = array(
            'numberposts'   =>  -1,
            'post_type'     =>  'mycred-dlr-reward',
            'post_parent'   =>  $this->calender_id,
            'menu_order'    =>  $current_day + 1
        );

        $posts = get_posts( $args );

        return $posts;
    }

    public function get_user_last_reward( $user_id, $calender_id = '' )
    {
        $calender_id = empty( $calender_id ) ? $this->calender_id : $calender_id;

        $calender = mycred_get_user_meta( $user_id, "mycred_dlr_calender_{$this->calender_id}", '', true );

        if( $calender )
        {
            $last_key = array_key_last( $calender );

            return $calender[$last_key];
        }

        return false;
    }
    
    public function update_user_calender_days( $user_id, $calender_id = '', $day_id, $day, $args = '' )
    {
        $calender_id = empty( $calender_id ) ? $this->calender_id : $calender_id;

        $date = date( "d-m-Y" );

        $time = time();

        $calender = mycred_get_user_meta( $user_id, "mycred_dlr_calender_{$calender_id}", '', true );

        if( $calender )
        {
            $calender[$date]['day_id'] = $day_id;
            $calender[$date]['day'] = $day;
            $calender[$date]['award_time'] = $time;
        }
        else
        {
            $calender = array();

            $calender[$date] = array( 
                'day_id'        =>  $day_id,
                'day'           =>  $day,
                'award_time'    =>  $time
            );
        }

        mycred_update_user_meta( $user_id, "mycred_dlr_calender_{$calender_id}", '', $calender );
    }

    public function update_user_calenders( $user_id = '', $calender_id = '' )
    {
        $calender_id = empty( $calender_id ) ? $this->calender_id : $calender_id;

        $user_id = empty( $user_id ) ? $this->user_id : $user_id;

        $calenders = mycred_get_user_meta( $user_id, "mycred_dlr_earned_calenders", '', true );

        if( $calenders )
        {
            $counts = '';
            if( array_key_exists( $calender_id, $calenders ) )
                $counts = $calenders[$calender_id] + 1;

            $calenders[$calender_id] = $counts;
        }
        else
        {
            $calenders = array();

            $calenders[$calender_id] = 1;
        }

        mycred_update_user_meta( $user_id, "mycred_dlr_earned_calenders", '', $calenders );
    }

    public function get_earned_calenders( $user_id = '' )
    {
        $user_id = empty( $user_id ) ? $this->user_id : $user_id;

        $calenders = mycred_get_user_meta( $user_id, 'mycred_dlr_earned_calenders', '', true );

        if( $calenders )
            return $calenders;

        return false;
    }

    public function has_user_earned_by_date( $date, $user_id = '', $calender_id = '' )
    {
        $calender_id = empty( $calender_id ) ? $this->calender_id : $calender_id;

        $user_id = empty( $user_id ) ? $this->user_id : $user_id;

        $days = mycred_get_user_meta( $user_id, "mycred_dlr_calender_{$calender_id}", '', true );

        if( !$days || empty( $days ) )
            return false;

        if( is_array( $days ) && array_key_exists( $date, $days ) )
            return true;
        else
            return false;
    }

    public function get_reward_by_date( $date, $user_id = '', $calender_id = '' )
    {
        $calender_id = empty( $calender_id ) ? $this->calender_id : $calender_id;

        $user_id = empty( $user_id ) ? $this->user_id : $user_id;

        $days = mycred_get_user_meta( $user_id, "mycred_dlr_calender_{$calender_id}", '', true );

        if( is_array( $days ) && array_key_exists( $date, $days ) )
        {
            return $days[$date];
        }
        else
            return false;
    }

    public function render_mycred_rewards_calendar( $atts )
    {
        extract( $atts );

        $user_id = get_current_user_id();

        $calender_id = $id;

        $calender_days = mycred_dlr_get_days_by_calendar( $calender_id );

        $columns = mycred_dlr_get_setting( $calender_id, 'rewards_columns' );

        $earned_days = mycred_dlr_get_user_earned_days( $user_id, $calender_id );

        $earned_day_ids = array();

        if( $earned_days )
            foreach( $earned_days as $day )
                $earned_day_ids[] = $day['day_id'];

        $img_size = mycred_dlr_get_setting( $calender_id, 'image_size') ? mycred_dlr_get_setting( $calender_id, 'image_size') : 100;
        
        $completed_img = mycred_dlr_get_setting( $calender_id, 'completed_image');
        
        $counter = 1;

        $output = '';

        $output = "
        <div class='mycred-dlr-shortcode' id='mycred-dlr-shortcode-$calender_id'>
            <div>".get_the_title( $calender_id )."</div>
            <!-- row <div> -->
            <div class='row'>
        ";

        foreach( $calender_days as $key => $day )
        {
            $output .= "<div><h2> ". __( $day->post_title, 'mycred-dlrewards' ) . "</h2></div>";
            $label = mycred_dlr_get_day_setting( $day->ID, 'label' ) ? mycred_dlr_get_day_setting( $day->ID, 'label' ) : '';;

            $thumbnail = mycred_dlr_get_day_thumbnail( $day->ID );

            $output .= "<div class='item'>";
            
            $output .= "<h5>" . __( "Day {$day->menu_order}", 'mycred-dlrewards' ) . "</h5>";

                //Day Image
                $output .= "<div style='background-image: url({$thumbnail}); width: {$img_size}px; height: {$img_size}px;background-repeat: no-repeat;background-size: cover;margin: 0 auto;'>";
                if( !empty( $earned_day_ids ) && in_array( $day->ID, $earned_day_ids ) )
                {
                    if( $completed_img )
                    {
                        $complete_url = wp_get_attachment_url( $completed_img );
                        if( $complete_url )
                            $output .= "<img src='{$complete_url}' width='{$img_size}px' />";
                    }
                }
                 $output .= "</div>";

                 $output .= '<p>' . sprintf( __( '%s', 'mycred-dlrewards' ), $label ) . '</p>';

             $output .='</div>';

            //row </div>
            if( $counter == $columns )
            {
                 $output .= '<div></div>';
                 $output .= '</div><div class="row">';
                $counter = 0;
            }
            
            $counter++;
        }
        $output .='
            </div>
        </div>';

        return $output;
    }
}
endif;

myCRED_DLR_Login_Reward::get_instance();