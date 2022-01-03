<?php
/* Top Header part for educavo Theme
*/
global $educavo_option;
$mobile_hide_topbar = (!empty($educavo_option['mobile_top_bar'])) ? 'mobile-hide-topbars' : '';
// Header Options here
require get_parent_theme_file_path('inc/header/header-options.php');

if($rs_top_bar != 'hide'){
  if(!empty($educavo_option['show-top']) || ($rs_top_bar == 'show')){
       if( !empty($educavo_option['top-email']) || !empty($educavo_option['phone']) || !empty($educavo_option['show-social'])){?> 

          <div class="toolbar-area toolbar-area4 <?php echo esc_attr($mobile_hide_topbar);?>">
            <div class="container2 <?php echo esc_attr($header_width);?>">
              <div class="row">
                <div class="col-lg-4">
                    <?php if(!empty($educavo_option['welcome_sms'])) { ?>
                        <span><?php echo esc_html($educavo_option['welcome_sms']); ?></span>
                    <?php } ?> 
                </div>
                <div class="col-lg-8">
                    <div class="toolbar-contact">
                        <ul class="rs-contact-info">
                            <?php if(!empty($educavo_option['top-email'])) { ?>
                            <li class="rs-contact-email">
                                <i class="glyph-icon flaticon-email"></i>                  
                                      <a href="mailto:<?php echo esc_attr($educavo_option['top-email'])?>"><?php echo esc_html($educavo_option['top-email'])?></a>                   
                            </li>
                            <?php } ?>

                            <?php
                                if(!empty($educavo_option['open_hours'])):
                                $open_hours = $educavo_option['open_hours']; ?>
                                <li class="opening"> 
                                    <i class="glyph-icon flaticon-location"></i> <?php echo esc_html($open_hours); ?> 
                                </li>
                            <?php
                                endif;
                            ?> 
                        </ul>
                    </div>
                </div>
              </div>
            </div>
          </div>
      <?php 
    }
  }
} ?>