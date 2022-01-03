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
		
		$termsArray  = get_the_terms( $best_wp->ID, "portfolio-category" );  //Get the terms for this particular item
		$termsString = ""; //initialize the string that will contain the terms
		$termsSlug   = "";

		 foreach ( $termsArray as $term ) { // for each term 
			$termsString .= 'filter_'.$term->slug.' '; //create a string that has all the slugs 
			$termsSlug   .= $term->name;
		 }
			
		$cats_show = get_the_term_list( $best_wp->ID, 'portfolio-category', ' ', '<span class="separator">,</span> ');
								
	?>	

		<div class="col-lg-<?php echo esc_html($settings['portfolio_columns']);?> col-md-6 col-xs-1 grid-item <?php echo esc_attr($termsString);?>">
			<div class="portfolio-item">
				<div class="overlay"></div>

				<?php if(has_post_thumbnail()):  
            		if('size_2' == $settings['portfolio_img_size']){
            			the_post_thumbnail('archtek_thumbnail_square', 'rsaddon');
            		}
            		else{
            			the_post_thumbnail($settings['thumbnail_size']);
            		}                 
                 endif;?>

                <div class="portfolio-content">
                	<div class="p-icon">
                        <a class="pointer-events" href="<?php the_permalink(); ?>"><i class="flaticon-right-arrow"></i></a>
                    </div>                    
                	<?php if(get_the_title()):?>
                		<div class="p-title">
                			<span class="p-category"><?php echo wp_kses_post($cats_show); ?></span>
                			<h3><a class="pointer-events" href="<?php the_permalink(); ?>">
                				<?php the_title();?>                					
                			</a></h3>                    			
                		</div>
                	<?php endif;?>  
               	</div>
            </div>
		</div>


	<?php	
	$x++;
	endwhile;
	wp_reset_query();  
 ?>