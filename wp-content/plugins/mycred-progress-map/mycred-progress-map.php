<?php

/**
 * Plugin Name: myCred Progress Map
 * Plugin URI: https://mycred.me
 * Description: Adding progress map to badges
 * Version: 1.0
 * Tags: point, badges
 * Author: myCRED
 * Author URI: https://mycred.me
 * Author Email: support@mycred.me
 * Requires at least: WP 4.8
 * Tested up to: WP 5.3.2
 * Text Domain: mycred-progress-map
 */
if (!defined('ABSPATH'))
    exit;
if (!defined('MYCRED_PROGRESS_MAP_DIR'))
    define('MYCRED_PROGRESS_MAP_DIR', plugin_dir_path(__FILE__));

if (!class_exists('MyCred_Progress_Map')) :

    class MyCred_Progress_Map {

        // Plugin Version
        public $version = '1.0';

        public function __construct() {

            $this->define_constants();
            $this->load_license();

            load_plugin_textdomain('mycred-progress-map', false, MYCRED_PROGRESS_MAP_DIR . 'languages');
            add_action('plugins_loaded', array($this, 'mycred_progress_map_init'));
        
        }

        /**
         * Define Constants
         * @since 1.0
         * @version 1.0
         */
        private function define_constants() {

            define( 'MYCRED_PROGRESS_MAP_VERSION', $this->version );
            define( 'MYCRED_PROGRESS_MAP_SLUG',    'mycred-progress-map' );
            define( 'MYCRED_PROGRESS_MAP',         __FILE__ );

        }

        /**
         * Load Plugin License
         * @since 1.0
         * @version 1.0
         */
        private function load_license() {
            
            require_once MYCRED_PROGRESS_MAP_DIR . 'license/license.php';

        }

        public function mycred_progress_map_init() {
            if (!class_exists('myCRED_Addons_Module')) {
                add_action('admin_notices', array($this, 'require_mycred_to_be_installed'));
                return;
            }
            if (class_exists('myCRED_Addons_Module')) {
                $obj = new myCRED_Addons_Module();
                if ($obj->is_active($id = 'badges') == false) {
                    add_action('admin_notices', array($this, 'require_badges_notice'));
                    return;
                }
            }
            require_once MYCRED_PROGRESS_MAP_DIR . 'includes/class-mycred-progress-maps.php';
        }

        /**
         * Require myCRED to be installed notice 
         */
        public function require_mycred_to_be_installed() {
            $class = 'notice notice-error';
            $message = __('mycred need to be active and installed to use mycred progress map addon', 'mycred-progress-map');

            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
        }

        /**
         * Require Badges addon to active and installed
         */
        public function require_badges_notice() {
            $class = 'notice notice-error';
            $message = __('mycred Badges need to be activated', 'mycred-progress-map');

            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
        }

    }

    new MyCred_Progress_Map;
    

    
endif;


