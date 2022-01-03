<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    global $wpdb;

    define("CTL_ARCADE_LITE_PLUGIN_VERSION", "1.0.0" );
    define("CTL_ARCADE_LITE_DB_TABLE_PREFIX", "ctl_arcade_lite_" );

    define("CTL_ARCADE_LITE_PLUGIN_DIR", "ctl-arcade-lite" );
    define("CTL_ARCADE_LITE_PLUGIN_NAME", "CTL Arcade Lite" );

    define("CTL_ARCADE_LITE_DB_TABLE_SETTINGS", $wpdb->prefix . CTL_ARCADE_LITE_DB_TABLE_PREFIX . "settings" );
    define("CTL_ARCADE_LITE_DB_TABLE_GAMES", $wpdb->prefix . CTL_ARCADE_LITE_DB_TABLE_PREFIX . "games" );
