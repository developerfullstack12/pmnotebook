<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    function _ctl_arcade_lite_page_game_page($szGamePluginDir) {
        ?>
        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_main_menu"
               class="ctl-arcade-lite-btn">Plugin settings</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games" class="ctl-arcade-lite-btn">games list</a>   
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>
            
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
               class="ctl-arcade-lite-btn">about us</a>
               
            <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>                
        </div>
<?php
        global $wpdb;

        $oGame = $wpdb->get_results( "SELECT * FROM " . CTL_ARCADE_LITE_DB_TABLE_GAMES . " WHERE game_plugin_dir = '". $szGamePluginDir ."'" );

        if(!$oGame){
            ?>
                <p class="ctl-arcade-lite-admin-message-red">Game not Found!</p>
            <?php
            return false;
        }

        $oGame = $oGame[0];

 
        ?>
        <h3><?php echo $oGame->game_name; ?></h3>

        <div>
            <img class="ctl-arcade-lite-admin-game-cover" src="<?php echo plugins_url() . "/" . $oGame->game_plugin_dir;
            ?>/images/cover.jpg"/>
        </div>

        <h3>Description</h3>
        <?php
            echo file_get_contents(plugins_url() . "/" . $oGame->game_plugin_dir . "/description.html");
        ?>

        <h3>Status</h3>

        <?php
            if( is_plugin_inactive( $oGame->game_plugin_dir . "/". $oGame->game_plugin_dir .".php")){
                ?>
                <p>Game correctly installed but <strong>disabled</strong>!</p>
                <a class="ctl-arcade-lite-btn ctl-arcade-lite-btn-mini" href="<?php echo
                admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games&game=<?php echo $oGame->game_plugin_dir; ?>&action=activate&sub=game">activate</a>
                <?php
            }else{
                ?>
                <p>Game correctly installed!</p>
                <a class="ctl-arcade-lite-btn ctl-arcade-lite-btn-mini" href="<?php echo
                admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games&game=<?php echo $oGame->game_plugin_dir; ?>&action=deactivate&sub=game">deactivate</a>
                <?php
            }
        ?>

        <h3>Pictures</h3>

        <section class="ctl-arcade-lite-admin-game-gallery" data-gallery="shots">
            <?php
                for( $i = 0; $i < 3; $i++){
                    $szImg =
                        plugins_url() . "/" . $oGame->game_plugin_dir . "/images/" .
                        $oGame->game_plugin_dir . "-" . $i . ".jpg";
                    ?>
                    <div class="ctl-arcade-lite-admin-game-gallery-item" data-fullsize="<?php echo $szImg; ?>"><img src="<?php echo $szImg; ?>"></div>
                    <?php
                }
            ?>
        </section>

        <h3>Testing</h3>
        <p>Try the game</p>

        <div class="ctl-arcade-lite-game-preview-window">
            <?php
                echo ctl_arcade_lite_print_shortcode(
                    array( "mode" => "iframe", "game" => $oGame->game_plugin_dir ) );
            ?>
        </div>

        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_main_menu"
               class="ctl-arcade-lite-btn">plugin settings</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games" class="ctl-arcade-lite-btn">games list</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
               class="ctl-arcade-lite-btn">about us</a>
           <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>                             
        </div>

        <?php
    }
    
    function _ctl_arcade_lite_page_game_list() {
        ?>
        
        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_main_menu"
               class="ctl-arcade-lite-btn">Plugin settings</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
               class="ctl-arcade-lite-btn">about us</a>
            <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>                           
        </div>
        
        <?php
        
        
        global $wpdb;

        $aGames = $wpdb->get_results( "SELECT * FROM " . CTL_ARCADE_LITE_DB_TABLE_GAMES . " ORDER BY game_name ASC" );
        $iNumGames = count($aGames);
        $aInstalledGames = array();

        if( $iNumGames > 0 ){
            ?>
            <h3>List of installed games ( <?php echo $iNumGames; ?> )</h3>

            <p>Search by tag or name</p>
            <input type="text" placeholder="puzzle..." class="ctl-arcade-lite-installed-game-filter"/>


            <div class="ctl-arcade-lite-admin-game-list ctl-arcade-lite-admin-installed-game-list">
                <?php
                    foreach($aGames as $oGame){

                        $aInstalledGames[$oGame->game_plugin_dir] = true;

                        if( is_plugin_inactive( $oGame->game_plugin_dir . "/". $oGame->game_plugin_dir .".php")){
                            $bGameActive = false;
                        }else{
                            $bGameActive = true;
                        }
                        ?>
                        <div class="ctl-arcade-lite-admin-game-preview-box" data-tags="<?php echo $oGame->game_tags; ?>">
                            <a target="_self" href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games&game=<?php echo $oGame->game_plugin_dir; ?>">
                                <h3><?php echo $oGame->game_name; ?></h3>
                                <img class="ctl-arcade-lite-traffic-light" src="<?php echo plugins_url() . "/" . CTL_ARCADE_LITE_PLUGIN_DIR;?>/images/<?php echo ($bGameActive ? "traffic_light_circle_green.png" : "traffic_light_circle_red.png" ); ?>">
                                <img class="ctl-arcade-lite-admin-game-preview-thumb" src="<?php echo plugins_url() . "/" . $oGame->game_plugin_dir;?>/images/<?php echo $oGame->game_plugin_dir; ?>-icon.png"/>
                            </a>
                            <div class="ctl-arcade-lite-admin-game-preview-box-footer">
                                <?php
                                    if(!$bGameActive){
                                        ?>
                                        <a class="ctl-arcade-lite-btn ctl-arcade-lite-btn-mini" href="<?php echo
                                        admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games&game=<?php echo $oGame->game_plugin_dir; ?>&action=activate&sub=list">activate</a>
                                        <?php
                                    }else{
                                        ?>
                                        <a class="ctl-arcade-lite-btn ctl-arcade-lite-btn-mini" href="<?php echo
                                        admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games&game=<?php echo $oGame->game_plugin_dir; ?>&action=deactivate&sub=list">deactivate</a>
                                    <?php
                                    }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                ?>
            </div>

            <div class="ctl-clear"></div>

            <div>
                <p class="ctl-arcade-lite-admin-message-red ctl-arcade-lite-admin-installed-game-list-message"></p>
            </div>
        <?php
            }else{

            ?>
            <h3>There are no games installed!</h3>

            <p>Check under "CTL Arcade Games" menu if there are some games to install or buy them from <a href="http://codecanyon.net/collections/5401443-ctl-arcade-lite-plugin/?ref=codethislab" target="_blank">our full catalogue</a>.</p>
            
            <p>Our premium games works only with <a target="_self" href="https://codecanyon.net/checkout/16947696/?ref=codethislab">CTL Arcade (Full version)</a>.</p>

            
            <h4>Free games for CTL Arcade Lite:</h4>
            <ul>
                <li>
                    
                    <a target="_self" href="<?php 
                        
                        if(is_multisite()){
                            echo "network/";
                        }else{
                            echo "";
                        }
                        
                        ?>plugin-install.php?s=ctl+battleship+minesweeper&tab=search&type=term">CTL Battleship Minesweeper Lite</a>
                    
                    </a></li>
            </ul>
            
            <?php
        }
?>
       
        <div>
            <a href="http://codecanyon.net/collections/5401443-ctl-arcade-lite-plugin/?ref=codethislab" target="_blank">
                <h3 class="ctl-arcade-lite-admin-message-green">We develop the best HTML5 Games on Envato<br>Discover our full catalog!</h3>
            
                <div>
                    <img class="ctl-arcade-lite-img-responsive-2" src="<?php echo plugins_url() ?>/ctl-arcade-lite/images/img_new_games.png"/>    
                            
                </div>
</a>
        </div>

        <div class="ctl-arcade-lite-game-settings-btn-wrapper">
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_main_menu"
               class="ctl-arcade-lite-btn">Plugin settings</a>             
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_documentation" class="ctl-arcade-lite-btn">documentation</a>                 
            <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_company"
               class="ctl-arcade-lite-btn">about us</a>
            <a href="https://codecanyon.net/collections/5964631/?ref=codethislab" class="ctl-arcade-lite-btn">CTL Plugins</a>                           
        </div>

        <?php
    }

   
    function ctl_arcade_lite_page_manage_games() {

        ?>
        <div class="ctl-arcade-lite-wrapper">
            
        <h2>Manage Games</h2>
        <?php


        $szGame = filter_input(INPUT_GET, 'game');

        if($szGame){
            $action = filter_input(INPUT_GET, 'action');
            switch($action){
                case "activate":{
                    activate_plugin($szGame . "/" . $szGame . ".php");
                    $sub = filter_input(INPUT_GET, 'sub');
                    if( $sub == "list"){
                        _ctl_arcade_lite_page_game_list();
                    }else{
                        _ctl_arcade_lite_page_game_page($szGame);
                    }
                }break;
                case "deactivate":{
                    deactivate_plugins($szGame . "/" . $szGame . ".php");
                    $sub = filter_input(INPUT_GET, 'sub');
                    if( $sub == "list"){
                        _ctl_arcade_lite_page_game_list();
                    }else{
                        _ctl_arcade_lite_page_game_page($szGame);
                    }
                }break;
                default:{
                    _ctl_arcade_lite_page_game_page($szGame);
                }
            }
        }else{
            _ctl_arcade_lite_page_game_list();
        }

            ctl_arcade_lite_print_footer();
        ?>

        </div>
        <?php
    }

?>