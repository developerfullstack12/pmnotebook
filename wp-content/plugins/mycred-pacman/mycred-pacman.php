<?php
/**
 * Plugin Name: myCred Pacman
 * Description: Earn MyCred points by playing Pacman.
 * Version: 2.0
 * Tags: pacman, mycred
 * Author Email: support@mycred.me
 * Author: myCred
 * Author URI: http://mycred.me
 * License: Copyrighted
 */
if ( ! class_exists( 'myCRED_Pacman' ) ) :
	final class myCRED_Pacman {

		// Plugin Version
		public $version             = '2.0';

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
		public function __clone() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->version ); }

		/**
		 * Not allowed
		 * @since 1.1.2
		 * @version 1.0
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->version ); }

		/**
		 * Define
		 * @since 1.1.2
		 * @version 1.0
		 */
		private function define( $name, $value, $definable = true ) {
			if ( ! defined( $name ) )
				define( $name, $value );
			elseif ( ! $definable && defined( $name ) )
				_doing_it_wrong( 'define->define()', 'Could not define: ' . $name . ' as it is already defined somewhere else!', $this->version );
		}

		/**
		 * Require File
		 * @since 1.1.2
		 * @version 1.0
		 */
		public function file( $required_file ) {
			if ( file_exists( $required_file ) )
				require_once $required_file;
			else
				_doing_it_wrong( 'myCRED_Pacman->file()', 'Requested file ' . $required_file . ' not found.', $this->version );
		}

		/**
		 * Construct
		 * @since 1.0
		 * @version 1.0
		 */
		public function __construct() {
			$this->define_constants();
			$this->load_module();

			add_action( 'wp_enqueue_scripts', array( $this, 'MYCRED_PACMAN_scripts' ) ); // wp_enqueue_script
			
		}
		
		
		/**
		 * Enqueue All PACMAN related scripts
		**/
		public function MYCRED_PACMAN_scripts() {
			$pacman_settings=get_option( 'pacman_settings' );
			$lives=$pacman_settings['pacman']['lives'];
			$game_over_color=$pacman_settings['pacman']['game_over_color'];
			$game_over_label=$pacman_settings['pacman']['game_over_label'];
			$walls_color=$pacman_settings['pacman']['walls_color'];
			$bubbles_color=$pacman_settings['pacman']['bubbles_color'];
			$background_color=$pacman_settings['pacman']['background_color'];
			$text_color=$pacman_settings['pacman']['text_color'];

			if(empty($lives)){
				$lives="2";
			}
			if(empty($game_over_color)){
				$game_over_color="Red";
			}
			if(empty($game_over_label)){
				$game_over_label="Game Over";
			}
			if(empty($walls_color)){
				$walls_color="Purple";
			}
			if(empty($bubbles_color)){
				$bubbles_color="White";
			}
			if(empty($background_color)){
				$background_color="Black";
			}
			if(empty($text_color)){
				$text_color="Brown";
			}
			$pacman_popup_or_page=isset($pacman_settings['pacman']['pacman_popup_or_page']) ? $pacman_settings['pacman']['pacman_popup_or_page'] : 'popup' ;

			if($pacman_popup_or_page == 'page'){
				wp_enqueue_style( 'mycred-pacman-page',  plugins_url('assets/css/pacman-page.css',__FILE__ ), array(), $this->version );
				wp_enqueue_style( 'mycred-pacman-home-page',  plugins_url('assets/css/pacman-home-page.css',__FILE__ ), array(), $this->version );
				wp_register_script( 'mycred-custom-page-js', plugins_url('assets/js/custom-page.js',__FILE__ ), array(), $this->version );
				wp_localize_script('mycred-custom-page-js', 'assets', array(
				'pluginsurl' => plugins_url('',__FILE__),
				'background_color' => $background_color,
				'text_color' => $text_color
				));
			} else {
				wp_enqueue_style( 'mycred-pacman',  plugins_url('assets/css/pacman.css',__FILE__ ), array(), $this->version );
				wp_enqueue_style( 'mycred-pacman-home',  plugins_url('assets/css/pacman-home.css',__FILE__ ), array(), $this->version );
				wp_register_script( 'mycred-custom-js', plugins_url('assets/js/custom.js',__FILE__ ), array(), $this->version );
				wp_localize_script('mycred-custom-js', 'assets', array(
				'pluginsurl' => plugins_url('',__FILE__),
				'background_color' => $background_color,
				'text_color' => $text_color
				));
			}

			wp_enqueue_script( 'jquery' );
			
			wp_register_script( 'mycred-jquery-buzz', plugins_url('assets/js/jquery-buzz.js',__FILE__ ) );
			wp_register_script( 'mycred-game', plugins_url('assets/js/game.js',__FILE__ ), array(), $this->version );
			wp_localize_script('mycred-game', 'game', array(
	'ajax_url' => admin_url( 'admin-ajax.php' ),
	'nonce' => wp_create_nonce( 'paCman_updAte' ),
	'lives' => $lives,
	'game_over_color' => $game_over_color,
	'game_over_label' => $game_over_label,
	'pause_translation' => __('Pause', 'mycred-pacman'),
	'ready_translation' => __('Ready', 'mycred-pacman'),
	));
			wp_register_script( 'mycred-tools', plugins_url('assets/js/tools.js',__FILE__ ), array(), $this->version );
			wp_register_script( 'mycred-board', plugins_url('assets/js/board.js',__FILE__ ), array(), $this->version );
			wp_localize_script('mycred-board', 'color', array(
	'walls_color' => $walls_color
	));
			wp_register_script( 'mycred-paths', plugins_url('assets/js/paths.js',__FILE__ ), array(), $this->version );
			wp_register_script( 'mycred-bubbles', plugins_url('assets/js/bubbles.js',__FILE__ ), array(), $this->version );
			wp_localize_script('mycred-bubbles', 'color', array(
	'bubbles_color' => $bubbles_color
	));
			wp_register_script( 'mycred-fruits', plugins_url('assets/js/fruits.js',__FILE__ ), array(), $this->version );
			wp_register_script( 'mycred-pacman', plugins_url('assets/js/pacman.js',__FILE__ ), array(), $this->version );
			wp_register_script( 'mycred-ghosts', plugins_url('assets/js/ghosts.js',__FILE__ ), array(), $this->version );
			wp_register_script( 'mycred-home', plugins_url('assets/js/home.js',__FILE__ ), array(), $this->version );
			wp_register_script( 'mycred-sound', plugins_url('assets/js/sound.js',__FILE__ ), array(), $this->version );
			wp_localize_script('mycred-sound', 'sounds', array(
    'pluginsurl' => plugins_url('',__FILE__)));
	
			
		}

		/**
		 * Define Constants
		 * @since 1.0
		 * @version 1.0
		 */
		private function define_constants() {

			$this->define( 'MYCRED_PACMAN_VERSION',        $this->version );
			$this->define( 'MYCRED_PACMAN_SLUG',          'mycred-pacman' );
			$this->define( 'MYCRED_DEFAULT_TYPE_KEY',  	 'mycred_default' );

			$this->define( 'MYCRED_PACMAN',               __FILE__ );
			$this->define( 'MYCRED_PACMAN_ROOT',          plugin_dir_path( MYCRED_PACMAN  ) );
			$this->define( 'MYCRED_PACMAN_INCLUDE', plugin_dir_path( MYCRED_PACMAN ) . 'inc/' );
			$this->define( 'MYCRED_PACMAN_ASSETS', plugin_dir_path( MYCRED_PACMAN)  . 'assets/' );
			
			
		}
		
		/**
		 * Load Module
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_module() {

			$this->file( MYCRED_PACMAN_ROOT . 'license/license.php' );
			$this->file( MYCRED_PACMAN_INCLUDE . 'pacman-hooks.php' );
			$this->file( MYCRED_PACMAN_INCLUDE . 'shortcode.php' );
			$this->file( MYCRED_PACMAN_INCLUDE . 'class-pacman-settings.php' );
			$this->file( MYCRED_PACMAN_INCLUDE . 'pacman-functions.php' );

		}

	}
endif;

function myCRED_Pacman_plugin() {
	return myCRED_Pacman::instance();
}
add_action( 'mycred_init', 'myCRED_Pacman_plugin' );


function mycred_pacman_notice__error() {

	if(!class_exists('myCRED_Core')){
		$class = 'notice notice-error';
    	$message = __( 'Mycred Pacman Requires mycred to be installed and activated.', 'mycred-pacman' );
 
    	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}
	
    
}
add_action( 'admin_notices', 'mycred_pacman_notice__error' );