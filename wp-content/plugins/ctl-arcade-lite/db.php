<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }// Exit if accessed directly
    
    function ctl_arcade_lite_remove_db(){
        global $wpdb;
        $wpdb->query( "DROP TABLE IF EXISTS ". CTL_ARCADE_LITE_DB_TABLE_SETTINGS );
        $wpdb->query( "DROP TABLE IF EXISTS ". CTL_ARCADE_LITE_DB_TABLE_GAMES );
    }


    function ctl_arcade_lite_install_db_schema() {
        global $wpdb;
        $installed_ver = get_option( "CTL_ARCADE_LITE_PLUGIN_VERSION" );

        if( ($installed_ver != CTL_ARCADE_LITE_PLUGIN_VERSION) ) {

            $charset_collate = $wpdb->get_charset_collate();

            // create table settings
            $sql = "CREATE TABLE ". CTL_ARCADE_LITE_DB_TABLE_SETTINGS . " (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                option_name varchar(64) CHARACTER SET ascii NOT NULL,
                option_value text CHARACTER SET ascii NOT NULL,
                UNIQUE KEY id (id),
                UNIQUE KEY option_name (option_name)
            ) $charset_collate;";
            $wpdb->query( $sql );


            // create table games
            $sql = "CREATE TABLE ". CTL_ARCADE_LITE_DB_TABLE_GAMES . " (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                game_plugin_dir varchar(32) CHARACTER SET ascii NOT NULL,
                game_name varchar(64) CHARACTER SET ascii NOT NULL,
                game_aspect_ratio varchar(5) CHARACTER SET ascii NOT NULL,
                game_settings text CHARACTER SET ascii NOT NULL,
                game_tags text CHARACTER SET ascii NOT NULL,
                game_rating_value_votes bigint DEFAULT 0,
                game_rating_num_votes bigint DEFAULT 0,
                game_rank tinyint(1),
                UNIQUE KEY id (id),
                UNIQUE KEY game_name (game_name)
            ) $charset_collate;";
            $wpdb->query( $sql );

            add_option( 'CTL_ARCADE_LITE_PLUGIN_VERSION', CTL_ARCADE_LITE_PLUGIN_VERSION );
        }
    }

    function ctl_arcade_lite_update_db_check() {
        if (get_site_option('CTL_ARCADE_LITE_PLUGIN_VERSION') != CTL_ARCADE_LITE_PLUGIN_VERSION) {
            // there are no update
        }
    }