<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "educavo_option";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'educavo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        'page_priority'        => 8,
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Educavo Options', 'educavo' ),
        'page_title'           => esc_html__( 'Educavo Options', 'educavo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 20,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        'forced_dev_mode_off' => true,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        'compiler' => true,

        // OPTIONAL -> Give you extra features
        'page_priority'        => 20,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        'force_output' => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( esc_html__( 'Educavo Theme', 'educavo' ), $v );
    } else {
        $args['intro_text'] = esc_html__( 'Educavo Theme', 'educavo' );
    }

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTSeducavo
      
     */     
   // -> START General Settings
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General Sections', 'educavo' ),
        'id'               => 'basic-checkbox',
        'customizer_width' => '450px',
        'fields'           => array(

        	array(
        	    'id'       => 'enable_global',
        	    'type'     => 'switch', 
        	    'title'    => esc_html__('Enable Global Settings', 'educavo'),
        	    'subtitle' => esc_html__('If you enable global settings all option will be work only theme option', 'educavo'),
        	    'default'  => false,
        	),         
        	
            array(
                'id'       => 'container_size',
                'title'    => esc_html__( 'Container Size', 'educavo' ),
                'subtitle' => esc_html__( 'Container Size example(1200px)', 'educavo' ),
                'type'     => 'text',
                'default'  => '1270px'                
            ),

            array(
                'id'       => 'logo',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Default Logo', 'educavo' ),
                'subtitle' => esc_html__( 'Upload your logo', 'educavo' ),
                'url'=> true                
            ),

            array(
                'id'       => 'logo_light',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Your Light', 'educavo' ),
                'subtitle' => esc_html__( 'Upload your light logo', 'educavo' ),
                'url'=> true                
            ),

            array(
                'id'       => 'logo_icons',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload default icon logo', 'educavo' ),
                'subtitle' => esc_html__( 'Upload default icon logo', 'educavo' ),
                'url'=> true
            ),

            array(
                'id'       => 'logo_icons_light',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Light icon logo', 'educavo' ),
                'subtitle' => esc_html__( 'Upload Light icon logo', 'educavo' ),
                'url'=> true
            ),

            array(
                    'id'       => 'logo-height',                               
                    'title'    => esc_html__( 'Logo Height', 'educavo' ),
                    'subtitle' => esc_html__( 'Logo max height example(50px)', 'educavo' ),
                    'type'     => 'text',
                    'default'  => '25px'                    
            ),

            array(
                'id'       => 'rswplogo_sticky',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Your Sticky Logo', 'educavo' ),
                'subtitle' => esc_html__( 'Upload your sticky logo', 'educavo' ),
                'url'=> true                
            ),

            array(
                'id'       => 'sticky_logo_height',                               
                'title'    => esc_html__( 'Sticky Logo Height', 'educavo' ),
                'subtitle' => esc_html__( 'Sticky Logo max height example(20px)', 'educavo' ),
                'type'     => 'text',
                'default'  => '25px'                    
            ),  

            array(
            'id'       => 'rs_favicon',
            'type'     => 'media',
            'title'    => esc_html__( 'Upload Favicon', 'educavo' ),
            'subtitle' => esc_html__( 'Upload your faviocn here', 'educavo' ),
            'url'=> true            
            ),         
            
            array(
                'id'        => 'logo_bg_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Logo Area Background Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '',                        
                'validate'  => 'color',                        
            ), 
     
            array(
                'id'       => 'show_top_bottom',
                'type'     => 'switch', 
                'title'    => esc_html__('Go to Top', 'educavo'),
                'subtitle' => esc_html__('You can show or hide here', 'educavo'),
                'default'  => false,
            ),
        )
    ) 
);
    
                                       
    //Topbar settings
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Topbar area', 'educavo' ),
        'desc'   => esc_html__( 'Topbar area Style Here', 'educavo' ),        
        'subsection' => false, 
        'icon' => 'el el-certificate',  
        'fields' => array(                 
                array(
                    'id'       => 'topbar_layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Topbar Layout', 'educavo'), 
                    'subtitle' => esc_html__('Select topbar layout. Choose between 1, 2 or 3 layout.', 'educavo'),
                    'options'  => array(
                        'style1'   => array(
                            'alt'      =>  esc_html__('Topbar Style 1','educavo'),  
                            'img'      => get_template_directory_uri().'/libs/img/top_1.png'                    
                        ),                        
                        'style2' => array(
                            'alt'    =>  esc_html__('Topbar Style 2','educavo'),  
                            'img'    => get_template_directory_uri().'/libs/img/top_2.png'
                        ),
                        'style3' => array(
                            'alt'    =>  esc_html__('Topbar Style 3','educavo'),  
                            'img'    => get_template_directory_uri().'/libs/img/top_3.png'                  
                        ),
                        'style4' => array(
                            'alt'    =>  esc_html__('Topbar Style 4','educavo'),  
                            'img'    => get_template_directory_uri().'/libs/img/top_4.png'                  
                        ), 
                    ),
                    'default' => 'style1'
                ), 

                array(
                    'id'       => 'show-top',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Show Top Bar', 'educavo'),
                    'subtitle' => esc_html__('You can select top bar show or hide', 'educavo'),
                    'default'  => false,
                ),         
                
                array(
                    'id'       => 'show-social',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Show Social Icons', 'educavo'),
                    'subtitle' => esc_html__('You can select Social Icons show or hide', 'educavo'),
                    'default'  => true,
                ),

                array(
                    'id'       => 'welcome_sms',                               
                    'title'    => esc_html__( ' Welcome Message', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter Welcome Message', 'educavo' ),
                    'type'     => 'text',     
                ),

                
                array(
                    'id'       => 'phone',                               
                    'title'    => esc_html__( ' Phone Number', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter Phone Number', 'educavo' ),
                    'type'     => 'text',     
                ),

                       
                array(
                    'id'       => 'top-email',                               
                    'title'    => esc_html__( 'Email Address', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter Email Address', 'educavo' ),
                    'type'     => 'text',
                    'validate' => 'email',
                    'msg'      => esc_html__('Email Address Not Valid', 'educavo')  
                ),         

                array(
                    'id'       => 'open_hours',                               
                    'title'    => esc_html__( 'Address', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter Address Hours', 'educavo' ),
                    'type'     => 'text',
                    
                ),  

                array(
                    'id'       => 'login_btns',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Show Login / Register Button', 'educavo'),
                    'subtitle' => esc_html__('You can show or hide Login Button', 'educavo'),
                    'default'  => false,
                ),

                array(
                    'id'       => 'loginbtn',                               
                    'title'    => esc_html__( 'Login / Register Button Text', 'educavo' ),                  
                    'type'     => 'text',
                        
                ), 
                array(
                    'id'       => 'login_link',                               
                    'title'    => esc_html__( 'Login / Register Button Link', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter Login Button Link Here', 'educavo' ),
                    'type'     => 'text',            
                ),

                array(
                    'id'        => 'toolbar_bg_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar background Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#273C66',                        
                    'validate'  => 'color',                        
                ),    

                array(
                    'id'        => 'toolbar_text_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Text Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ), 

                 array(
                    'id'        => 'transparent_toolbar_text_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Transparent Topbar Text Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ),  

                array(
                    'id'        => 'toolbar_link_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Link Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ),                

                array(
                    'id'        => 'toolbar_link_hover_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Link Hover Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#ff5421',                        
                    'validate'  => 'color',                        
                ),  

                 array(
                    'id'        => 'transparent_toolbar_link_hover_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Transparent Topbar Link Hover Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#cccccc',                        
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'        => 'toolbar_borer_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Border Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#071433',                        
                    'validate'  => 'color',                        
                ),

                array(
                    'id'        => 'toolbar_text_size',
                    'type'      => 'text',                       
                    'title'     => esc_html__('Topbar Font Size','educavo'),
                    'subtitle'  => esc_html__('Font Size', 'educavo'),    
                    'default'   => '14px',                                            
                ),

                array(
                    'id'        => 'toolbar_btn_bg_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Button Bg Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#ff5421',                        
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'        => 'toolbar_btn_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Button Text Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'        => 'toolbar_icons_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Icon Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ),

                array(
                    'id'        => 'social_icons_colors',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Social Icon Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ),

                array(
                    'id'        => 'social_icons_hover_colors',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Topbar Social Icon Hover Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#ff5421',                        
                    'validate'  => 'color',                        
                ),                
            )
        )
    );

    // -> START Header Section
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header', 'educavo' ),
        'id'               => 'header',
        'customizer_width' => '450px',
        'icon' => 'el el-certificate',      
        'fields'           => array(          
        array(
            'id'     => 'notice_critical2',
            'type'   => 'info',
            'notice' => true,
            'style'  => 'success',
            'title'  => esc_html__('Header Area', 'educavo')            
        ),

        array(
                'id'               => 'header-grid',
                'type'             => 'select',
                'title'            => esc_html__('Header Area Width', 'educavo'),                  
               
                //Must provide key => value pairs for select options
                'options'          => array(                                     
                
                    'container' => esc_html__('Container', 'educavo'),
                    'full'      => esc_html__('Container Fluid', 'educavo'),
                ),

                'default'          => 'container',            
            ),       

        array(
            'id'       => 'quote_btns',
            'type'     => 'switch', 
            'title'    => esc_html__('Show Apply Button', 'educavo'),
            'subtitle' => esc_html__('You can show or hide apply button', 'educavo'),
            'default'  => false,
        ),      

        array(
            'id'       => 'quote',                               
            'title'    => esc_html__( 'Apply Button Text', 'educavo' ),                  
            'type'     => 'text',
                
        ),  
        
        array(
            'id'       => 'quote_link',                               
            'title'    => esc_html__( 'Apply Button Link', 'educavo' ),
            'subtitle' => esc_html__( 'Enter apply Button Link Here', 'educavo' ),
            'type'     => 'text',
            
        ),       

        array(
            'id'       => 'skew_off',
            'type'     => 'switch', 
            'title'    => esc_html__('Skew Show or Hide', 'educavo'),
            'subtitle' => esc_html__('You can show or hide skew', 'educavo'),
            'default'  => false,
        ), 

        array(
            'id'       => 'off_search',
            'type'     => 'switch', 
            'title'    => esc_html__('Show Search', 'educavo'),
            'subtitle' => esc_html__('You can show or hide search icon at menu area', 'educavo'),
            'default'  => false,
        ),

        )
    ) 
);  
   

Redux::setSection( $opt_name, array(
'title'            => esc_html__( 'Header Layout', 'educavo' ),
'id'               => 'header-style',
'customizer_width' => '450px',
'subsection' => true,      
'fields'    => array( 
                    
                array(
                    'id'       => 'header_layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Header Layout', 'educavo'), 
                    'subtitle' => esc_html__('Select header layout. Choose between 1, 2 or 3 layout.', 'educavo'),
                    'options'  => array(
                    'style1'   => array(
                    'alt'      => esc_html__('Header Style 1','educavo'),  
                    'img'      => get_template_directory_uri().'/libs/img/style_2.png'                    
                    ),                        
                    'style2' => array(
                    'alt'    => esc_html__('Header Style 2','educavo'), 
                    'img'    => get_template_directory_uri().'/libs/img/style_1.png'
                    ),
                    'style3' => array(
                    'alt'    => esc_html__('Header Style 3', 'educavo'),  
                    'img'    => get_template_directory_uri().'/libs/img/style_3.png'
                    ),
                    'style4' => array(
                    'alt'    => esc_html__('Header Style 4', 'educavo'),  
                    'img'    => get_template_directory_uri().'/libs/img/style_7.png'
                    ),
                    'style5' => array(
                    'alt'    => esc_html__('Header Style 5', 'educavo'),  
                    'img'    => get_template_directory_uri().'/libs/img/style_6.png'
                    ),
                    'style6' => array(
                    'alt'    => esc_html__('Header Style 6', 'educavo'),  
                    'img'    => get_template_directory_uri().'/libs/img/style_4.png'
                    ),
                    'style7' => array(
                    'alt'    => esc_html__('Header Style 7', 'educavo'),  
                    'img'    => get_template_directory_uri().'/libs/img/style_5.png'
                    ),
                    ),
                    'default' => 'style5'
            ),                           
                
        )
    ) 
);

    //Menu settings
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Main Menu', 'educavo' ),
        'desc'   => esc_html__( 'Main Menu Style Here', 'educavo' ), 
        'icon' => 'el el-brush',       
        'subsection' => false,  
        'fields' => array( 

            array(
                'id'     => 'notice_critical_menu',
                'type'   => 'info',
                'notice' => true,
                'style'  => 'success',
                'title'  => esc_html__('Main Menu Settings', 'educavo'),                                           
            ),

            array(
                'id'       => 'main_menu_icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Main Menu Icon Hide', 'educavo' ),
                'on'       => esc_html__( 'Enabled', 'educavo' ),
                'off'      => esc_html__( 'Disabled', 'educavo' ),
                'default'  => false,
            ),

            array(
                'id'        => 'menu_area_bg_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Main Menu Background Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '',                        
                'validate'  => 'color',                        
            ), 
            
            array(
                'id'        => 'menu_text_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Main Menu Text Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '#333333',                        
                'validate'  => 'color',                        
            ), 
            
            array(
                'id'        => 'transparent_menu_text_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Tranparent Menu Text Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '#fff',                        
                'validate'  => 'color',                        
            ), 

            array(
                'id'        => 'transparent_menu_hover_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Tranparent Menu Hover Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '#ff5421',                        
                'validate'  => 'color',                        
            ),  

            array(
                'id'        => 'transparent_menu_active_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Tranparent Menu Active Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '#ff5421',                        
                'validate'  => 'color',                        
            ), 

            array(
                'id'        => 'menu_text_hover_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Main Menu Text Hover Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),           
                'default'   => '#ff5421',                 
                'validate'  => 'color',                        
            ), 

            array(
                'id'        => 'menu_text_active_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Main Menu Text Active Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),
                'default'   => '#ff5421',
                'validate'  => 'color',                        
            ),

             array(
                            'id'        => 'menu_des_color',
                            'type'      => 'color',                       
                            'title'     => esc_html__('Main Item Description Text Color','educavo'),
                            'subtitle'  => esc_html__('Pick color', 'educavo'),
                            'default'   => '',
                            'validate'  => 'color', 
                            'output' => array(                 
                                'color'            => 'span.description'
                            )                          
                        ),

            array(
                'id'        => 'menu_item_gap',
                'type'      => 'text',                       
                'title'     => esc_html__('Menu Item Left Gap','educavo'),   
                'default'   => '0px',                             
            ), 

            array(
                'id'        => 'menu_item_gapd2',
                'type'      => 'text',                       
                'title'     => esc_html__('Menu Item Right Gap','educavo'),   
                'default'   => '16px',                             
            ), 
            
            array(
                'id'        => 'menu_item_gap2',
                'type'      => 'text',                       
                'title'     => esc_html__('Menu Item Top Gap','educavo'),   
                'default'   => '45px',                             
            ),                        

            array(
                'id'        => 'menu_item_gap3',
                'type'      => 'text',                       
                'title'     => esc_html__('Menu Item Bottom Gap','educavo'),   
                'default'   => '45px',                             
            ),

            array(
                'id'       => 'menu_text_trasform',
                'type'     => 'switch',
                'title'    => esc_html__( 'Menu Text Uppercase', 'educavo' ),
                'on'       => esc_html__( 'Enabled', 'educavo' ),
                'off'      => esc_html__( 'Disabled', 'educavo' ),
                'default'  => false,
            ),

            array(
                'id'     => 'notice_critical_dropmenu',
                'type'   => 'info',
                'notice' => true,
                'style'  => 'success',
                'title'  => esc_html__('Dropdown Menu Settings', 'educavo'),                                           
            ),
                                   
            array(
                'id'        => 'drop_down_bg_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Dropdown Menu Background Color','educavo'),
                'subtitle'  => esc_html__('Pick bg color', 'educavo'),
                'default'   => '#fff',
                'validate'  => 'color',                        
            ), 
            
            array(
                'id'        => 'drop_down_bdr_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Dropdown Menu Border Color','educavo'),
                'subtitle'  => esc_html__('Pick Border color', 'educavo'),
                'default'   => '#ff5421',
                'validate'  => 'color',                        
            ), 
            
            array(
                'id'        => 'drop_text_color',
                'type'      => 'color',                     
                'title'     => esc_html__('Dropdown Menu Text Color','educavo'),
                'subtitle'  => esc_html__('Pick text color', 'educavo'),
                'default'   => '#171f32',
                'validate'  => 'color',                        
            ), 
            
            array(
                'id'        => 'drop_text_hover_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Dropdown Menu Hover Text Color','educavo'),
                'subtitle'  => esc_html__('Pick text color', 'educavo'),
                'default'   => '#ff5421',
                'validate'  => 'color',                        
            ),                              
         

            array(
                'id'       => 'menu_text_trasform2',
                'type'     => 'switch',
                'title'    => esc_html__( 'Dropdown Menu Text Uppercase', 'educavo' ),
                'on'       => esc_html__( 'Enabled', 'educavo' ),
                'off'      => esc_html__( 'Disabled', 'educavo' ),
                'default'  => false,
            ),

            array(
                'id'       => 'drob_align_s',
                'type'     => 'switch',
                'title'    => esc_html__( 'Dropdown Menu 3rd Level Left Align', 'educavo' ),
                'on'       => esc_html__( 'Enabled', 'educavo' ),
                'off'      => esc_html__( 'Disabled', 'educavo' ),
                'default'  => false,
            ),

            array(
                 'id'        => 'dropdown_menu_item_gap',
                 'type'      => 'text',                       
                 'title'     => esc_html__('Dropdown Menu Item Left Right Gap','educavo'),   
                 'default'   => '40px',                             
             ), 

            array(
                 'id'        => 'dropdown_menu_item_separate',
                 'type'      => 'text',                       
                 'title'     => esc_html__('Dropdown Menu Item Middle Gap','educavo'),   
                 'default'   => '10px',                             
             ), 
             array(
                 'id'        => 'dropdown_menu_item_gap2',
                 'type'      => 'text',                       
                 'title'     => esc_html__('Dropdown Menu Boxes Top Bottom Gap','educavo'),   
                 'default'   => '21px',                             
             ),
             array(
                 'id'     => 'notice_critical3',
                 'type'   => 'info',
                 'notice' => true,
                 'style'  => 'success',
                 'title'  => esc_html__('Mega Menu Settings', 'educavo'),                                           
             ),

              array(
                'id'        => 'meaga_menu_item_gap',
                'type'      => 'text',                       
                'title'     => esc_html__('Mega Menu Item Left Right Gap','educavo'),   
                'default'   => '40px',                             
            ), 

             array(
                'id'        => 'mega_menu_item_separate',
                'type'      => 'text',                       
                'title'     => esc_html__('Mega Menu Item Middle Gap','educavo'),   
                'default'   => '10px',                             
            ),  
            array(
                'id'        => 'mega_menu_item_gap2',
                'type'      => 'text',                       
                'title'     => esc_html__('Mega Menu Boxes Top Bottom Gap','educavo'),   
                'default'   => '21px',                             
            ),                                 
        )
    )
); 

    //Sticky Menu settings
    Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Sticky Menu', 'educavo' ),
    'desc'       => esc_html__( 'Sticky Menu Style Here', 'educavo' ),  
    'icon' => 'el el-brush',      
    'subsection' => false,  
    'fields' => array(                       

            array(
                'id'       => 'off_sticky',
                'type'     => 'switch', 
                'title'    => esc_html__('Sticky Menu', 'educavo'),
                'subtitle' => esc_html__('You can show or hide sticky menu here', 'educavo'),
                'default'  => false,
            ),

            array(
                'id'        => 'stiky_menu_area_bg_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Sticky Menu Area Background Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '#fff',                        
                'validate'  => 'color',                        
            ), 
            
            array(
                'id'        => 'stikcy_menu_text_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Menu Text Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),    
                'default'   => '#101010',                        
                'validate'  => 'color',                        
            ), 
           

            array(
                'id'        => 'sticky_menu_text_hover_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Menu Text Hover Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),           
                'default'   => '#ff5421',                 
                'validate'  => 'color',                        
            ), 

            array(
                'id'        => 'stikcy_menu_text_active_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Main Menu Text Active Color','educavo'),
                'subtitle'  => esc_html__('Pick color', 'educavo'),
                'default'   => '#ff5421',
                'validate'  => 'color',                        
            ),

            array(
                'id'        => 'stikcy_menu_font_size',
                'type'      => 'text',                       
                'title'    => __( 'Stikcy Menu Font Size', 'educavo' ),
                'subtitle' => __( 'Stikcy menu font size here ( 15px )', 'educavo' ),  
                'default'   => '',                                            
            ), 
                                   
            array(
                'id'        => 'sticky_drop_down_bg_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Dropdown Menu Background Color','educavo'),
                'subtitle'  => esc_html__('Pick bg color', 'educavo'),
                'default'   => '#fff',
                'validate'  => 'color',                        
            ), 
                
            
            array(
                'id'        => 'stikcy_drop_text_color',
                'type'      => 'color',                     
                'title'     => esc_html__('Dropdown Menu Text Color','educavo'),
                'subtitle'  => esc_html__('Pick text color', 'educavo'),
                'default'   => '#171f32',
                'validate'  => 'color',                        
            ), 
            
            array(
                'id'        => 'sticky_drop_text_hover_color',
                'type'      => 'color',                       
                'title'     => esc_html__('Dropdown Menu Hover Text Color','educavo'),
                'subtitle'  => esc_html__('Pick text color', 'educavo'),
                'default'   => '#ff5421',
                'validate'  => 'color',                        
            ),  
            array(
                'id'        => 'stikcy_dropdown_menu_font_size',
                'type'      => 'text',                       
                'title'    => __( 'Stikcy Dropdown Menu Font Size', 'educavo' ),
                'subtitle' => __( 'Stikcy dropdown menu font size here ( 15px )', 'educavo' ),  
                'default'   => '',                                            
            ),                      
        )
    )
); 


  //Preloader settings
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Preloader Style', 'educavo' ),
        'desc'   => esc_html__( 'Preloader Style Here', 'educavo' ),               
        'fields' => array( 
                        array(
                            'id'       => 'show_preloader',
                            'type'     => 'switch', 
                            'title'    => esc_html__('Show Preloader', 'educavo'),
                            'subtitle' => esc_html__('You can show or hide preloader', 'educavo'),
                            'default'  => false,
                        ), 

                        array(
                            'id'        => 'preloader_bg_color',
                            'type'      => 'color',                       
                            'title'     => esc_html__('Preloader Background Color','educavo'),
                            'subtitle'  => esc_html__('Pick color', 'educavo'),    
                            'default'   => '#fff',                        
                            'validate'  => 'color',                        
                        ), 
                        
                        array(
                            'id'        => 'preloader_text_color',
                            'type'      => 'color',                       
                            'title'     => esc_html__('Preloader Border Color','educavo'),
                            'subtitle'  => esc_html__('Pick color', 'educavo'),    
                            'default'   => '#ebebec',                        
                            'validate'  => 'color',                        
                        ),  

                        array(
                            'id'        => 'preloader_animate_color',
                            'type'      => 'color',                       
                            'title'     => esc_html__('Preloader Animate Circle Color','educavo'),
                            'subtitle'  => esc_html__('Pick color', 'educavo'),    
                            'default'   => '#ff5421',                        
                            'validate'  => 'color',                        
                        ), 

                        array(
                            'id'    => 'preloader_img', 
                            'url'   => true,     
                            'title' => esc_html__( 'Preloader Image', 'educavo' ),                 
                            'type'  => 'media',                                  
                        ),       
                    )
                )
            ); 


               
//End Preloader settings  
    // -> START Style Section
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Style', 'educavo' ),
        'id'               => 'stle',
        'customizer_width' => '450px',
        'icon' => 'el el-brush',
        ));
    
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Global Style', 'educavo' ),
        'desc'   => esc_html__( 'Style your theme', 'educavo' ),        
        'subsection' => true,  
        'fields' => array( 
                        
                        array(
                            'id'        => 'body_bg_color',
                            'type'      => 'color',                           
                            'title'     => esc_html__('Body Backgroud Color','educavo'),
                            'subtitle'  => esc_html__('Pick body background color', 'educavo'),
                            'default'   => '#fff',
                            'validate'  => 'color',                        
                        ), 
                        
                        array(
                            'id'        => 'body_text_color',
                            'type'      => 'color',            
                            'title'     => esc_html__('Text Color','educavo'),
                            'subtitle'  => esc_html__('Pick text color', 'educavo'),
                            'default'   => '#555',
                            'validate'  => 'color',                        
                        ),     
        
                        array(
                            'id'        => 'primary_color',
                            'type'      => 'color', 
                            'title'     => esc_html__('Primary Color','educavo'),
                            'subtitle'  => esc_html__('Select Primary Color.', 'educavo'),
                            'default'   => '#171F32',
                            'validate'  => 'color',                        
                        ), 

                        array(
                            'id'        => 'secondary_color',
                            'type'      => 'color', 
                            'title'     => esc_html__('Secondary Color','educavo'),
                            'subtitle'  => esc_html__('Select Secondary Color.', 'educavo'),
                            'default'   => '#ff5421',
                            'validate'  => 'color',                        
                        ),

                        array(
                            'id'        => 'link_text_color',
                            'type'      => 'color',                       
                            'title'     => esc_html__('Link Color','educavo'),
                            'subtitle'  => esc_html__('Pick Link color', 'educavo'),
                            'default'   => '#ff5421',
                            'validate'  => 'color',                        
                        ),
                        
                        array(
                            'id'        => 'link_hover_text_color',
                            'type'      => 'color',                 
                            'title'     => esc_html__('Link Hover Color','educavo'),
                            'subtitle'  => esc_html__('Pick link hover color', 'educavo'),
                            'default'   => '#ff5421',
                            'validate'  => 'color',                        
                        ),    
                       
                 ) 
            ) 
    ); 

    //Breadcrumb settings
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Breadcrumb Style', 'educavo' ),      
        'subsection' => true,  
        'fields' => array( 

                    array(
                        'id'       => 'off_breadcrumb',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Show off Breadcrumb', 'educavo'),
                        'subtitle' => esc_html__('You can show or hide off breadcrumb here', 'educavo'),
                        'default'  => true,
                    ),

                    array(
                        'id'       => 'align_breadcrumb',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Breadcrumb Align Left', 'educavo'),
                        'subtitle' => esc_html__('You can breadcrumb align left', 'educavo'),
                        'default'  => false,
                    ), 

                    array(
                        'id'        => 'breadcrumb_bg_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Background Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#171F32',                        
                        'validate'  => 'color',                        
                    ),                     

                     array(
                        'id'       => 'page_banner_main',
                        'type'     => 'media',
                        'title'    => esc_html__( 'Background Banner', 'educavo' ),
                        'subtitle' => esc_html__( 'Upload your banner', 'educavo' ),                  
                    ), 
                    
                    array(
                        'id'        => 'breadcrumb_title_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Title Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#fff',                        
                        'validate'  => 'color',                        
                    ), 
                    
                    array(
                        'id'        => 'breadcrumb_text_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Text Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#fff',                        
                        'validate'  => 'color',                        
                    ), 
                    
                  
                    array(
                        'id'        => 'breadcrumb_top_gap',
                        'type'      => 'text',                       
                        'title'     => esc_html__('Top Gap','educavo'),                          
                        'default'   => '170px',                        
                                            
                    ), 
                     array(
                        'id'        => 'breadcrumb_bottom_gap',
                        'type'      => 'text',                       
                        'title'     => esc_html__('Bottom Gap','educavo'),                          
                        'default'   => '170px',                   
                    ), 
                    
                    array(
                        'id'        => 'mobile_breadcrumb_top_gap',
                        'type'      => 'text',                       
                        'title'     => esc_html__('Mobile Top Gap','educavo'),                          
                        'default'   => '150px',                        
                                            
                    ), 
                     array(
                        'id'        => 'mobile_breadcrumb_bottom_gap',
                        'type'      => 'text',                       
                        'title'     => esc_html__('Mobile Bottom Gap','educavo'),                          
                        'default'   => '100px',                   
                    ),     
                        
                )
            )
        );

    //Button settings
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Button Style', 'educavo' ),
        'desc'       => esc_html__( 'Button Style Here', 'educavo' ),        
        'subsection' => true,  
        'fields' => array( 

                    array(
                        'id'        => 'btn_bg_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Background Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#FF5421',                        
                        'validate'  => 'color',                        
                    ), 

                    array(
                        'id'        => 'btn_bg_hover',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Hover Background','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#171F32',                        
                        'validate'  => 'color',                        
                    ), 

                    array(
                        'id'        => 'btn_bg_hover_border',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Hover Border Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#171F32',                        
                        'validate'  => 'color',                        
                    ), 
                    
                    array(
                        'id'        => 'btn_text_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Text Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#fff',                        
                        'validate'  => 'color',                        
                    ), 
                    
                    array(
                        'id'        => 'btn_txt_hover_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Hover Text Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#fff',                        
                        'validate'  => 'color',                        
                    ),  
                )
            )
        );
    
    //offcanvas  settings
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Offcanvas Style', 'educavo' ),
        'desc'   => esc_html__( 'Offcanvas Style Here', 'educavo' ),        
        
        'fields' => array( 

                array(
                    'id'       => 'off_canvas',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Show off Canvas', 'educavo'),
                    'subtitle' => esc_html__('You can show or hide off canvas here', 'educavo'),
                    'default'  => false,
                ),

                array(
                    'id'       => 'offcanvas_logo',
                    'type'     => 'media',
                    'title'    => esc_html__( 'Offcanvas Logo', 'educavo' ),
                    'subtitle' => esc_html__( 'Upload your  logo', 'educavo' ),                  
                ), 

             
                array(
                    'id'       => 'offcanvas_logo_height',                               
                    'title'    => esc_html__( 'Logo Height', 'educavo' ),
                    'subtitle' => esc_html__( 'Logo max height example(50px)', 'educavo' ),
                    'type'     => 'text',
                    'default'  => '30px'                    
                ),

                array(
                    'id'        => 'offcan_bgs_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Background Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#171F32',                        
                    'validate'  => 'color',                        
                ),  

                array(
                    'id'        => 'offcan_text_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Text Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#333',                        
                    'validate'  => 'color',                        
                ),                 

                array(
                    'id'        => 'offcan_title_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Title Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#333',                        
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'        => 'offcan_link_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Link  Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#333',                        
                    'validate'  => 'color',                        
                ),

                array(
                    'id'        => 'offcan_link_hover_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Link Hover Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#ff5421',                        
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'        => 'offcan_border_color',
                    'type'      => 'color_rgba',                       
                    'title'     => esc_html__('Seperator Border Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),   
                      
                    'default'  => array(
		                'color'     => '#040933',
		                'alpha'     => 1	                
            		),
				    'output' => array(				   
				    'border-color'            => '.sidenav .widget,
						body .sidenav #mobile_menu .widget_nav_menu ul li a'
					)
                ),                 

                array(
                    'id'        => 'offcanvas_icon_bgs_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Hamburger Icon Bg Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ),    

                array(
                    'id'        => 'offcanvas_icon_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Hamburger Icon Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#363636',                        
                    'validate'  => 'color',                        
                ), 

          
                array(
                    'id'        => 'offcanvas_close_bg_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Close Icon Bg Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#ff5421',                        
                    'validate'  => 'color',                        
                ),

                array(
                    'id'        => 'offcanvas_close_color',
                    'type'      => 'color',                       
                    'title'     => esc_html__('Close Icon Color','educavo'),
                    'subtitle'  => esc_html__('Pick color', 'educavo'),    
                    'default'   => '#fff',                        
                    'validate'  => 'color',                        
                ),   
            )
        )
    );
    
    //Mobile settings
    Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Mobile Settings', 'educavo' ),
    'id'               => 'mobilestle',
    'customizer_width' => '450px',
    'icon' => 'el el-cog',
    ));

    Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Header Settings', 'educavo' ),
    'desc'   => esc_html__( 'Header Settings Here', 'educavo' ),        
    'subsection' => true,
    'fields' => array(  

                array(
                    'id'       => 'mobile_top_bar',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Topbar Hide On Mobile', 'educavo'),
                    'subtitle' => esc_html__('You can show or hide On Mobile', 'educavo'),
                    'default'  => false,
                ),

                array(
                    'id'       => 'mobile_off_cart',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Cart Hide On Mobile', 'educavo'),
                    'subtitle' => esc_html__('You can show or hide On Mobile', 'educavo'),
                    'default'  => false,
                ),
                array(
                    'id'       => 'mobile_off_search',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Search Hide On Mobile', 'educavo'),
                    'subtitle' => esc_html__('You can show or hide On Mobile', 'educavo'),
                    'default'  => false,
                ), 
                array(
                    'id'       => 'mobile_off_button',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Quote Button Hide On Mobile', 'educavo'),
                    'subtitle' => esc_html__('You can show or hide On Mobile', 'educavo'),
                    'default'  => false,
                ),
            )
        )
    ); 

    //-> START Typography
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Typography', 'educavo' ),
        'id'     => 'typography',
        'desc'   => esc_html__( 'You can specify your body and heading font here','educavo'),
        'icon'   => 'el el-font',
        'fields' => array(
            array(
                'id'       => 'opt-typography-body',
                'type'     => 'typography',
                'title'    => esc_html__( 'Body Font', 'educavo' ),
                'subtitle' => esc_html__( 'Specify the body font properties.', 'educavo' ),
                'google'   => true, 
                'font-style' =>false,           
                'default'  => array(                    
                    'font-size'   => '16px',
                    'font-family' => 'Rubik',
                    'font-weight' => '400',
                ),
            ),
             array(
                'id'       => 'opt-typography-menu',
                'type'     => 'typography',
                'title'    => esc_html__( 'Navigation Font', 'educavo' ),
                'subtitle' => esc_html__( 'Specify the menu font properties.', 'educavo' ),
                'google'   => true,
                'font-backup' => true,                
                'all_styles'  => true,              
                'default'  => array(
                    'color'       => '#333',                    
                    'font-family' => 'Rubik',
                    'google'      => true,
                    'font-size'   => '15px',                    
                    'font-weight' => '500',                    
                ),
            ),
            array(
                'id'          => 'opt-typography-h1',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading H1', 'educavo' ),
                'font-backup' => true,                
                'all_styles'  => true,
                'units'       => 'px',
                'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'educavo' ),
                'default'     => array(
                    'color'       => '#333',
                    'font-style'  => '700',
                    'font-family' => 'Nunito',
                    'google'      => true,
                    'font-size'   => '46px',
                    'line-height' => '56px'
                    
                    ),
                ),
            array(
                'id'          => 'opt-typography-h2',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading H2', 'educavo' ),
                'font-backup' => true,                
                'all_styles'  => true,                 
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'educavo' ),
                'default'     => array(
                    'color'       => '#333',
                    'font-style'  => '700',
                    'font-family' => 'Nunito',
                    'google'      => true,
                    'font-size'   => '36px',
                    'line-height' => '46px'
                    
                ),
                ),
            array(
                'id'          => 'opt-typography-h3',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading H3', 'educavo' ),             
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'educavo' ),
                'default'     => array(
                    'color'       => '#333',
                    'font-style'  => '700',
                    'font-family' => 'Nunito',
                    'google'      => true,
                    'font-size'   => '28px',
                    'line-height' => '32px'
                    
                    ),
                ),
            array(
                'id'          => 'opt-typography-h4',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading H4', 'educavo' ),                
                'font-backup' => false,                
                'all_styles'  => true,               
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'educavo' ),
                'default'     => array(
                    'color'       => '#333',
                    'font-style'  => '700',
                    'font-family' => 'Nunito',
                    'google'      => true,
                    'font-size'   => '20px',
                    'line-height' => '28px'
                    ),
                ),
            array(
                'id'          => 'opt-typography-h5',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading H5', 'educavo' ),                
                'font-backup' => false,                
                'all_styles'  => true,                
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'educavo' ),
                'default'     => array(
                    'color'       => '#333',
                    'font-style'  => '700',
                    'font-family' => 'Nunito',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '26px'
                    ),
                ),
            array(
                'id'          => 'opt-typography-6',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading H6', 'educavo' ),
             
                'font-backup' => false,                
                'all_styles'  => true,                
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'educavo' ),
                'default'     => array(
                    'color'       => '#333',
                    'font-style'  => '700',
                    'font-family' => 'Nunito',
                    'google'      => true,
                    'font-size'   => '16px',
                    'line-height' => '20px'
                ),
            ),
                
        )
    )                    
   
);

    /*Blog Sections*/
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Blog', 'educavo' ),
        'id'               => 'blog',
        'customizer_width' => '450px',
        'icon' => 'el el-comment',
        )
    );
        
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Blog Settings', 'educavo' ),
        'id'               => 'blog-settings',
        'subsection'       => true,
        'customizer_width' => '450px',      
        'fields'           => array(
                array(
                    'id'    => 'blog_banner_main', 
                    'url'   => true,     
                    'title' => esc_html__( 'Blog Page Banner', 'educavo' ),                 
                    'type'  => 'media',                                  
                ),  

                array(
                    'id'        => 'blog_bg_color',
                    'type'      => 'color',                           
                    'title'     => esc_html__('Body Backgroud Color','educavo'),
                    'subtitle'  => esc_html__('Pick body background color', 'educavo'),
                    'default'   => '#fbfbfb',
                    'validate'  => 'color',                        
                ),
                
                array(
                    'id'       => 'blog_title',                               
                    'title'    => esc_html__( 'Blog  Title', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter Blog  Title Here', 'educavo' ),
                    'type'     => 'text',                                   
                ),
                
                array(
                    'id'               => 'blog-layout',
                    'type'             => 'image_select',
                    'title'            => esc_html__('Select Blog Layout', 'educavo'), 
                    'subtitle'         => esc_html__('Select your blog layout', 'educavo'),
                    'options'          => array(
                    'full'             => array(
                        'alt'              => esc_html__('Blog Style 1', 'educavo'), 
                        'img'              => get_template_directory_uri().'/libs/img/1c.png'          
                    ),
                    '2right'           => array(
                        'alt'              => esc_html__('Blog Style 2', 'educavo'), 
                        'img'              => get_template_directory_uri().'/libs/img/2cr.png'
                    ),
                    '2left'            => array(
                        'alt'              => esc_html__('Blog Style 3', 'educavo'), 
                        'img'              => get_template_directory_uri().'/libs/img/2cl.png'
                        ),                                  
                    ),
                    'default'          => '2right'
                ),                      
                
                array(
                    'id'               => 'blog-grid',
                    'type'             => 'select',
                    'title'            => esc_html__('Select Blog Gird', 'educavo'),                   
                    'desc'             => esc_html__('Select your blog gird layout', 'educavo'),
                //Must provide key => value pairs for select options
                'options'          => array(
                    '12'               => esc_html__('1 Column','educavo'),                                   
                    '6'                => esc_html__('2 Column', 'educavo'),                                         
                    '4'                => esc_html__('3 Column', 'educavo'),
                    '3'                => esc_html__('4 Column', 'educavo'),
                    ),
                    'default'          => '12',                                  
                ),  
                
                array(
                'id'               => 'blog-author-post',
                'type'             => 'select',
                'title'            => esc_html__('Show Author Info ', 'educavo'),                   
                'desc'             => esc_html__('Select author info show or hide', 'educavo'),
                //Must provide key => value pairs for select options
                'options'          => array(                                            
                'show'             => esc_html__('Show','educavo'), 
                'hide'             => esc_html__('Hide', 'educavo'),
                ),
                'default'          => 'show',
                
                ), 

                

                array(
                'id'               => 'blog-category',
                'type'             => 'select',
                'title'            => esc_html__('Show Category', 'educavo'),                   
               
                //Must provide key => value pairs for select options
                'options'          => array(                                            
                'show'             => esc_html__('Show','educavo'), 
                'hide'             => esc_html__('Hide', 'educavo'),
                ),
                'default'          => 'show',
                
                ), 
                
                array(
                    'id'               => 'blog-date',
                    'type'             => 'switch',
                    'title'            => esc_html__('Show Date', 'educavo'),                   
                    'desc'             => esc_html__('You can show/hide date at blog page', 'educavo'),
                    
                    'default'          => true,
                ), 
                array(
                    'id'               => 'blog_readmore',                               
                    'title'            => esc_html__( 'Blog  ReadMore Text', 'educavo' ),
                    'subtitle'         => esc_html__( 'Enter Blog  ReadMore Here', 'educavo' ),
                    'type'             => 'text',                                   
                ),
                
            )
        ) 
                
    );
    
    
    /*Single Post Sections*/
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single Post', 'educavo' ),
        'id'               => 'spost',
        'subsection'       => true,
        'customizer_width' => '450px',      
        'fields'           => array(                            
        
                            array(
                                    'id'       => 'blog_banner', 
                                    'url'      => true,     
                                    'title'    => esc_html__( 'Blog Single page banner', 'educavo' ),                  
                                    'type'     => 'media',
                                    
                            ),  
                           
                            array(
                                    'id'       => 'blog-comments',
                                    'type'     => 'select',
                                    'title'    => esc_html__('Show Comment', 'educavo'),                   
                                    'desc'     => esc_html__('Select comments show or hide', 'educavo'),
                                     //Must provide key => value pairs for select options
                                    'options'  => array(                                            
                                            'show' => esc_html__('Show', 'educavo'),
                                            'hide' => esc_html__('Hide', 'educavo'),
                                            ),
                                        'default'  => 'show',
                                        
                            ),  
                            
                            array(
                                    'id'       => 'blog-author',
                                    'type'     => 'select',
                                    'title'    => esc_html__('Show Ahthor Info', 'educavo'),                   
                                    'desc'     => esc_html__('Select author info show or hide', 'educavo'),
                                     //Must provide key => value pairs for select options
                                    'options'  => array(                                            
                                            'show' => esc_html__('Show', 'educavo'),
                                            'hide' => esc_html__('Hide', 'educavo'),
                                        ),
                                    'default'  => 'show',
                                        
                            ),  
                              
                        )
                ) 
    
    
    );

  
    /*Team Sections*/
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Team Section', 'educavo' ),
        'id'               => 'team',
        'customizer_width' => '450px',
        'icon' => 'el el-user',
        'fields'           => array(
        
            array(
                    'id'       => 'team_single_image', 
                    'url'      => true,     
                    'title'    => esc_html__( 'Team Single page banner image', 'educavo' ),                    
                    'type'     => 'media',
                    
            ),  

             array(
                    'id'        => 'team_single_bg_color',
                    'type'      => 'color',                           
                    'title'     => esc_html__('Sinlge Team Body Backgroud Color','educavo'),
                    'subtitle'  => esc_html__('Pick body background color', 'educavo'),
                    'default'   => '#fff',
                    'validate'  => 'color',                        
                ),
            
            array(
                    'id'       => 'team_slug',                               
                    'title'    => esc_html__( 'Team Slug', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter Team Slug Here', 'educavo' ),
                    'type'     => 'text',
                    'default'  => esc_html__('teams', 'educavo'),
                    
                ),      
                
                          
             )
         ) 
    );
    

    Redux::setSection( $opt_name, array(

        'title'            => esc_html__( 'Course', 'educavo' ),
        'id'               => 'course_layout',
        'customizer_width' => '450px',      
        'fields'           => array(          
            array(
                'id'       => 'course_banner',
                'url'      => true,
                'title'    => esc_html__( 'Single Course Page Banner', 'educavo' ),        
                'type'     => 'media',                       
                ), 
            array(
                'id'       => 'show_search_top',
                'type'     => 'switch', 
                'title'    => esc_html__('Hide Search at Single Search View', 'educavo'),
                'subtitle' => esc_html__('You can show or hide search here', 'educavo'),
                'default'  => false,
            ), 
            array(
                'id'       => 'show_banner__course',
                'type'     => 'switch', 
                'title'    => esc_html__('Hide Course Banner', 'educavo'),
                'subtitle' => esc_html__('You Can Hide Course Banner', 'educavo'),
                'default'  => false,
            ), 
            )
        ) 
    );
    

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single Course', 'educavo' ),
        'id'               => 'single_fea_layout',
        'customizer_width' => '450px',      
        'fields'           => array(          
            array(
                'id'       => 'lectures',
                'title'    => esc_html__( 'Lectures Text', 'educavo' ),        
                'type'     => 'text',                       
                ), 

            array(
                'id'       => 'quizzes',
                'title'    => esc_html__( 'Quizzes Text', 'educavo' ),        
                'type'     => 'text',                       
                ),
            array(
                'id'       => 'duration',
                'title'    => esc_html__( 'Duration Text', 'educavo' ),        
                'type'     => 'text',                       
                ),            
            array(
                'id'       => 'skilllevel',
                'title'    => esc_html__( 'Skill level', 'educavo' ),        
                'type'     => 'text',                       
                ),
            array(
                'id'       => 'students',
                'title'    => esc_html__( 'Students Text', 'educavo' ),        
                'type'     => 'text',                       
                ),
            array(
                'id'       => 'assessments',
                'title'    => esc_html__( 'Assessments Text', 'educavo' ),        
                'type'     => 'text',                       
                ),
            )
        ) 
    );


    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Social Icons', 'educavo' ),
        'desc'   => esc_html__( 'Add your social icon here', 'educavo' ),
        'icon'   => 'el el-share',
         'submenu' => true, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
        'fields' => array(
                    array(
                        'id'       => 'facebook',                               
                        'title'    => esc_html__( 'Facebook Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Facebook Link', 'educavo' ),
                        'type'     => 'text',                     
                    ),
                        
                     array(
                        'id'       => 'twitter',                               
                        'title'    => esc_html__( 'Twitter Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Twitter Link', 'educavo' ),
                        'type'     => 'text'
                    ),
                    
                        array(
                        'id'       => 'rss',                               
                        'title'    => esc_html__( 'Rss Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Rss Link', 'educavo' ),
                        'type'     => 'text'
                    ),
                    
                     array(
                        'id'       => 'pinterest',                               
                        'title'    => esc_html__( 'Pinterest Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Pinterest Link', 'educavo' ),
                        'type'     => 'text'
                    ),
                     array(
                        'id'       => 'linkedin',                               
                        'title'    => esc_html__( 'Linkedin Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Linkedin Link', 'educavo' ),
                        'type'     => 'text',
                        
                    ),
                     array(
                        'id'       => 'google',                               
                        'title'    => esc_html__( 'Google Plus Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Google Plus  Link', 'educavo' ),
                        'type'     => 'text',                       
                    ),

                    array(
                        'id'       => 'instagram',                               
                        'title'    => esc_html__( 'Instagram Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Instagram Link', 'educavo' ),
                        'type'     => 'text',                       
                    ),

                     array(
                        'id'       => 'youtube',                               
                        'title'    => esc_html__( 'Youtube Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Youtube Link', 'educavo' ),
                        'type'     => 'text',                       
                    ),

                    array(
                        'id'       => 'tumblr',                               
                        'title'    => esc_html__( 'Tumblr Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Tumblr Link', 'educavo' ),
                        'type'     => 'text',                       
                    ),

                    array(
                        'id'       => 'vimeo',                               
                        'title'    => esc_html__( 'Vimeo Link', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter Vimeo Link', 'educavo' ),
                        'type'     => 'text',                       
                    ),         
            ) 
        ) 
    );
    
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Mouse Pointer', 'educavo' ),
        'desc'   => esc_html__( 'Add your Mouse Pointer here', 'educavo' ),
        'icon'   => 'el el-hand-up',
         'submenu' => true, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
        'fields' => array(
                        array(
                            'id'       => 'show_pointer',
                            'type'     => 'switch', 
                            'title'    => esc_html__('Show Pointer', 'educavo'),
                            'subtitle' => esc_html__('You can show or hide Mouse Pointer', 'educavo'),
                            'default'  => false,
                        ), 

                        array(
                            'id'        => 'pointer_border',
                            'type'      => 'color',                       
                            'title'     => esc_html__('Pointer Border','educavo'),
                            'subtitle'  => esc_html__('Pick color', 'educavo'),    
                            'default'   => '#ff5421',                        
                            'validate'  => 'color',                        
                        ), 

                        array(
                            'id'       => 'border_width',                               
                            'title'    => esc_html__( 'Border Width', 'educavo' ),
                            'subtitle' => esc_html__( 'Enter Pointer Border Width', 'educavo' ),
                            'type'     => 'text',
                            'default'   => '2',                         
                        ), 

                        array(
                            'id'        => 'pointer_bg',
                            'type'      => 'color',                       
                            'title'     => esc_html__('Pointer Background','educavo'),
                            'subtitle'  => esc_html__('Enter Pointer Background color', 'educavo'),    
                            'default'   => 'transparent',                        
                            'validate'  => 'color',                        
                        ),  


                        array(
                            'id'       => 'diameter',                               
                            'title'    => esc_html__( 'Diameter', 'educavo' ),
                            'subtitle' => esc_html__( 'Enter Pointer diameter Size', 'educavo' ),
                            'type'     => 'text',  
                            'default'   => '40',                    
                        ),   

                        array(
                            'id'       => 'speed',                               
                            'title'    => esc_html__( 'Pointer Speed', 'educavo' ),
                            'subtitle' => esc_html__( 'Enter Pointer Scale Size', 'educavo' ),
                            'type'     => 'text',
                            'default'   => '4',                         
                        ),                     

                        array(
                            'id'       => 'scale',                               
                            'title'    => esc_html__( 'Hover Scale', 'educavo' ),
                            'subtitle' => esc_html__( 'Enter Pointer Scale Size', 'educavo' ),
                            'type'     => 'text',
                            'default'   => '1.3',                         
                        ),
            ) 
        ) 
    );
    if ( class_exists( 'WooCommerce' ) ) {
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Woocommerce', 'educavo' ),    
        'icon'   => 'el el-shopping-cart',    
        ) 
    ); 

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Shop', 'educavo' ),
        'id'               => 'shop_layout',
        'customizer_width' => '450px',
        'subsection' => true,      
        'fields'           => array(                      
            array(
                'id'       => 'shop_banner', 
                'url'      => true,     
                'title'    => esc_html__( 'Shop page banner', 'educavo' ),                    
                'type'     => 'media',
            ), 
            array(
                    'id'       => 'shop-layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Select Shop Layout', 'educavo'), 
                    'subtitle' => esc_html__('Select your shop layout', 'educavo'),
                    'options'  => array(
                        'full'      => array(
                            'alt'   => esc_html__('Shop Style 1','educavo'),
                            'img'   => get_template_directory_uri().'/libs/img/1c.png'                                      
                        ),
                        'right-col' => array(
                            'alt'   => esc_html__('Shop Style 2','educavo'), 
                            'img'   => get_template_directory_uri().'/libs/img/2cr.png'
                        ),
                        'left-col'  => array(
                            'alt'   => esc_html__('Shop Style 3','educavo'), 
                            'img'   => get_template_directory_uri().'/libs/img/2cl.png'
                        ),                                  
                    ),
                    'default' => 'full'
                ),

                array(
                    'id'       => 'wc_num_product',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Number of Products Per Page', 'educavo' ),
                    'default'  => '9',
                ),

                array(
                    'id'       => 'wc_num_product_per_row',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Number of Products Per Row', 'educavo' ),
                    'default'  => '3',
                ),

                array(
                    'id'       => 'wc_cart_icon',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Cart Icon Show At Menu Area', 'educavo' ),
                    'on'       => esc_html__( 'Enabled', 'educavo' ),
                    'off'      => esc_html__( 'Disabled', 'educavo' ),
                    'default'  => false,
                ), 

                 array(
                'id'       => 'disable-sidebar',
                'type'     => 'switch', 
                'title'    => esc_html__('Sidebar Disable For Single Product Page', 'educavo'),                
                'default'  => true,
            ), 
               
            )
        ) 
    );
}


    /*call-to-actio*/
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Newsletter Section', 'educavo' ),
        'id'               => 'call_to_action',
        'customizer_width' => '450px',
        'icon' => 'el el-indent-left',
        'fields'           => array(                

                array(
                    'id'       => 'call_tilte',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Title', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter title for call to action', 'educavo' ), 
                    'default'  => esc_html__('Subscribe Us to join Our Community', 'educavo')                
                ), 

                array(
                    'id'       => 'icons_to_d', 
                    'url'      => true,     
                    'title'    => esc_html__( 'Title Icon', 'educavo' ),                 
                    'type'     => 'media',                                  
                ), 

                array(
                    'id'       => 'icons_to_d_size',                               
                    'title'    => esc_html__( 'Icon Size', 'educavo' ),
                    'subtitle' => esc_html__( 'Icon Size max width example(40px)', 'educavo' ),
                    'type'     => 'text',
                    'default'  => '40px'                    
                ),  

                array(
                    'id'        => 'call_tilte_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Title Color','educavo'),
                    'default'   => '#fff',
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'       => 'call_des',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Sub Text', 'educavo' ),
                    'subtitle' => esc_html__( 'Enter sub text for call newsletter', 'educavo' ), 
                    'default'  => esc_html__('Newsletter', 'educavo')                
                ),  

                array(
                    'id'        => 'call_des_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Sub Text Color','educavo'),
                    'default'   => '#fff',
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'       => 'call_to_bg', 
                    'url'      => true,     
                    'title'    => esc_html__( 'Backgroud Image', 'educavo' ),                 
                    'type'     => 'media',                                  
                ),  

                array(
                    'id'        => 'news_bg_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Backgroud Color','educavo'),
                    'default'   => '#ff5421',
                    'validate'  => 'color',                        
                ),

                array(
                    'id'        => 'subscribe_input_bg_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Input Box Bg Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '',
                    'validate'  => 'color',                       
                ),

                        

                array(
                    'id'        => 'subscribe_input_text_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Input Box Text Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '',
                    'validate'  => 'color',                        
                ), 
          

                array(
                    'id'        => 'subscribe_btn_text_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Button Text Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '',
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'        => 'subscribe_input_button_bg_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Button Background Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '',
                    'validate'  => 'color',                        
                ), 

                array(
                    'id'        => 'subscribe_input_hover_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Button Hover Background Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '',
                    'validate'  => 'color',                        
                ),                                 
                     
            )
        ) 
    );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Event Section', 'educavo' ),
        'id'               => 'event',
        'customizer_width' => '450px',
        'icon' => 'el el-camera',
        'fields'           => array(
             array(
                'id'    => 'event_banner_main', 
                'url'   => true,     
                'title' => esc_html__( 'Event Main Page Banner', 'educavo' ),                 
                'type'  => 'media',                                  
            ),  
            array(
                'id'       => 'event_single_image', 
                'url'      => true,     
                'title'    => esc_html__( 'Event Single page banner image', 'educavo' ),                   
                'type'     => 'media', 
            ),  

            array(
                'id'        => 'event_title_font_size',
                'type'      => 'text',                       
                'title'    => __( 'Event Page Title Font Size', 'educavo' ),
                'subtitle' => __( 'Event page title font here', 'educavo' ),  
                'default'   => '',                                            
            ), 

            array(
                'id'       => 'event_info',                               
                'title'    => __( 'Event Page Title', 'educavo' ),
                'subtitle' => __( 'Event page title here', 'educavo' ),
                'type'     => 'text',
                'default'  => 'Event Main', 
            ), 

            array(
                'id'       => 'off_breadcrumb_event',
                'type'     => 'switch', 
                'title'    => esc_html__('Enable Breadcrumb', 'educavo'),
                'subtitle' => esc_html__('You can show or hide breadcrumb here', 'educavo'),
                'default'  => true,
            ),
            array(
                'id'       => 'date_style',
                'type'     => 'select',
                'title'    => esc_html__('Select Event Date Format', 'educavo'),                  
                'desc'     => esc_html__('Choose event date format', 'educavo'),
                'options'  => array(                                            
                        'style1' => 'mm / dd / yyyy',
                        'style2' => 'dd / mm / yyyy'
                        ),
                    'default'  => 'style1',    
            ),
            array(
                'id'       => 'time_style',
                'type'     => 'select',
                'title'    => esc_html__('Select Event Time Format', 'educavo'),                  
                'desc'     => esc_html__('Choose event time format', 'educavo'),
                'options'  => array(                                            
                        'style1' => '12 Hours clock',
                        'style2' => '24 Hours Clock'
                        ),
                    'default'  => 'style1',    
            ),
            array(
                'id'       => 'off_map_event',
                'type'     => 'switch', 
                'title'    => esc_html__('Enable Event Map', 'educavo'),
                'subtitle' => esc_html__('You can show or hide single event map here', 'educavo'),
                'default'  => true,
            ),
            array(
                'id'       => 'event_btn',                               
                'title'    => __( 'BooK Now', 'educavo' ),
                'subtitle' => __( 'Event book now here', 'educavo' ),
                'type'     => 'text',
                'default'  => 'Book Now', 
                
            ),
        )
    ));
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Notice Section', 'educavo' ),
        'id'               => 'notice',
        'customizer_width' => '450px',
        'icon' => 'el el-camera',
        'fields'           => array(
             array(
                    'id'    => 'notice_banner_main', 
                    'url'   => true,     
                    'title' => esc_html__( 'Notice Main Page Banner', 'educavo' ),                 
                    'type'  => 'media',                                  
                ),  
            array(
                    'id'       => 'notice_single_image', 
                    'url'      => true,     
                    'title'    => esc_html__( 'Notice Single page banner image', 'educavo' ),                   
                    'type'     => 'media',
                    
            ),  

            array(
                    'id'       => 'notice_info',                               
                    'title'    => __( 'Notice Page Title', 'educavo' ),
                    'subtitle' => __( 'Notice page title here', 'educavo' ),
                    'type'     => 'text',
                    'default'  => 'Notice Main', 
                    
            ),        
           
            
            array(
                'id'       => 'notice_slug',                               
                'title'    => __( 'Notice Slug', 'educavo' ),
                'subtitle' => __( 'Enter Notice Slug Here', 'educavo' ),
                'type'     => 'text',
                'default'  => '',                    
                ), 
            array(
                'id'       => 'off_breadcrumb_notice',
                'type'     => 'switch', 
                'title'    => esc_html__('Enable Breadcrumb', 'educavo'),
                'subtitle' => esc_html__('You can show or hide breadcrumb here', 'educavo'),
                'default'  => true,
            ),
            )
         ) 
    );



    Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Footer Option', 'educavo' ),
    'desc'   => esc_html__( 'Footer style here', 'educavo' ),
    'icon'   => 'el el-th-large',   
    'fields' => array(
                array(
                    'id'       => 'footer_bg_image', 
                    'url'      => true,     
                    'title'    => esc_html__( 'Footer Background Image', 'educavo' ),                 
                    'type'     => 'media',                                  
                ),

                array(
                    'id'               => 'background_position',
                    'type'             => 'select',
                    'title'            => esc_html__('Background Position', 'educavo'),             
                    'options'          => array(
                        'center center' => esc_html__( 'Center Center', 'educavo' ),
                        'center top'    =>  esc_html__( 'Center Top', 'educavo' ),          
                        'center bottom' =>  esc_html__( 'Center Bottom', 'educavo' ),           
                        'left top'      =>  esc_html__( 'Left Top', 'educavo' ),            
                        'left bottom'   =>  esc_html__( 'Left Bottom', 'educavo' ),         
                        'right top'     =>  esc_html__( 'Right Top', 'educavo' ),           
                        'right bottom'  =>  esc_html__( 'Right Bottom', 'educavo' ),
                    ),

                    'default'          => 'center bottom',            
                ),

                array(
                    'id'               => 'background_repeat',
                    'type'             => 'select',
                    'title'            => esc_html__('Background Repeat', 'educavo'),             
                    'options'          => array(
                        'repeat'    => esc_html__( 'Repeat', 'educavo' ),
                        'no-repeat' =>  esc_html__( 'No Repeat', 'educavo' ),            
                        'repeat-x'  =>  esc_html__( 'Repeat X', 'educavo' ),         
                        'repeat-y'  =>  esc_html__( 'Repeat Y', 'educavo' ),
                    ),

                    'default'          => 'no-repeat',            
                ),

                array(
                    'id'               => 'background_size',
                    'type'             => 'select',
                    'title'            => esc_html__('Background Size', 'educavo'),             
                    'options'          => array(
                        'auto'    => esc_html__( 'Auto', 'educavo' ),
                        'contain' =>  esc_html__( 'Contain', 'educavo' ),            
                        'cover'   =>  esc_html__( 'Cover', 'educavo' ),   
                        '100%'    =>  esc_html__( '100%', 'educavo' ),   
                    ),

                    'default'          => 'cover',            
                ),

                array(
                        'id'        => 'footer_bg_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Footer Bg Color','educavo'),
                        'subtitle'  => esc_html__('Pick color.', 'educavo'),
                        'default'   => '',
                        'validate'  => 'color',                        
                    ),  

                array(
                    'id'               => 'header_grid2',
                    'type'             => 'select',
                    'title'            => esc_html__('Footer Area Width', 'educavo'),                  
                    'options'          => array(                  
                    
                        'container' => esc_html__('Container', 'educavo'),
                        'full'      => esc_html__('Container Fluid', 'educavo')
                    ),

                    'default'          => 'container',            
                ),

                array(
                    'id'       => 'footer_logo',
                    'type'     => 'media',
                    'title'    => esc_html__( 'Footer Logo', 'educavo' ),
                    'subtitle' => esc_html__( 'Upload your footer logo', 'educavo' ),                  
                ), 

             
                array(
                    'id'       => 'footer-logo-height',                               
                    'title'    => esc_html__( 'Logo Height', 'educavo' ),
                    'subtitle' => esc_html__( 'Logo max height example(50px)', 'educavo' ),
                    'type'     => 'text',
                    'default'  => '30px'                    
                ),                                  
  
                array(
                    'id'        => 'footer_aicons_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Footer All Icon Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '#ff5421',
                    'validate'  => 'color',                        
                ), 


                array(
                    'id'        => 'foot_social_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Social Icon Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '#fff',
                    'validate'  => 'color',                        
                ),                

                array(
                    'id'        => 'foot_social_hover',
                    'type'      => 'color',
                    'title'     => esc_html__('Social Icon Hover','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '#eee',
                    'validate'  => 'color',                        
                ),   

                array(
                    'id'        => 'footer_text_size',
                    'type'      => 'text',                       
                    'title'     => esc_html__('Footer Font Size','educavo'),
                    'subtitle'  => esc_html__('Font Size', 'educavo'),    
                    'default'   => '16px',                                            
                ),  

                array(
                    'id'        => 'footer_h3_size',
                    'type'      => 'text',                       
                    'title'     => esc_html__('Footer Title Font Size','educavo'),
                    'subtitle'  => esc_html__('Font Size', 'educavo'),    
                    'default'   => '18px',                                            
                ),  

                array(
                    'id'        => 'footer_link_size',
                    'type'      => 'text',                       
                    'title'     => esc_html__('Footer Link Font Size','educavo'),
                    'subtitle'  => esc_html__('Font Size', 'educavo'),    
                    'default'   => '',                                            
                ), 
                array(
                    'id'        => 'footer_title_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Footer Title Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '#e0e0e0',
                    'validate'  => 'color',                        
                ),   

                array(
                    'id'        => 'footer_text_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Footer Text Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '#fff',
                    'validate'  => 'color',                        
                ),  

                array(
                    'id'        => 'footer_link_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Footer Link Hover Color','educavo'),
                    'subtitle'  => esc_html__('Pick color.', 'educavo'),
                    'default'   => '#ff5421',
                    'validate'  => 'color',                        
                ),                  
                
                array(
                    'id'       => 'copyright',
                    'type'     => 'textarea',
                    'title'    => esc_html__( 'Footer CopyRight', 'educavo' ),
                    'subtitle' => esc_html__( 'Add/Edit copyright text', 'educavo' ),
                    'default'  => esc_html__( '2020 All Rights Reserved', 'educavo' ),
                ),  

                array(
                    'id'       => 'copyright_bg',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Copyright Background', 'educavo' ),
                    'subtitle' => esc_html__( 'Copyright Background Color', 'educavo' ),      
                    'default'  => '',            
                ),
                array(
                    'id'       => 'copyright_borders',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Copyright Border Color', 'educavo' ),
                    'subtitle' => esc_html__( 'Copyright Border Color', 'educavo' ),      
                    'default'  => '',            
                ),
                array(
                    'id'       => 'copyright_text_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Copyright Text Color', 'educavo' ),
                    'subtitle' => esc_html__( 'Copyright Text Color', 'educavo' ),      
                    'default'  => '#e0e0e0',            
                ), 
            ) 
        ) 
    );

        Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Coming Soon Page', 'educavo' ),
        'desc'   => esc_html__( 'You can set coming soon/maintenance mode here', 'educavo' ),
        'icon'   => 'el el-time',    
        'fields' => array(

                    array(
                        'id'       => 'show-comingsoon',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Enable Coming Soon', 'educavo'),
                        'subtitle' => esc_html__('You can enable/disable coming soon', 'educavo'),
                        'default'  => false,
                    ),

                    array(
                        'id'       => 'coming_logo',
                        'type'     => 'media',
                        'title'    => esc_html__( 'Upload Coming Soon Logo', 'educavo' ),
                        'subtitle' => esc_html__( 'Upload your image', 'educavo' ),
                        'url'=> true                
                    ), 

                    array(
                        'id'       => 'coming_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Title', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter title for coming soon page', 'educavo' ), 
                        'default'  => esc_html__('Coming Soon', 'educavo')                
                    ),  
                    
                    array(
                        'id'       => 'coming_text',
                        'type'     => 'textarea',
                        'title'    => esc_html__( 'Text', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter text coming soon page', 'educavo' ),  
                        'default'  => esc_html__('Our Exciting Website Is Coming Soon! Check Back Later
    ', 'educavo')             
                    ),                         
                    
                    array(
                        'id'            => 'opt-date-time',
                        'type'          => 'text',
                        'title'         => esc_html__('Date/Time', 'educavo'),
                        'subtitle'      => esc_html__('Add Date/Time ex(Y-m-d  H:m:s)','educavo'), 
                        'default'  =>   esc_html__('2020-10-22 17:40:12','educavo'),                          
                    ),
                    array(
                        'id'       => 'coming_day',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Day Text', 'educavo' ),                  
                        'default'  => esc_html__('Days', 'educavo')                
                    ),

                  
                    array(
                        'id'       => 'coming_hour',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Hour Text', 'educavo' ),                  
                        'default'  => esc_html__('Hours', 'educavo')                
                    ), 

                    array(
                        'id'       => 'coming_min',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Minute Text', 'educavo' ),                  
                        'default'  => esc_html__('Minutes', 'educavo')                
                    ),

                   

                    array(
                        'id'       => 'coming_sec',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Second Text', 'educavo' ),                  
                        'default'  => esc_html__('Seconds', 'educavo')                
                    ),

                   
                  
                    array(
                        'id'       => 'coming_bg',
                        'type'     => 'media',
                        'title'    => esc_html__( 'Upload Page Background', 'educavo' ),
                        'subtitle' => esc_html__( 'Upload your image', 'educavo' ),
                        'url'=> true                
                    ), 

                     array(
                        'id'       => 'fllow_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Social Title', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter title', 'educavo' ), 
                        'default'  => esc_html__('Follow us', 'educavo')                
                    ), 

                    array(
                        'id'        => 'text_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Text Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#fff',                        
                        'validate'  => 'color',                        
                    ),

                    array(
                        'id'        => 'circle_border_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Countdown Circle Border Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#fff',                        
                        'validate'  => 'color',                        
                    ), 

                    array(
                        'id'        => 'circle_primary_color',
                        'type'      => 'color',                       
                        'title'     => esc_html__('Countdown Circle Bg Color','educavo'),
                        'subtitle'  => esc_html__('Pick color', 'educavo'),    
                        'default'   => '#ff5421',                        
                        'validate'  => 'color',                        
                    ),       
                                      
                ) 
            ) 
        ); 

    
    Redux::setSection( $opt_name, array(
    'title'  => esc_html__( '404 Error Page', 'educavo' ),
    'desc'   => esc_html__( '404 details  here', 'educavo' ),
    'icon'   => 'el el-error-alt',    
    'fields' => array(

                array(
                        'id'       => 'title_404',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Title', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter title for 404 page', 'educavo' ), 
                        'default'  => esc_html__('404', 'educavo')                
                    ),  
                
                array(
                        'id'       => 'text_404',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Text', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter text for 404 page', 'educavo' ),  
                        'default'  => esc_html__('Page Not Found', 'educavo')             
                    ),                      
                       
                
                array(
                        'id'       => 'back_home',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Back to Home Button Label', 'educavo' ),
                        'subtitle' => esc_html__( 'Enter label for "Back to Home" button', 'educavo' ),
                        'default'  => esc_html__('Back to Homepage', 'educavo')  
                                    
                    ),                             
            
                                  
            ) 
        ) 
    );   


    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";           
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.     
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'educavo' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'educavo' ),
                'icon'   => 'el el-paper-clip',              
                'fields' => array()
            );
            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_action( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );              
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }