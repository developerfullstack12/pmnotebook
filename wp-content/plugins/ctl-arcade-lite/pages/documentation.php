<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function ctl_arcade_lite_page_documentation(){
    ?>


<div class="ctl-arcade-lite-documentation ctl-arcade-lite-wrapper">

    <h2 class="jump-about-this-plugin ctl-doc-title">About this Plugin</h2>
    
    <div class="ctl-arcade-lite-game-settings-btn-wrapper">
        <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_main_menu"
           class="ctl-arcade-lite-btn">plugin settings</a>
        <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games" class="ctl-arcade-lite-btn">games list</a>
        <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>
        <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
           class="ctl-arcade-lite-btn">about us</a>
       <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>                             
    </div>
    
    <p>CTL Arcade will allow you to add a real arcade on your worpress website, in this way your users will be more involved and will stay connected longer.</p>

    <p>It's possible to add Ads banner at the beginning of each game and at the end of each level. This will give you a new tool to increase your revenues.</p>

    <p>Your own users will promote your website sharing their scores on the main Social Networks, with no extra costs for you.</p>

    <p>You'll get by default the score-sharing on Twitter. To add Facebook just follow the guideline below.</p>

    <p>3 widgets can be added in your pages through a shortcode:</p>

    <ul class="ctl-arcade-lite-documentation-list">
        <li>Game iframe</li>
        <li>Rate the Game</li>
        <li>Leaderboard</li>
    </ul>

    <p>Minimum Requirements:</p>

    <ul class="ctl-arcade-lite-documentation-list">
        <li>PHP 4.3</li>
        <li>WordPress 4.3.1</li>
        <li>HTML5</li>
        <li>Canvas</li>
        <li>Javascript / jQuery</li>
    </ul>

    <p><strong>This plugin is designed to work only with games built by Code This Lab.</strong></p>

    <p><strong><a target="_blank" href="http://codecanyon.net/collections/5401443-ctl-arcade-lite-plugin?ref=codethislab">Check all available games here.</a></strong></p>

    <h2 class="jump-installation ctl-doc-title">Installation</h2>


    <p class="ctl-arcade-lite-alert">Before installing CTL Arcade, please uninstall CTL Arcade Lite</p>

    <p>This plugin installation is the same as any other WordPress plugin. For further instructions, refer to the two options below:</p>

    <h3>Installation by ZIP File</h3>

    <p>From your WordPress dashboard, choose 'Add New' under the 'Plugins' category.<br>
    Select 'Upload' from the set of links at the top of the page (the second link).<br>
    From here, search the zip file titled 'ctl-arcade.zip' included in your plugin purchase and click the 'Install Now' button.<br>
    Once installation is complete, activate the plugin to enable its features.</p>

    <h3>Installation by FTP</h3>

    <p>Find the directoy titled 'ctl-arcade'.<br>
                Upload it and all the files in the plugins directory of your WordPress.<br>
                Install (/WORDPRESS-DIRECTORY/wp-content/plugins/).<br>
    From your WordPress dashboard, choose 'Installed Plugins' under the 'Plugins' category.<br>
    Locate the newly added plugin and click on the 'Activate' link to enable its features.</p>

    <h2 class="jump-plugin-settings ctl-doc-title">Plugin Settings</h2>

    <p>In this panel you can manage all the plugin features.</p>

    <div class="ctl-arcade-lite-img-guide">
        <img class="ctl-arcade-lite-img-responsive" src="<?php ctl_arcade_lite_print_image_url(); ?>/plugin_settings.png"/>
    </div>

    <h3>Empty Scores</h3>

    <p>Please Note:</p>

    <p class="alert-msg">This action is not reversible! All user's scores will be deleted!</p>

    <h3>Empty Ratings</h3>

    <p>Please Note:</p>

    <p class="alert-msg">This action is not reversible! All user's ratings will be deleted!</p>

    <h3>Facebook app id</h3>

    <p>If you want your users to share on Facebook their scores, add the app id of your website, or create a new one!</p>

    <p>It's totally free and will allow you to get free traffic from Facebook.</p>

    <p>Follow the guideline on <a href="https://developers.facebook.com/apps/" target="_blank">https://developers.facebook.com/apps/</a> to create a Facebook App for your website.</p>

    <p>Here is a useful guide created by<strong> TheFBDirectory</strong></p>

    <iframe class="youtube-video" width="560" height="315" src="https://www.youtube.com/embed/V97h03H21y0" frameborder="0" allowfullscreen></iframe>

    <h3>Styles</h3>

    <h4>Leaderboard Style</h4>

    <p>7 available colors to customize the widgets and the CTL Arcade buttons, choose the one that fits better with your website theme.</p>

    <p>If you don't like the default colors, you can customize the css in the dedicated section.</p>

    <h4>Extra CSS</h4>

    <p>In this field you can override the styles of CTL Arcade. You need good css3 skills to make these changes.</p>

    <p>Refer to <strong>admin-main.css</strong>, <strong>commons.css</strong> files in the folder /WORDPRESS-DIRECTORY/wp-content/plugins/ctl-arcade-lite-lite/css/ before the override.</p>


    <h3>Ads</h3>

    <p>CTL Arcade allows you to monetize with your games!</p>

    <p>You just need to set your Ads codes, your games will be already optimized to show Ads in the right spots.</p>

    <p>This plugin was tested with Adsense and Cpmstar.</p>

    <h4>Minimum time between ads</h4>

    <p>You can set the time between two Ads Banners, in this way you won't run the risk of bothering your users.</p>

    <h4>Preloader AD minimum duration</h4>

    <p>The preloader appears at the beginning of each game. This Ad is seen at least one time by all users when the game starts.</p>

    <p>In this field you can set the minimum duration of the Ad before users could skip it.</p>

    <h4>Preloader AD code</h4>

    <p>Add in this field the html/js code of your banner.</p>


    <h4>Interlevel AD minimum duration</h4>

    <p>The interlevel appears at the end of each game level and when users quit the game.</p>

    <p>In this field you can set the minimum duration of the Ad before users could skip it.</p>

    <h4>Interlevel AD code</h4>

    <p>Add in this field the html/js code of your banner.</p>

    <h2 class="jump-install-games ctl-doc-title">Install Games</h2>

    <p>Each game plugin installation is the same as any other WordPress plugin. We recommend to install them from zip file and after the installation of CTL Arcade Plugin.</p>


    <h2 class="jump-manage-games ctl-doc-title">Manage Games</h2>

    <p>In this section you can manage your Arcade.</p>

    <div class="ctl-arcade-lite-img-guide">
        <img class="ctl-arcade-lite-img-responsive" src="<?php ctl_arcade_lite_print_image_url(); ?>/manage_games.png"/>
    </div>



    <h3>List of installed games</h3>

    <p>In this list you'll find all the installed games. You can search it by name or the tags defined by Code This Lab.</p>

    <p>The button under the game icon allows you to activate/deactivate your game quickly.</p>

    <p class="alert-msg">Remember that in pages containing shortcodes of disabled games, will occur an error message. </p>

    <h3>Full compatible games</h3>

    <p>In this section will appear all the games compatible with your CTL Arcade Plugin that haven't been installed yet.</p>

    <p>You will be able to buy them easily and safely on <a target="_blank" href="http://codecanyon.net/collections/5401443-ctl-arcade-lite-plugin-game-list?ref=codethislab">CodeCanyon.net</a>.</p>

    <p><strong>Keep always an eye on this section because every month new games to install will be available.</strong></p>


    <h2 class="jump-game-settings ctl-doc-title">Game Settings</h2>

    <p>In this section you will access to the setting of each game.</p>

    <div class="ctl-arcade-lite-img-guide">
        <img class="ctl-arcade-lite-img-responsive" src="<?php ctl_arcade_lite_print_image_url(); ?>/game_settings.png"/>
    </div>

    <h3>Status</h3>

    <p>With this toggle you can enable/disable the game.</p>

    <h3>Empty Scores</h3>

    <p>Please note:</p>

    <p class="alert-msg">This action is not reversible! All game scores will be deleted!</p>

    <h3>Empty Ratings</h3>

    <p>Please note:</p>

    <p class="alert-msg">This action is not reversible! All game ratings will be deleted!</p>

    <h3>Testing</h3>

    <p>Play the game before publishing it on your website.</p>

    <h3>Rating</h3>

    <p>This widget allows to rate the game. You can view the current number of votes.</p>

    <h3>Leaderboard</h3>

    <p>This is the game ranking, you can filter the best scores by week, month and all time.</p>

    <h2 class="jump-shortcodes ctl-doc-title">Shortcodes</h2>

    <p>It's time to give life to your games!</p>

    <div class="ctl-arcade-lite-img-guide">
        <img class="ctl-arcade-lite-img-responsive" src="<?php ctl_arcade_lite_print_image_url(); ?>/shortcode_general.png"/>
    </div>

    <p>This plugin installs 3 buttons on Wordpress Visual Editor:</p>

    <ul class="ctl-arcade-lite-documentation-list">
        <li>Game Widget</li>
        <li>Game Rating</li>
        <li>Game Leaderboard</li>
    </ul>

    <p class="alert-msg">Please note, you can install only one kind of widget for each page.</p>

    <h3>Game Widget</h3>

    <div class="ctl-arcade-lite-img-guide">
        <img class="ctl-arcade-lite-img-responsive" src="<?php ctl_arcade_lite_print_image_url(); ?>/shortcode_game_widget.png"/>
    </div>

    <p>Choose the game among those already installed.</p>

    <p>You can set a maximum height for the game.</p>

    <p>The game in the website will resize according to its aspect ratio.</p>

    <p>Once clicked on the game, click <strong>insert</strong> to place the shortcode into the content.</p>

    <h3>Game Rating</h3>

    <div class="ctl-arcade-lite-img-guide">
        <img class="ctl-arcade-lite-img-responsive" src="<?php ctl_arcade_lite_print_image_url(); ?>/shortcode_game_rating.png"/>
    </div>

    <p>Choose the game among those already installed.</p>

    <p>Once clicked on the game, click <strong>insert</strong> to place the shortcode into the content.</p>

    <h3>Game Leaderboard</h3>

    <div class="ctl-arcade-lite-img-guide">
        <img class="ctl-arcade-lite-img-responsive" src="<?php ctl_arcade_lite_print_image_url(); ?>/shortcode_game_rank.png"/>
    </div>

    <p>Choose the game among those already installed.</p>

    <p>You can set the default ranking period and the number of scores to show (max 50).</p>

    <p>Once clicked on the game, click <strong>insert</strong> to place the shortcode into the content.</p>

    <h2 class="jump-uninstall ctl-doc-title">Uninstall</h2>

    <p class="alert-msg">When you unistall the plugin or a game, you'll lose all stored data!</p>

    <p class="alert-msg">Be careful before uninstalling the program!</p>

    <h2 class="jump-credits ctl-doc-title">Credits</h2>

    <p>We used the following resources to create this guide and plugin.

    <ul>
        <li><a target="_blank" href="https://www.youtube.com/user/thefbdirectory">TheFBDirectory</a></li>
    </ul>

    <p>Thank you very much for purchasing this plugin. We'd be glad to help you if you have any questions related to the plugin. We'll do our best to assist you. If you have a more general question about the plugins on CodeCanyon, you might consider visiting the forums and asking your question in the "Item Discussion" section.</p>



</div>
        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_main_menu"
               class="ctl-arcade-lite-btn">plugin settings</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games" class="ctl-arcade-lite-btn">games list</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
               class="ctl-arcade-lite-btn">about us</a>
           <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>                             
        </div>
<?php
    ctl_arcade_lite_print_footer();    
}