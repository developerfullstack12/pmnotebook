<?php 
    global $educavo_option;
    $post_meta_data = get_post_meta(get_the_ID(), 'banner_image', true);
    //theme option chekcing
    if($post_meta_data == ''){
        if(!empty($educavo_option['course_banner']['url'])):
        $post_meta_data = $educavo_option['course_banner']['url'];
        endif;
    }  
    $banner_hide = get_post_meta(get_the_ID(), 'banner_hide', true);
    if( 'show' == $banner_hide ||  $banner_hide == '' ){  
    $post_meta_data = $post_meta_data;
    } else {
        $post_meta_data = '';
    }
    $post_menu_type = get_post_meta(get_the_ID(), 'menu-type', true);
    $content_banner = get_post_meta(get_the_ID(), 'content_banner', true); 

    if(!empty($educavo_option['show_banner__course'])):
      $post_meta_data = $educavo_option['show_banner__course'];
    endif;
?>



<div class="rs-breadcrumbs  porfolio-details">

    <?php if($post_meta_data !=''){ ?>

    <div class="breadcrumbs-single" style="background-image: url('<?php echo esc_url($post_meta_data); ?>')">
      <div class="<?php echo esc_attr($header_width);?>">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="breadcrumbs-inner bread-<?php echo esc_attr($post_menu_type); ?>">
              <?php 
              if (empty($educavo_option['show_banner__course'])) {
              if (!is_singular('sfwd-lessons') && !is_singular('sfwd-topic') && !is_singular('sfwd-quiz')):
                $post_meta_title = get_post_meta(get_the_ID(), 'select-title', true);?>
                <?php if($post_meta_title != 'hide'){             
              ?>
              <h1 class="page-title">
                <?php if($content_banner !=''){
                    echo esc_html($content_banner);
                } else {
                    the_title();
                }
                ?>
              </h1>             
              <?php } 
                if(!empty($educavo_option['off_breadcrumb'])){
                    $rs_breadcrumbs = get_post_meta(get_the_ID(), 'select-bread', true);
                    if($rs_breadcrumbs != 'hide'):        
                        if(function_exists('bcn_display')){?>
                            <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                        <?php } 
                    endif;
                }
                endif;
            }
              ?>        
            </div>
          </div>
        </div>
      </div>
    </div>
    
        <?php } elseif(!empty($educavo_option['course_banner']['url'])){ 
        $course_banner = $educavo_option['course_banner']['url'];?>
        <div class="breadcrumbs-single" style="background-image: url('<?php echo esc_url( $course_banner );?>')">   
            <div class="container">
              <div class="row">
                <div class="col-md-12 text-center">
                    <div class="breadcrumbs-inner"> 
                        <?php 
                        if (!is_singular('sfwd-lessons') && !is_singular('sfwd-topic') && !is_singular('sfwd-quiz')):
                        if(is_single()){ ?>
                            <h1 class="page-title"><?php the_title(); ?></h1>
                        <?php } else{ ?>
                           <h1 class="page-title"><?php the_archive_title();?></h1>
                           <?php
                        } if(!empty($educavo_option['off_breadcrumb'])){
                            $rs_breadcrumbs = get_post_meta(get_the_ID(), 'select-bread', true);
                            if($rs_breadcrumbs != 'hide'):        
                                if(function_exists('bcn_display')){?>
                                    <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                                <?php } 
                            endif;
                        }
                        endif;
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
                 <?php 
                 if (!is_singular('sfwd-lessons') && !is_singular('sfwd-topic') && !is_singular('sfwd-quiz')):
                 if(is_single()){ ?>
                       <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php } else{ ?>
                       <h1 class="page-title"><?php the_archive_title();?></h1>
                       <?php
                    }         
                    if(!empty($educavo_option['off_breadcrumb'])){
                        $rs_breadcrumbs = get_post_meta(get_the_ID(), 'select-bread', true);
                        if($rs_breadcrumbs != 'hide'):        
                            if(function_exists('bcn_display')){?>
                                <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                            <?php } 
                        endif;
                    }
                    endif;
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