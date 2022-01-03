<?php
/**
 * Plugin Name: myCred Social Proof
 * Version: 1.2.3
 * Description: myCred social proof builds instant credibility for your business. Grab the attention and engage your visitors with real-time notifications and let them experience your user’s activities.
 * Author: myCred
 * Author URI: https://mycred.me
 */

define('MYCRED_SP_SLUG','mycred-social-proof');
define('MYCRED_SP_VERSION','1.2.3');
define('MYCRED_SP_THIS',__FILE__);

include 'license/license.php';

function mycred_sp_load_addon() {

    add_action('wp_enqueue_scripts','mycred_sp_load_scrpits_styles');
    add_action('admin_enqueue_scripts','mycred_sp_load_setting_styles');

    include 'includes/mycred-social-share-popup.php';
    include 'includes/mycred-social-share-settings.php';
}
mycred_sp_load_addon();

function mycred_sp_load_scrpits_styles() {
    
    wp_enqueue_script( 'jquery' );
    wp_register_script( 'mycred-social-proof-js', plugins_url( 'assets/js/script.js', __FILE__ ) );

    $mycred_notify = mycred_get_option('mycred_pref_core');
    $on_screen_time = ( isset( $mycred_notify['mycred_popup_notify']['on_screen_time'] ) && !empty( $mycred_notify['mycred_popup_notify']['on_screen_time'] ) ? $mycred_notify['mycred_popup_notify']['on_screen_time'] . '000' : '5000' );
    $interval_time = ( isset( $mycred_notify['mycred_popup_notify']['interval_time'] ) && !empty( $mycred_notify['mycred_popup_notify']['interval_time'] ) ? $mycred_notify['mycred_popup_notify']['interval_time'] . '000' : '2000' );
    $theme = ( isset( $mycred_notify['mycred_popup_notify']['theme'] ) && !empty( $mycred_notify['mycred_popup_notify']['theme'] ) ? $mycred_notify['mycred_popup_notify']['theme'] : 'light_theme' );
    $border_style = ( isset( $mycred_notify['mycred_popup_notify']['border_style'] ) && !empty( $mycred_notify['mycred_popup_notify']['border_style'] ) ? $mycred_notify['mycred_popup_notify']['border_style'] : 'round' );
    $mycred_popup = array(
        'on_screen_time' => $on_screen_time,
        'interval' => $interval_time,
        'theme' => $theme,
        'border_style' => $border_style
    );
    wp_localize_script( 'mycred-social-proof-js', 'mycred_popup', $mycred_popup );

    wp_enqueue_script( 'mycred-social-proof-js' );
    wp_enqueue_style( 'mycred-social-proof-css', plugins_url( 'assets/css/style.css', __FILE__ ) );
}

function mycred_sp_load_setting_styles() {
    wp_enqueue_style( 'mycred-social-proof-setting-css', plugins_url( 'assets/css/admin-style.css', __FILE__ ) );
    wp_enqueue_script( 'mycred-social-proof-setting-js', plugins_url( 'assets/js/admin-script.js', __FILE__ ) );
}