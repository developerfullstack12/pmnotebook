<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-single-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */
global $educavo_option;
/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}


$user        = learn_press_get_current_user();
$course_id   = get_the_ID();
$course      = LP()->global['course'];
$course_enroll_count = $course->get_users_enrolled();
$course_enroll_count = $course_enroll_count ? $course_enroll_count : 0; 

/**
 * @deprecated
 */
do_action( 'learn_press_before_main_content' );
do_action( 'learn_press_before_single_course' );
do_action( 'learn_press_before_single_course_summary' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

do_action( 'learn-press/before-single-course' );

?>
</div>

<?php $course = LP_Global::course();

if ( ! $course ) {
	return;
}
?>

<div class="rs-courses-details">     
    <div class="row">
        <div class="col-lg-8 col-md-12 contents-sticky">
            <div id="learn-press-course" class="course-summary learn-press">            
                <div class="course-summary">
                    <?php
                    /**
                     * @since 3.0.0
                     *
                     * @see learn_press_single_course_summary()
                     */
                    do_action( 'learn-press/single-course-summary' );
                    ?>
                </div>             
            </div>
        </div>
        <div class="col-lg-4 col-md-12 sticky-sidebar">
            <div class="inner-column sticky-top">
                <?php 
                    $video_link = get_post_meta(get_the_ID(), 'video_links', true);
                    $video_bg   = get_the_post_thumbnail_url();                  
                    $video_link = !empty( $video_link ) ? $video_link : '';                   
                ?>
                <div class="intro-video">
                    <?php the_post_thumbnail();?>       
                    <?php if(!empty(  $video_link )) : ?>            
                        <a href="<?php echo wp_kses($video_link, 'educavo');?>" class="popup-videos intro-video-box"><span class="fa fa-play"></span></a>
                    <?php endif; ?>
                </div>
                
                <?php do_action('educavo_single_course_feature'); ?>

                <div class="btn-secs">
                    <div class="course-seats price">
                       <div class="course-price">
                                <span class="price"><?php echo wp_kses_post($course->get_price_html()); ?></span>
                            </div>
                    </div>                
                    <div class="payments">
                        <?php do_action( 'learn-press/course-buttons' ); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

do_action( 'learn-press/after-single-course' );

/**
 * @deprecated
 */
do_action( 'learn_press_after_single_course_summary' );
do_action( 'learn_press_after_single_course' );
do_action( 'learn_press_after_main_content' );
?>