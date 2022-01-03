<?php
/**
 * Plugin Name: myCred Anniversary Pro
 * Description: Reward your users with points on their Anniversary.
 * Version: 1.0.0
 * Tags: points, tokens, credit, management, reward, charge, anniversary
 * Author: myCRED
 * Author URI: https://www.mycred.me
 * Author Email: support@mycred.me
 * Requires at least: WP 4.0
 * Tested up to: WP 5.8
 * Text Domain: mycred_anniversary_pro
**/

 if ( ! class_exists( 'myCRED_Anniversary_Pro' ) ) :
	final class myCRED_Anniversary_Pro {

		// Plugin Version
		public $version             = '1.0.0';

		// Instnace
		protected static $_instance = NULL;

		/**
		 * Setup Instance
		 * @since 1.0
		 * @version 1.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Not allowed
		 * @since 1.0
		 * @version 1.0
		 */
		public function __clone() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0' ); }

		/**
		 * Not allowed
		 * @since 1.0
		 * @version 1.0
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0' ); }

		/**
		 * Define
		 * @since 1.0
		 * @version 1.0
		 */
		private function define( $name, $value, $definable = true ) {
			if ( ! defined( $name ) )
				define( $name, $value );
		}

		/**
		 * Require File
		 * @since 1.0
		 * @version 1.0
		 */
		public function file( $required_file ) {
			if ( file_exists( $required_file ) )
				require_once $required_file;
		}

		/**
		 * Construct
		 * @since 1.0
		 * @version 1.0
		 */
		public function __construct() {
			$this->define_constants();
			$this->init();
			$this->includes();
		}

		/**
		 * Initialize
		 * @since 1.0
		 * @version 1.0
		 */
		private function init() {

			$this->file( ABSPATH . 'wp-admin/includes/plugin.php' );

			if ( is_plugin_active('mycred/mycred.php') ) {

				add_action( 'admin_enqueue_scripts', array( $this, 'admin_script') );
				add_filter( 'mycred_setup_hooks', array( $this, 'mycred_register_anniversary_pro' ), 90 );
				add_action( 'mycred_load_hooks',  array( $this, 'mycred_anniversary_pro_load_hook' ) );
				add_filter( 'mycred_all_references', array( $this, 'anniversary_pro_register_refrences' ) );
			}

            add_action( 'admin_notices',         array( $this, 'mycred_anniversary_pro_plugin_notices' ) );

		}


		/**
		 * Define Constants
		 * @since 1.0
		 * @version 1.0
		 */
		public function define_constants() {

			$this->define( 'myCred_anniversary_pro_VER',  $this->version );
			$this->define( 'myCred_anniversary_pro_SLUG', 'mycred-anniversary-pro' );
			$this->define( 'myCred_anniversary_pro',    __FILE__ );
			$this->define( 'myCred_anniversary_pro_ROOT_DIR',       plugin_dir_path( myCred_anniversary_pro ) );
			$this->define( 'myCred_anniversary_pro_ASSETS_DIR_URL', plugin_dir_url( myCred_anniversary_pro ) . 'assets/' );
			$this->define( 'myCred_anniversary_pro_INCLUDES_DIR',   myCred_anniversary_pro_ROOT_DIR . 'includes/' );

		}

		/**
		 * Includes
		 * @since 1.0
		 * @version 1.0
		 */
		public function includes() {

			$this->file( myCred_anniversary_pro_INCLUDES_DIR . 'mycred-anniversary-functions.php' );
		}


		/**
		 * Include Hook Files
		 * @since 1.0
		 * @version 1.0
		 */
		public function mycred_anniversary_pro_load_hook() {

			$this->file( myCred_anniversary_pro_INCLUDES_DIR . 'mycred-anniversary-hooks.php' );

		}

		/**
		 * admin-enque-scripts
		 * @since 1.0
		 * @version 1.0
		 */
		public function admin_script($hook){	
		
			if ( is_mycred_hook_page( $hook ) ) {

				wp_enqueue_style( 'mycred-anniversary-pro-style',myCred_anniversary_pro_ASSETS_DIR_URL . 'css/admin-style.css' );
				wp_enqueue_script( 'mycred-anniversary-pro-script', myCred_anniversary_pro_ASSETS_DIR_URL . 'js/admin-script.js', array('jquery') );
				
			}
			
		}

		/**
		 * Register Hook
		 * @since 1.0
		 * @version 1.0
		 */
		public function mycred_register_anniversary_pro( $installed ) {

			$installed['anniversary_pro'] = array(
				'title'         => __( '%plural% for Anniversary', 'mycred_anniversary_pro' ),
				'description'   => __( 'Reward users with points on their specific anniversary', 'mycred_anniversary_pro' ),
				'documentation' => '',
				'callback'      => array( 'myCRED_Anniversary_Hook_Class' )
			);

			if (isset( $installed['anniversary'] )) {
				
				unset( $installed['anniversary'] );
			}
			
			return $installed;

		}

		/**
		 * Add References
		 * @since 1.0
		 * @version 1.0
		 */
		public function anniversary_pro_register_refrences( $references ) {

			$references['anniversary_pro'] = __( 'Anniversary', 'mycred_anniversary_pro' );

			return $references;

		}

		public function mycred_anniversary_pro_plugin_notices() {
 
			$msg = __( 'need to be active and installed to use myCred anniversary pro plugin.', 'mycred_anniversary_pro' );
			
			if ( !is_plugin_active('mycred/mycred.php') ) {
				printf( '<div class="notice notice-error"><p><a href="https://wordpress.org/plugins/mycred/">%1$s</a> %2$s</p></div>', __( 'myCred', 'mycred_anniversary_pro' ), esc_html( $msg ) );
			}
		}
	}
endif;

function mycred_anniversary_pro_plugin() {
	return myCRED_Anniversary_Pro::instance();
}
mycred_anniversary_pro_plugin();