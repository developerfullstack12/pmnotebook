<?php
class EducavoWordPressTheme {
	public $plugin_file   =__FILE__;
	public $responseObj;
	public $licenseMessage;
	public $showMessage   =false;
	public $slug          ="educavo";
	private $product_id   = "55";
	private $product_name = "Educavo - Online Courses & Education WordPress Theme";
	private $server_host  = "https://rstheme.com/products/api/";
	function __construct() {
		add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
		$licenseKey  = get_option("EducavoWordPressTheme_lic_Key","");
		$templateDir = get_template_directory();
		if(!empty($licenseKey)){
			add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);
			require_once get_template_directory() . '/framework/class-tgm-plugin-activation.php';
			require_once get_template_directory() . '/framework/tgm-config.php';
			add_action( 'admin_post_EducavoWordPressTheme_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
		}else{
			if(!empty($licenseKey) && !empty($this->licenseMessage)){
				$this->showMessage=true;
			}
			update_option("EducavoWordPressTheme_lic_Key","") || add_option("EducavoWordPressTheme_lic_Key","");
			update_option("EducavoWordPressTheme_lic_msg","") || add_option("EducavoWordPressTheme_lic_msg","");
			update_option("EducavoWordPressTheme_lic_msg2","") || add_option("EducavoWordPressTheme_lic_msg2","");
			add_action( 'admin_post_EducavoWordPressTheme_el_activate_license', [ $this, 'action_activate_license' ] );
			add_action( 'admin_menu', [$this,'InactiveMenu']);
			remove_action( 'init', 'portfolio_post_types' );
			remove_action('init', 'umaya_register_metabox_list');
		}
    }
	function SetAdminStyle() {
		wp_register_style( "EducavoWordPressThemeLic", get_theme_file_uri("_lic_style.css"),10);
		wp_enqueue_style( "EducavoWordPressThemeLic" );
	}
	function ActiveAdminMenu(){		 
		add_menu_page (  "Educavo WordPress Theme", "About Educavo", "activate_plugins", $this->slug, [$this,"Activated"], " dashicons-megaphone ");
	}


	private function getDomain() {
		global $wp;
	    if(function_exists("site_url")){
            return site_url();
        }
		if ( defined( "WPINC" ) && function_exists( "get_home_url" ) ) {
			return home_url( 'url' );
		} else {

			$base_url = home_url(add_query_arg(array(), $wp->request));

			return $base_url;
		}
	}



	function InactiveMenu() {
		add_menu_page( "Educavo WordPress Theme", "About Educavo", 'activate_plugins', $this->slug,  [$this,"LicenseForm"], " dashicons-megaphone " );
		
	}
	function action_activate_license(){
		$licenseKey=!empty($_POST['rs_license_key'])?$_POST['rs_license_key']:"";
		if(!empty($licenseKey)){
			$host  = $this->getDomain();
			$pid   = $this->product_id;
			$pcode = $licenseKey;

			$args = array(
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array( 'pcode' => $pcode, 'host' => $this->getDomain(), 'pid' => $this->product_id, 'pname' => $this->product_name, 'state' => 1 ),
				'cookies'     => array()
			);

 			$response = wp_remote_post( $this->server_host, $args );

				// error check
				if ( is_wp_error( $response ) ) {
				   $error_message = $response->get_error_message();
				   $message = "Something went wrong: $error_message"; die;
				}
				else {
				    if($response['body']=='Valid'){
				    	  $message = "Welcome !!! Your Purchase Key is valid";
		              	  update_option("EducavoWordPressTheme_lic_Key",$licenseKey) || add_option("EducavoWordPressTheme_lic_Key",$licenseKey);
		              	  update_option("EducavoWordPressTheme_lic_msg",$message) || add_option("EducavoWordPressTheme_lic_msg",$message);
					      update_option('_site_transient_update_themes','');
					      wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
					      
		            } else{
		        
		            	$message = "Your Purchase License Key invalid";
		            	echo esc_html($message);
		            	update_option("EducavoWordPressTheme_lic_msg2",$message) || add_option("EducavoWordPressTheme_lic_msg2",$message);
		            	wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
		           }	 
			 
       			} 
        } else{

        	echo 'no license key';
        }	
	}
	function action_deactivate_license() {
		$licenseKey=get_option("EducavoWordPressTheme_lic_Key","");
		if(!empty($licenseKey)){
			$host  = $this->getDomain();
			$pid   = $this->product_id;
			$pcode = $licenseKey;
		       
			$params = array(
	         	"pcode" => $pcode, 
	         	'host' => $this->getDomain(), 
	         	'pid' => $this->product_id, 
	         	'pname' => $this->product_name
	         );

			$args = array(
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array( 'pcode' => $pcode, 'host' => $this->getDomain(), 'pid' => $this->product_id, 'pname' => $this->product_name, 'state' => 0 ),
				'cookies'     => array()
			);

 			$response = wp_remote_post( $this->server_host, $args );

			// error check
			if ( is_wp_error( $response ) ) {
			   $error_message = $response->get_error_message();
			   $message = "Something went wrong: $error_message"; die;
			}
			else {
			    if($response['body']=='true'){
					update_option("EducavoWordPressTheme_lic_Key","") || add_option("EducavoWordPressTheme_lic_Key","");
					update_option('_site_transient_update_themes','');
					wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));			      
	            } 
			}
		}
			
		
    }
	function Activated(){
		$licenseKey=get_option("EducavoWordPressTheme_lic_Key","");
		?>
	    <div class="clear"></div>
		<div class="wrap-theside">
			<div class="wrap theside-page-welcome about-wrap">
				<?php 
				   		$msg=get_option("EducavoWordPressTheme_lic_msg","");
				   		if($msg){
				   			echo '<span class="success">'.$msg.'</span>';
				   		}

				    ?>	
				<h1>Welcome to Educavo - Online Courses & Education WordPress Theme</h1>
				<h2></h2> <br />
				
				<div class="wp-badge vc-page-logo">
					Version 2.8.2
				</div>
				<div class="page-content-theside ">
				<div class="wr-col-1">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	            <input type="hidden" name="action" value="EducavoWordPressTheme_el_deactivate_license"/>
	            <div class="rs-lic-container">
	                
	                <ul class="rs-lic-info">
	                	<li class="list">WordPress 5.x Compatible</li>
						<li class="list">Elementor: #1 Drag & Drop Editor & Live Editing WordPress Page Builder Used.</li> 
		                <li>
		                    <div>
		                        <h3 class="rs-lic-info-title"><?php esc_html_e("Your License Key:", 'educavo');?></h3>
		                        <div class="rs-lic-key"><?php echo esc_html($licenseKey); ?></div>
		                    </div>
		                </li>

	                </ul>
	                <div class="rs-lic-active-btn">
	                    <?php wp_nonce_field( 'rs-lic' ); ?>
	                    <?php submit_button('Deactivate'); ?>
	                    <a href="https://www.rstheme.com/products/documentations/Educavo/" target="_blank" class="doc-link">Online Documentation</a>
	                </div>
					<div class="infobox">
							<div class="bluetitle">1 Purchase Code per Website</div>
							<div class="simpletext">If you want to use Educavo Theme on another domain, please purchase another license</a></div>
						</div>
	            </div>
	        </form>
				</div>
				<div class="wr-col-1">
				<div class="wr-right">								
					<div class="theside-chnagelog">	
					    <a href="https://themeforest.net/user/rs-theme/portfolio" target="_blank"><img src="<?php echo esc_url($this->server_host); ?>show.jpg" alt="rstheme">		
					</div>
				</div>
				</div>
				</div>
			</div>
		</div>
        
		<?php
	}
	
	function LicenseForm() {
		?>
		<div class="clear"></div>
	<div class="wrap-theside">
		<div class="wrap theside-page-welcome about-wrap">
			<h1>Welcome to Educavo - Online Courses & Education WordPress Theme</h1>
			 <?php 
			   		$msg2 = get_option("EducavoWordPressTheme_lic_msg2","");
			   		if($msg2){
			   			echo wp_kses_post($msg2);
			   		}

			    ?>	
			<div class="about-text">
			   Educavo Theme Licensing.
			</div>
			<div class="wp-badge vc-page-logo">
				Version 2.8.2
			</div>
			
			<div class="page-content-theside">
			<h3>Active License!</h3>
				<p><?php esc_html_e("Enter your item purchase code here, to activate the product, and get full feature updates and premium support.", 'educavo');?></p>
				<hr>
				<br>
				<br>
				<br>
				<div class="theside-chnagelog">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="EducavoWordPressTheme_el_activate_license"/>
            <div class="rs-lic-container">
               
				<?php
					if(!empty($this->showMessage) && !empty($this->licenseMessage)){
						?>
                        <div class="notice notice-error is-dismissible">
                            <p><?php echo esc_html($this->licenseMessage); ?></p>
                        </div>
						<?php
					}
				?>
                
    		    <div class="rs-lic-field">
    			    <label for="el_license_key"><?php esc_html_e("Purchase code",'educavo');?></label>
    			    <input type="text" class="regular-text code" name="rs_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
    		    </div>
              
                <div class="rs-lic-active-btn">
					<?php wp_nonce_field( 'rs-lic' ); ?>
					<?php submit_button('Activate'); ?>
                </div>
            </div>
        </form>		
				</div>
			</div>
		</div>
	</div>
        
		<?php
	}
}

new EducavoWordPressTheme();