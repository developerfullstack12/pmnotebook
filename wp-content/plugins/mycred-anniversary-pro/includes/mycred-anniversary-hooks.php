<?php

/**
 * Hook for Anniversary
 * @since 1.8
 * @version 1.0
 */
if ( ! class_exists( 'myCRED_Anniversary_Hook_Class' ) ) :
	class myCRED_Anniversary_Hook_Class extends myCRED_Hook {

		/**
		 * Construct
		 */
		function __construct( $hook_prefs, $type = MYCRED_DEFAULT_TYPE_KEY ) {

			parent::__construct( array(
				'id'       => 'anniversary_pro',
				'defaults' => array(
					'creds'   => 10,
					'log'     => '%plural% for being a member for a year',
					'specific_anniversary' 	=> array(
						'creds'    		=> array(),
						'anniversary'   => array(),
						'log'      		=> array()
					),
				)
			), $hook_prefs, $type );

		}

		/**
		 * Run
		 * @since 1.8
		 * @version 1.0
		 */
		public function run() {

			add_action( 'template_redirect', array( $this, 'page_load' ) );

		}

		/**
		 * Page Load
		 * @since 1.8
		 * @version 1.0
		 */
		public function page_load() {

			if ( ! is_user_logged_in() ) return;

			$user_id  = get_current_user_id();

			// Make sure user is not excluded
			if ( $this->core->exclude_user( $user_id ) ) return;

			// Make sure this only runs once a day
			$last_run = mycred_get_user_meta( $user_id, 'anniversary-' . $this->mycred_type, '', true );
			$today    = date( 'Y-m-d', current_time( 'timestamp' ) );
			if ( $last_run == $today ) return;

			global $wpdb;

			$result = $wpdb->get_row( $wpdb->prepare( "SELECT user_registered, TIMESTAMPDIFF( YEAR, user_registered, CURDATE()) AS difference FROM {$wpdb->users} WHERE ID = %d;", $user_id ) );

			// If we have been a member for more then one year
			if ( isset( $result->user_registered ) && $result->difference >= 1 ) {

				$year_joined = substr( $result->user_registered, 0, 4 );
				$year_join = $year_joined;
				$date_joined = strtotime( $result->user_registered );
				$year = date_diff( date_create($year_joined), date_create($today) );
				$anniversary = $year->y;

				// First time we give points we might need to give for more then one year
				// so we give points for each year.
				for ( $i = 0; $i < $result->difference; $i++ ) {
					
					$user_anniversary = $this->prefs['specific_anniversary']['anniversary'];
					$year_joined++;
					$year_difference = $year_joined - $year_join;
					$hook_index = array_search( $year_difference, $user_anniversary );
					

					if ( $this->core->has_entry( 'anniversary_pro', $year_joined, $user_id, $date_joined, $this->mycred_type ) ) continue;

					if ( in_array( $year_difference, $user_anniversary ) ) {

						// Execute
						$this->core->add_creds(
							'anniversary_pro',
							$user_id,
							$this->prefs['specific_anniversary']['creds'][$hook_index],
							$this->prefs['specific_anniversary']['log'][$hook_index],
							$year_joined,
							$date_joined,
							$this->mycred_type
						);
					}
					else {

						// Execute
						$this->core->add_creds(
							'anniversary_pro',
							$user_id,
							$this->prefs['creds'],
							$this->prefs['log'],
							$year_joined,
							$date_joined,
							$this->mycred_type
						);
					}
				}
			}

			mycred_update_user_meta( $user_id, 'anniversary-' . $this->mycred_type, '', $today );

		}

		/**
		 * Preference for Anniversary Hook
		 * @since 1.8
		 * @version 1.0
		 */
		public function preferences() {

			$prefs = $this->prefs;

?>
<div class="hook-instance">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="<?php echo $this->field_id( 'creds' ); ?>"><?php echo $this->core->plural(); ?></label>
				<input type="text" name="<?php echo $this->field_name( 'creds' ); ?>" id="<?php echo $this->field_id( 'creds' ); ?>" value="<?php echo $this->core->number( $prefs['creds'] ); ?>" class="form-control" />
			</div>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="<?php echo $this->field_id( 'log' ); ?>"><?php _e( 'Log Template', 'mycred' ); ?></label>
				<input type="text" name="<?php echo $this->field_name( 'log' ); ?>" id="<?php echo $this->field_id( 'log' ); ?>" placeholder="<?php _e( 'required', 'mycred' ); ?>" value="<?php echo esc_attr( $prefs['log'] ); ?>" class="form-control" />
				<span class="description"><?php echo $this->available_template_tags( array( 'general' ) ); ?></span>
			</div>
		</div>
	</div>
</div>
<?php
			if (  count ( $prefs['specific_anniversary']['creds'] ) > 0 ) {
				
				$hooks = $this->mycred_anniversary_pro_arrange_data( $prefs['specific_anniversary'] );

				$this->mycred_anniversary_pro_html( $hooks, $this );
			
			}else {
				$defaults = array(
					array(
						'creds'          => '10',
						'log'            => '%plural% for specific anniversary.',
						'anniversary' 	 => '0'
					)
				);
				
				$this->mycred_anniversary_pro_html( $defaults, $this );
			}

		}

		/**
		 * Sanitize Preferences
		 * If the hook has settings, this method must be used
		 * to sanitize / parsing of settings.
		 */
		public function sanitise_preferences( $data ) {

			$new_data = array();

			$new_data['creds'] = ( !empty( $data['creds'] ) ) ? sanitize_text_field( $data['creds'] ) : '';
			$new_data['log'] = ( !empty( $data['log'] ) ) ? sanitize_text_field( $data['log'] ) : '';

			
			foreach ( $data['specific_anniversary'] as $fields => $values ) {
				
				foreach ( $values as $key => $value ) {

					if ( $fields == 'creds' ) {
						$new_data['specific_anniversary'][$fields][$key] = ( !empty( $value ) ) ? floatval( $value ) : '';
					}
					else if ( $fields == 'anniversary' ) {
						$new_data['specific_anniversary'][$fields][$key] = ( !empty( $value ) ) ? floatval( $value ) : 0;
					}
					else if ( $fields== 'log' ) {
						$new_data['specific_anniversary'][$fields][$key] = ( !empty( $value ) ) ? sanitize_text_field( $value ) : '%plural% for specific anniversary.';
					}
				}
			}

			return $new_data;	
		}

		public function mycred_anniversary_pro_field_name( $type, $attr ){

			$hook_prefs_key = 'mycred_pref_hooks';

			if ( $type != MYCRED_DEFAULT_TYPE_KEY ) {
				$hook_prefs_key = 'mycred_pref_hooks_'.$type;
			}

			return "{$hook_prefs_key}[hook_prefs][anniversary_pro][specific_anniversary][{$attr}][]";
		
		}

		public function  mycred_anniversary_pro_arrange_data( $data ){

			$hook_data = array();

			foreach ( $data['anniversary'] as $key => $value ) {
				
				$hook_data[$key]['creds']      = $data['creds'][$key];
				$hook_data[$key]['log']        = $data['log'][$key];
				$hook_data[$key]['anniversary']    = $value;
			}

			return $hook_data;
		}


		public function mycred_anniversary_pro_html($data,$obj){
			
			foreach($data as $prefs)
			{

				?>
				<div class="repeater-hook-instance">
					<div class="row hook-instance">
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="<?php echo $this->field_id( 'creds' ); ?>"><?php echo $this->core->plural(); ?></label>
								<input type="text" name="<?php echo $this->mycred_anniversary_pro_field_name( $obj->mycred_type, 'creds' ); ?>" id="<?php echo $this->field_id( 'creds' ); ?>" value="<?php echo $this->core->number( $prefs['creds'] ); ?>" class="form-control mycred-anniversary-pro-creds" />
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="form-group">
								<label for="<?php echo $this->field_id( 'anniversary' ); ?>"><?php _e( 'Anniversary', 'mycred_anniversary_pro' ); ?></label>
								<input type="text" name="<?php echo $this->mycred_anniversary_pro_field_name( $obj->mycred_type, 'anniversary' ); ?>" id="<?php echo $this->field_id( 'age' ); ?>" placeholder="<?php _e( 'required', 'mycred_anniversary_pro' ); ?>" value="<?php echo esc_attr( $prefs['anniversary'] ); ?>" class="form-control mycred-anniversary-pro-anniversary" />
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="<?php echo $this->field_id( 'log' ); ?>"><?php _e( 'Log Template', 'mycred_anniversary_pro' ); ?></label>
								<input type="text" name="<?php echo $this->mycred_anniversary_pro_field_name( $obj->mycred_type,'log' ); ?>" id="<?php echo $this->field_id( 'log' ); ?>" placeholder="<?php _e( 'required', 'mycred_anniversary_pro' ); ?>" value="<?php echo esc_attr( $prefs['log'] ); ?>" class="form-control mycred-anniversary-pro-log" />
								<span class="description"><?php echo $this->available_template_tags( array( 'general' ) ); ?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group specific-hook-actions textright">
									<button class="button button-small mycred-add-anniversary-pro-hook" type="button">Add More</button>
									<button class="button button-small mycred-remove-anniversary-pro-hook" type="button">Remove</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
	}
endif;