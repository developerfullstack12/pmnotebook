<?php
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function educavo_body_classes( $classes ) {
  // Adds a class of hfeed to non-singular pages.
  if ( ! is_singular() ) {
    $classes[] = 'hfeed';
  }

  return $classes;
}
add_filter( 'body_class', 'educavo_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function educavo_pingback_header() {
  if ( is_singular() && pings_open() ) {
    echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
  }
}

add_action( 'wp_head', 'educavo_pingback_header' );

/**  kses_allowed_html */

function educavo_prefix_kses_allowed_html($tags, $context) {
  switch($context) {
    case 'educavo': 
      $tags = array( 
        'a' => array('href' => array()),
        'b' => array()
      );
      return $tags;
    default: 
      return $tags;
  }
}

add_filter( 'wp_kses_allowed_html', 'educavo_prefix_kses_allowed_html', 10, 2);

/*
Register Fonts theme google font
*/
function educavo_studio_fonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'educavo' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Rubik:300,400,500,600,700,900|Nunito:300,400,500,600,700,900' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}
/*
Enqueue scripts and styles.
*/
function educavo_studio_scripts() {
    wp_enqueue_style( 'studio-fonts', educavo_studio_fonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'educavo_studio_scripts' );


//Favicon Icon
function educavo_site_icon() {
 if ( ! ( function_exists( 'has_site_icon' ) && has_site_icon() ) ) {     
    global $educavo_option;
     
    if(!empty($educavo_option['rs_favicon']['url']))
    {?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url(($educavo_option['rs_favicon']['url'])); ?>"> 
  <?php 
    }
  }
}
add_filter('wp_head', 'educavo_site_icon');


//excerpt for specific section
function educavo_wpex_get_excerpt( $args = array() ) {
  // Defaults
  $defaults = array(
    'post'            => '',
    'length'          => 48,
    'readmore'        => false,
    'readmore_text'   => esc_html__( 'read more', 'educavo' ),
    'readmore_after'  => '',
    'custom_excerpts' => true,
    'disable_more'    => false,
  );
  // Apply filters
  $defaults = apply_filters( 'educavo_wpex_get_excerpt_defaults', $defaults );
  // Parse args
  $args = wp_parse_args( $args, $defaults );
  // Apply filters to args
  $args = apply_filters( 'educavo_wpex_get_excerpt_args', $defaults );
  // Extract
  extract( $args );
  // Get global post data
  if ( ! $post ) {
    global $post;
  }


  $post_id = $post->ID;
  if ( $custom_excerpts && has_excerpt( $post_id ) ) {
    $output = $post->post_excerpt;
  } 
  else { 
    $readmore_link = '<a href="' . get_permalink( $post_id ) . '" class="readmore">' . $readmore_text . $readmore_after . '</a>';    
    if ( ! $disable_more && strpos( $post->post_content, '<!--more-->' ) ) {
      $output = apply_filters( 'the_content', get_the_content( $readmore_text . $readmore_after ) );
    }    
    else {     
      $output = wp_trim_words( strip_shortcodes( $post->post_content ), $length );      
      if ( $readmore ) {
        $output .= apply_filters( 'educavo_wpex_readmore_link', $readmore_link );
      }
    }
  }
  // Apply filters and echo
  return apply_filters( 'educavo_wpex_get_excerpt', $output );
}


//Demo content file include here

function educavo_import_files() {
  return array(
    array(
      'import_file_name'           => 'Educavo LearnPress Demo Import',
      'categories'                 => array( 'LearnPress' ),
      'import_file_url'            => trailingslashit( get_template_directory_uri() ) . 'ocdi/learnpress/educavo-content.xml',
      'import_widget_file_url'     => trailingslashit( get_template_directory_uri() ) . 'ocdi/learnpress/educavo-widget.wie',      
      'import_redux'               => array(
        array(
          'file_url'    => trailingslashit( get_template_directory_uri() ) . 'ocdi/learnpress/educavo-options.json',
          'option_name' => 'educavo_option',
        ),
      ),
      
       'import_preview_image_url'   => 'http://keenitsolutions.com/wordpress/educavo/desc/demo1.png',
      'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'educavo' ),
      'preview_url'                => 'https://keenitsolutions.com/products/wordpress/educavo',
      
    ),

    array(
      'import_file_name'           => 'Educavo LearnDash Demo Import',
      'categories'                 => array( 'LearnDash' ),
      'import_file_url'            => trailingslashit( get_template_directory_uri() ) . 'ocdi/learndash/educavo-content-ld.xml',
      'import_widget_file_url'     => trailingslashit( get_template_directory_uri() ) . 'ocdi/learndash/educavo-widget-ld.wie',      
      'import_redux'               => array(
        array(
          'file_url'    => trailingslashit( get_template_directory_uri() ) . 'ocdi/learndash/educavo-options-ld.json',
          'option_name' => 'educavo_option',
        ),
      ),
      
       'import_preview_image_url'   => 'http://keenitsolutions.com/wordpress/educavo/desc/demo1.png',
      'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'educavo' ),
      'preview_url'                => 'https://keenitsolutions.com/products/wordpress/educavo-dash',
      
    ),

    array(
      'import_file_name'           => 'Educavo Tutor LMS Demo Import',
      'categories'                 => array( 'Tutor' ),
      'import_file_url'            => trailingslashit( get_template_directory_uri() ) . 'ocdi/tutor/tutor-content.xml',
      'import_widget_file_url'     => trailingslashit( get_template_directory_uri() ) . 'ocdi/tutor/tutor-widget.wie',      
      'import_redux'               => array(
        array(
          'file_url'    => trailingslashit( get_template_directory_uri() ) . 'ocdi/tutor/tutor-options.json',
          'option_name' => 'educavo_option',
        ),
      ),
      
       'import_preview_image_url'   => 'http://keenitsolutions.com/wordpress/educavo/desc/demo1.png',
      'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'educavo' ),
      'preview_url'                => 'https://keenitsolutions.com/products/wordpress/educavo-tutor',
      
    ),
    
  );
}

add_filter( 'pt-ocdi/import_files', 'educavo_import_files' );
function educavo_after_import_setup() {
  // Assign menus to their locations.
	$main_menu     = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$left_menu     = get_term_by( 'name', 'Left Menu', 'nav_menu' );
	$right_menu    = get_term_by( 'name', 'Right Menu', 'nav_menu' );
	$category_menu = get_term_by( 'name', 'Category Menu', 'nav_menu' ); 

  set_theme_mod( 'nav_menu_locations', array(
      'menu-1' => $main_menu->term_id,       
      'menu-4' => $category_menu->term_id,       
      'menu-6' => $left_menu->term_id,       
      'menu-5' => $right_menu->term_id,       
    )
  );

  // Assign front page and posts page (blog page).
  $front_page_id = get_page_by_title( 'Main Demo' );
  $blog_page_id  = get_page_by_title( 'Blog' );

  update_option( 'show_on_front', 'page' );
  update_option( 'page_on_front', $front_page_id->ID );
  update_option( 'page_for_posts', $blog_page_id->ID ); 

  //Import Revolution Slider
  if ( class_exists( 'RevSlider' ) ) {
    $slider_array = array(
      get_template_directory()."/ocdi/sliders/admission.zip",
      get_template_directory()."/ocdi/sliders/home2.zip", 
      get_template_directory()."/ocdi/sliders/home-2-11.zip",                               
      get_template_directory()."/ocdi/sliders/home-3.zip",                               
      get_template_directory()."/ocdi/sliders/home4.zip",                               
      get_template_directory()."/ocdi/sliders/home-6.zip",       
      get_template_directory()."/ocdi/sliders/home7.zip",                               
      get_template_directory()."/ocdi/sliders/home-8.zip",                               
      get_template_directory()."/ocdi/sliders/home-10.zip",                               
      get_template_directory()."/ocdi/sliders/main-home-1.zip",                               
      get_template_directory()."/ocdi/sliders/remote-training.zip",                               
      get_template_directory()."/ocdi/sliders/slider-11.zip",                               
      get_template_directory()."/ocdi/sliders/coach-new.zip",                             
      get_template_directory()."/ocdi/sliders/slider-12.zip",
      get_template_directory()."/ocdi/sliders/home-new.zip",                           
      get_template_directory()."/ocdi/sliders/home-13.zip",                           
    );

    $slider = new RevSlider();
    foreach($slider_array as $filepath){
      $slider->importSliderFromPost(true,true,$filepath);  
    }
  } 
}
add_action( 'pt-ocdi/after_import', 'educavo_after_import_setup' );