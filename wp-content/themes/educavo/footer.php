<?php
/**
 * @author  rs-theme
 * @since   1.0
 * @version 1.0 
 */
?>
     
</div><!-- .main-container -->
<?php
global $educavo_option;
require get_parent_theme_file_path('inc/footer/footer-options.php');
$header_grid2 = "";
$hide_footer ='';
$hide_footer =  get_post_meta(get_queried_object_id(), 'hide_footer', true);
if($hide_footer != 'yes'):


$footer_logo_size = !empty($educavo_option['footer-logo-height']) ? 'style="height: '.$educavo_option['footer-logo-height'].'"' : '';

if ( class_exists( 'WooCommerce' ) && is_shop() || class_exists( 'WooCommerce' ) && is_product_tag()  || class_exists( 'WooCommerce' ) && is_product_category()  ) {
    $educavo_shop_id    = get_option( 'woocommerce_shop_page_id' ); 
    $header_width_meta = get_post_meta($educavo_shop_id, 'header_width_custom2', true);
    $footer_logo       = get_post_meta($educavo_shop_id, 'footer_logo_img', true);

} elseif (is_home() && !is_front_page() || is_home() && is_front_page()){

    $header_width_meta = get_post_meta(get_queried_object_id(), 'header_width_custom2', true);
    $footer_logo       =  get_post_meta(get_queried_object_id(), 'footer_logo_img', true);
    
} else {
    $header_width_meta = get_post_meta(get_queried_object_id(), 'header_width_custom2', true);
   $footer_logo       =  get_post_meta(get_queried_object_id(), 'footer_logo_img', true);
}  
    
if ($header_width_meta != ''){
    $header_width = ( $header_width_meta == 'full' ) ? 'container-fluid': 'container';
}else{  
    $header_width = !empty($educavo_option['header-grid2']) ? $educavo_option['header-grid2'] : '';
    $header_width = ( $header_width == 'full' ) ? 'container-fluid': 'container';
}

// Footer Options here
get_template_part( 'inc/footer/footer','subscribe' ); 

$footer_gap = '';

if($hide_footer_subscribe != 'yes'  && is_active_sidebar( 'footer_top') ){
    $footer_gap = 'rs-footer-top-gap';
}



if(!empty( $footer_bg_img)):?>
    <footer id="rs-footer" class="ff <?php echo esc_attr($footer_select);?> rs-footer footer-style-1 <?php echo esc_attr($footer_gap); ?>" style="background-image: url('<?php echo esc_url($footer_bg_img); ?>'); <?php if (!empty($footer_bg_pos)): ?> background-position: <?php echo esc_attr($footer_bg_pos); ?> !important; <?php endif; ?> <?php if (!empty($footer_bg_rep)): ?> background-repeat: <?php echo esc_attr($footer_bg_rep); ?> !important; <?php endif; ?> <?php if (!empty($footer_bg_sizes)): ?> background-size: <?php echo esc_attr($footer_bg_sizes); ?> !important; <?php endif; ?> <?php if (!empty($footer_bg)): ?> background-color: <?php echo esc_attr($footer_bg) ?> <?php endif; ?>">

<?php elseif(!empty( $footer_bg)):?>
    <footer id="rs-footer" class="<?php echo esc_attr($footer_select);?> rs-footer footer-style-1 <?php echo esc_attr($footer_gap); ?>" style="background: <?php echo esc_attr($footer_bg);?> !important; <?php if (!empty($footer_bg_rep)): ?> background-repeat: <?php echo esc_attr($footer_bg_rep); ?> !important; <?php endif; ?> <?php if (!empty($footer_bg_sizes)): ?> background-size: <?php echo esc_attr($footer_bg_sizes); ?> !important; <?php endif; ?> <?php if (!empty($footer_bg_pos)): ?> background-position: <?php echo esc_attr($footer_bg_pos);?> !important; <?php endif; ?>">

<?php elseif( !empty( $educavo_option['footer_bg_image']['url'])):?>
    <footer id="rs-footer" class="<?php echo esc_attr($footer_select);?> rs-footer footer-style-1 <?php echo esc_attr($footer_gap); ?>" style="background-image: url('<?php echo esc_url($educavo_option['footer_bg_image']['url']);?>'); <?php if (!empty($footer_bg_rep)): ?> background-repeat: <?php echo esc_attr($footer_bg_rep); ?> !important; <?php endif; ?> <?php if (!empty($footer_bg_sizes)): ?> background-size: <?php echo esc_attr($footer_bg_sizes); ?> !important; <?php endif; ?> <?php if (!empty($footer_bg_pos)): ?> background-position: <?php echo esc_attr($footer_bg_pos); ?> !important; <?php endif; ?>">
    <?php else:?>
        <footer id="rs-footer" class="<?php echo esc_attr($footer_select);?> rs-footer footer-style-1 <?php echo esc_attr($footer_gap); ?>" >
<?php 
endif; 
 get_template_part( 'inc/footer/footer','top' ); 
?>
<div class="footer-bottom" <?php if(!empty( $copyright_bg)): ?> style="background: <?php echo esc_attr($copyright_bg); ?> !important;" <?php elseif(!empty( $copy_trans)): ?> style="background: <?php echo esc_attr($copy_trans); ?> !important;" <?php endif; ?>>
    <div class="<?php echo esc_attr($header_width);?>">
        <div class="copyright_border">
            <div class="rows"> 
                <?php if(is_active_sidebar( 'copy_right')){?>                                        
                    <div class="cols frist-cols">
                        <div class="copyright text-center" <?php if(!empty( $copy_space)): ?> style="padding: <?php echo esc_attr($copy_space); ?>" <?php endif; ?> >
                            <?php if(!empty($educavo_option['copyright'])){?>
                            <p><?php echo wp_kses($educavo_option['copyright'], 'educavo'); ?></p>
                            <?php }
                             else{
                                ?>
                            <p><?php echo esc_html('&copy;')?> <?php echo date("Y");?>. <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> 
                            </p>
                            <?php
                             }   
                            ?>
                        </div>
                    </div>            
                    <div class="cols">
                        <div class="copyright-widget" <?php if(!empty( $copy_space)): ?> style="padding: <?php echo esc_attr($copy_space); ?>" <?php endif; ?> >
                            <?php dynamic_sidebar( 'copy_right'); ?>
                        </div>
                    </div>
                     
                <?php }  elseif(is_active_sidebar( 'copy_right'  )){?>
                    <div class="cols">
                        <div class="copyright text-left" <?php if(!empty( $copy_space)): ?> style="padding: <?php echo esc_attr($copy_space); ?>" <?php endif; ?> >
                            <?php if(!empty($educavo_option['copyright'])){?>
                            <p><?php echo wp_kses($educavo_option['copyright'], 'educavo'); ?></p>
                            <?php }
                             else{
                                ?>
                            <p><?php echo esc_html('&copy;')?> <?php echo date("Y");?>. <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> 
                            </p>
                            <?php
                             }   
                            ?>
                        </div>
                    </div>            
                    <div class="cols">
                        <div class="copyright-widget" <?php if(!empty( $copy_space)): ?> style="padding: <?php echo esc_attr($copy_space); ?>" <?php endif; ?> >
                            <?php dynamic_sidebar( 'copy_right'); ?>
                        </div>
                    </div>
                <?php }  else { ?>
                    <div class="cols">
                        <div class="copyright text-center" <?php if(!empty( $copy_space)): ?> style="padding: <?php echo esc_attr($copy_space); ?>" <?php endif; ?> >
                            <?php if(!empty($educavo_option['copyright'])){?>
                            <p><?php echo wp_kses($educavo_option['copyright'], 'educavo'); ?></p>
                            <?php }
                             else{
                                ?>
                            <p><?php echo esc_html('&copy;')?> <?php echo date("Y");?>. <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> 
                            </p>
                            <?php
                             }   
                            ?>
                        </div>
                    </div> 
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</footer>
<?php endif; ?>
</div><!-- #page -->
<?php 
if(!empty($educavo_option['show_top_bottom'])){
?>
 <!-- start scrollUp  -->
<div id="scrollUp">
    <i class="fa fa-angle-up"></i>
</div>   
<?php } 
 wp_footer(); ?>
  </body>
</html>
