<?php
/**
 * the template for displaying all posts.
 */

get_header();

?>
<div class="container">
    <div id="content">

      <div class="row">
         <div class="<?php echo esc_attr($turitor_column); ?>">
                     
               <div class="learndash-course row">   
                  <?php
                  if ( have_posts() ) { 

                     while ( have_posts() ) : the_post();
                         get_template_part('template-parts/learndash/learndash', 'content'); 
                     endwhile;
                     
                        wp_reset_postdata();
                     }
                  ?>
               </div><!-- .row -->

         </div>
       
      </div>
   </div>
 </div>

<?php get_footer(); ?>