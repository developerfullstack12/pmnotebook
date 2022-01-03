<?php
get_header();

    global $assuranc_option;
    $portfolio_layout = get_post_meta( get_the_ID(), 'image_select', true );

    if ($portfolio_layout == 'slider'){
        require get_parent_theme_file_path('inc/portfolio/single-slider.php');       
    } 

    elseif ($portfolio_layout == 'gallery') {         
        require get_parent_theme_file_path('inc/portfolio/single-gallery.php');             
    }
    else{
      require get_parent_theme_file_path('inc/portfolio/single-standard.php');
    } ?>

    <!-- Portfolio Detail End -->
    <?php $best_wp = new wp_Query(array(
        'post_type'    => 'portfolios',
        'post__not_in' => array(get_the_ID())   
    ));
    if($best_wp->have_posts()) {
    ?>
        <div class="rs-related-section gray-bg">
            <div class="container">
                <div class="rs-related-title">
                    <h2><?php echo esc_html__('Related Portfolio', 'assuranc');?></h2>
                </div>

                <div class="rs-portfolio-style2 portfolio-carousel project-single-carousel blog-slider owl-carousel">
                    <?php while($best_wp->have_posts()): $best_wp->the_post();
                        $content = get_the_content();                       
                        $limit = 20;
                        $taxonomy = 'portfolio-category';
                        $cats_show = get_the_term_list( $best_wp->ID, $taxonomy, ' ', '<span class="separator">,</span> ');?>

                        <div class="portfolio-item">
                            <?php the_post_thumbnail('assuranc_carousel_slider');?>

                            <div class="portfolio-content">

                                <div class="team-des">
                                    <h4 class="p-title">
                                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                    </h4>
                                    <p><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                                </div>
                                <div class="rs-btmsec">
                                    <h4 class="p-title">
                                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                    </h4>

                                    <div class="rs-view-btn">
                                        <a class="rs-btn rs-btnwhite" href="<?php the_permalink(); ?>">
                                            <span class="rs_btn__text">
                                                <span><?php esc_html_e('View Details','assuranc');?></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>
        </div>
        <?php
    }
get_footer();?>