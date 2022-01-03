<?php
/**
* Plugin Name: RS Framework
* Plugin URI: https://codecanyon.net/user/rs-theme
* Description: RS Framework plugin for page metabox
* Version: 1.0
* Author: RS Theme
* Author URI: http://www.rstheme.com
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die( 'You shouldnt be here' );
}

/**
* Function when plugin is activated
*
* @param void
*
*/
//Including file that manages all template

//All Post type include here

$dir = plugin_dir_path( __FILE__ );
//For team
require_once $dir .'/metaboxes/page-header.php';
require_once $dir .'/metaboxes/rs-functions.php';
require_once $dir .'/metaboxes/cmb2/init.php';

/**
 * Implement widgets
 */
require_once $dir . '/inc/widgets/post_recent_widget.php';
require_once $dir . '/inc/widgets/post_popular_widget.php';
require_once $dir . '/inc/widgets/post_slider_widget.php';
require_once $dir . '/inc/widgets/rs-category-list.php';
require_once $dir . '/inc/widgets/recent_project_widget.php';
require_once $dir . '/inc/widgets/rs_contact.php';
require_once $dir . '/inc/widgets/rs-theme-widget/rs-theme-widget.php';
require_once $dir . '/inc/widgets/social-icon.php';
?>