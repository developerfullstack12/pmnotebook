<?php 

global $educavo_option;
if(!empty($educavo_option['facebook']) || !empty($educavo_option['twitter']) || !empty($educavo_option['rss']) || !empty($educavo_option['pinterest']) || !empty($educavo_option['google']) || !empty($educavo_option['instagram']) || !empty($educavo_option['vimeo']) || !empty($educavo_option['tumblr']) ||  !empty($educavo_option['youtube'])){
?>

    <ul class="offcanvas_social">  
        <?php
        if(!empty($educavo_option['facebook'])) { ?>
        <li> 
        <a href="<?php echo esc_url($educavo_option['facebook'])?>" target="_blank"><span><i class="fa fa-facebook"></i></span></a> 
        </li>
        <?php } ?>
        <?php if(!empty($educavo_option['twitter'])) { ?>
        <li> 
        <a href="<?php echo esc_url($educavo_option['twitter']);?> " target="_blank"><span><i class="fa fa-twitter"></i></span></a> 
        </li>
        <?php } ?>
        <?php if(!empty($educavo_option['rss'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['rss']);?> " target="_blank"><span><i class="fa fa-rss"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($educavo_option['pinterest'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['pinterest']);?> " target="_blank"><span><i class="fa fa-pinterest-p"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($educavo_option['linkedin'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['linkedin']);?> " target="_blank"><span><i class="fa fa-linkedin"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($educavo_option['google'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['google']);?> " target="_blank"><span><i class="fa fa-google-plus-square"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($educavo_option['instagram'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['instagram']);?> " target="_blank"><span><i class="fa fa-instagram"></i></span></a> 
        </li>
        <?php } ?>
        <?php if(!empty($educavo_option['vimeo'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['vimeo'])?> " target="_blank"><span><i class="fa fa-vimeo"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($educavo_option['tumblr'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['tumblr'])?> " target="_blank"><span><i class="fa fa-tumblr"></i></span></a> 
        </li>
        <?php } ?>
        <?php if (!empty($educavo_option['youtube'])) { ?>
        <li> 
        <a href="<?php  echo esc_url($educavo_option['youtube'])?> " target="_blank"><span><i class="fa fa-youtube"></i></span></a> 
        </li>
        <?php } ?>     
    </ul>
<?php }

