<?php
/**
 * Plugin Name: myCRED for Courseware
 * Plugin URI: http://mycred.me
 * Description: Allows you to reward users points for courses, modules or units.
 * Version: 1.1.1
 * Tags: mycred, points, course, module, unit
 * Author: myCRED
 * Author URI: https://mycred.me
 * Author Email: support@mycred.me
 * Text Domain: mycred_courseware
 * Tested up to: 5.8.1
 * Domain Path: /lang
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
if ( ! class_exists( 'myCRED_WP_Courseware' ) ) :
	final class myCRED_WP_Courseware {

		// Plugin Version
		public $version             = '1.1.1';

		// Instnace
		protected static $_instance = NULL;

		// Current session
		public $session             = NULL;

		public $slug                = '';
		public $domain              = '';
		public $plugin              = NULL;
		public $plugin_name         = '';

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

			$this->slug        = 'mycred-courseware';
			$this->plugin      = plugin_basename( __FILE__ );
			$this->domain      = 'mycred_courseware';
			$this->plugin_name = 'myCRED for Courseware';

			$this->define_constants();

			add_filter( 'mycred_setup_hooks',    array( $this, 'register_hook' ) );
			add_action( 'mycred_init',           array( $this, 'load_textdomain' ) );
			add_action( 'mycred_all_references', array( $this, 'add_badge_support' ) );
			add_action( 'mycred_load_hooks',    'mycred_load_courseware_hook' );

		}

		/**
		 * Define Constants
		 * @since 1.0
		 * @version 1.0
		 */
		public function define_constants() {

			$this->define( 'MYCRED_COURSEWARE_SLUG',  $this->slug );
			$this->define( 'MYCRED_DEFAULT_TYPE_KEY', 'mycred_default' );

		}

		/**
		 * Includes
		 * @since 1.0
		 * @version 1.0
		 */
		public function includes() { }

		/**
		 * Load Textdomain
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_textdomain() {

			// Load Translation
			$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );

			load_textdomain( $this->domain, WP_LANG_DIR . '/' . $this->slug . '/' . $this->domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $this->domain, false, dirname( $this->plugin ) . '/lang/' );

		}

		/**
		 * Register Hook
		 * @since 1.0
		 * @version 1.0
		 */
		public function register_hook( $installed ) {

			if ( ! function_exists( 'WPCW_plugin_init' ) ) return $installed;

			$installed['courseware'] = array(
				'title'       => __( 'Courseware', $this->domain ),
				'description' => __( 'Award or deduct %plural% for users completing Courseware courses, modules or units.', $this->domain ),
				'callback'    => array( 'myCRED_Hook_CourseWare' )
			);

			return $installed;

		}

		/**
		 * Add Badge Support
		 * @since 1.0
		 * @version 1.0
		 */
		public function add_badge_support( $references ) {

			if ( ! function_exists( 'WPCW_plugin_init' ) ) return $references;

			$references['completing_unit']   = __( 'Completing Unit (Courseware)', $this->domain );
			$references['completing_module'] = __( 'Completing Module (Courseware)', $this->domain );
			$references['completing_course'] = __( 'Completing Course (Courseware)', $this->domain );

			return $references;

		}

	}
endif;

function mycred_wp_courseware_plugin() {
	return myCRED_WP_Courseware::instance();
}
mycred_wp_courseware_plugin();

/**
 * Courseware Hook
 * @since 1.0
 * @version 1.0
 */
if ( ! function_exists( 'mycred_load_courseware_hook' ) ) :
	function mycred_load_courseware_hook() {

		if ( class_exists( 'myCRED_Hook_CourseWare' ) || ! function_exists( 'WPCW_plugin_init' ) ) return;

		class myCRED_Hook_CourseWare extends myCRED_Hook {

			/**
			 * Construct
			 */
			function __construct( $hook_prefs, $type = MYCRED_DEFAULT_TYPE_KEY ) {

				parent::__construct( array(
					'id'       => 'courseware',
					'defaults' => array(
						'unit'    => array(
							'creds'   => 1,
							'log'     => '%plural% for completing unit'
						),
						'module'  => array(
							'creds'   => 1,
							'log'     => '%plural% for completing module'
						),
						'course'  => array(
							'creds'   => 1,
							'log'     => '%plural% for completing course'
						)
					)
				), $hook_prefs, $type );

			}

			/**
			 * Run
			 * @since 1.0
			 * @version 1.0
			 */
			public function run() {

				if ( $this->prefs['unit']['creds'] != 0 )
					add_action( 'wpcw_user_completed_unit',   array( $this, 'completed_unit' ), 10, 3 );

				if ( $this->prefs['module']['creds'] != 0 )
					add_action( 'wpcw_user_completed_module', array( $this, 'completed_module' ), 10, 3 );

				if ( $this->prefs['course']['creds'] != 0 )
					add_action( 'wpcw_user_completed_course', array( $this, 'completed_course' ), 10, 3 );

			}

			/**
			 * Unit Hook
			 * @since 1.0
			 * @version 1.0
			 */
			public function completed_unit( $user_id, $unit_id, $parent = '' ) {

				// Check for exclusion
				if ( $this->core->exclude_user( $user_id ) === true ) return;

				// Prevent duplicates
				if ( $this->has_entry( 'completing_unit', $unit_id, $user_id ) ) return;

				// Execute
				$this->core->add_creds(
					'completing_unit',
					$user_id,
					$this->prefs['unit']['creds'],
					$this->prefs['unit']['log'],
					$unit_id,
					array( 'module' => $parent->parent_module_id, 'course' => $parent->parent_course_id ),
					$this->mycred_type
				);

			}

			/**
			 * Module Hook
			 * @since 1.0
			 * @version 1.0
			 */
			public function completed_module( $user_id, $module_id, $unitParentData = '' ) {

				// Check for exclusion
				if ( $this->core->exclude_user( $user_id ) === true ) return;

				// Prevent duplicates
				if ( $this->has_entry( 'completing_module', $module_id, $user_id ) ) return;

				// Execute
				$this->core->add_creds(
					'completing_module',
					$user_id,
					$this->prefs['module']['creds'],
					$this->prefs['module']['log'],
					$module_id,
					array( 'ref_type' => 'post' ),
					$this->mycred_type
				);

			}

			/**
			 * Course Hook
			 * @since 1.0
			 * @version 1.0
			 */
			public function completed_course( $user_id, $course_id, $unitParentData = '' ) {

				// Check for exclusion
				if ( $this->core->exclude_user( $user_id ) === true ) return;

				// Prevent duplicates
				if ( $this->has_entry( 'completing_course', $course_id, $user_id ) ) return;

				// Execute
				$this->core->add_creds(
					'completing_course',
					$user_id,
					$this->prefs['course']['creds'],
					$this->prefs['course']['log'],
					$course_id,
					array( 'ref_type' => 'post' ),
					$this->mycred_type
				);

			}

			/**
			 * Preferences
			 * @since 1.0
			 * @version 1.0
			 */
			public function preferences() {

				$prefs = $this->prefs;

?>
<label class="subheader"><?php _e( 'Completing Unit', 'mycred_courseware' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'unit' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'unit' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['unit']['creds'] ); ?>" size="8" /></div>
	</li>
</ol>
<label class="subheader"><?php _e( 'Log Template', 'mycred_courseware' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'unit' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'unit' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['unit']['log'] ); ?>" class="long" /></div>
		<span class="description"><?php echo $this->available_template_tags( array( 'general' ) ); ?></span>
	</li>
</ol>
<label class="subheader"><?php _e( 'Completing Module', 'mycred_courseware' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'module' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'module' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['module']['creds'] ); ?>" size="8" /></div>
	</li>
</ol>
<label class="subheader"><?php _e( 'Log Template', 'mycred_courseware' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'module' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'module' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['module']['log'] ); ?>" class="long" /></div>
		<span class="description"><?php echo $this->available_template_tags( array( 'general' ) ); ?></span>
	</li>
</ol>
<label class="subheader"><?php _e( 'Completing Course', 'mycred_courseware' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'course' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'course' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['course']['creds'] ); ?>" size="8" /></div>
	</li>
</ol>
<label class="subheader"><?php _e( 'Log Template', 'mycred_courseware' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'course' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'course' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['course']['log'] ); ?>" class="long" /></div>
		<span class="description"><?php echo $this->available_template_tags( array( 'general' ) ); ?></span>
	</li>
</ol>
<?php

			}

		}

	}
endif;
