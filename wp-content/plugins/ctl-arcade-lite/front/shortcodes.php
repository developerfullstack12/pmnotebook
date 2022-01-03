<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    }
    
    function ctl_arcade_lite_print_shortcode( $atts ) {
        
        ob_start();
     

        switch($atts["mode"]){
            case "iframe":{

                if (!defined('CTL_ARCADE_SHORTCODE_MODE_IFRAME')) {
                    define('CTL_ARCADE_SHORTCODE_MODE_IFRAME',true);
                } else {
                    break;
                }

        
                if( !is_plugin_active( $atts["game"]."/".$atts["game"].".php")){
                    ?>
                    <div>
                        <p class="ctl-arcade-lite-admin-message-red">Game <?php echo $atts["game"]; ?> Disabled or not Installed!</p>
                    </div>
                <?php
                }else{                
                 
                    global $wpdb;

                    $oGame = $wpdb->get_results( "SELECT * FROM " . CTL_ARCADE_LITE_DB_TABLE_GAMES .
                        " WHERE game_plugin_dir = '". $atts["game"] ."'" )[0];
              
                    if(!$oGame){
                        ?>
                        <div>
                            <p class="ctl-arcade-lite-admin-message-red">Game <?php echo $atts["game"]; ?> Not Installed!</p>
                        </div>
                        <?php
                        return;
                    }

                    $iframeUrl = plugins_url() . "/". $atts["game"] . "/game/";
                    ?>

                    <div class="ctl-arcade-lite-game-iframe-wrapper">
                        <iframe class='ctl-arcade-lite-game-iframe'
                                <?php
                                    if(isset($atts["max-height"])) {
                                        echo 'data-max-height="' . $atts["max-height"] . '"';
                                    }
                                 ?>
                                data-aspect-ratio="<?php echo $oGame->game_aspect_ratio; ?>"
                                data-src="<?php echo $iframeUrl;?>"
                                src="<?php echo $iframeUrl; ?>"
                                width="100%"
                                height="500px"
                                scrolling="no"></iframe>
                    </div>


                <?php
                }
            }break;
        }

        return ob_get_clean();
    }
