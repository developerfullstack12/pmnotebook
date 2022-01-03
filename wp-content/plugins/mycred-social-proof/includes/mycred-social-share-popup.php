<?php
/**
 * Handle myCred Social Proof Popup
 */

add_action('wp_footer','mycred_sp_handle_logs');

if( !function_exists('mycred_sp_handle_logs') ) {
	function mycred_sp_handle_logs() {		
		?>
		<script>
		function get_logs(last_log_id) {
			console.log(last_log_id);
			<?php
			$mycred_notify = mycred_get_option('mycred_pref_core');
			$user_id = get_current_user_id();

			if($user_id){ // if user is logged in
				$last_log_id = intval(get_user_meta( $user_id, 'social_proof_log_id', true ));
			} else { // if user is not logged in
				$last_log_id = intval($_COOKIE['social_proof_log_id']);
			}

			if( empty($last_log_id ) || (isset($_COOKIE['social_proof_log_id']) && intval($_COOKIE['social_proof_log_id']) > $last_log_id)){
				$last_log_id = isset($_COOKIE['social_proof_log_id']) ? intval($_COOKIE['social_proof_log_id']) : 0;
			}


			if( !isset( $mycred_notify['mycred_popup_notify']['enable_popup'] ) || empty( $mycred_notify['mycred_popup_notify']['enable_popup'] ) ) { ?>
				return;
			<?php } ?>

			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' )?>';			
			var interval_time = '<?php echo ( isset( $mycred_notify['mycred_popup_notify']['interval_time'] ) && !empty( $mycred_notify['mycred_popup_notify']['interval_time'] ) ) ? $mycred_notify['mycred_popup_notify']['interval_time'] . '000' : '10000' ?>';			
			
			if(last_log_id == 0 || last_log_id == '' || last_log_id == undefined)
				last_log_id = <?php echo $last_log_id; ?>;

			var data = {
				'action': 'msp_popup_ajax',
				'last_log_id': last_log_id,
			};

			jQuery.post(ajaxurl, data, function(response) {
			    
				if( response != '' ) {

					var obj = JSON.parse(response);
					
					if( obj.length <= 0 ) {
						setTimeout(function() { get_logs(last_log_id); },interval_time);
					}

					if( obj.length <=0 )
						return;

					var i = 0;

					function msp_loop () {
					setTimeout(function () {
						var log_id = obj[i].id;
						var img = obj[i].user_avatar;
						var username = obj[i].user_name;
						var title_text = '';

						var social_proof_title = '<?php echo ( isset( $mycred_notify['mycred_popup_notify']['title'] ) && !empty( $mycred_notify['mycred_popup_notify']['title'] ) ) ? $mycred_notify['mycred_popup_notify']['title'] : '%username% has been rewarded' ?>';
						var social_proof_description = '<?php echo ( isset( $mycred_notify['mycred_popup_notify']['description'] ) && !empty( $mycred_notify['mycred_popup_notify']['description'] ) ) ? $mycred_notify['mycred_popup_notify']['description'] : '%creds% %ctype% for %reference%' ?>';
						
						social_proof_title = replace_tags(social_proof_title,obj[i]);
						social_proof_description = replace_tags(social_proof_description,obj[i]);

						popup_alert(social_proof_title,social_proof_description,img );
						setCookie('social_proof_log_id',log_id);
						i++;
						if (i < obj.length) {
							msp_loop();
						} else {
						   get_logs(log_id);
						}
					}, interval_time);
					}

					msp_loop();
				}
			});
		
		}

		function replace_tags( string,obj ) {
			
			if(string.includes('%username%')){
				string = string.replace(/%username%/g,"<span class='msp-username' >"+obj.user_name+"</span>");
			}
			if(string.includes('%creds%')){
				string = string.replace(/%creds%/g,"<span class='msp-creds' >"+obj.creds+"</span>");  
			}
			if(string.includes('%ctype%')){
				string = string.replace(/%ctype%/g,"<span class='msp-pointtype' >"+obj.point_type+"</span>");
			}
			if(string.includes('%reference%')){
				string = string.replace(/%reference%/g,"<span class='msp-reference' >"+obj.reference+"</span>");
			}
			
			string = string.replace(/_/g,' ');

			return string;
		}
		</script>
		<?php
		echo '<div class="mycred-popup-alert"></div>';
	}
}

add_action( 'wp_ajax_msp_popup_ajax', 'msp_popup_ajax' );
add_action( 'wp_ajax_nopriv_msp_popup_ajax', 'msp_popup_ajax' );

function msp_popup_ajax() {
	global $wpdb; // this is how you get access to the database

	$last_log_id = intval( $_POST['last_log_id'] );
	
	

    $mycred_notify = mycred_get_option('mycred_pref_core');
    
	$user_id = get_current_user_id();
	
	if(!empty($last_log_id) && $last_log_id >= intval($_COOKIE['social_proof_log_id'])){
		update_user_meta($user_id, 'social_proof_log_id', $last_log_id );
	}
	else{
		update_user_meta($user_id, 'social_proof_log_id', intval($_COOKIE['social_proof_log_id']) );
	}
	$args = array(
        'number' => 5,
        'ref' 		=> array(
            'ids'     	=> $mycred_notify['mycred_popup_notify']['references'],
            'compare' 	=> 'IN'
        ),
        'user_id' => array(
            'ids'     => $user_id,
            'compare' => '!='
        )
    );
    $log  = new myCRED_Query_Log( $args );

	$user_data = array();
	
	$social_proof_log_id = intval(get_user_meta( $user_id, 'social_proof_log_id', true ));

	if( empty($social_proof_log_id)){
		$social_proof_log_id = $_COOKIE['social_proof_log_id'];
		update_user_meta($user_id, 'social_proof_log_id', $social_proof_log_id );
	}



    foreach( array_reverse( $log->results ) as $result ) {
        if( $result->id <= $social_proof_log_id )
            continue;
            
        $reference = mycred_get_all_references();
        $user_id = get_user_by( 'id', $result->user_id );
        $user_name = array( 'user_name' => $user_id->data->user_login );
        $reference = array( 'reference' => $reference[$result->ref] );
        $user_img = get_avatar_url( $result->user_id );
        $user_avatar = array( 'user_avatar' => $user_img );
        $social_proof_data = (array) $result;
        $social_proof_data = array_merge($social_proof_data,$user_name);
        $social_proof_data = array_merge($social_proof_data,$reference);
        $is_plural = ( floatval( $result->creds ) == 1 );
		$social_proof_data['point_type'] = mycred_get_point_type_name( $result->ctype, $is_plural );
        $user_data[] = array_merge($social_proof_data,$user_avatar);
    }
    
    echo json_encode($user_data);

	wp_die(); // this is required to terminate immediately and return a proper response
}