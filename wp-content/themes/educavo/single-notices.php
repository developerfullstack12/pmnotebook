<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */
    get_header(); 
    global $educavo_option; 
    $post_id      = get_the_id();
    $author_id    = get_post_field ('post_author', $post_id);
    $display_name = get_the_author_meta( 'display_name' , $author_id );
    ?>

  </div>
</div>
<!-- Main content Start -->

<div class="main-contain"> 
  <!-- Breadcrumbs Start -->
  <?php  get_template_part( 'inc/page-header/breadcrumbs-notice' ); ?>
  <!-- Breadcrumbs End --> 
  
  <!-- Team Detail Start -->  
  	<div class="rs-notice-details">
	    <div id="content" class="container">	    	
	      	<?php while ( have_posts() ) : the_post(); ?>
	      		<div class="row">
	      		   	<div class="col-lg-8">
			      		<?php if(has_post_thumbnail()){ ?>
			      		<div class="bs-img">
			      		  <?php the_post_thumbnail()?>
			      		</div>
			      		<?php } ?>

			      		
				    	<div class="event-desc"> 
				    		<ul class="single-posts-meta">
				    		    <li>                                
				    		        <span class="p-date">
				    		            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?php $post_date = get_the_date(); echo esc_attr($post_date);?>
				    		        </span>
				    		    </li>
				    		    <li>
				    		        <span class="p-user">                                        
				    		            <i class="fa fa-user-o" aria-hidden="true"></i> <?php echo esc_html($display_name); ?>
				    		        </span>
				    		    </li>      
				    		
				    		    
				    		    <li class="post-comment">
				    		        <i class="fa fa-comments-o" aria-hidden="true"></i> <?php echo get_comments_number( '0', '1', '%' ); ?> 
				    		    </li>
				    		</ul>       
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
				    </div>				    
				    <?php get_sidebar('single');?>				    
				</div>
	      		
      		<?php endwhile; ?>		   
		</div>
	</div>
<!-- Portfolio Detail End -->
<?php
get_footer();
