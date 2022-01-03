<?php 
    $cat = $settings['portfolio_category']; 

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	if(empty($cat)){
    	$best_wp = new wp_Query(array(
				'post_type'      => 'portfolios',
				'posts_per_page' => $settings['per_page'],								
		));	  
    }   
    else{
    	$best_wp = new wp_Query(array(
				'post_type'      => 'portfolios',
				'posts_per_page' => $settings['per_page'],				
				'tax_query'      => array(
			        array(
						'taxonomy' => 'portfolio-category',
						'field'    => 'term_id', //can be set to ID
						'terms'    => $cat //if field is ID you can reference by cat/term number
			        ),
			    )
		));	  
    }
    $x = 1;
	while($best_wp->have_posts()): $best_wp->the_post();	
		$content = get_the_content();
		$client    = get_post_meta( get_the_ID(), 'client', true );
		$location    = get_post_meta( get_the_ID(), 'location', true );
		$surface_area    = get_post_meta( get_the_ID(), 'surface_area', true );
		$created    = get_post_meta( get_the_ID(), 'created', true );
		$date    = get_post_meta( get_the_ID(), 'date', true );
		$project_value    = get_post_meta( get_the_ID(), 'project_value', true );		
		
		$cats_show = get_the_term_list( $best_wp->ID, 'portfolio-category', ' ', '<em class="separator">,</em> ');

		if(!empty($settings['content_word_show'])){
            $limit = $settings['content_word_show'];
        }
        else{
            $limit = 20;
        }
								
	?>	

		<div class="col-lg-<?php echo esc_html($settings['portfolio_columns']);?> col-md-6 col-xs-1 grid-item ">
			<div class="portfolio-item">
				<div class="overlay"></div>
				<?php if(has_post_thumbnail()): ?>                    
                    <div class="portfolio-img">
	                	<?php  the_post_thumbnail($settings['thumbnail_size']);?>
	                	<div class="p-icons"><a href="<?php the_permalink(); ?>"><i class="flaticon-right-arrow"></i> </a></div>
	                </div>                
                <?php endif;?>
                <div class="portfolio-content"> 
                    <?php if(($settings['e_content_show_hide'] == 'yes') ){ ?>
                    <div class="team-des" <?php echo wp_kses_post($popup_port_content_color);?>>
                    	<p><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                    </div>  
                    <?php } ?>
                    <div class="rs-btmsec">
	                	<?php if(get_the_title()):?>
	                		<div class="p-title">
	                			<p class="p-category"><?php echo wp_kses_post($cats_show ); ?></p>
	                			<a class="pointer-eventss" href="<?php the_permalink(); ?>"><?php the_title();?></a>
	                		</div>
	                	<?php endif;?>

	                	<?php if(($settings['view_show_hide'] == 'yes') ){ ?>
	                    	<div class="rs-view-btn">
	                    		<a class="rs-btn rs-btnwhite" href="<?php the_permalink(); ?>">
	    	                		<span class="rs_btn__text">
	    	                			<span><?php echo esc_html($settings['port_btn_text']);?></span>
	    	                		</span>
	                    		</a>
	                    	</div>
	                	<?php } ?>	                	
                	</div>  
               	</div>
            </div>
		</div>
	<?php	
	$x++;
	endwhile;
	wp_reset_query();  
 ?>  
