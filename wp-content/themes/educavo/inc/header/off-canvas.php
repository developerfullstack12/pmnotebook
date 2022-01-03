<?php 
global $educavo_option;
$rs_offcanvas = get_post_meta(get_the_ID(), 'show-off-canvas', true);
$logo_height = !empty($educavo_option['logo-height']) ? 'style = "max-height: '.$educavo_option['logo-height'].'"' : '';
    //off convas here
?>
    
<nav class="menu-wrap-off nav-container nav menu-ofcn">       
<div class="inner-offcan">
    <div class="nav-link-container">  
        <a href='#' class="nav-menu-link close-button" id="close-button2">              
            <span class="hamburger1"></span>
            <span class="hamburger3"></span>
        </a> 
    </div> 
    <div class="sidenav offcanvas-icon">
            <div id="mobile_menu" class="rs-offcanvas-inner-left">
                <?php
                    if ( has_nav_menu( 'menu-1' ) ) {
                        // User has assigned menu to this location;
                        // output it
                        ?>                                
                            <div class="widget widget_nav_menu mobile-menus">      
                                <?php
                                    wp_nav_menu( array(
                                        'theme_location' => 'menu-1',
                                        'menu_id'        => 'primary-menu-single1',
                                    ) );
                                ?>
                            </div>                                
                        <?php
                    }
                    ?>
            </div>            
        <?php 
        if(!empty( $educavo_option['off_canvas'] ) || ($rs_offcanvas == 'show') ){
            $off = $educavo_option['off_canvas'];
            if( ($off == 1) || ($rs_offcanvas == 'show')){ ?>            
            <div class="rs-innner-offcanvas-contents"> 

                <?php $offcanvas_logo_height = !empty($educavo_option['offcanvas_logo_height']) ? 'style="height: '.$educavo_option['offcanvas_logo_height'].'"' : '';

                if (!empty( $educavo_option['offcanvas_logo']['url'] ) ) { ?>
                    <div class="offcanvas_logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img <?php echo wp_kses($offcanvas_logo_height, 'educavo');?> src="<?php echo esc_url( $educavo_option['offcanvas_logo']['url']); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
                    </div>
                <?php }
                 dynamic_sidebar('sidebarcanvas-1');?>
            </div>            
            <?php }
        }?>
    </div>
    </div>
</nav>