<?php
       
   global $post; $post_id = $post->ID;
   $course_id = $post_id;
   $user_id   = get_current_user_id();
   $current_id = $post->ID;

   $options = get_option('sfwd_cpt_options');


   $currency = null;

   if ( ! is_null( $options ) ) {
      if ( isset($options['modules'] ) && isset( $options['modules']['sfwd-courses_options'] ) && isset( $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'] ) )
         $currency = $options['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'];

   }

   if( is_null( $currency ) )
      $currency = 'USD';

   $course_options = get_post_meta($post_id, "_sfwd-courses", true);


   $price = $course_options && isset($course_options['sfwd-courses_course_price']) ? $course_options['sfwd-courses_course_price'] : esc_html__( 'Free', 'educavo' );

   $has_access   = sfwd_lms_has_access( $course_id, $user_id );
   $is_completed = learndash_course_completed( $user_id, $course_id );

   if( $price == '' )
      $price .= esc_html__( 'Free', 'educavo' );

   if ( is_numeric( $price ) ) {
      if ( $currency == "USD" )
         $price = '$' . $price;
      else
         $price .= ' ' . $currency;
   }

   $class       = '';
   $ribbon_text = '';

   if ( $has_access && ! $is_completed ) {
      $class = 'ld_course_grid_price ribbon-enrolled';
      $ribbon_text = esc_html__( 'Enrolled', 'educavo' );
   } elseif ( $has_access && $is_completed ) {
      $class = 'ld_course_grid_price';
      $ribbon_text = esc_html__( 'Completed', 'educavo' );
   } else {
      $class = ! empty( $course_options['sfwd-courses_course_price'] ) ? 'ld_course_grid_price price_' . $currency : 'ld_course_grid_price free';
      $ribbon_text = $price;
   }

   $cat_with_link = '';
   $taxonomy  = 'ld_course_category'; 
   $cat_with_link = get_the_term_list( $course_id, $taxonomy, ' ', '<span class="separator">,</span> ');       
?>
<div class="col-lg-4">
    <div class="rs-courses rs_course_style1">
        <div class="courses-item">
         <?php if ( has_post_thumbnail() ):?>
               <div class="img-part">
                  <a href="<?php the_permalink(); ?>">
                     <?php the_post_thumbnail();?>
                  </a>
               </div>
         <?php endif; ?>
          <div class="content-part">
             <div class="course-category">
                  <ul class="meta-part">
                      <li><span class="price"><?php echo esc_html($ribbon_text); ?></span></li>
                      <li class="cat"><?php 
                         echo wp_kses($cat_with_link, 'educavo');
                      ?></li>
                  </ul>                          
             </div>
             <?php echo do_shortcode('[student]')  ;?>                      
                <h3 class="title">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo get_the_title();?>
                    </a>
                </h3>
             
                <div class="bottom-part">                       
                    <div class="ld-course-read-more info-meta read-border">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo esc_html__("Enroll Now", 'educavo');?>
                        </a>
                    </div>
                    <div class="btn-part">
                        <a href="<?php the_permalink(); ?>">
                            <i class="flaticon-right-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>