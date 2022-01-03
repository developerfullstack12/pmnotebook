<?php
/*
Plugin Name: CTL Arcade Lite
Plugin URI: http://www.codethislab.com/
Description: Install and manage high quality HTML5 games in your wordpress site.
Version: 1.0
Author: Code This Lab srl
Author URI: http://www.codethislab.com/
License: GPL
Copyright: Code This Lab srl
*/
    if ( ! defined( 'ABSPATH' ) ) { exit; }// Exit if accessed directly

    require_once("config.php");
    require_once("db.php");
    require_once("pages/manage-games.php");
    require_once("pages/settings.php");
    require_once("pages/company.php");
    require_once("pages/documentation.php");    
    require_once("front/shortcodes.php");


    function ctl_arcade_lite_remove_qs_var($url, $varname) {
        return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
    }
    function ctl_arcade_lite_menu() {
        add_menu_page(
            CTL_ARCADE_LITE_PLUGIN_NAME, CTL_ARCADE_LITE_PLUGIN_NAME, 'manage_options', 'ctl_arcade_lite_main_menu',
            "ctl_arcade_lite_load_page" , "none");

        add_submenu_page( 'ctl_arcade_lite_main_menu', "Settings", "Settings (PRO)", 'manage_options',
            'ctl_arcade_lite_main_menu', "ctl_arcade_lite_load_page" );
        add_submenu_page( 'ctl_arcade_lite_main_menu', "Manage Games", "Manage Games", 'manage_options',
            'ctl_arcade_lite_page_manage_games', 'ctl_arcade_lite_load_page' );

        add_submenu_page( 'ctl_arcade_lite_main_menu', "Documentation", "Documentation", 'manage_options',
            'ctl_arcade_lite_page_documentation', 'ctl_arcade_lite_load_page' );
        
        add_submenu_page( 'ctl_arcade_lite_main_menu', "About us", "About us", 'manage_options',
            'ctl_arcade_lite_page_company', 'ctl_arcade_lite_load_page' );
    }
    function ctl_arcade_lite_load_page(){
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        $page = filter_input(INPUT_GET, 'page');

        switch ($page) {
            case 'ctl_arcade_lite_main_menu':{
                ctl_arcade_lite_page_settings();
            }break;
            case 'ctl_arcade_lite_page_manage_games':{
                ctl_arcade_lite_page_manage_games();
            }break;
            case 'ctl_arcade_lite_page_documentation':{
                ctl_arcade_lite_page_documentation();
            }break;        
            case 'ctl_arcade_lite_page_company':{
                ctl_arcade_lite_page_company();
            }break;
        }
    }
    function ctl_arcade_lite_plugin_front_styles_and_scripts(){
        // css
        wp_register_style( 'ctl-arcade-lite-style-front-commons', plugins_url( '/css/commons.css', __FILE__ ) );
        wp_register_style( 'ctl-arcade-lite-style-front-animation', plugins_url( '/css/animation.css', __FILE__ ) );
        wp_register_style( 'ctl-arcade-lite-style-front-dingbats', plugins_url( '/css/ctl-arcade.css', __FILE__ ) );

        wp_enqueue_style( 'ctl-arcade-lite-style-front-commons' );
        wp_enqueue_style( 'ctl-arcade-lite-style-front-animation' );
        wp_enqueue_style( 'ctl-arcade-lite-style-front-dingbats' );

        // js
        wp_register_script( 'ctl-arcade-lite-script-front-commons', plugins_url( '/js/commons.js', __FILE__ ), array(
            'jquery') );
        wp_register_script( 'ctl-arcade-lite-script-front-main', plugins_url( '/js/front-main.js', __FILE__ ), array(
            'jquery') );

        wp_enqueue_script( 'ctl-arcade-lite-script-front-commons' );
        wp_enqueue_script( 'ctl-arcade-lite-script-front-main' );
    }
    function ctl_arcade_lite_plugin_admin_styles_and_scripts(){
        wp_register_style( 'ctl-arcade-lite-style-admin-commons', plugins_url( '/css/commons.css', __FILE__ ) );
        wp_register_style( 'ctl-arcade-lite-style-admin-animation', plugins_url( '/css/animation.css', __FILE__ ) );
        wp_register_style( 'ctl-arcade-lite-style-admin-dingbats', plugins_url( '/css/ctl-arcade.css', __FILE__ ) );
        wp_register_style( 'ctl-arcade-lite-style-admin-main', plugins_url( '/css/admin-main.css', __FILE__ ) );

        wp_enqueue_style( 'ctl-arcade-lite-style-admin-commons' );
        wp_enqueue_style( 'ctl-arcade-lite-style-admin-animation' );
        wp_enqueue_style( 'ctl-arcade-lite-style-admin-dingbats' );
        wp_enqueue_style( 'ctl-arcade-lite-style-admin-main' );

        // js
        wp_register_script( 'ctl-arcade-lite-script-base64', plugins_url( '/js/base64.min.js', __FILE__ ), array(
            'jquery') );
        wp_register_script( 'ctl-arcade-lite-script-commons', plugins_url( '/js/commons.js', __FILE__ ), array(
            'jquery') );
        wp_register_script( 'ctl-arcade-lite-script-admin-main', plugins_url( '/js/admin-main.js', __FILE__ ), array(
            'jquery')  );
        wp_register_script( 'ctl-arcade-lite-script-front-main', plugins_url( '/js/front-main.js', __FILE__ ), array(
            'jquery') );

        wp_enqueue_script( 'ctl-arcade-lite-script-base64' );
        wp_enqueue_script( 'ctl-arcade-lite-script-commons' );
        wp_enqueue_script( 'ctl-arcade-lite-script-admin-main' );
        wp_enqueue_script( 'ctl-arcade-lite-script-front-main' );
    }

    function ctl_arcade_lite_shortcode_init_buttons() {
        add_filter( 'mce_external_plugins', 'ctl_arcade_lite_shortcode_add_buttons' );
        add_filter( 'mce_buttons', 'ctl_arcade_lite_shortcode_register_buttons' );
    }
    function ctl_arcade_lite_shortcode_register_buttons( $buttons ) {
        array_push( $buttons,
            'ctl_arcade_lite_shortcode_add_game_iframe' );
        return $buttons;
    }
    function ctl_arcade_lite_shortcode_add_buttons( $plugin_array ) {
        $plugin_array['ctl_arcade_lite_shortcode_buttons'] = plugins_url( '/js/admin-shortcode-game.js', __FILE__ );
        return $plugin_array;
    }
    function ctl_arcade_lite_print_footer(){
        ?>
        <div class="ctl-arcade-lite-footer-copyright">
            <div>
                <span>Copyright ©</span>
                <span>Code This Lab srl 2009-<?php echo date("Y"); ?></span>
            </div>
            <div>
                <span>VAT IT06367951214</span>
                <span>REA NA810739</span>
            </div>
            <div>
                <span>cap soc. €16'000,00 i.v.</span>
            </div>
            <div>
                <a target="_blank" href="mailto:info@codethislab.com">info@codethislab.com</a>
            </div>
            <div>
                <a target="_blank" href="http://www.codethislab.com">www.codethislab.com</a>
            </div>
        </div>
        <?php
    }
    function ctl_arcade_lite_add_action_links ( $links ) {
        $mylinks = array(
            '<a href="' . admin_url() . 'admin.php?page=ctl_arcade_lite_main_menu">Settings (PRO)</a>',
            '<a href="' . admin_url() . 'admin.php?page=ctl_arcade_lite_page_manage_games">Manage Games</a>'
        );
        return array_merge( $mylinks, $links );
    }    
    
    function ctl_arcade_lite_ajax_game_widget(){

        echo ctl_arcade_lite_shortcode_composer();
        wp_die();
    }
    
    function ctl_arcade_lite_shortcode_composer(){
        ob_start();        
        global $wpdb;
        $aGames = $wpdb->get_results( "SELECT * FROM " . CTL_ARCADE_LITE_DB_TABLE_GAMES . " ORDER BY game_name ASC" );
        ?>


<div class="ctl-arcade-lite-shortcode-game-wrapper">

    <div class="ctl-arcade-lite-shortcode-game-iframe-game-filter">
        <label>Digit some letters or choose one game from the list below</label>
        <input type="text">
    </div>

<?php
    if( count($aGames) > 0 ){
?>
        <div class="ctl-arcade-lite-shortcode-game-iframe-gamelist-wrapper">
            <ul>
            <?php
        foreach( $aGames as $oGame ){
            if( is_plugin_inactive( $oGame->game_plugin_dir . "/". $oGame->game_plugin_dir .".php")){
                continue;
            }

            ?>
            <li data-game-plugin-dir="<?php echo $oGame->game_plugin_dir; ?>">
                <img width="32"
                     src="<?php echo plugins_url() . "/" . $oGame->game_plugin_dir;?>/images/<?php echo $oGame->game_plugin_dir; ?>-icon.png"/>
                <span><?php echo $oGame->game_name; ?></span>
            </li>
        <?php
        }
?>
            </ul>
            </div>



        <div class="ctl-arcade-lite-shortcode-game-iframe-game-max-height">
            <label>Game iframe max height (px)</label>
            <input type="number" class="small-text" value="1000">
        </div>
   
        <div class="ctl-arcade-lite-shortcode-game-iframe-game-max-height">
        <label>Final shortcode</label>
        <textarea rows="3" class="ctl-arcade-lite-shortcode-game-iframe-output"></textarea>
        </div>
    
        <div class="ctl-arcade-lite-shortcode-game-iframe-gamelist-btn-wrapper">
            <div onclick="ctl_arcade_lite_shortcode_game_iframe_insert()" class="button button-primary">insert</div>
            <div onclick="ctl_arcade_lite_shortcode_game_iframe_close();" class="button">close</div>
        </div>

            <?php

    }else{
    ?>
        <h3>There are no games installed!</h3>
        <p>Go to the <a target="_self" href="<?php echo admin_url()."plugins.php"; ?>">plugin page</a> to enable games for CTL Arcade Plugin or buy games from <a href="http://codecanyon.net/user/codethislab/portfolio" target="_blank">our full catalogue</a></p>
    <?php
    }
?>
</div>

    <?php
        return ob_get_clean();
    }
  
    
    function ctl_arcade_lite_print_image_url(){
        echo plugins_url() . "/ctl-arcade-lite/images";        
    }
    

    add_action( 'wp_enqueue_scripts', 'ctl_arcade_lite_plugin_front_styles_and_scripts' );
    add_action( 'admin_init', 'ctl_arcade_lite_plugin_admin_styles_and_scripts' );
    add_action( 'admin_menu', 'ctl_arcade_lite_menu' );
    add_action( 'plugins_loaded', 'ctl_arcade_lite_update_db_check');
    add_action( 'init', 'ctl_arcade_lite_shortcode_init_buttons' );    

    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ctl_arcade_lite_add_action_links' );

    register_activation_hook( __FILE__, 'ctl_arcade_lite_install_db_schema' );
    
    add_shortcode( 'ctl_arcade_lite_game', 'ctl_arcade_lite_print_shortcode' );    
    
    add_action( 'wp_ajax_ctl-arcade-lite', 'ctl_arcade_lite_ajax_game_widget' );   
    add_action( 'wp_ajax_nopriv_ctl-arcade-lite', 'ctl_arcade_lite_ajax_game_widget' );       
    
  