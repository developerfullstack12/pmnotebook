<?php
/**
 * Team custom post type
 * This file is the basic custom post type for use any where in theme.
 *
 * @author RS Theme
 * @link http://www.rstheme.com
 */
global $educavo_option;
// Register Event Post Type
function rs_event_register_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Events', 'rsaddon' ),
		'singular_name'      => esc_html__( 'Event', 'rsaddon' ),
		'add_new'            => esc_html_x( 'Add New Event', 'rsaddon', 'rsaddon' ),
		'add_new_item'       => esc_html__( 'Add New Event', 'rsaddon' ),
		'edit_item'          => esc_html__( 'Edit Event', 'rsaddon' ),
		'new_item'           => esc_html__( 'New Event', 'rsaddon' ),
		'all_items'          => esc_html__( 'All Events', 'rsaddon' ),
		'view_item'          => esc_html__( 'View Event', 'rsaddon' ),
		'search_items'       => esc_html__( 'Search Events', 'rsaddon' ),
		'not_found'          => esc_html__( 'No Events found', 'rsaddon' ),
		'not_found_in_trash' => esc_html__( 'No Events found in Trash', 'rsaddon' ),
		'parent_item_colon'  => esc_html__( 'Parent Event:', 'rsaddon' ),
		'menu_name'          => esc_html__( 'Event', 'rsaddon' ),
	);
	global $educavo_option;
	$event_slug = (!empty($educavo_option['event_slug']))? $educavo_option['event_slug'] :'event';
	$args = array(
		'labels'             => $labels,
		'public'             => true,	
		'show_in_menu'       => true,
		'show_in_admin_bar'  => true,
		'can_export'         => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'rewrite' => 		 array('slug' => $event_slug,'with_front' => false),
		'menu_icon'          =>  plugins_url( 'img/icon.png', __FILE__ ),
		'supports'           => array( 'title', 'thumbnail','editor' ),		
	);
	register_post_type( 'events', $args );
}
add_action( 'init', 'rs_event_register_post_type' );
function tr_create_event() {
	register_taxonomy(
		'event-category',
		'events',
		array(
			'label' => __( 'Event Categories','rsaddon' ),
			'rewrite' => array( 'slug' => 'event-category' ),
			'hierarchical' => true,
			'show_admin_column' => true,	
		)
	);
}
add_action( 'init', 'tr_create_event' );