<?php
if(class_exists('myCRED_Hook')){
	// Register Hook
	add_filter( 'mycred_setup_hooks', 'register_mycred_pacman_hook',10,2 );
	function register_mycred_pacman_hook( $installed, $mycred_type )
	{
		$installed['play_pacman'] = array(
			'title'       => __( '%plural% for Playing Pacman', 'mycred-pacman' ),
			'description' => __( 'This hook adds awards/limits points to users on the basis of their score in PACMAN.', 'mycred-pacman' ),
			'callback'    => array( 'myCRED_Hook_Pacman' )
		);
		return $installed;
	}

	// myCRED Custom Hook Class
	class myCRED_Hook_Pacman extends myCRED_Hook {

		private $current_point_type;

		/**
		 * Construct
		 */
		function __construct( $hook_prefs, $type = MYCRED_DEFAULT_TYPE_KEY ) {
			parent::__construct( array(
				'id'       => 'play_pacman',
				'defaults' => array(
					'creds'   => 1,
					'log'     => '%plural% for Playing Pacman',
					'limit'  => '0/x'
				)
			), $hook_prefs, $type );

			$this->current_point_type=$type;
			
		}

		/**
		 * Hook into WordPress
		 */
		public function run() {

			add_filter( 'is_allowed_to_play', array($this,'user_can_play'),10, 1 );
			add_action("wp_ajax_update_mypacman_user_log", array($this,"update_mypacman_user_log"));
			add_action("wp_ajax_nopriv_update_mypacman_user_log", array($this,"mypacman_user_not_logged_in"));
			add_filter('mycred_translate_limit_code', array($this,"pacman_hook_table_fix"),10,4);
		}

		function pacman_hook_table_fix($result, $code, $id, $mycred) {
			if($id=='play_pacman'){
				$result = str_replace( 'times', $mycred->name['plural'], $result );
			}
			
			return $result;
		}

		/**
			 * PACMAN user not logged in
			**/
			function mypacman_user_not_logged_in()
			{
				$pacman_settings=get_option( 'pacman_settings' );
				$logout_during_gameplay=$pacman_settings['pacman']['pacman_msg_failure'];
				if(empty($logout_during_gameplay)){
					$logout_during_gameplay=__('You Must Login to Save Points against your Score','mycred-pacman');
				}

				echo $logout_during_gameplay;
				die;
			}
			
			/**
			 * PACMAN update user points according to his score
			**/
			function update_mypacman_user_log() {
				if ( ! wp_verify_nonce( $_POST['pacman-nonce'], 'paCman_updAte' ) ) {
					die( __( 'Security check Failed', 'mycred-pacman' ) ); 
				}
				$user_id=get_current_user_id();
				$score=intval($_POST['score']);
				$new_points=$score*$this->prefs['creds']; 
				$limit=explode("/",$this->prefs['limit']);
				$log=$this->prefs['log'];
				
				$pacman_settings=get_option( 'pacman_settings' );
				$pacman_msg_failure=$pacman_settings['pacman']['pacman_msg_failure'];
				$pacman_msg_success=$pacman_settings['pacman']['pacman_msg_success'];
				$pacman_msg_limit=$pacman_settings['pacman']['pacman_msg_limit'];
				$pacman_msg_zero=$pacman_settings['pacman']['pacman_msg_zero'];

				if(empty($pacman_msg_failure)){
					$pacman_msg_failure=__("Could Not Add Points against your Score",'mycred-pacman');
				}
				if(empty($pacman_msg_success)){
					$pacman_msg_success=__("Points Successfully Added against your Score",'mycred-pacman');
				}
				if(empty($pacman_msg_limit)){
					$pacman_msg_limit=__("Could not add all points as they were crossing the limit set by admin, points added=%pacman_points_added%",'mycred-pacman');
				}
				if(empty($pacman_msg_zero)){
					$pacman_msg_zero=__("You have scored 0",'mycred-pacman');
				}

				if($score != 0 && $new_points != 0)
				{

					if($limit[1]!='x') // if there is a limit set to maximum points earned within a limited time
					{
						
						$user_points_earned_in_time = $this->get_user_pacman_points($user_id,$limit[1],$this->current_point_type);
						$total_points=$user_points_earned_in_time+$new_points;
						
						if($limit[0] > $total_points)
						{
							if(mycred_add('pacman_points', $user_id, $new_points, $log, 0, array(), $this->current_point_type)) //$this->current_point_type
							{
								update_pacman_leaderboard($user_id, $score);
								update_pacman_user_history($user_id, $score);
								echo str_replace("%pacman_points_added%",$new_points,$pacman_msg_success);
							}
							else
							{
								echo $pacman_msg_failure;
							}
						}
						else
						{
							$points_upto_limit=$limit[0]-$user_points_earned_in_time;
							if(mycred_add('pacman_points',$user_id,$points_upto_limit,$log, 0, array(), $this->current_point_type))
							{
								update_pacman_leaderboard($user_id, $score);
								update_pacman_user_history($user_id, $score);
								echo str_replace("%pacman_points_added%",$points_upto_limit,$pacman_msg_limit);
							}
							else
							{
								echo $pacman_msg_failure;
							}
						}
					}
					else
					{
						if(mycred_add('pacman_points',$user_id,$new_points,$log,0, array(), $this->current_point_type))
						{
							update_pacman_leaderboard($user_id, $score);
							update_pacman_user_history($user_id, $score);
							echo str_replace("%pacman_points_added%",$new_points,$pacman_msg_success);
						}
						else
						{
							echo $pacman_msg_failure;
						}
					}

				}
				else
				{
					echo $pacman_msg_zero;
				}
				
				die;
				
			}
			

			/**
		 * PACMAN check if user can play game
		 */

		public function user_can_play( $allowed ) {
			$user_id = get_current_user_id();
			if($user_id != 0)   // is user logged in
			{
				$limit=explode("/",$this->prefs['limit']);

				if($limit[1]=='x') // no limit set, user can play and earn unlimited points
				{
					return true;
				}
				else
				{
					$user_points_earned_in_time = $this->get_user_pacman_points($user_id,$limit[1],$this->current_point_type);
					
					if($limit[0] > $user_points_earned_in_time) // check if user has reached the points earned limit
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				
			}
			return false;
		}

		/**
		 * PACMAN get user points earned within a specified time
		 */
		public function get_user_pacman_points($user_id, $time, $point_type='mycred_default') {
			
			if(!empty($user_id) && !empty($time))
			{
				if($time=='d') // limit set to per day
				{
					$qtime='today';
				}
				else if($time=='w') // limit set to per week
				{
					$qtime='thisweek';
				}
				else if($time=='m') // limit set to per month
				{
					$qtime='thismonth';
				}
				else if($time=='t') // No timeframe set in limit
				{
					$qtime=0;
				}

				if($qtime)
				{
					$args = array(
						'ref'    => 'pacman_points',
						'time' => $qtime,
						'user_id' => $user_id,
						'ctype' =>  $point_type
					);
				}
				else
				{
					$args = array(
						'ref'    => 'pacman_points',
						'user_id' => $user_id,
						'ctype' =>  $point_type
					);
				}
				$log  = new myCRED_Query_Log( $args );

				$points=0;
				if ( $log->have_entries() ) {

					foreach ( $log->results as $entry ) {

						$points+=$entry->creds;
				
					}
					return $points ;
				
				}
			}
			return 0 ;
		}
		
		/**
		 * Add Settings
		 */
		public function preferences() {
			// Our settings are available under $this->prefs
			$prefs = $this->prefs; ?>

	<!-- First we set the amount -->

	<div class="hook-instance">
		<h3><?php _e( 'Playing Pacman', 'mycred-pacman' ); ?></h3>
		<div class="row">
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="<?php echo $this->field_id( 'creds' ); ?>"><?php _e( 'Points for each score', 'mycred-pacman' ); ?></label>
					<input type="text" name="<?php echo $this->field_name( 'creds' ); ?>" id="<?php echo $this->field_id( 'creds' ); ?>" value="<?php echo esc_attr( $prefs['creds'] ); ?>" class="form-control" />
					<span class="description"><?php _e( 'The above value will be miltiplied by the total score of user and the result will be added as points', 'mycred-pacman' ); ?></span>
				</div>
			</div>
			<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="<?php echo $this->field_id( 'log' ); ?>"><?php _e( 'Log template', 'mycred-pacman' ); ?></label>
					<input type="text" name="<?php echo $this->field_name( 'log' ); ?>" id="<?php echo $this->field_id( 'log' ); ?>" value="<?php echo esc_attr( $prefs['log'] ); ?>" class="form-control" />
					<span class="description"><?php echo $this->available_template_tags( array( 'general' ) ); ?></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="<?php echo $this->field_id( 'limit' ); ?>"><?php _e( 'Points Limit', 'mycred-pacman' ); ?></label>
					<?php echo $this->hook_limit_setting( $this->field_name( 'limit' ), $this->field_id( 'limit' ), $prefs['limit'] ); ?>
				</div>
			</div>
			
		</div>
	</div>

	<?php
		}

		/**
		 * Sanitize Preferences
		 */
		public function sanitise_preferences( $data ) {
			$new_data = $data;

			// Apply defaults if any field is left empty
			$new_data['creds'] = ( !empty( $data['creds'] ) ) ? $data['creds'] : $this->defaults['creds'];
			$new_data['log'] = ( !empty( $data['log'] ) ) ? sanitize_text_field( $data['log'] ) : $this->defaults['log'];

			
			if ( isset( $new_data['limit'] ) && isset( $new_data['limit_by'] ) ) {
				$limit = sanitize_text_field( $new_data['limit'] );
				if ( $limit == '' ) $limit = 0;
				$new_data['limit'] = $limit . '/' . $new_data['limit_by'];
				unset( $new_data['limit_by'] );
			}

			return $new_data;
		}
	}
}