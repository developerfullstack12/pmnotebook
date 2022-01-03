<?php
if( !class_exists( 'myCRED_DRL_Admin' ) ):
class myCRED_DRL_Admin
{
    private static $_instance;

    public $point_types = array();

    public $badges = array();

    public $ranks = array();

    public $is_manual_rank;

    public static function get_instance()
    {
        if (self::$_instance == null)
            self::$_instance = new self();

        return self::$_instance;
    }

    public function __construct()
    {
        add_action( 'wp_loaded', array( $this, 'load_attributes' ) );
        add_action('init', array($this, 'register_daily_login_reward'));
        add_action('add_meta_boxes', array($this, 'add_calender_meta_box'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('save_post_mycred-login-reward', array($this, 'save_post'));

        //AJAX
        add_action('wp_ajax_mycred-create-calendar-day', array($this, 'mycred_create_calendar_day'));
        add_action('wp_ajax_mycred-delete-calendar-day', array($this, 'mycred_delete_calendar_day'));
        add_action('wp_ajax_mycred-dlr-save-all-rewards', array($this, 'mycred_save_all_rewards'));
    }

    public function load_attributes()
    {
        $this->point_types = mycred_get_types();

        if( $this->is_badge_active() )
        {
            $badge_ids = mycred_get_badge_ids();

            foreach( $badge_ids as $id )
                $this->badges[$id] = get_the_title( $id );

        }

        $this->get_ranks();
    }

    public function is_badge_active()
    {
        if( class_exists( 'myCRED_Badge' ) )
            return true;

        return false;
    }

    public function is_rank_active()
    {
        if( class_exists( 'myCRED_Ranks_Module' ) )
            return true;

        return false;
    }

    public function get_ranks()
    {
        if( $this->is_rank_active() )
        {
            foreach( $this->point_types as $key => $value )
            {
                $ranks = mycred_get_ranks( 'publish', '-1', 'ASC', $key );

                foreach( $ranks as $key => $value )
                {
                    $this->ranks[$value->post->ID] = $value->post->post_title;
                }
            }

            return $this->ranks;
        }

        return false;
    
    }

    public function admin_enqueue_scripts()
    {
        $object = array();

        $object['pointTypes'] = $this->point_types;

        $object['badges'] = $this->badges;

        $object['ranks'] = $this->ranks;

        $object['isManualRank'] = $this->is_manual_rank() ? 'true' : 'false';

        wp_localize_script( MYCRED_DLR_PREFIX . '-scripts', 'myCredDLRData', $object );
    }

    public function register_daily_login_reward()
    {
        global $mycred;

        if (mycred_override_settings() && !mycred_is_main_site()) return;

        $capability = $mycred->get_point_editor_capability();

        //Registering Post type for reward calendar
        register_post_type('mycred-login-reward', array(
            'labels'             => array(
                'name'               => __('myCred Rewards Calender', 'mycred-dlrewards'),
                'singular_name'      => __('myCred Rewards Calender', 'mycred-dlrewards'),
                'add_new'            => __('Add New', 'mycred-dlrewards'),
                'add_new_item'       => __('Add New Rewards Calender', 'mycred-dlrewards'),
                'edit_item'          => __('Edit Rewards Calender', 'mycred-dlrewards'),
                'new_item'           => __('New Rewards Calender', 'mycred-dlrewards'),
                'all_items'          => __('Rewards Calenders'),
                'view_item'          => __('View Rewards Calender', 'mycred-dlrewards'),
                'search_items'       => __('Search Rewards Calender', 'mycred-dlrewards'),
                'not_found'          => __('No Rewards Calender found', 'mycred-dlrewards'),
                'not_found_in_trash' => __('No Rewards Calender found in Trash', 'mycred-dlrewards'),
                'parent_item_colon'  => '',
                'menu_name'          => __('myCred Rewards Calender', 'mycred-dlrewards'),
            ),
            //'public'             => true,
            //'publicly_queryable' => true,
            'show_ui'            => current_user_can($capability),
            'show_in_menu'       => 'mycred-main',
            'show_in_rest'       => true,
            'query_var'          => true,
            //'rewrite'            => ,
            'capability_type'    => 'page',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            //'supports'           => 
        ));

        //registering post type for login reward calendar day
        $resp =  register_post_type('mycred-dlr-reward', array(
            'labels'             => array(
                'name'               => __('myCred Calender Reward', 'mycred-dlrewards'),
                'singular_name'      => __('myCred Calender Reward', 'mycred-dlrewards'),
                'add_new'            => __('Add New', 'gamipress-daily-login-rewards'),
                'add_new_item'       => __('Add New Calendar Reward', 'mycred-dlrewards'),
                'edit_item'          => __('Edit myCred Calender Reward', 'mycred-dlrewards'),
                'new_item'           => __('New myCred Calender Reward', 'mycred-dlrewards'),
                'all_items'          => __('myCred Calender Rewards', 'mycred-dlrewards'),
                'view_item'          => __('View myCred Calender Reward', 'mycred-dlrewards'),
                'search_items'       => __('myCred Calender Reward Search Not Found', 'mycred-dlrewards'),
                'not_found'          => __('myCred Calender Reward Not Found', 'mycred-dlrewards'),
                'not_found_in_trash' => __('myCred Calender Reward Not Found in trash', 'mycred-dlrewards'),
                'parent_item_colon'  => '',
                'menu_name'          => __('myCred Calender Reward', 'mycred-dlrewards'),
            ),
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => current_user_can($capability),
            'show_in_menu'       => false,
            'query_var'          => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'thumbnail'),

        ));
    }

    public function add_calender_meta_box()
    {
        if (mycred_override_settings() && !mycred_is_main_site()) return;

        add_meta_box(
            'mycred-login-reward',
            __('Reward Calender', 'mycred-dlrewards'),
            array($this, 'reward_calender_meta'),
            'mycred-login-reward',
            'advanced',
            'default'
        );

        add_meta_box(
            'mycred-login-reward-shortcode',
            __('Shortcode', 'mycred-dlrewards'),
            array($this, 'reward_calender_shortcode'),
            'mycred-login-reward',
            'side',
            'default'
        );
    }

    public function reward_calender_meta()
    {
        $post_id = get_the_ID();

        //Getting all calendars
        $other_calenders = mycred_dlr_get_calendars();

        //If not empty/ false
        if( $other_calenders )
        {
            //removing current calendar from the array
            foreach ($other_calenders as $key => $value) {
                if ($value->ID == get_the_ID())
                    unset($other_calenders[$key]);
            }
        }

    
        $rewards_penalty = array(
            'continue'  => 'Continue',
            'restart'   => 'Restart'
        );

        $rewards_columns = array(
            '1' => '1 Column',
            '2' => '2 Columns',
            '3' => '3 Columns',
            '4' => '4 Columns',
            '5' => '5 Columns',
            '6' => '6 Columns',
            '7' => '7 Columns',
        );
        ?>
        <table width="100%" class="mycred-reward-calender-table">
            <tr>
                <td class="mycred-rc-left">
                    <label><b>Consecutively</b></label>
                </td>
                <td class="mycred-rc-right">
                    <label class="switch">
                        <input type="checkbox" <?php echo mycred_dlr_get_setting($post_id, 'penalty') ? 'checked' : ''; ?> name="penalty" id="mycred-rc-penalty">
                        <span class="slider round"></span>
                    </label>
                    <p>
                        User needs to log in consecutively to earn rewards.
                    </p>
                </td>
            </tr>
            <tr class="mycred-rc-penalty-tab <?php echo mycred_dlr_get_setting($post_id, 'penalty') ? 'mycred-show' : ''; ?>">
                <td class="mycred-rc-left">
                    <label><b>Penalty</b></label>
                </td>
                <td class="mycred-rc-right">
                    <select name="rewards_penalty">
                        <?php
                        foreach ($rewards_penalty as $key => $value) {
                            if (mycred_dlr_get_setting($post_id, 'rewards_penalty') == $key)
                                echo "<option value='$key' selected='selected'>$value</option>";
                            else
                                echo "<option value='$key'>$value</option>";
                        }
                        ?>
                    </select>
                    <p>
                        Continue: If user miss any day, Reward will be continue from next reward.
                        <br>
                        Restart: If user miss any day, Reward will start again.
                    </p>
                </td>
            </tr>
            <tr>
                <td class="mycred-rc-left">
                    <label><b>Limited time</b></label>
                </td>
                <td class="mycred-rc-right">
                    <label class="switch">
                        <input type="checkbox" name="limited_time" <?php echo mycred_dlr_get_setting($post_id, 'limited_time') ? 'checked' : ''; ?> id="mycred-limited-time">
                        <span class="slider round"></span>
                    </label>
                    <p>
                        Make this calender available for limited time.
                    </p>
                </td>
            </tr>
            <tr class="mycred-rc-limited-tab <?php echo mycred_dlr_get_setting($post_id, 'limited_time') ? 'mycred-show' : ''; ?>">
                <td class="mycred-rc-left">
                    <label><b>Start date</b></label>
                </td>
                <td class="mycred-rc-right">
                    <input type="date" value="<?php echo !mycred_dlr_get_setting($post_id, 'start_date') ? '' : mycred_dlr_get_setting($post_id, 'start_date'); ?>" name="start_date">
                    <p>
                        Start date
                    </p>
                </td>
            </tr>
            <tr class="mycred-rc-limited-tab <?php echo mycred_dlr_get_setting($post_id, 'limited_time') ? 'mycred-show' : ''; ?>">
                <td class="mycred-rc-left">
                    <label><b>End date</b></label>
                </td>
                <td class="mycred-rc-right">
                    <input type="date" value="<?php echo !mycred_dlr_get_setting($post_id, 'end_date') ? '' : mycred_dlr_get_setting($post_id, 'end_date'); ?>" name="end_date">
                    <p>
                        End date
                    </p>
                </td>
            </tr>

            <tr>
                <td class="mycred-rc-left">
                    <label><b>Repeatable</b></label>
                </td>
                <td class="mycred-rc-right">
                    <label class="switch">
                        <input type="checkbox" name="repeatable" <?php echo mycred_dlr_get_setting($post_id, 'repeatable') ? 'checked' : ''; ?> id="mycred-repeatable">
                        <span class="slider round"></span>
                    </label>
                    <p>
                        Make this calendar repeatable to let users earn the rewards limited or unlimited times.
                    </p>
                </td>
            </tr>
            <tr class="mycred-rc-repeatable-tab <?php echo mycred_dlr_get_setting($post_id, 'repeatable') ? 'mycred-show' : ''; ?>">
                <td class="mycred-rc-left">
                    <label><b>Maximum times</b></label>
                </td>
                <td class="mycred-rc-right">
                    <input type="number" value="<?php echo !mycred_dlr_get_setting($post_id, 'repeatable_limit') ? '' : mycred_dlr_get_setting($post_id, 'repeatable_limit'); ?>" name="repeatable_limit">
                    <p>
                        Number of times a user can repeat this calendar (set it to 0 for no maximum).
                    </p>
                </td>
            </tr>

            <tr>
                <td class="mycred-rc-left">
                    <label><b>Complete other calenders</b></label>
                </td>
                <td class="mycred-rc-right">
                    <label class="switch">
                        <input type="checkbox" name="complete_calender" <?php echo mycred_dlr_get_setting($post_id, 'complete_calender') ? 'checked' : ''; ?> id="mycred-complete-calender">
                        <span class="slider round"></span>
                    </label>
                    <p>
                        User needs to complete other calendars to being awarded.
                    </p>
                </td>
            </tr>
            <tr class="mycred-rc-calender-tab <?php echo mycred_dlr_get_setting($post_id, 'complete_calender') ? 'mycred-show' : ''; ?>">
                <td class="mycred-rc-left">
                    <label><b>Calenders</b></label>
                </td>
                <td class="mycred-rc-right">
                    <select name="complete_calenders[]" multiple>
                        <?php

                        $saved_calendars = mycred_dlr_get_setting($post_id, 'complete_calenders');

                        if( !empty( $other_calenders ) )
                        {
                            foreach ($other_calenders as $other_calender) {
                                if ($saved_calendars) {
                                    if (in_array($other_calender->ID, $saved_calendars)) {
                                        echo "<option value='$other_calender->ID' selected='selected'>$other_calender->post_title</option>";
                                        continue;
                                    }
                                }
                                echo "<option value='$other_calender->ID'>$other_calender->post_title</option>";
                            }
                        }
                        ?>
                    </select>
                    <p>
                        Choose the calendar(s) that user needs to complete.
                    </p>
                </td>
            </tr>

            <!-- Rewards Calender Display Options -->
            <tr>
                <td class="mycred-rc-left">
                    <label><b>Show pop-up on reward</b></label>
                </td>
                <td class="mycred-rc-right">
                    <label class="switch">
                        <input type="checkbox" <?php echo mycred_dlr_get_setting($post_id, 'show_popup') ? 'checked' : ''; ?> name="show_popup">
                        <span class="slider round"></span>
                    </label>
                    <p>
                        When user gets rewarded, show a pop-up to notify it.
                    </p>
                </td>
            </tr>

            <tr class="">
                <td class="mycred-rc-left">
                    <label><b>Image Size</b></label>
                </td>
                <td class="mycred-rc-right">
                    <input type="number" value="<?php echo !mycred_dlr_get_setting($post_id, 'image_size') ? '' : mycred_dlr_get_setting($post_id, 'image_size'); ?>" name="image_size">
                    <p>
                        Size of the rewards images.
                    </p>
                </td>
            </tr>
            <tr class="">
                <td class="mycred-rc-left">
                    <label><b>Columns</b></label>
                </td>
                <td class="mycred-rc-right">
                    <select name="rewards_columns">
                        <?php
                        foreach ($rewards_columns as $key => $value) {
                            if (mycred_dlr_get_setting($post_id, 'rewards_columns') == $key)
                                echo "<option value='$key' selected='selected'>$value</option>";
                            else
                                echo "<option value='$key'>$value</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr class="">
                <td class="mycred-rc-left">
                    <label><b>Completed Image</b></label>
                </td>
                <td class="mycred-rc-right">
                    <div class="completed-image">
                        <div class='mycred-complete-thumbnail <?php echo mycred_dlr_get_setting($post_id, 'completed_image') ? 'has-thumbnail' : ''; ?>'>
                                <input type='hidden' name='completed_image' value='<?php echo mycred_dlr_get_setting($post_id, 'completed_image') ? mycred_dlr_get_setting($post_id, 'completed_image') : ''; ?>'>
                                <span class='dashicons dashicons-camera'></span>
                                <span class='dashicons dashicons-no-alt mycred-remove-reward-thumbnail' style='<?php echo mycred_dlr_get_setting($post_id, 'completed_image') ? '' : 'display: none;'; ?>'></span>
                                <?php
                                if( mycred_dlr_get_setting($post_id, 'completed_image') )
                                {
                                    $img_url = wp_get_attachment_url( mycred_dlr_get_setting($post_id, 'completed_image') );
                                    echo "<img src='{$img_url}' class='thumbnail-img'>";
                                }
                            ?>
                        </div>
                    </div>
                </td>
            </tr>

        </table>
        <ul class="mycred-daily-login-rewards-rewards-list">
            <?php

            global $mycred;

            $days = mycred_dlr_get_days_by_calendar(get_the_ID());

            if ($days) {
                foreach ($days as $key => $day) {
                ?>
                <li class='reward-row reward-<?php echo $day->ID ?>'>
                    <input type='hidden' name='reward_id' class='reward-id' value='<?php echo $day->ID ?>'>
                    <input type='hidden' name='current_post_id' class='current-post-id' value='<?php echo $day->post_parent ?>'>
                    <input type='hidden' name='order' class='menu-order' value='<?php echo $day->menu_order ?>'>
                    <div class='reward-header'>
                        <h3>Day <?php echo $day->menu_order ?></h3>
                        <div class='delete-reward'>
                            <span class='dashicons dashicons-no-alt'></span>
                        </div>
                    </div>
                    <div class='mycred-reward-thumbnail <?php echo $this->get_day_thumbnail( $day->ID ) ? 'has-thumbnail' : ''; ?>'>
                        <input type='hidden' name='reward_thumbnail' value='<?php echo $this->get_day_setting( $day->ID, 'thumbnail' ) ? $this->get_day_setting( $day->ID, 'thumbnail' ) : ''; ?>'>
                        <span class='dashicons dashicons-camera'></span>
                        <span class='dashicons dashicons-no-alt mycred-remove-reward-thumbnail' style='<?php echo $this->get_day_thumbnail( $day->ID ) ? '' : 'display: none;'; ?>'></span>
                        <?php
                        if( $this->get_day_thumbnail( $day->ID ) )
                            echo "<img src='{$this->get_day_thumbnail( $day->ID )}' class='thumbnail-img'>";
                        ?>
                    </div>
                    <span class='mycred-reward-thumbnail-desc reward-field-desc'>Click the image to edit or update.</span>
                    <input type='text' placeholder='Label' class='reward-label' name='mycred_reward_label[]' value='<?php echo $this->get_day_setting( $day->ID, 'label' ) ? $this->get_day_setting( $day->ID, 'label' ) : ''; ?>'>
                    <div class='reward-types-list'>
                        <div class='reward-type-row'>
                            <label for='reward-type-none-<?php echo $day->ID ?>'>
                                <input type='radio' id='reward-type-none-<?php echo $day->ID ?>' name='mycred-dlr-type-<?php echo $day->ID ?>' class='reward-type' value='none' <?php echo $this->get_day_setting( $day->ID, 'rewardType' )  == 'none' ? 'checked' : ''; ?>>
                                <span class='dashicons dashicons-marker'></span>
                                <span>Nothing</span>
                            </label>
                            <div class='reward-type-form reward-type-none-form'>
                                <span class='reward-nothing-desc'>That's okay, a day that user needs to log in but without get rewarded.</span>
                            </div>
                        </div>
                        <div class='reward-type-row'>
                            <label for='reward-type-points-<?php echo $day->ID ?>'>
                                <input type='radio' id='reward-type-points-<?php echo $day->ID ?>' name='mycred-dlr-type-<?php echo $day->ID ?>' class='reward-type' value='points' <?php echo $this->get_day_setting( $day->ID, 'rewardType' )  == 'points' ? 'checked' : ''; ?>>
                                <span class='dashicons dashicons-star-filled'></span>
                                <span>Points</span>
                            </label>
                            <div class='reward-type-form reward-type-points-form' style='<?php echo $this->get_day_setting( $day->ID, 'rewardType' )  == 'points' ? '' : 'display:none'; ?>'>
                                <input type='number' class='reward-points-amount' name='mycred-dlr-type-<?php echo $day->ID ?>' min='1' placeholder='0' value='<?php echo $this->get_day_setting( $day->ID, 'pointAmount' ) ? $this->get_day_setting( $day->ID, 'pointAmount' ) : '11'; ?>'>
                                <select class='reward-points-type'>
                                    <?php
                                    foreach( $this->point_types as $key => $pt )
                                    {
                                        if( $this->get_day_setting( $day->ID, 'pointType' )  == $key )
                                        {
                                            echo "<option value='{$key}' selected>{$pt}</option>";
                                            continue;
                                        }

                                        echo "<option value='{$key}'>{$pt}</option>";

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='reward-type-row'>
                            <label for='reward-type-badge-<?php echo $day->ID ?>'>
                                <input type='radio' id='reward-type-badge-<?php echo $day->ID ?>' name='mycred-dlr-type-<?php echo $day->ID ?>' class='reward-type' value='badge' <?php echo $this->get_day_setting( $day->ID, 'rewardType' )  == 'badge' ? 'checked' : ''; ?>>
                                <span class='dashicons dashicons-awards'></span>
                                <span>Badge</span>
                            </label>
                            <div class='reward-type-form reward-type-badge-form' style='<?php echo $this->get_day_setting( $day->ID, 'rewardType' )  == 'badge' ? '' : 'display:none'; ?>'>
                                <select class='reward-badge'>
                                    <?php
                                    foreach( $this->badges as $id => $badge )
                                    {

                                        if( $this->get_day_setting( $day->ID, 'badgeID' ) == $id )
                                        {
                                            echo "<option value='{$id}' selected>{$badge}</option>";
                                            continue;
                                        }

                                        echo "<option value='{$id}'>{$badge}</option>";
                                        
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                        if( $this->is_manual_rank() )
                        {
                            ?>
                            <div class='reward-type-row'>
                                <label for='reward-type-rank-<?php echo $day->ID ?>'>
                                    <input type='radio' id='reward-type-rank-<?php echo $day->ID ?>' name='mycred-dlr-type-<?php echo $day->ID ?>' class='reward-type' value='rank' <?php echo $this->get_day_setting( $day->ID, 'rewardType' )  == 'rank' ? 'checked' : ''; ?>>
                                    <span class='dashicons dashicons-rank'></span>
                                    <span>Rank</span>
                                </label>
                                <div class='reward-type-form reward-type-rank-form' style='<?php echo $this->get_day_setting( $day->ID, 'rewardType' )  == 'rank' ? '' : 'display:none'; ?>'>
                                    <select class='reward-rank'>
                                        <?php
                                        foreach( $this->ranks as $id => $rank )
                                        {
                                            if( $this->get_day_setting( $day->ID, 'rankID' ) == $id )
                                            {
                                                echo "<option value='{$id}' selected>{$rank}</option>";
                                                continue;
                                            }

                                            echo "<option value='{$id}'>{$rank}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </li>
                <?php
                }
            }

            ?>
            <li class="mycred-daily-login-rewards-add-new-reward">
                <input type="hidden" class="post-id" value="<?php echo get_the_ID(); ?>">
                <span class="dashicons dashicons-plus"></span>
                <span>Add New Reward</span>
            </li>
        </ul>
        <button class="button button-primary" id="save-all-rewards">
            <span class="dashicons dashicons-update mycred-animate-switch"></span>
            Save All Rewards
        </button>
    <?php
    }

    public function is_manual_rank()
    {
        if( $this->is_rank_active() && mycred_manual_ranks() )
            return true;

        return false;
    }

    public function get_day_setting( $post_id, $key )
    {
        return mycred_dlr_get_day_setting( $post_id, $key );
    }

    public function get_day_thumbnail( $post_id )
    {
        return mycred_dlr_get_day_thumbnail( $post_id );
    }

    public function reward_calender_shortcode()
    {
    ?>
        <input type="text" readonly="readonly" value="[mycred_rewards_calendar id='<?php echo get_the_ID(); ?>']">
        <p>
            Place this shortcode anywhere to display this rewards calendar.
        </p>
    <?php
    }

    public function sanitize_array($args = array())
    {
        $sanitized = array();

        if (is_array($args) && !empty($args))
            foreach ($args as $arg)
                $sanitized[] = sanitize_text_field($arg);

        return $sanitized;
    }

    public function save_post()
    {
        $mycred_dlr_settings = array();

        $mycred_dlr_settings['penalty'] = isset($_POST['penalty'] ) ? sanitize_text_field($_POST['penalty'] ) : '';

        $mycred_dlr_settings['rewards_penalty'] = isset($_POST['rewards_penalty'] ) ? sanitize_text_field($_POST['rewards_penalty'] ) : '';

        $mycred_dlr_settings['limited_time'] = isset($_POST['limited_time'] ) ? sanitize_text_field($_POST['limited_time'] ) : '';

        $mycred_dlr_settings['start_date'] = isset( $_POST['start_date'] ) ? sanitize_text_field($_POST['start_date'] ) : '';

        $mycred_dlr_settings['end_date'] = isset( $_POST['end_date'] ) ? sanitize_text_field($_POST['end_date'] ) : '';

        $mycred_dlr_settings['repeatable'] = isset( $_POST['repeatable'] ) ? sanitize_text_field($_POST['repeatable'] ) : '';

        $mycred_dlr_settings['repeatable_limit'] = isset( $_POST['repeatable_limit'] ) ? sanitize_text_field($_POST['repeatable_limit'] ) : '';

        $mycred_dlr_settings['complete_calender'] = isset( $_POST['complete_calender'] ) ? sanitize_text_field($_POST['complete_calender'] ) : '';

        $mycred_dlr_settings['complete_calenders'] = isset( $_POST['complete_calenders'] ) ? sanitize_text_field($_POST['complete_calenders'] ) : '';

        $mycred_dlr_settings['show_popup'] = isset( $_POST['show_popup'] ) ? sanitize_text_field($_POST['show_popup'] ) : '';

        $mycred_dlr_settings['image_size'] = isset( $_POST['image_size'] ) ? sanitize_text_field($_POST['image_size'] ) : '';

        $mycred_dlr_settings['rewards_columns'] = isset( $_POST['rewards_columns'] ) ? sanitize_text_field($_POST['rewards_columns'] ) : '';

        if( array_key_exists( 'complete_calenders', $_POST ) )
            $mycred_dlr_settings['complete_calenders'] = !empty( $this->sanitize_array($_POST['complete_calenders']) ) ? $this->sanitize_array($_POST['complete_calenders']) : '';

        $mycred_dlr_settings['completed_image'] = isset( $_POST['completed_image'] ) ? sanitize_text_field($_POST['completed_image'] ) : '';

        update_post_meta(get_the_ID(), 'mycred_dlr_settings', $mycred_dlr_settings);
    }



    public function mycred_create_calendar_day()
    {

        global $wpdb;

        $last = $wpdb->get_var($wpdb->prepare(
            "SELECT p.menu_order
            FROM {$wpdb->posts} AS p
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND p.post_parent = %s
            ORDER BY menu_order DESC
            LIMIT 1",
            'mycred-dlr-reward',
            'publish',
            $_POST['post_id']
        ));

        $last = absint($last) + 1;

        $args = array(
            'post_type'     => 'mycred-dlr-reward',
            'post_status'   => 'publish',
            'post_parent'   => $_POST['post_id'],
            'menu_order'    =>  $last
        );

        $post_id = wp_insert_post($args);

        echo $post_id;

        die;
    }

    public function mycred_delete_calendar_day()
    {
        $reward_id = sanitize_text_field( $_POST['reward_id'] );

        $menu_order = sanitize_text_field( $_POST['menu_order'] );

        $parent_post_id = sanitize_text_field( $_POST['parent_post_id'] );

        $response = wp_delete_post( $reward_id );

        //If successfully deleted
        if ( $response ) 
        {
            mycred_delete_post_meta( $reward_id, 'mycred_dlr_day' );

            $result = $this->update_days( $parent_post_id, $menu_order );

            echo wp_json_encode( $result );
        }

        die;
    }

    public function mycred_save_all_rewards()
    {
        $rewards = json_decode( stripslashes( $_POST['reward'] ) );
        
        foreach( $rewards as $post_id => $reward )
            mycred_update_post_meta( $post_id, 'mycred_dlr_day', $reward );

        die;
    }

    public function update_days( $parent_post_id, $menu_order )
    {

        $result = array();

        $_menu_order = $menu_order;

        global $wpdb;

        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_parent = %d AND menu_order > %d AND post_type = %s ORDER BY menu_order ASC",
                $parent_post_id,
                $menu_order,
                'mycred-dlr-reward'
            ),
            ARRAY_A
        );

        //Updating existing posts 
        foreach( $results as $key => $post )
        {
            $postarr = array(
                'ID'            =>  $post['ID'],
                'menu_order'    =>   $menu_order
            );

            $result['post_ids'][] = $post['ID'];

            wp_update_post( $postarr );

            $menu_order++;
        }

        $result['response'] = 'success';

        $result['menu_order'] = $_menu_order;

        return $result;
    }
}
endif;

myCRED_DRL_Admin::get_instance();