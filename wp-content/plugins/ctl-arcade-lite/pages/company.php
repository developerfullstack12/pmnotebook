<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function ctl_arcade_lite_page_company(){
    ?>
    <div id="fb-root"></div>

    <div class="ctl-arcade-lite-wrapper">
        <div class="ctl-arcade-lite-company-logo-wrapper">
            <img src="<?php echo plugins_url(); ?>/ctl-arcade-lite/images/ctl_logo.png">
        </div>

        <img width="100%" src="<?php echo plugins_url(); ?>/ctl-arcade-lite/images/ctl_banner.jpg">

        <p>We started as game developers then we broadened our horizons to explore new worlds.</p>
        <p>As the days went by, our working group got bigger, we acquired new skills and now we are a team able to deal with all that concern the digital world.</p>

        <p>We live in Naples, a city that spreads passion.</p>
        <p>The same passion that allows us creating new and original digital contents to meet our customers’ requirements tirelessly.</p>

        <p>Our “motto” is: <strong>If you can imagine it, we can create it for you</strong>.</p>
        <p>We are here to welcome your ideas to make them come true.</p>


        <div>
            <div class="ctl-arcade-lite-company-social-widget">
                <a class="twitter-timeline" href="https://twitter.com/CodeThisLab" data-widget-id="654309982813483009">Tweets by @CodeThisLab</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>

            <div class="ctl-arcade-lite-company-social-widget">
                <div class="fb-page" data-href="https://www.facebook.com/codethislab.srl" data-width="300" data-height="400" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/codethislab.srl"><a href="https://www.facebook.com/codethislab.srl">Code This Lab srl</a></blockquote></div></div>
            </div>

            <div class="ctl-clear"></div>
        </div>



        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_main_menu"
               class="ctl-arcade-lite-btn">Plugin settings</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games" class="ctl-arcade-lite-btn">games list</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>            
            <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>            
        </div>


    <?php

    ctl_arcade_lite_print_footer();
    ?>

    </div>
    <?php

}