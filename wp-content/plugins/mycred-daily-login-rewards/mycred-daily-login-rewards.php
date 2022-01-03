<?php

/**
 * Plugin Name: myCRED Daily Login Rewards
 * Plugin URI: https://mycred.me
 * Description: myCRED Daily Login Rewards
 * Version: 1.0.0
 * Author: myCred
 * Author URI: https://www.mycred.me
 * Author Email: support@mycred.me
 * Text Domain: mycred_coupon_plus
 * Requires at least: WP 4.0
 * Tested up to: WP 5.7.2
 * License: GPLv2 or later
 */
if (!class_exists('myCRED_Daily_Login_Rewards')) :
class myCRED_Daily_Login_Rewards
{
    private static $_instance;

    public static function get_instance()
    {
        if (self::$_instance == null)
            self::$_instance = new self();

        return self::$_instance;
    }

    public function __construct()
    {
        $this->run();
    }

    public function meet_requirements()
    {
        if (!function_exists('is_plugin_active'))
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        if (!is_plugin_active('mycred/mycred.php'))
            return false;
        else
            return true;
    }

    public function run()
    {
        if (!$this->meet_requirements()) 
        {
            add_action('admin_notices', array($this, 'admin_notices'));
            return;
        }
        $this->constants();
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        $this->includes();
    }

    public function constants()
    {
        $this->define('MYCRED_DLR_VERSION', '1.0');
        $this->define('MYCRED_DLR_DIR', plugin_dir_path(__FILE__));
        $this->define('MYCRED_DLR_PREFIX', 'mycred_dlr');
        $this->define('MYCRED_DLR_PLUGIN_URL', plugin_dir_url(__FILE__));
    }

    public function define($constant = '', $value = '')
    {
        defined($constant) or define($constant, $value);
    }

    public function includes()
    {
        require_once MYCRED_DLR_DIR . 'includes/functions.php';
        require_once MYCRED_DLR_DIR . 'includes/mycred-dlr-admin.php';
        require_once MYCRED_DLR_DIR . 'includes/mycred-dlr-login-reward.php';
    }

    public function admin_enqueue_scripts()
    {
        wp_enqueue_script('jquery-ui-sortable', '', array('jquery'), false, true);

        wp_enqueue_script(MYCRED_DLR_PREFIX . '-scripts', MYCRED_DLR_PLUGIN_URL . 'assets/js/admin-scripts.js', array(), MYCRED_DLR_VERSION, true);
        
        wp_enqueue_style(MYCRED_DLR_PREFIX . '-admin-style', MYCRED_DLR_PLUGIN_URL . 'assets/css/admin-style.css', array(), MYCRED_DLR_VERSION);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(MYCRED_DLR_PREFIX . '-front-script', MYCRED_DLR_PLUGIN_URL . 'assets/js/front-script.js', array( 'jquery' ), MYCRED_DLR_VERSION);

        wp_enqueue_style(MYCRED_DLR_PREFIX . '-front-style', MYCRED_DLR_PLUGIN_URL . 'assets/css/front-style.css', array(), MYCRED_DLR_VERSION);
    }

    public function admin_notices()
    {
    ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e('In order to use myCRED Daily Login Reward, Make sure myCRED is install and active.', 'mycred-dlrewards'); ?></p>
        </div>
    <?php
    }
}
endif;

myCRED_Daily_Login_Rewards::get_instance();
