<?php

/*
Header Style 1
*/

global $educavo_option;
$sticky               = !empty($educavo_option['off_sticky']) ? $educavo_option['off_sticky'] : ''; 
$sticky_menu          = ($sticky == 1) ? ' menu-sticky' : '';
$drob_aligns          = (!empty($educavo_option['drob_align_s'])) ? 'menu-drob-align' : '';
$mobile_hide_search   = (!empty($educavo_option['mobile_off_search'])) ? 'mobile-hide-search' : '';
$mobile_hide_cart     = (!empty($educavo_option['mobile_off_cart'])) ? 'mobile-hide-cart-no' : 'mobile-hide-cart';
$mobile_hide_button   = (!empty($educavo_option['mobile_off_button'])) ? 'mobile-hide-button' : '';

// Header Options here
require get_parent_theme_file_path('inc/header/header-options.php');
?>
  <?php 
      //off convas here
      get_template_part('inc/header/off-canvas');
  ?> 


<!-- Mobile Menu Start -->
    <div class="responsive-menus"><?php require get_parent_theme_file_path('inc/header/responsive-menu.php');?></div>
<!-- Mobile Menu End -->
<header id="rs-header" class="single-header header-style5 mainsmenu<?php echo esc_attr($main_menu_hides);?> <?php echo esc_attr($main_menu_center);?> <?php echo esc_attr($main_menu_icon);?> <?php echo esc_attr($skew_style);?> <?php echo esc_attr($skew_styles);?> <?php echo esc_attr($mobile_hide_search);?> <?php echo esc_attr($mobile_hide_cart);?> <?php echo esc_attr($mobile_hide_button);?> <?php echo esc_attr($drob_aligns);?>">
    <?php 
      //include sticky search here
      get_template_part('inc/header/search');

    ?>
    <div class="header-inner <?php echo esc_attr($sticky_menu);?>">        
        <!-- Header Menu Start -->
        <?php        
        //check individual header 
        $menu_bg_color = !empty($menu_bg) ? 'style=background:'.$menu_bg.'' : ''; 
        ?>

        <!-- Topbar Start -->
        <?php
            get_template_part('inc/header/topbar');
        ?>
        <!-- Topbar End -->

        <div class="menu-area menu_type_<?php echo esc_attr($main_menu_type);?>" <?php echo wp_kses($menu_bg_color, 'educavo');?>>
            <div class="<?php echo esc_attr($header_width);?>">
                <div class="row-table">
                    <div class="col-cell header-logo">
                      <?php get_template_part('inc/header/logo');  ?>
                    </div>
    
                    <div class="col-cell menu-responsive"> 
                        <?php if(is_page_template('page-single.php')){
                            require get_parent_theme_file_path('inc/header/menu-single.php'); 
                        }else{
                            require get_parent_theme_file_path('inc/header/menu.php'); 
                        } ?> 
                    </div>
                    <div class="col-cell header-quote">

                        <?php 
                        
                        if($rs_top_search != 'hide'){
                            if(!empty($educavo_option['off_search'])): ?>
                                <div class="sidebarmenu-search text-right">
                                    <div class="sidebarmenu-search">
                                        <div class="sticky_search"> 
                                          <i class="flaticon-search"></i> 
                                        </div>
                                    </div>
                                </div>                        
                            <?php endif; 
                        }


                        //include Cart here
                        if($rs_show_cart != 'hide'){
                            if(!empty($educavo_option['wc_cart_icon'])) { ?>
                            <?php  get_template_part('inc/header/cart'); ?>
                        <?php } } ?>            
                                      
                        
                        
                        <?php if(!empty($educavo_option['login_btns'])) { ?>
                            <div class="user-icons"> 
                                <a href="<?php echo esc_url($educavo_option['login_link']); ?>" class="login-icon">
                                <i class="far fa-user" aria-hidden="true"></i>     
                                </a>
                            </div>
                        <?php } ?> 

                        <?php if($rs_show_quote != 'hide'){
                            if(!empty($educavo_option['quote_btns']) || ($rs_show_quote == 'show') ){ ?>
                                <?php if($quote_btn_texts !=''){?>
                                    <div class="btn_quote">
                                        <a href="<?php echo esc_url($educavo_option['quote_link']); ?>" class="quote-button"><?php  echo esc_html($quote_btn_texts); ?>                                            
                                        </a>
                                    </div>
                                        
                                    <?php } else {
                                        if(!empty($educavo_option['quote'])){?>
                                        <div class="btn_quote">
                                            <a href="<?php echo esc_url($educavo_option['quote_link']); ?>" class="quote-button"><?php  echo esc_html($educavo_option['quote']); ?>                                            
                                            </a>
                                        </div>
                                    <?php } }
                                ?>  
                        <?php } } ?>

                        <?php if($rs_offcanvas != 'hide'):
                              if(!empty($educavo_option['off_canvas']) || ($rs_offcanvas == 'show') ): ?>
                              <div class="sidebarmenu-area text-right">
                                <?php if(!empty($educavo_option['off_canvas']) || ($rs_offcanvas == 'show') ){
                                        $off = $educavo_option['off_canvas'];
                                        if( ($off == 1) || ($rs_offcanvas == 'show') ){
                                   ?>
                                    <ul class="offcanvas-icon">
                                        <li class="nav-link-container"> 
                                            <a href='#' class="nav-menu-link menu-button">
                                                <span class="dot1"></span>
                                                <span class="dot2"></span>
                                                <span class="dot3"></span>                                          
                                            </a> 
                                        </li>
                                    </ul>
                                    <?php } 
                                }?> 
                              </div>
                            <?php endif; endif; ?>

                            <?php if ( has_nav_menu( 'menu-1' ) ) { ?>
                            <div class="sidebarmenu-area text-right mobilehum">                                    
                                <ul class="offcanvas-icon">
                                    <li class="nav-link-container"> 
                                        <a href='#' class="nav-menu-link menu-button">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                            <span class="dot3"></span>                                        
                                        </a> 
                                    </li>
                                </ul>                                       
                            </div> 
                            <?php } ?>     
                    </div>
                </div>
            </div> 
        </div>
        <!-- Header Menu End -->
    </div>
     <!-- End Slider area  -->
   <?php 
    get_template_part( 'inc/breadcrumbs' );
  ?>
</header>

<?php  
    get_template_part('inc/header/slider/slider');
?>
