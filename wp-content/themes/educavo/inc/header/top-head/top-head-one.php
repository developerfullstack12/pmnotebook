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

            <div class="toolbar-area <?php echo esc_attr($mobile_hide_topbar);?>">
                <div class="<?php echo esc_attr($header_width);?>">
                    <div class="row alignitems">
                        <div class="col-lg-7">
                            <div class="toolbar-contact">
                                <ul class="rs-contact-info">
                                    <?php if(!empty($educavo_option['top-email'])) { ?>
                                    <li class="rs-contact-email">
                                        <i class="glyph-icon flaticon-email"></i>                  
                                        <a href="mailto:<?php echo esc_attr($educavo_option['top-email'])?>"><?php echo esc_html($educavo_option['top-email'])?></a>                
                                    </li>
                                    <?php }
                                    
                                    if(!empty($educavo_option['open_hours'])):
                                    $open_hours = $educavo_option['open_hours']; ?>
                                        <li class="opening"> <i class="glyph-icon flaticon-location"></i> <?php echo esc_html($open_hours); ?> </li>
                                    <?php
                                      endif;
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <?php if( !empty($educavo_option['quote']) || !empty($educavo_option['show-social'])){?>
                                <div class="tops-btn">
                                    <?php if(!empty($educavo_option['login_btns']) ) { ?>
                                    <?php if(!empty($educavo_option['loginbtn'])){ ?>
                                        <div class="btn_login">
                                        <?php if(is_user_logged_in()){ 
                                                global $post;
                                                $postid = $post->ID;
                                                $log_out_me = wp_logout_url( get_permalink($postid) );
                                            ?> 
                                            <a href="<?php echo esc_url($log_out_me); ?>" class="login-buttons"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php  echo esc_html("Logout", 'educavo'); ?> </a>

                                        <?php }
                                        else{ ?> 

                                            <a href="<?php echo esc_url($educavo_option['login_link']); ?>" class="login-buttons"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php  echo esc_html($educavo_option['loginbtn']); ?>                                            
                                        </a>
                                    <?php } ?>
                                        
                                        </div>
                                    <?php } } 

                                    
                                    if(!empty($educavo_option['quote'])){ ?>
                                        <div class="btn_quotes">
                                            <a href="<?php echo esc_url($educavo_option['quote_link']); ?>" class="quote-buttons"><?php  echo esc_html($educavo_option['quote']); ?>                                            
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
      <?php 
    }}
  }
?>