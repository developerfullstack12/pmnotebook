<?php
/**
 * Template for displaying instructor of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/instructor.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();

$profile = LP_Profile::instance();

$user = $profile->get_user();
?>

<div class="course-author">    
	<?php do_action( 'learn-press/before-single-course-instructor' ); ?>

    <div class="author-name">
		<?php echo wp_kses_post($course->get_instructor()->get_profile_picture(278,319)); ?>		
    </div>

    <?php 
		$lp_designation = get_the_author_meta( 'designation' ); 
		$lp_facebook    = get_the_author_meta( 'facebook' );
		$lp_twitter     = get_the_author_meta( 'twitter' );
		$lp_linkadin    = get_the_author_meta( 'linkedin' );
		$lp_google      = get_the_author_meta( 'google');
		$lp_youtube     = get_the_author_meta( 'youtube');
	?>

    <div class="author-info">

    	<h4><?php echo wp_kses_post($course->get_instructor_html()); ?>
    		<?php if(!empty($lp_designation)):?><span><?php echo esc_html( $lp_designation );?></span>
    		<?php endif; ?>
    	</h4>

    	<ul class="bootcamp-author-social">
            <?php if ( $lp_facebook ) : ?>
                <li>
                    <a href="<?php echo esc_url( $lp_facebook ); ?>" class="facebook"><i class="fa fa-facebook"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( $lp_twitter ) : ?>
                <li>
                    <a href="<?php echo esc_url( $lp_twitter ); ?>" class="twitter"><i class="fa fa-twitter"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( $lp_google ) : ?>
                <li>
                    <a href="<?php echo esc_url( $lp_google ); ?>" class="google-plus"><i class="fa fa-google-plus"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( $lp_linkadin ) : ?>
                <li>
                    <a href="<?php echo esc_url( $lp_linkadin); ?>" class="linkedin"><i class="fa fa-linkedin"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( $lp_youtube ) : ?>
                <li>
                    <a href="<?php echo esc_url( $lp_youtube ); ?>" class="youtube"><i class="fa fa-youtube"></i></a>
                </li>
            <?php endif; ?>
        </ul>

    </div>
    <div class="clear-fix"></div>
	<?php do_action( 'learn-press/after-single-course-instructor' ); ?>
</div>