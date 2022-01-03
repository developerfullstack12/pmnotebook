<?php
  global $educavo_option;
  $header_trans = '';
    if(!empty($educavo_option['header_layout'])){               
        $header_style = $educavo_option['header_layout'];               
        if($header_style == 'style2'){       
            $header_trans = 'heads_trans';    
        }
    }
?>

<div class="rs-breadcrumbs porfolio-details <?php echo esc_attr($header_trans);?>">
    <?php  if(is_post_type_archive('events')){
        $archive_banner = !empty($educavo_option['event_banner_main']['url']) ? $educavo_option['event_banner_main']['url'] : '';
    }
    elseif(is_post_type_archive('notices')){
        $archive_banner = !empty($educavo_option['notice_banner_main']['url']) ? $educavo_option['notice_banner_main']['url'] : '';
    }
    elseif(is_post_type_archive('lp_course')){
        $archive_banner = !empty($educavo_option['course_banner']['url']) ? $educavo_option['course_banner']['url'] : '';
    }
    else{
        $archive_banner = !empty($educavo_option['blog_banner_main']['url']) ? $educavo_option['blog_banner_main']['url'] : '';
    }

    if(!empty($educavo_option['show_banner__course'])):
      $archive_banner = $educavo_option['show_banner__course'];
    endif;

   if(!empty($archive_banner)) { ?>
    <div class="breadcrumbs-single" style="background-image: url('<?php echo esc_url($archive_banner);?>')">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="breadcrumbs-inner">

            <?php if (empty($educavo_option['show_banner__course'])) {
                if(!empty($educavo_option['event_info']) && is_post_type_archive('events')){
                    echo '<h1 class="page-title a">'.esc_html($educavo_option['event_info']).'</h1>';
                        if( !empty($educavo_option['off_breadcrumb_event'])){
                            if(function_exists('bcn_display')){?>
                                <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                            <?php } 
                        }                 
                    }
                    elseif(!empty($educavo_option['notice_info']) && is_post_type_archive('notices')){
                    echo '<h1 class="page-title b">'.esc_html($educavo_option['notice_info']).'</h1>';  
                    if(!empty($educavo_option['off_breadcrumb_notice'])){
                        if(function_exists('bcn_display')){?>
                            <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                        <?php } 
                    }                 
                    } else {
                    the_archive_title( '<h1 class="page-title c">', '</h1>' );
                    if(!empty($educavo_option['off_breadcrumb'])){
                        if(function_exists('bcn_display')){?>
                            <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                        <?php } 
                    }  
                } 
            }          
            ?>   
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php }
  else{   
  ?>
  <div class="rs-breadcrumbs-inner">  
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="breadcrumbs-inner">
           <?php if(!empty($educavo_option['event_info']) && is_post_type_archive('events')){
                echo '<h1 class="page-title">'.esc_html($educavo_option['event_info']).'</h1>';
                    if(!empty($educavo_option['off_breadcrumb_event'])){
                        if(function_exists('bcn_display')){?>
                            <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                        <?php } 
                    }                 
               }
                elseif(!empty($educavo_option['notice_info']) && is_post_type_archive('notices')){
                echo '<h1 class="page-title">'.esc_html($educavo_option['notice_info']).'</h1>';  
                if(!empty($educavo_option['off_breadcrumb_notice'])){
                    if(function_exists('bcn_display')){?>
                        <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                    <?php } 
                }                 
               }else{
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                if(!empty($educavo_option['off_breadcrumb'])){
                    if(function_exists('bcn_display')){?>
                        <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                    <?php } 
                }  
               }
              ?>              
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  }
?>  
</div>