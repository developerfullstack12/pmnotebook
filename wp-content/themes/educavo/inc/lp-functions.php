<?php
/**
 * Custom functions for LearnPress 3.x
 *
 */
if ( ! function_exists( 'educavo_remove_learnpress_hooks' ) ) {
    function educavo_remove_learnpress_hooks() {
        remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_begin_meta', 10 );
        remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_price', 20 );
        remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_instructor', 25 );
        remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_end_meta', 30 );
        remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_buttons', 35 );
        remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_user_progress', 40 );
        remove_action( 'learn-press/before-main-content', 'learn_press_breadcrumb', 10 );
        remove_action( 'learn-press/before-main-content', 'learn_press_search_form', 15 );
        remove_action( 'learn-press/content-landing-summary', 'learn_press_course_meta_start_wrapper', 5 );
        remove_action( 'learn-press/content-landing-summary', 'learn_press_course_meta_end_wrapper', 15 );
        remove_action( 'learn-press/content-landing-summary', 'learn_press_course_price', 25 );
        remove_action( 'learn-press/content-landing-summary', 'learn_press_course_buttons', 30 );      
    }
}
add_action( 'after_setup_theme', 'educavo_remove_learnpress_hooks', 15 );

add_action( 'wp_enqueue_scripts', 'educavo_load_dashicons_front_end' );
function educavo_load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}


add_action( 'learn-press/profile/dashboard-summary', 'educavo_user_contact_information', 15 );

function educavo_user_contact_information(){ 
   $profile  = LP_Profile::instance();
   $user     = $profile->get_user();
   $lp_phone = get_the_author_meta( 'billing_phone', $user->get_id() );
   $lp_email = get_the_author_meta( 'billing_email', $user->get_id() ); 
   if( !empty( $lp_phone) || !empty( $lp_email)) : ?>
    <h4><?php esc_html_e('Contact Information', 'educavo');?></h4>    
    <?php endif;

    if( !empty( $lp_email) ) : ?>
        <span class="emails"><i class="glyph-icon flaticon-email"></i>
            <a href="mailto:<?php echo esc_attr($lp_email)?>"><?php echo esc_html($lp_email)?></a>
        </span>
    <?php endif;

    if( !empty( $lp_phone) ) : ?>
        <span class="phones"><i class="fa flaticon-call"></i>
            <a href="tel:+<?php echo esc_attr(str_replace(" ","",($lp_phone)))?>"> <?php echo esc_html($lp_phone);?> </a>
        </span>
    <?php endif;
}

/** Display course ratings
 */
if ( ! function_exists( 'educavo_course_ratings' ) ) {
    function educavo_course_ratings() {       
        if ( function_exists( 'learn_press_get_course_rate' ) ) {
            $course_id      = get_the_ID();    
            $rstheme_course = LP()->global['course'];
            $course_rate_res = learn_press_get_course_rate( $course_id, false );
            $course_rate     = $course_rate_res['rated'];
            $course_rate_total = $course_rate_res['total'];
            $course_rate_text = $course_rate_total > 1 ? esc_html__( 'Reviews', 'educavo' ) : esc_html__( 'Review', 'educavo' );
        } 


        if ( function_exists( 'learn_press_get_course_rate' ) ) : ?>  
        <div class="client-rating">
            <span class="course-rating-total"> <?php echo esc_html( $course_rate_total );?> </span> <?php echo esc_html( $course_rate_text );?>
            <?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );?> 
        </div>
        <?php endif;        
    }
}


add_action('educavo_single_course_meta', 'educavo_course_ratings', 25);
;

add_action( 'educavo_single_course_payment', 'learn_press_course_buttons', 20 ); 

//Show single course information
if( !function_exists( 'educavo_single_course_feature_info' )){
    function educavo_single_course_feature_info(){ 

        $course             = LP()->global['course'];
        $course_id          = get_the_ID();
        $course = LP_Global::course();
        
        $course_skill_level = get_post_meta( $course_id, 'educavo_course_skill_level', true );
        $course_language    = get_post_meta( $course_id, 'educavo_course_language', true );
        $duration           = get_post_meta( $course_id, '_lp_duration', true );
        $duration_type      = get_post_meta( $course_id, '_lp_duration_select', true );
        $duration_total     = $duration.' '.$duration_type;
        global $educavo_option;
        ?>
        <div class="course-features-info">      
            <ul>
                <li class="lectures-feature">
                <i class="fa fa-files-o"></i>
                <?php if (!empty($educavo_option['lectures'])) { ?>
                    <span class="label"><?php echo esc_html($educavo_option['lectures'])?></span>
                <?php } else { ?>
                    <span class="label"><?php esc_html_e( 'Lectures', 'educavo' ); ?></span>
                <?php } ?>
                
                <span class="value">
                    <?php $couser_get = $course->get_curriculum_items('lp_lesson') ? count( $course->get_curriculum_items('lp_lesson') ) : 0;    
                    echo wp_kses_post($couser_get);?>
                    </span>
                </li>
               
                <li class="quizzes-feature">
                    <i class="fa fa-puzzle-piece"></i>

                    <?php if (!empty($educavo_option['quizzes'])) { ?>
                        <span class="label"><?php echo esc_html($educavo_option['quizzes'])?></span>
                    <?php } else { ?>
                        <span class="label"><?php esc_html_e( 'Quizzes', 'educavo' ); ?></span>
                    <?php } ?>

                    <span class="value"><?php $quiq_item = $course->get_curriculum_items('lp_quiz') ? count( $course->get_curriculum_items('lp_quiz') ) : 0; 
                        echo wp_kses_post($quiq_item);
                    ?></span>
                </li>
               
                    <li class="duration-feature">
                        <i class="fa fa-clock-o"></i>

                        <?php if (!empty($educavo_option['duration'])) { ?>
                            <span class="label"><?php echo esc_html($educavo_option['duration'])?></span>
                        <?php } else { ?>
                            <span class="label"><?php esc_html_e( 'Duration', 'educavo' ); ?></span>
                        <?php } ?>

                        <span class="value"><?php echo esc_html($duration_total); ?></span>
                    </li>
              
                <?php if ( ! empty( $course_skill_level ) ): ?>
                    <li class="skill-feature">
                        <i class="fa fa-level-up"></i>

                        <?php if (!empty($educavo_option['skilllevel'])) { ?>
                            <span class="label"><?php echo esc_html($educavo_option['skilllevel'])?></span>
                        <?php } else { ?>
                            <span class="label"><?php esc_html_e( 'Skill level', 'educavo' ); ?></span>
                        <?php } ?>

                        <span class="value"><?php echo esc_html( $course_skill_level ); ?></span>
                    </li>
                <?php endif; ?>
                <?php if ( ! empty( $course_language ) ): ?>
                    <li class="language-feature">
                        <i class="fa fa-language"></i>

                        <?php if (!empty($educavo_option['language'])) { ?>
                            <span class="label"><?php echo esc_html($educavo_option['language'])?></span>
                        <?php } else { ?>
                            <span class="label"><?php esc_html_e( 'Language', 'educavo' ); ?></span>
                        <?php } ?>
                        <span class="value"><?php echo esc_html( $course_language ); ?></span>
                    </li>
                <?php endif; ?>
                <li class="students-feature">
                    <i class="fa fa-users"></i>

                    <?php if (!empty($educavo_option['students'])) { ?>
                        <span class="label"><?php echo esc_html($educavo_option['students'])?></span>
                    <?php } else { ?>
                        <span class="label"><?php esc_html_e( 'Students', 'educavo' ); ?></span>
                    <?php } ?>

                    <?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>
                    <span class="value"><?php echo esc_html( $user_count ); ?></span>
                </li>
               
                <li class="assessments-feature">
                    <i class="fa fa-check-square-o"></i>

                    <?php if (!empty($educavo_option['assessments'])) { ?>
                        <span class="label"><?php echo esc_html($educavo_option['assessments'])?></span>
                    <?php } else { ?>
                        <span class="label"><?php esc_html_e( 'Assessments', 'educavo' ); ?></span>
                    <?php } ?>
                    <span class="value"><?php echo ( get_post_meta( $course_id, '_lp_course_result', true ) == 'evaluate_lesson' ) ? esc_html__( 'Yes', 'educavo' ) : esc_html__( 'Self', 'educavo' ); ?></span>
                </li>

                <?php $course_custom_data = get_post_meta( get_the_ID(), 'course_custom_skill', true );

                if(!empty($course_custom_data)){  foreach ( $course_custom_data as $value ) { ?>
                    <li class="assessments-feature">
                    <i class="fa fa-check-square-o"></i>                 
                        <span class="label"> <?php echo esc_html($value['info_title']);?></span>        
                                   
                        <span class="value"> <?php echo esc_html($value['info_level']);?></span>
                 
                </li>
                <?php  } }?>
            </ul>
        </div>
        <?php
    }
}

add_action( 'educavo_single_course_feature', 'educavo_single_course_feature_info' );


//Custom metabox for course

//test for admin metabox for learnpress
/**
 * Add some meta data for a course
 *
 * @param $meta_box
 */

add_filter( 'learn_press_course_settings_meta_box_args', 'educavo_add_course_meta' );


/**
 * Display ratings count
 */

if ( ! function_exists( 'educavo_course_ratings_count' ) ) {
    function educavo_course_ratings_count( $course_id = null ) {
        
        if ( ! $course_id ) {
            $course_id = get_the_ID();
        }
        $ratings = learn_press_get_course_rate_total( $course_id ) ? learn_press_get_course_rate_total( $course_id ) : 0;
        echo '<div class="course-comments-count">';
        echo '<div class="value"><i class="fa fa-comment"></i>';
        echo esc_html( $ratings );
        echo '</div>';
        echo '</div>';
    }
}
/* extra field at for user profile */

add_action( 'show_user_profile', 'educavo_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'educavo_show_extra_profile_fields' );

function educavo_show_extra_profile_fields( $user ) { ?>
  <h3><?php  esc_html_e('Extra profile information', 'educavo');?></h3>
  <table class="form-table">
    <tr>
      <th><label for="designation"><?php esc_html_e('Designation', 'educavo');?></label></th>
      <td>
        <input type="text" name="designation" id="designation" value="<?php echo esc_attr( get_the_author_meta( 'designation', $user->ID ) ); ?>" class="regular-text" /><br />       
      </td>
    </tr>
    <tr>
      <th><label for="facebook"><?php esc_html_e('Facebook', 'educavo'); ?></label></th>
      <td>
        <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />       
      </td>
    </tr>
    <tr>
      <th><label for="twitter"><?php esc_html_e('Twitter', 'educavo');?></label></th>
      <td>
        <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
       
      </td>
    </tr>
    <tr>
      <th><label for="linkedin "><?php esc_html_e('Linkedin', 'educavo');?></label></th>
      <td>
        <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />       
      </td>
    </tr>

    <tr>
      <th><label for="youtube"><?php esc_html_e('Youtube', 'educavo');?></label></th>
      <td>
        <input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />       
      </td>
    </tr>
  </table>
<?php }
/* update user profile field */
add_action( 'personal_options_update', 'educavo_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'educavo_save_extra_profile_fields' );

function educavo_save_extra_profile_fields( $user_id ) {

  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;
  update_user_meta( $user_id, 'designation', $_POST['designation'] );
  update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
  update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
  update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
  update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
}