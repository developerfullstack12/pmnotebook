<?php

function update_pacman_leaderboard($user_id = 0, $score = 0){
	$pacman_settings=get_option( 'pacman_settings' );

	$enable_leaderboard = 0;
	if(isset($pacman_settings['pacman']['enable_hs'])){
		$enable_leaderboard=$pacman_settings['pacman']['enable_hs'];
	}

	$max_records = 10;
	if(isset($pacman_settings['pacman']['hs_lb_count'])){
		$max_records=$pacman_settings['pacman']['hs_lb_count'];
	}

	if( !empty($user_id) && !empty($score) && !empty($enable_leaderboard) ){

		$leaderboard = get_option( 'mycred_pacman_leaderboard' );

		if(empty($leaderboard)){
			$leaderboard[0]['userid'] = $user_id;
			$leaderboard[0]['score'] = $score;
			$leaderboard[0]['score_date'] = time();

			update_option( 'mycred_pacman_leaderboard',$leaderboard );
			return true;
			
		}
		$scores = array_column($leaderboard, 'score');

		if(min($scores) <= $score || $max_records>count($leaderboard)) {
			$next_key = count($leaderboard);
			$leaderboard[$next_key]['userid'] = $user_id;
			$leaderboard[$next_key]['score'] = $score;
			$leaderboard[$next_key]['score_date'] = time();
			usort($leaderboard, function($a, $b) {
				return $b['score'] <=> $a['score'];
			});

			$leaderboard= array_slice($leaderboard, 0, $max_records, true );

			if(update_option( 'mycred_pacman_leaderboard',$leaderboard )){
				return true;
			}
		}
		
	}
	
	return false;
}


function pacman_leaderboard_display(){
	$leaderboard = get_option( 'mycred_pacman_leaderboard' );

	$html = '<table class="mycred-pacman-leaderboard"><tr><th>'.__('Count', 'mycred-pacman').'</th><th>'.__('User Name', 'mycred-pacman').'</th><th>'.__('Score', 'mycred-pacman').'</th><th>'.__('Date', 'mycred-pacman').'</th></tr>';

	if(!empty($leaderboard)){
		foreach($leaderboard as $key =>$value){
			$user = get_user_by( 'id', $value['userid'] );
			
			if($user){
				$html.= '<tr><td>'.($key+1).'</td><td>'.$user->display_name.'</td><td>'.$value['score'].'</td><td>'.date("Y-m-d h:i:sa", $value['score_date']).'</td></tr>';
			}
			
		}

	} else {
		$html.= '<tr><th colspan=4>'.__('No Records Found','mycred-pacman').'</th></tr>';
	}
	$html.= '</table>';

	return $html;
}

add_shortcode( 'pacman_leaderboard', 'pacman_leaderboard_display' );


function update_pacman_user_history($user_id = 0, $score = 0){
	$pacman_settings=get_option( 'pacman_settings' );

	// psh = personal score history
	$enable_history = 0;
	if(isset($pacman_settings['pacman']['enable_psh'])){
		$enable_history=$pacman_settings['pacman']['enable_psh'];
	}

	$max_records = 10;
	if(isset($pacman_settings['pacman']['psh_count'])){
		$max_records=$pacman_settings['pacman']['psh_count'];
	}

	if( !empty($user_id) && !empty($score) && !empty($enable_history) ){

		$history = get_user_meta($user_id, 'mycred_pacman_history', true);

		if(empty($history)){
			$history = array();
			$history[0]['score'] = $score;
			$history[0]['score_date'] = time();
			update_user_meta($user_id, 'mycred_pacman_history', $history);
			return true;
			
		} else{
			$next_key = count($history);
			$history[$next_key]['score'] = $score;
			$history[$next_key]['score_date'] = time();

			if(count($history) > $max_records) {
				$history = array_shift($history);
			}
			
			if(update_user_meta($user_id, 'mycred_pacman_history', $history)){
				return true;
			}

		}
		
	}
	 
	return false;
}

// 
function pacman_user_history_display(){
	$user_id = get_current_user_id();

	if(empty($user_id)){
		return '<table class="mycred-pacman-userhistory"><tr><th>'.__('Login to see your Pacman History').'</th></tr></table>';
	}
	$user = get_user_by( 'id', $user_id );
	$history = get_user_meta($user_id, 'mycred_pacman_history', true);


	$html = '<table class="mycred-pacman-userhistory"><th colspan="3">'.__('User Name', 'mycred-pacman').': '.$user->display_name.'</th>';
	$html.= '<tr><th>'.__('Count', 'mycred-pacman').'</th><th>'.__('Score', 'mycred-pacman').'</th><th>'.__('Date', 'mycred-pacman').'</th></tr>';

	if(!empty($history)){
		foreach($history as $key => $value){
				$html.= '<tr><td>'.($key+1).'</td><td>'.$value['score'].'</td><td>'.date("Y-m-d h:i:sa", $value['score_date']).'</td></tr>';
		}

	} else {
		$html.= '<tr><th colspan=3>'.__('No Records Found','mycred-pacman').'</th></tr>';
	}
	$html.= '</table>';

	return $html;

}
add_shortcode( 'pacman_user_history', 'pacman_user_history_display' );


add_action( 'show_user_profile', 'pacman_clear_history_check' );
add_action( 'edit_user_profile', 'pacman_clear_history_check' );

function pacman_clear_history_check( $user ) { ?>

    <table class="form-table">
    <tr>
        <th><label for="clear-pacman-history"><?php _e('Mycred Pacman History', 'mycred-pacman'); ?></label></th>
        <td>
		<label for="clear_pacman_history">
				<input name="clear_pacman_history" type="checkbox" id="clear_pacman_history" value="1" >
				<?php _e('Check and update profile to clear pacman history', 'mycred-pacman'); ?></label>
        </td>
    </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'pacman_clear_history' );
add_action( 'edit_user_profile_update', 'pacman_clear_history' );

function pacman_clear_history( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
	
	if(isset($_POST['clear_pacman_history']) && !empty($_POST['clear_pacman_history'])){
		update_user_meta($user_id, 'mycred_pacman_history', '');
	}
}