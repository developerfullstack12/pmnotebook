<?php

if(class_exists('myCRED_Module')){
	class myCRED_Pacman_Settings extends myCRED_Module {
		
		function __construct() {
			parent::__construct('myCRED_Pacman');
			add_action( 'mycred_after_core_prefs', array( $this, 'mycred_pacman_settings' ), 10, 1 );
			add_filter( 'mycred_save_core_prefs', array( $this, 'mypacman_save_settings' ), 10, 3 );
		}
		
		function mycred_pacman_settings( $object ) {
			
			$pacman_settings=get_option( 'pacman_settings' );	
			$pacman_settings['pacman']['hs_lb_count'] = isset($pacman_settings['pacman']['hs_lb_count']) ? esc_attr($pacman_settings['pacman']['hs_lb_count']) : 10;
			$pacman_settings['pacman']['psh_count'] = isset($pacman_settings['pacman']['psh_count']) ? esc_attr($pacman_settings['pacman']['psh_count']) : 10;
			$pacman_settings['pacman']['lives'] = isset($pacman_settings['pacman']['lives']) ? esc_attr($pacman_settings['pacman']['lives']) : 2;
			$pacman_settings['pacman']['game_title'] = isset($pacman_settings['pacman']['game_title']) ? esc_attr($pacman_settings['pacman']['game_title']) : 'Pacman Game';
			$pacman_settings['pacman']['game_over_label'] = isset($pacman_settings['pacman']['game_over_label']) ? esc_attr($pacman_settings['pacman']['game_over_label']) : 'Game Over';
			$pacman_settings['pacman']['game_over_color'] = isset($pacman_settings['pacman']['game_over_color']) ? esc_attr($pacman_settings['pacman']['game_over_color']) : 'Red';
			$pacman_settings['pacman']['bubbles_color'] = isset($pacman_settings['pacman']['bubbles_color']) ? esc_attr($pacman_settings['pacman']['bubbles_color']) : 'White';
			$pacman_settings['pacman']['walls_color'] = isset($pacman_settings['pacman']['walls_color']) ? esc_attr($pacman_settings['pacman']['walls_color']) : 'Purple';
			$pacman_settings['pacman']['background_color'] = isset($pacman_settings['pacman']['background_color']) ? esc_attr($pacman_settings['pacman']['background_color']) : 'Black';
			$pacman_settings['pacman']['text_color'] = isset($pacman_settings['pacman']['text_color']) ? esc_attr($pacman_settings['pacman']['text_color']) : 'Brown';
			$pacman_settings['pacman']['ghost1'] = isset($pacman_settings['pacman']['ghost1']) ? esc_attr($pacman_settings['pacman']['ghost1']) : 'Blinky';
			$pacman_settings['pacman']['ghost2'] = isset($pacman_settings['pacman']['ghost2']) ? esc_attr($pacman_settings['pacman']['ghost2']) : 'Pinky';
			$pacman_settings['pacman']['ghost3'] = isset($pacman_settings['pacman']['ghost3']) ? esc_attr($pacman_settings['pacman']['ghost3']) : 'Inky';
			$pacman_settings['pacman']['ghost4'] = isset($pacman_settings['pacman']['ghost4']) ? esc_attr($pacman_settings['pacman']['ghost4']) : 'Clyde';
			$pacman_settings['pacman']['pacman_button'] = isset($pacman_settings['pacman']['pacman_button']) ? esc_attr($pacman_settings['pacman']['pacman_button']) : '';
			$pacman_settings['pacman']['pacman_msg_success'] = isset($pacman_settings['pacman']['pacman_msg_success']) ? esc_attr($pacman_settings['pacman']['pacman_msg_success']) : '';
			$pacman_settings['pacman']['pacman_msg_failure'] = isset($pacman_settings['pacman']['pacman_msg_failure']) ? esc_attr($pacman_settings['pacman']['pacman_msg_failure']) : '';
			$pacman_settings['pacman']['pacman_msg_limit'] = isset($pacman_settings['pacman']['pacman_msg_limit']) ? esc_attr($pacman_settings['pacman']['pacman_msg_limit']) : '';
			$pacman_settings['pacman']['pacman_msg_zero'] = isset($pacman_settings['pacman']['pacman_msg_zero']) ? esc_attr($pacman_settings['pacman']['pacman_msg_zero']) : '';
			$pacman_settings['pacman']['pacman_msg_limit_crossed'] = isset($pacman_settings['pacman']['pacman_msg_limit_crossed']) ? esc_attr($pacman_settings['pacman']['pacman_msg_limit_crossed']) : '';
			$pacman_settings['pacman']['pacman_msg_hook'] = isset($pacman_settings['pacman']['pacman_msg_hook']) ? esc_attr($pacman_settings['pacman']['pacman_msg_hook']) : '';
			$pacman_settings['pacman']['pacman_msg_login'] = isset($pacman_settings['pacman']['pacman_msg_login']) ? esc_attr($pacman_settings['pacman']['pacman_msg_login']) : '';
			$pacman_settings['pacman']['pacman_msg_required_mycred'] = isset($pacman_settings['pacman']['pacman_msg_required_mycred']) ? esc_attr($pacman_settings['pacman']['pacman_msg_required_mycred']) : '';


			?>
			<h4><span class="dashicons dashicons-admin-plugins static"></span><label><?php _e( 'Pacman Game', 'mycred-pacman' ); ?></label></h4>
				<div class="body" style="display:none;">

					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="shortcode">Shortcodes [mycred_pacman_game], [pacman_leaderboard], [pacman_user_history]</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<div class="radio">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'popup' ) ); ?>"><input type="radio" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_popup_or_page' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman_popup_or_page' => 'popup' ) ); ?>"<?php @checked( $pacman_settings['pacman']['pacman_popup_or_page'], 'popup' ); ?> value="popup" /> <?php _e( 'Play Pacman in Popup', 'mycred-pacman' ); ?></label>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<div class="radio">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'page' ) ); ?>"><input type="radio" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_popup_or_page' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman_popup_or_page' => 'page' ) ); ?>"<?php @checked( $pacman_settings['pacman']['pacman_popup_or_page'], 'page' ); ?> value="page" /> <?php _e( 'Play Pacman in page', 'mycred-pacman' ); ?></label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'enable_hs' ) ); ?>"><input type="checkbox" name="<?php echo $this->field_name( array( 'pacman' => 'enable_hs' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'enable_hs' ) ); ?>" <?php @checked( $pacman_settings['pacman']['enable_hs'], 1 ); ?> value="1" /> <?php _e( 'Enable Leaderboard', 'mycred-pacman' ); ?></label>
										<p><em><?php _e( 'Enable Highscores Leaderboard', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'hs_lb_count' ) ); ?>"><?php _e( 'Leaderboard Count', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'hs_lb_count' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'hs_lb_count' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['hs_lb_count'] ); ?>" />
										<p><em><?php _e( 'The maximum number of records to be displayed in leaderboard', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'clear_hs' ) ); ?>"><input type="checkbox" name="<?php echo $this->field_name( array( 'pacman' => 'clear_hs' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'clear_hs' ) ); ?>"  value="1" /> <?php _e( 'Clear Leaderboard', 'mycred-pacman' ); ?></label>
										<p><em><?php _e( 'Check this and save settings to erase all leaderboard entries', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'enable_psh' ) ); ?>"><input type="checkbox" name="<?php echo $this->field_name( array( 'pacman' => 'enable_psh' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'enable_psh' ) ); ?>" <?php @checked( $pacman_settings['pacman']['enable_psh'], 1 ); ?> value="1" /> <?php _e( 'Enable User History', 'mycred-pacman' ); ?></label>
										<p><em><?php _e( 'Enable Personal Score History of user', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'psh_count' ) ); ?>"><?php _e( 'History Count', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'psh_count' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'psh_count' ) ); ?>" class="form-control" value="<?php echo ( isset($pacman_settings['pacman']['psh_count']) ? esc_attr( $pacman_settings['pacman']['psh_count'] ) : ''); ?>" />
										<p><em><?php _e( 'The maximum number of records to be displayed in history table', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'lives' ) ); ?>"><?php _e( 'Pacman Lives (max 4)', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'lives' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'lives' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['lives'] ); ?>" />
										<p><em><?php _e( 'By default, Pacman has 3 lives', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'game_title' ) ); ?>"><?php _e( 'Game Title', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'game_title' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'game_title' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['game_title'] ); ?>" />
										<p><em><?php _e( 'This message appears when the game starts', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'game_over_label' ) ); ?>"><?php _e( 'Game Over Label', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'game_over_label' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'game_over_label' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['game_over_label'] ); ?>" />
										<p><em><?php _e( 'This message appears when the game is over', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
							</div>
							<div class="row">
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'game_over_color' ) ); ?>"><?php _e( 'Game Over Color', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'game_over_color' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'game_over_color' ) ); ?>" class="wp-color-picker-field" value="<?php echo esc_attr( $pacman_settings['pacman']['game_over_color'] ); ?>" />
										<p><em><?php _e( 'Set the color for Game Over/Ready Text', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'bubbles_color' ) ); ?>"><?php _e( 'Bubbles Color', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'bubbles_color' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'bubbles_color' ) ); ?>"  class="wp-color-picker-field"  value="<?php echo esc_attr( $pacman_settings['pacman']['bubbles_color'] ); ?>" />
										<p><em><?php _e( 'Set the color for points that pacman eats', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'walls_color' ) ); ?>"><?php _e( 'Walls Color', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'walls_color' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'walls_color' ) ); ?>"  class="wp-color-picker-field"  value="<?php echo esc_attr( $pacman_settings['pacman']['walls_color'] ); ?>" />
										<p><em><?php _e( 'Set the color for walls', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'background_color' ) ); ?>"><?php _e( 'Background Color', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'background_color' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'background_color' ) ); ?>"  class="wp-color-picker-field"  value="<?php echo esc_attr( $pacman_settings['pacman']['background_color'] ); ?>" />
										<p><em><?php _e( 'Set the background color', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'pacman' => 'text_color' ) ); ?>"><?php _e( 'Text Color', 'mycred-pacman' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'text_color' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'text_color' ) ); ?>"  class="wp-color-picker-field"  value="<?php echo esc_attr( $pacman_settings['pacman']['text_color'] ); ?>" />
										<p><em><?php _e( 'Set the color for title/score', 'mycred-pacman' ); ?></em></p>
									</div>
								</div>
							</div>
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'ghost1' ) ); ?>"><?php _e( 'Ghost1 Name', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'ghost1' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'ghost1' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['ghost1'] ); ?>" />
											<p><em><?php _e( 'Name your ghost 1', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'ghost2' ) ); ?>"><?php _e( 'Ghost2 Name', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'ghost2' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'ghost2' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['ghost2'] ); ?>" />
											<p><em><?php _e( 'Name your ghost 2', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'ghost3' ) ); ?>"><?php _e( 'Ghost3 Name', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'ghost3' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'ghost3' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['ghost3'] ); ?>" />
											<p><em><?php _e( 'Name your ghost 3', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'ghost4' ) ); ?>"><?php _e( 'Ghost4 Name', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'ghost4' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'ghost4' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['ghost4'] ); ?>" />
											<p><em><?php _e( 'Name your ghost 4', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_button' ) ); ?>"><?php _e( 'Pacman Button Text', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_button' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_button' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_button'] ); ?>" />
											<p><em><?php _e( 'Mycred Pacman', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_success' ) ); ?>"><?php _e( 'Points Successfully added', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_success' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_success' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_success'] ); ?>" />
											<p><em><?php _e( 'Points Successfully Added against your Score', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_failure' ) ); ?>"><?php _e( 'Could not add points', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_failure' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_failure' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_failure'] ); ?>" />
											<p><em><?php _e( 'Could Not Add Points against your Score', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_limit' ) ); ?>"><?php _e( 'Points Crossing Limit', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_limit' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_limit' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_limit'] ); ?>" />
											<p><em><?php _e( 'Could not add all points as they were crossing the limit set by admin, points added=%pacman_points_added%', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_zero' ) ); ?>"><?php _e( 'User has scored 0 points', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_zero' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_zero' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_zero'] ); ?>" />
											<p><em><?php _e( 'You have scored 0', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_limit_crossed' ) ); ?>"><?php _e( 'User has Earned Maximum Points', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_limit_crossed' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_limit_crossed' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_limit_crossed'] ); ?>" />
											<p><em><?php _e( 'Sorry! You have crossed the limit for maximum points earned within a given time', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_hook' ) ); ?>"><?php _e( 'Pacman Hook not activated', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_hook' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_hook' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_hook'] ); ?>" />
											<p><em><?php _e( 'You need to activate the mycred pacman hook', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_login' ) ); ?>"><?php _e( 'Please Login to play', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_login' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_login' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_login'] ); ?>" />
											<p><em><?php _e( 'Please logged in to play this game', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_required_mycred' ) ); ?>"><?php _e( 'Pacman requires mycred', 'mycred-pacman' ); ?></label>
											<input type="text" name="<?php echo $this->field_name( array( 'pacman' => 'pacman_msg_required_mycred' ) ); ?>" id="<?php echo $this->field_id( array( 'pacman' => 'pacman_msg_required_mycred' ) ); ?>" class="form-control" value="<?php echo esc_attr( $pacman_settings['pacman']['pacman_msg_required_mycred'] ); ?>" />
											<p><em><?php _e( 'Mycred Pacman Requires mycred to be installed and activated', 'mycred-pacman' ); ?></em></p>
										</div>
									</div>
								</div>

							
						</div>
						<script>
						jQuery(document).ready(function($){
						// Load wp color picker
						$( '.wp-color-picker-field' ).wpColorPicker();
						});

						</script>
					</div>

				</div>
			<?php
		}
		
		function mypacman_save_settings( $new_data, $post, $object ) {
			
			$pacman_settings = array();
			$pacman_settings['pacman'] = $post['pacman'];

			// clear pacman highscores leaderboard
			if(isset($post['pacman']['clear_hs']) && $post['pacman']['clear_hs']==1){

				update_option( 'mycred_pacman_leaderboard', array() );
			}
			
			update_option( 'pacman_settings', $pacman_settings );
			
			return $new_data;
		}

	}

	$myCRED_Pacman_Settings = new myCRED_Pacman_Settings();
}
