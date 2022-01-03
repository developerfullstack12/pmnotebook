<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    function ctl_arcade_lite_page_settings() {
        ?>
        <div class="ctl-arcade-lite-wrapper">
        <h2>CTL Arcade Settings (PRO)</h2>
        <?php
            _ctl_arcade_lite_page_all_settings();
            ctl_arcade_lite_print_footer();
        ?>
        </div>
        <?php
    }


    function _ctl_arcade_lite_page_all_settings() {
        ?>

        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games" class="ctl-arcade-lite-btn">games list</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>                  
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
               class="ctl-arcade-lite-btn">about us</a>
               <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>       
        </div>

        <p class="ctl-arcade-lite-alert">These features work only with CTL Arcade (full version)</p>


        <h3>Scores</h3>
        <p>Empty all scores from DB:</p>
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>
        
        <h3>Ratings</h3>
        <p>Empty all ratings from DB:</p>
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>
        
        <h3>Facebook app id</h3>
        <p>Share your users' scores on Facebook:</p>
        <input disabled readonly type="text" id="ctl-arcade-lite-id-fb-app-id-value" value="">
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>
        
        <h3>Min time between ads</h3>
        <p>Minimum time between ads in seconds:</p>
        <input disabled readonly type="number" min="1" max="120" id="ctl-arcade-lite-id-min-time-between-ads" value=7>
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>
        
        <h3>Preloader AD</h3>
        <p>Minimum duration of preloader ad in seconds:</p>
        <input disabled readonly type="number" min="1" max="120" id="ctl-arcade-lite-id-ad-preloader-min-time" value=7>
        <p>Insert your ad code, it will appear before the game:</p>
        <textarea disabled readonly rows="3" cols="50" id="ctl-arcade-lite-id-ad-preloader-code"></textarea>
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>

        <h3>Interlevel AD</h3>
        <p>Minimum duration of interlevel ad in seconds:</p>
        <input disabled readonly type="number" min="1" max="120" id="ctl-arcade-lite-id-ad-interlevel-min-time" value=7>
        <p>Insert your ad code, it will appear at the end of each game level and when users quit the game:</p>
        <textarea disabled readonly rows="3" cols="50" id="ctl-arcade-lite-id-ad-interlevel-code"></textarea>
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>

        <h3>Leaderboard Style</h3>
        <ul class="ctl-arcade-lite-admin-rank-colors">
            <li><input disabled readonly type="radio" name="rank-style" value="green" />green<div class="ctl-arcade-lite-admin-rank-preview-green">
                    <span></span><span></span></div>
            </li>
            <li><input disabled readonly type="radio" name="rank-style" value="red" />red<div class="ctl-arcade-lite-admin-rank-preview-red">
                    <span></span><span></span></div>
            </li>
            <li><input disabled readonly type="radio" name="rank-style" value="orange" />orange<div class="ctl-arcade-lite-admin-rank-preview-orange">
                    <span></span><span></span></div>
            </li>
            <li><input disabled readonly type="radio" name="rank-style" value="pink" />pink<div class="ctl-arcade-lite-admin-rank-preview-pink">
                    <span></span><span></span></div>
            </li>
            <li><input disabled readonly type="radio" name="rank-style" value="violet" />violet<div class="ctl-arcade-lite-admin-rank-preview-violet">
                    <span></span><span></span></div>
            </li>
            <li><input disabled readonly type="radio" name="rank-style" value="blue" />blue<div class="ctl-arcade-lite-admin-rank-preview-blue">
                    <span></span><span></span></div>
            </li>
            <li><input disabled readonly type="radio" name="rank-style" value="gray" />gray<div class="ctl-arcade-lite-admin-rank-preview-gray">
                    <span></span><span></span></div>
            </li>
        </ul>
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>
        
        <h3>Extra Css</h3>
        <p>Override our styles here:</p>
        <textarea disabled readonly rows="10" cols="50" id="ctl-arcade-lite-id-extra-css-value"></textarea>
        <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">Buy a CTL Arcade License to unlock this feature!</a>
        
        <p class="ctl-arcade-lite-alert">Before installing CTL Arcade (full version), please uninstall CTL Arcade Lite</p>
        
        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games" class="ctl-arcade-lite-btn">games list</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>      
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
               class="ctl-arcade-lite-btn">about us</a>
               <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>       
        </div>

    <?php

    }