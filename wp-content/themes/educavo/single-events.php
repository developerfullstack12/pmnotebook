<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */
    get_header(); 
    global $educavo_option; 
    ?>

  </div>
</div>
<!-- Main content Start -->

<div class="main-contain"> 
  <!-- Breadcrumbs Start -->
  <?php  get_template_part( 'inc/page-header/breadcrumbs-event' ); ?>
  <!-- Breadcrumbs End --> 
  
  <!-- Team Detail Start -->  
  <div class="rs-courses-details">
    <div class="container">
    	<div id="content">
	      <?php while ( have_posts() ) : the_post();
	      //take metafield value
			$ev_start_date = get_post_meta(  get_the_ID(), 'ev_start_date', true );
			$ev_end_date   = get_post_meta(  get_the_ID(), 'ev_end_date', true );
			$ev_start_time = get_post_meta(  get_the_ID(), 'ev_start_time', true );
			$ev_end_time   = get_post_meta(  get_the_ID(), 'ev_end_time', true );
			$ev_location   = get_post_meta ( get_the_ID(), 'ev_location', true);
			$ev_link       = get_post_meta ( get_the_ID(), 'ev_link', true);

			$new_sDate = date("d/m/Y", strtotime($ev_start_date));  
			$new_eDate = date("d/m/Y", strtotime($ev_end_date));


			$new_sDate = date("d/m/Y", strtotime($ev_start_date));  

			$date_style = $educavo_option['date_style'];

			if( 'style2' == $date_style ){
				$ev_start_date = $new_sDate;
				$ev_end_date = $new_eDate;
			}


			$time_style = $educavo_option['time_style'];

			$new_stime  = date("H:i", strtotime($ev_start_time));
			$new_etime  = date("H:i", strtotime($ev_end_time));

			if( 'style2' == $time_style ){
				$ev_start_time = $new_stime;
				$ev_end_time   = $new_etime;
			}

		  ?>
	      	<div class="row">
		        <div class="col-lg-8 col-md-12">
		          <div class="ps-image">
		            <?php the_post_thumbnail(); ?>
		          </div>
		        </div>
		        <div class="col-lg-4 col-md-12">
		         	<div class="course-features-info">
		         		<?php if(!empty($educavo_option['event_info'])):?>
        					<h3 class="title"> <?php echo esc_attr($educavo_option['event_info']);?></h3>
        				<?php endif;?>
			            <ul>
			            	<?php if(!empty($ev_start_date)): ?>
				                <li class="lectures-feature">
				                    <i class="fa fa-calendar"></i>
				                    <span class="label"><?php esc_html_e('Start Date', 'educavo');?></span>
				                    <span class="value"><?php echo esc_attr($ev_start_date);?></span>
				                </li>
				            <?php endif; ?>    
			               
			                <?php if(!empty($ev_start_time)): ?>
				                <li class="lectures-feature">
				                    <i class="fa fa-clock-o"></i>
				                    <span class="label"><?php esc_html_e('Start Time', 'educavo');?></span>
				                    <span class="value"><?php echo esc_attr($ev_start_time);?></span>
				                </li>
				            <?php endif; ?> 

				            <?php if(!empty($ev_end_date)): ?>
				                <li class="lectures-feature">
				                    <i class="fa fa-calendar"></i>
				                    <span class="label"><?php  esc_html_e('End Date', 'educavo');?></span>
				                    <span class="value"><?php echo esc_attr($ev_end_date);?></span>
				                </li>
				            <?php endif; ?>

				            <?php if(!empty($ev_end_time)): ?>
				                <li class="lectures-feature">
				                    <i class="fa fa-clock-o"></i>
				                    <span class="label"><?php  esc_html_e('End Time', 'educavo');?></span>
				                    <span class="value"><?php echo esc_attr($ev_end_time);?></span>
				                </li>
				            <?php endif; ?> 

				            <?php if(!empty($ev_location)): ?>
				                <li class="lectures-feature">
				                    <i class="fa fa-map-marker"></i>
				                    <span class="label"><?php esc_html_e('Location', 'educavo');?></span>
				                    <span class="value"><?php echo esc_attr($ev_location);?></span>
				                </li>
				            <?php endif; ?> 		               
			                   
			            </ul>

			            <?php if(!empty($educavo_option['event_btn'])): ?>
			            <div class="book-btn">
 							
			            	<a href="<?php echo esc_url($ev_link);?>"><?php echo esc_attr($educavo_option['event_btn']);?></a>
			            	
			            </div>
			            <?php endif; ?>

       				 </div>
	      		</div>
	      	</div>
		     <div class="event-desc">        
		        <?php
		            the_content( sprintf(
		              wp_kses(
		                /* translators: %s: Name of current post. Only visible to screen readers */
		                __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'educavo' ),
		                array(
		                  'span' => array(
		                    'class' => array(),
		                  ),
		                )
		              ),
		              get_the_title()
		            ) );

		            wp_link_pages( array(
		              'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'educavo' ),
		              'after'  => '</div>',
		            ) );
		          ?>
		      </div>
		      <div class="event_map">
		       <iframe width="100%" height="400"
				    src="https://maps.google.com/maps?q= <?php echo esc_attr($ev_location); ?> &t=&z=14&ie=UTF8&iwloc=&output=embed"
				    frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
				</iframe>
			</div>
	      <?php
            get_template_part( 'pagination');
          ?>
      <?php endwhile; ?>
    </div>
  </div>
</div>
<!-- Portfolio Detail End -->
<?php
get_footer();
