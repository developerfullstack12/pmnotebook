<?php
/**
 * Team custom post type
 * This file is the basic custom post type for use any where in theme.
 *
 * @author RS Theme
 * @link http://www.rstheme.com
 */
global $educavo_option;
// Register Notice Post Type
function rs_notice_register_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Notices Board', 'educavo' ),
		'singular_name'      => esc_html__( 'Notice Board', 'educavo' ),
		'add_new'            => esc_html_x( 'Add New Notice', 'educavo', 'educavo' ),
		'add_new_item'       => esc_html__( 'Add New Notice', 'educavo' ),
		'edit_item'          => esc_html__( 'Edit Notice', 'educavo' ),
		'new_item'           => esc_html__( 'New Notice', 'educavo' ),
		'all_items'          => esc_html__( 'All Notices', 'educavo' ),
		'view_item'          => esc_html__( 'View Notice', 'educavo' ),
		'search_items'       => esc_html__( 'Search Notices', 'educavo' ),
		'not_found'          => esc_html__( 'No Notices found', 'educavo' ),
		'not_found_in_trash' => esc_html__( 'No Notices found in Trash', 'educavo' ),
		'parent_item_colon'  => esc_html__( 'Parent Notice:', 'educavo' ),
		'menu_name'          => esc_html__( 'Notice Borad', 'educavo' ),
	);
	global $educavo_option;
	$notice_slug = (!empty($educavo_option['notice_slug']))? $educavo_option['notice_slug'] :'notice';
	$args = array(
		'labels'             => $labels,
		'public'             => true,	
		'show_in_menu'       => true,
		'show_in_admin_bar'  => true,
		'can_export'         => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'rewrite' => 		 array('slug' => $notice_slug,'with_front' => false),
		'menu_icon'          =>  plugins_url( 'img/icon.png', __FILE__ ),
		'supports'           => array( 'title', 'thumbnail','editor' ),		
	);
	register_post_type( 'notices', $args );
}
add_action( 'init', 'rs_notice_register_post_type' );
function tr_create_notice() {
	register_taxonomy(
		'notice-category',
		'notices',
		array(
			'label' => __( 'Categories','educavo' ),
			'rewrite' => array( 'slug' => 'notice-category' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'tr_create_notice' );