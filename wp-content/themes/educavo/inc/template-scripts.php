<?php
function educavo_scripts() {
	//register styles
	global $educavo_option;
	wp_enqueue_style( 'boostrap', get_template_directory_uri() .'/assets/css/bootstrap.min.css' );	
	wp_enqueue_style( 'font-awesome-all', get_template_directory_uri() .'/assets/css/font-awesome.min.all.css');
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/assets/css/font-awesome.min.css');	
	wp_enqueue_style( 'flaticon', get_template_directory_uri() .'/assets/css/flaticon.css');
	wp_enqueue_style( 'animate', get_template_directory_uri() .'/assets/css/animate.css');
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() .'/assets/css/owl.carousel.css' );
	wp_enqueue_style( 'slick', get_template_directory_uri() .'/assets/css/slick.css' );	
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() .'/assets/css/magnific-popup.css');
	wp_enqueue_style( 'educavo-style-default', get_template_directory_uri() .'/assets/css/default.css' );
	wp_enqueue_style( 'educavo-style-custom', get_template_directory_uri() .'/assets/css/custom.css' );	
	wp_enqueue_style( 'educavo-gutenberg-custom', get_template_directory_uri() .'/assets/css/gutenberg-custom.css' );
	if(class_exists( 'SFWD_LMS' )){
		wp_enqueue_style( 'educavo-style-edash', get_template_directory_uri() .'/assets/css/edash.css' );	
	}
	if ( function_exists('tutor')) {
		wp_enqueue_style( 'educavo-style-tutor', get_template_directory_uri() .'/assets/css/tutor.css' );
	}
	wp_enqueue_style( 'educavo-style-responsive', get_template_directory_uri() .'/assets/css/responsive.css' );
	wp_enqueue_style( 'educavo-style', get_stylesheet_uri() );	
	// Mouse Pointer Scripts
	$rs_mouse_pointer="";
	$rs_mouse_pointer  = get_post_meta(get_queried_object_id(), 'mouse-pointer', true);
	
	if($rs_mouse_pointer != 'hide'){
		if(!empty($educavo_option['show_pointer']) || ($rs_mouse_pointer == 'show') ){
			wp_enqueue_script( 'pointer', get_template_directory_uri() . '/assets/js/pointer.js', array('jquery'), '20151215', true );
		} 
	}
	
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr-2.8.3.min.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '20151215', true );
	
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets/js/waypoints.min.js', array('jquery'), '20151215', true );

	

	wp_enqueue_script( 'waypoints-sticky', get_template_directory_uri() . '/assets/js/waypoints-sticky.min.js', array('jquery'), '20151215', true );

	
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '20151215', true );		
	wp_enqueue_script( 'isotope-educavo', get_template_directory_uri() . '/assets/js/isotope-educavo.js', array('jquery', 'imagesloaded'), '20151215', true );
	
	wp_enqueue_script('educavo-classie', get_template_directory_uri() . '/assets/js/classie.js', array('jquery'), '201513434', true);
	
	wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.js', array('jquery'), '20151215', true );



	if ( is_page_template( 'page-single.php' ) ) {
		wp_enqueue_script( 'jquery-nav', get_template_directory_uri() . '/assets/js/jquery.easing.min.js', array('jquery'), '20151215', true );
	}

	wp_enqueue_script('educavo-mobilemenu', get_template_directory_uri() . '/assets/js/mobilemenu.js', array('jquery'), '201513434', true);
	wp_enqueue_script('educavo-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '201513434', true);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'educavo_scripts' );


add_action( 'wp_enqueue_scripts', 'educavo_rtl_scripts', 1500 );
if ( !function_exists( 'educavo_rtl_scripts' ) ) {
	function educavo_rtl_scripts() {	
		// RTL
		if ( is_rtl() ) {
			wp_enqueue_style( 'educavo-rtl', get_template_directory_uri() . '/assets/css/rtl.css', array(), 1.0 );
		}		
		
	}
}
	
add_action( 'admin_enqueue_scripts', 'educavo_load_admin_styles' );
function educavo_load_admin_styles($screen) {
	wp_enqueue_style( 'educavo-admin-style', get_template_directory_uri() . '/assets/css/admin-style.css', true, '1.0.0' );
	wp_enqueue_script( 'educavo-admin-script', get_template_directory_uri() . '/assets/js/admin-script.js', array('jquery'), '20151215', true );
} 