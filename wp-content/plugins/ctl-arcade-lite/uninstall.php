<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    //if uninstall not called from WordPress exit
    if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
        exit();
    }    
    
    require_once("config.php");
    require_once("db.php");
   
    $option_name = 'CTL_ARCADE_LITE_PLUGIN_VERSION';

    $installed_ver = get_option( $option_name );
    if( ($installed_ver == CTL_ARCADE_LITE_PLUGIN_VERSION) ) {
        ctl_arcade_lite_remove_db();
    }

    delete_option( $option_name );

    // For site options in multisite
    delete_site_option( $option_name );



