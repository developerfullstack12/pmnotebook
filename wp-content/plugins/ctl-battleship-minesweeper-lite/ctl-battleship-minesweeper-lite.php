<?php
    /*
    Plugin Name: CTL Arcade Lite - Battleship Minesweeper Lite
    Plugin URI: http://www.codethislab.com/
    Description: Battleship Minesweeper Lite for CTL Arcade Lite Wordpress Plugin.
    Version: 1.0
    Author: Code This Lab srl
    Author URI: http://www.codethislab.com/
    License: GPL
    Copyright: Code This Lab srl
    */

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class CTLArcadeBattleshipMinesweeper {

        // variabili membro
        private $_szCompatibleArcadeVersion = "1";
        private $_szPluginDir               = "ctl-battleship-minesweeper-lite";
        private $_szPluginName              = "Battleship Minesweeper";
        private $_szAspectRatio             = "9:16";
        private $_bGameRankAvailable        = 1; // 1 yes, 0 no
        private $_szGameTags                = "canvas, html5, minesweeper, mobile, puzzle, strategy,windows game,field of flower,campo minato,démineur,buscaminas,campo minado,android, ios";
        protected $_szAdminPageUrl            = null;

        // funzioni
        public function __construct() {
            $this->_szAdminPageUrl = admin_url() . "admin.php?page=" . $this->_szPluginDir . "-";

            register_activation_hook( __FILE__,
                array( $this, 'onInstallDbData' ) );
            add_action( 'admin_menu',
                array( $this, 'onMenu' ) );
            register_activation_hook( __FILE__,
                array($this,'onSetActivationRedirect') );
            add_action( 'admin_init',
                array( $this, 'onActivationRedirect') );

        }

        private function __checkArcadePluginVersion(){
            $installed_ver = get_option( "CTL_ARCADE_LITE_PLUGIN_VERSION" );            
            
            if(!$installed_ver){
                return false;
            }

            $aVersions = explode(" ", $installed_ver);

            if( intval($aVersions[0]) != intval($this->_szCompatibleArcadeVersion) ){
                return false;
            }

            return true;
        }

        private function __checkDbData(){
            global $wpdb;
            $oRow = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "ctl_arcade_lite_games WHERE game_plugin_dir = '". $this->_szPluginDir."'");

            if( !$oRow ){
                return false;
            }
            return true;
        }

        private function __printAdminMenu($szSection){
            $aMenu = array();

            array_push($aMenu, array(
                "label" => "ctl_arcade_lite_game_". $this->_szPluginDir,
                "title" => "Install" 
            ) );

            array_push($aMenu, array( 
                "label" => "ctl_arcade_lite_games",
                "title" => "Premium Games"
            ));            
            
            array_push($aMenu, array(
                "label" => "ctl_arcade_lite_games_about_us",
                "title" => "About Us"
            ) );                
            
            array_push($aMenu, array(
                "label" => "ctl-plugins",
                "title" => "CTL Plugins"
            ) );            


            ?>
            <h2 id="wsal-tabs" class="nav-tab-wrapper">
                <?php
                    foreach( $aMenu as $oLink ){
                        if( $oLink["label"] == "ctl-plugins"){
                            $target = "_blank";
                            $href = "https://codecanyon.net/collections/5964631-ctl-plugins/?ref=codethislab"; 
                        }else{
                            $target = "_self";
                            $href = "?page=" . $oLink["label"]; 
                        }                        
                        echo '<a target="'. $target .'" href="'. $href .'" class="nav-tab '. (strcmp($szSection, $oLink["label"]) == 0 ? "nav-tab-active" : "") .'">'. $oLink["title"] . '</a>';
                    }
                ?>
            </h2>
            <?php
        }
        
        private function __copyFiles( $szFileName ){

            $upload_dir = wp_upload_dir();
            $_szFileName = $szFileName;

            if ( !$this->__checkRecursiveFileExists($szFileName, $upload_dir["basedir"]) ){
                // $filename should be the path to a file in the upload directory.
                $szPath = plugins_url() .
                    "/" . $this->_szPluginDir .
                    "/images/". $_szFileName;

                media_sideload_image($szPath,0);
            }
        }

        private function __checkRecursiveFileExists($filename, $directory){
            try {
                // loop through the files in directory
                foreach(new recursiveIteratorIterator( new recursiveDirectoryIterator($directory)) as $file) {
                    // if the file is found
                    if( $filename == basename($file) ) {
                        return true;

                    }
                }
                // if the file is not found
                return false;
            } catch(Exception $e) {
                // if the directory does not exist or the directory
                // or a sub directory does not have sufficent
                //permissions return false
                return false;
            }
        }

        public function onMenu() {

            if( !(is_plugin_active("ctl-arcade-lite/ctl-arcade-lite.php") &&
                $this->__checkArcadePluginVersion() &&
                $this->__checkDbData()) ){


                $bAppendPages = false;
                if ( empty ( $GLOBALS['admin_page_hooks']['ctl_arcade_lite_games'] ) ){
                    add_menu_page(
                        'CTL Games',
                        'CTL Games',
                        'manage_options',
                        'ctl_arcade_lite_games',
                        array( $this, 'onShowDollyPage'),
                        'dashicons-smiley'
                    );
                    $bAppendPages = true;
                }
                
                add_submenu_page( 'ctl_arcade_lite_games',
                    $this->_szPluginName,
                    "Install " . $this->_szPluginName, 'manage_options',
                    'ctl_arcade_lite_game_'.$this->_szPluginDir,
                    array($this, "onShowSettings") );                
                
                if ( $bAppendPages == true ){                    
                    add_submenu_page( 'ctl_arcade_lite_games', 
                                      "Premium Games", 
                                      "Premium Games", 
                                      'manage_options',
                                      'ctl_arcade_lite_games', 
                                       array( $this,"onShowDollyPage") );
                    
                    add_submenu_page( 'ctl_arcade_lite_games',
                                        "About Us",
                                        "About Us",
                                        'manage_options',
                                        "ctl_arcade_lite_games_about_us",
                                        array($this, "onShowAboutUs") );                
                 
                }
                
            }else{
                add_filter( 'plugin_action_links_' . plugin_basename(__FILE__),
                    array($this,'onAddActionLinks') );
            }
        }

        public function onShowDollyPage(){
            ?>
            <div class="wrap">
                <h1>Premium Games</h1>
                <?php             
                    $this->__printAdminMenu(filter_input(INPUT_GET, 'page'));
                ?>
                
                <p>Check if new games are available: <a target="_blank" href="http://codecanyon.net/collections/5401443-ctl-arcade-plugin/?ref=codethislab">http://codecanyon.net/collections/5401443-ctl-arcade-plugin</a>.</p>

                <p>These games works only with <a target="_blank" href="https://codecanyon.net/item/ctl-arcade-wordpress-plugin/13856421/?ref=codethislab">CTL Arcade Full</a>.</p>                
                
                <?php                    
                    $this->printFooter();
                ?>
            </div>
        <?php
        }

        public function onInstallDbData(){
            global $wpdb;

            if(!$this->__checkArcadePluginVersion() ||
                $this->__checkDbData() ){
                return false;
            }

            $oResult = $wpdb->insert(
                $wpdb->prefix ."ctl_arcade_lite_games",
                array(
                    'time'              => current_time( 'mysql' ),
                    'game_plugin_dir'   => $this->_szPluginDir,
                    'game_name'         => $this->_szPluginName,
                    'game_aspect_ratio' => $this->_szAspectRatio,
                    'game_rank'         => $this->_bGameRankAvailable,
                    'game_tags'         => $this->_szGameTags,
                    'game_settings'     => ""
                )
            );

            if(!$oResult){
                $wpdb->print_error();
                return false;
            }

            for($i = 0; $i < 3; $i++){
                $this->__copyFiles($this->_szPluginDir ."-". $i .".jpg");
            }
            $this->__copyFiles($this->_szPluginDir ."-icon.png");

            return true;
        }

        public function printFooter(){
            ?>
            <div>
                <p>------------</p>
                <div>
                    <span>Copyright ©</span>
                    <span>Code This Lab srl 2009-<?php echo date("Y"); ?></span>
                </div>
                <div>
                    <span>VAT IT06367951214</span>
                    <span>REA NA810739</span>
                </div>
                <div>
                    <span>cap soc. €16'000,00 i.v.</span>
                </div>
                <div>
                    <a target="_blank" href="mailto:support@codethislab.com">support@codethislab.com</a>
                </div>
                <div>
                    <a target="_blank" href="http://www.codethislab.com">www.codethislab.com</a>
                </div>
            </div>
            <?php
        }
        
        public function onShowAboutUs(){

            ?>
            <div class="wrap">                
                <h1>About Us</h1>
                <?php             
                    $this->__printAdminMenu(filter_input(INPUT_GET, 'page'));
                ?>   
                
                <br>
                
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.5&appId=49655289489";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>

                <img width="100%;" src="<?php echo plugins_url() . "/" . $this->_szPluginDir; ?>/images/ctl_banner.jpg">

                <p>We started as game developers then we broadened our horizons to explore new worlds.</p>
                <p>As the days went by, our working group got bigger, we acquired new skills and now we are a team able to deal with all that concern the digital world.</p>

                <p>We live in Naples, a city that spreads passion.</p>
                <p>The same passion that allows us creating new and original digital contents to meet our customers’ requirements tirelessly.</p>

                <p>Our “motto” is: <strong>If you can imagine it, we can create it for you</strong>.</p>
                <p>We are here to welcome your ideas to make them come true.</p>


                <div>
                    <div>
                        <a class="twitter-timeline" href="https://twitter.com/CodeThisLab" data-widget-id="654309982813483009">Tweets by @CodeThisLab</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    </div>

                    <div>
<div class="fb-page" data-href="https://www.facebook.com/codethislabsrl" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/codethislabsrl" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/codethislabsrl">Code This Lab srl</a></blockquote></div>
                    </div>

                </div>
            </div>
            <?php
            $this->printFooter();
        }
        
        public function onShowSettings(){

            $page = filter_input(INPUT_GET, 'sub');

            switch($page){
                case "install":{
                    $this->onInstallDbData();
                }break;
            }

            ?>

            <div class="wrap">
                <h1><?php echo $this->_szPluginName; ?></h1>
                <?php             
  
                    $this->__printAdminMenu(filter_input(INPUT_GET, 'page'));
                
                    if ( !current_user_can( 'manage_options' ) )  {
                        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
                    }
                ?>

                <?php
                
                    if( is_plugin_inactive("ctl-arcade-lite/ctl-arcade-lite.php") ){
                        ?>
                        <p>In order to use the game, you have to install and enable the <strong>CTL Arcade
                                Plugin</strong> first.</p>

                        <p>Download it from wordpress plugin directory: <a target="_self" href="<?php 
                        
                        if(is_multisite()){
                            echo "network/";
                        }else{
                            echo "";
                        }
                        
                        ?>plugin-install.php?s=ctl+arcade&tab=search&type=term">CTL Arcade Lite</a></p>   
                    <?php
                    }else if( !$this->__checkArcadePluginVersion() ){
                        ?>
                        
                        TEST TEST
                        
                        <h1>Attention</h1>
                        <p>This game is compatible with <strong>CTL Arcade Plugin ver <?php echo $this->_szCompatibleArcadeVersion; ?>.</strong></p>

                        <p>In order to use the game, you have to install the compatible <strong>CTL Arcade Plugin</strong>, or
                            vice versa.</p>
                        <p>You can buy it from this url: <a target="_blank" href="http://codecanyon.net/user/codethislab/portfolio/?ref=codethislab">http://codecanyon.net/user/codethislab/portfolio</a></p>

                    <?php
                    }else if(!$this->__checkDbData()){
                        $this->onInstallDbData();
                        
                        if( is_plugin_active( "ctl-arcade-lite/ctl-arcade-lite.php") ){
                        ?>
                        <p>Click <a target="_self" href="<?php echo admin_url() .
                                    "admin.php?page=ctl_arcade_lite_page_manage_games&game=" . $this->_szPluginDir; ?>">here</a> to manage the game.</p>
                        <?php
                        }
                    }else{
                        ?>
                        <p>Go to the <a href="<?php echo admin_url(); ?>admin.php?page=ctl_arcade_lite_page_manage_games&game=<?php echo $this->_szPluginDir; ?>">plugin page</a> to edit game settings for CTL Arcade Plugin</p>
                    <?php
                    }
                    
                    $this->printFooter();
                ?>
            </div>
        <?php
        }

        public function onSetActivationRedirect(){
            add_option($this->_szPluginDir . '_do_activation_redirect', true);
        }

        public function onActivationRedirect() {
            if (get_option($this->_szPluginDir . '_do_activation_redirect', false)) {
                delete_option($this->_szPluginDir . '_do_activation_redirect');

                if(!isset($_GET['activate-multi']) &&
                    is_admin() &&
                    is_plugin_active($this->_szPluginDir . "/" .
                        $this->_szPluginDir . ".php") &&
                    filter_input(INPUT_GET, 'action') != "deactivate" &&
                        is_plugin_active("ctl-arcade-lite/ctl-arcade-lite.php") ) {
                    
                    wp_redirect(admin_url() .
                        "admin.php?page=ctl_arcade_lite_page_manage_games&game=" .
                        $this->_szPluginDir );
                 
                }
            }
        }

        public function onAddActionLinks ( $links ) {
            $mylinks = array(
                '<a href="' . admin_url() .
                'admin.php?page=ctl_arcade_lite_page_manage_games&game='.
                $this->_szPluginDir .'">Settings</a>',
            );
            return array_merge( $mylinks, $links );
        }
    }

    $g_oCTLArcadeBattleshipMinesweeper =  new CTLArcadeBattleshipMinesweeper();
