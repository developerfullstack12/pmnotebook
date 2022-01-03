<?php

/**
 * Template for displaying archive course content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-archive-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */


/**
 * Prevent loading this file directly
 */

defined( 'ABSPATH' ) || exit();

global $post, $wp_query, $lp_tax_query, $wp_query, $educavo_option;


/**
 * 
 *
 * @see LP_Template_General::template_header()
 */
do_action( 'learn-press/template-header' );

/**
 * LP Hook
 */
do_action( 'learn-press/before-main-content' );

$page_title = learn_press_page_title( false );
?>

<?php
global $post, $wp_query, $lp_tax_query, $wp_query;
$show_description = get_theme_mod( 'thim_learnpress_cate_show_description' );
$show_desc        = !empty( $show_description ) ? $show_description : '';
$cat_desc         = term_description();
$total            = $wp_query->found_posts;

if ( $total == 0 ) {
    $message = '<p class="message message-error">' . esc_html__( 'No courses found!', 'educavo' ) . '</p>';
    $index   = esc_html__( 'There are no available courses!', 'educavo' );
}elseif ( $total == 1 ) {
    $index = esc_html__( 'Showing only one result', 'educavo' );
}else {
    $courses_per_page = absint( LP()->settings->get( 'archive_course_limit' ) );
    $paged            = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $from             = 1 + ( $paged - 1 ) * $courses_per_page;
    $to               = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;
    if ( $from == $to ) {
        $index = sprintf(
            esc_html__( 'Showing last course of %s results', 'educavo' ),
            $total
        );
    } else {
        $index = sprintf(
            esc_html__( 'Showing %s-%s of %s results', 'educavo' ),
            $from,
            $to,
            $total
        );
    }
}
$licenseKey = get_option("EducavoWordPressTheme_lic_Key","");

if(!empty($licenseKey)) {
?>

<div class="rs-course-archive-top"> 
    <div class="row">
        <div class="col-lg-6">
            <div class="course-left">
                <div class="course-icons">
                    <a href="#" class="rs-grid active-grid"><i class="fa fa-th-large"></i></a>
                    <a href="#" class="rs-list active-list"><i class="fa fa-list-ul"></i></a>
                </div>
                <div class="course-index">
                    <span><?php echo esc_html( $index ); ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="rs-search">
                <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
                    <input type="hidden" name="ref" value="course">
                    <input type="text" value="<?php echo esc_attr( get_search_query() );?>" name="s" placeholder="<?php esc_attr_e( 'Search our courses', 'educavo' ) ?>" class="form-control" />
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 

global  $paged;

$category = get_queried_object_id(); 

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if(!empty($category)){
    
    $best_wp = new wp_Query(array(
        'post_type'           => 'lp_course',
        'posts_per_page' => LP()->settings->get('learn_press_archive_course_limit') ,
        'ignore_sticky_posts' => 1,  
        'paged'          => $paged,
        'tax_query' => array(
        array(
            'taxonomy' => 'course_category', //double check your taxonomy name in you dd 
            'field'    => 'id',
            'terms'    => $category,
        ),
       )
    ));  
}else{
   $best_wp = new wp_Query(array(
    'post_type'           => 'lp_course',
    'posts_per_page' => LP()->settings->get('learn_press_archive_course_limit') ,
    'ignore_sticky_posts' => 1,  
    'paged'          => $paged
));   
}
 
if ( have_posts() ) :   
    learn_press_begin_courses_loop();
    while($best_wp->have_posts()): $best_wp->the_post();?>   
    <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="rs-courses rs_course_style1">
        <?php    
            
            $course_id      = get_the_ID();
            $course = LP_Global::course();
            $rstheme_course = LP()->global['course'];
            if ( empty( $rstheme_course ) ) return;
                $rstheme_course      = LP()->global['course'];
                $course_enroll_count = $rstheme_course->get_users_enrolled();
                $course_enroll_count = $course_enroll_count ? $course_enroll_count : 0;

                if ( empty( $rstheme_course ) ) return;

                $course_author       = get_post_field( 'post_author', $course_id );
                $course_author       = get_post_field( 'post_author', $course_id );
                $course_enroll_count = $course_enroll_count ? $course_enroll_count : 0; 
                $lessons             = $rstheme_course->get_curriculum_items( 'lp_lesson' )? count( $rstheme_course->get_curriculum_items( 'lp_lesson' ) ) : 0;

            if ( function_exists( 'learn_press_get_course_rate' ) ) {
                $course_rate_res   = learn_press_get_course_rate( $course_id, false );
                $course_rate       = $course_rate_res['rated'];
                $course_rate_total = $course_rate_res['total'];
                $course_rate_text  = $course_rate_total > 1 ? esc_html__( 'Reviews', 'educavo' ) : esc_html__( 'Review', 'educavo' );
            }

            $taxonomy  = 'course_category'; 
            $cats_show = get_the_term_list( $course_id, $taxonomy, ' ', '<span class="separator">,</span> ');     

        ?>

            <div class="courses-item">
                <div class="img-part">
                    <a href="<?php the_permalink();?>"><?php the_post_thumbnail();?></a>
                </div>
                <div class="content-part">
                    <ul class="meta-part">
                        <li> 
                            <div class="course-price">
                                <span class="price"><?php echo wp_kses_post($course->get_price_html()); ?></span>
                            </div>
                        
                        <li class="cat"><?php echo wp_kses($cats_show, 'educavo'); ?></li>
                    </ul>

                    <h3 class="title">
                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                    </h3>            

                    <div class="bottom-part">
                        <div class="info-meta">
                            <ul>
                                <li class="user"><i class="far fa-user"></i><?php echo esc_html($course_enroll_count); ?></li>
                                <?php if ( function_exists( 'learn_press_get_course_rate' ) ) { ?>
                                <li class="course-ratings">
                                    <?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );?><div class="course-rating-total"> 
                                    (<?php echo esc_html( $course_rate_total );?>)</div>
                                </li> <?php } ?>
                            </ul>
                        </div>
                        <div class="btn-part">
                            <a href="<?php the_permalink();?>"><i class="flaticon-right-arrow"></i></a>                         
                        </div>
                    </div>
                </div>
            </div>
        
            <?php // @since 3.0.0

            // @deprecated

            do_action( 'learn_press_after_courses_loop_item' );

            ?>
        </div>
    </li>

<?php

    endwhile;
    $paginate = paginate_links( array(
            'total' => $best_wp->max_num_pages
        ));

    if(!empty($paginate )){ ?>
        <div class="rs-pagination-area"><div class="nav-links"><?php echo wp_kses_post($paginate); ?></div></div>
    <?php } 
    LP()->template( 'course' )->end_courses_loop();

    /**

     * @since 3.0.0

     */

    do_action( 'learn_press_after_courses_loop' );
    /**

     * @deprecated

     */
    do_action( 'learn-press/after-courses-loop' );
    wp_reset_postdata();
else:
    learn_press_display_message( __( 'No course found.', 'educavo' ), 'error' );
endif;
}



/**
 * @since 4.0.0
 *
 * @see   LP_Template_General::template_footer()
 */
do_action( 'learn-press/template-footer' );
