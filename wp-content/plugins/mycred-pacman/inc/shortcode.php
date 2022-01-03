<?php

// This just echoes the chosen line, we'll position it later.


function pacman()
{

	$pacman_settings=get_option( 'pacman_settings' );
	$game_title=$pacman_settings['pacman']['game_title'];
	$ghost1=$pacman_settings['pacman']['ghost1'];
	$ghost2=$pacman_settings['pacman']['ghost2'];
	$ghost3=$pacman_settings['pacman']['ghost3'];
	$ghost4=$pacman_settings['pacman']['ghost4'];
	$pacman_msg_login=$pacman_settings['pacman']['pacman_msg_login'];
	$pacman_msg_required_mycred=$pacman_settings['pacman']['pacman_msg_required_mycred'];
	$pacman_msg_hook=$pacman_settings['pacman']['pacman_msg_hook'];
	$pacman_msg_limit_crossed=$pacman_settings['pacman']['pacman_msg_limit_crossed'];
	$pacman_button=$pacman_settings['pacman']['pacman_button'];
	$pacman_popup_or_page=isset($pacman_settings['pacman']['pacman_popup_or_page']) ? $pacman_settings['pacman']['pacman_popup_or_page'] : 'popup';

	if(empty($pacman_popup_or_page)){
		$pacman_popup_or_page='popup';
	}
	if(empty($game_title)){
		$game_title=__("Pacman Game",'mycred-pacman');
	}
	if(empty($ghost1)){
		$ghost1=__("Blinky",'mycred-pacman');
	}
	if(empty($ghost2)){
		$ghost2=__("Pinky",'mycred-pacman');
	}
	if(empty($ghost3)){
		$ghost3=__("Inky",'mycred-pacman');
	}
	if(empty($ghost4)){
		$ghost4=__("Clyde",'mycred-pacman');
	}
	if(empty($pacman_msg_login)){
		$pacman_msg_login=__("Please logged in to play this game",'mycred-pacman');
	}
	if(empty($pacman_msg_required_mycred)){
		$pacman_msg_required_mycred=__("Mycred Pacman Requires mycred to be installed and activated",'mycred-pacman');
	}
	if(empty($pacman_msg_hook)){
		$pacman_msg_hook=__("You need to activate the mycred pacman hook",'mycred-pacman');
	}
	if(empty($pacman_msg_limit_crossed)){
		$pacman_msg_limit_crossed=__("Sorry! You have crossed the limit for maximum points earned within a given time",'mycred-pacman');
	}
	if(empty($pacman_button)){
		$pacman_button=__("Mycred MyPacman",'mycred-pacman');
	}

	if(!is_user_logged_in())
	{
		return '<p>'.$pacman_msg_login.'</p>';
	}
	if(!class_exists('myCRED_Core')){
		return '<p>'.$pacman_msg_required_mycred.'</p>';
	}
	
	do_action( 'before_pacman_game' );

	$is_hook_active=false;
	
	$all_point_types=mycred_get_types();

	foreach($all_point_types as $point_type_key=>$point_type_value){
		$point_type_slug='';
		if($point_type_key != 'mycred_default'){
			$point_type_slug='_'.$point_type_key;
		}

		$active_hooks=get_option('mycred_pref_hooks'.$point_type_slug);
		if(is_array($active_hooks['active']) && !empty($active_hooks['active']) && in_array('play_pacman',$active_hooks['active'])){
			$is_hook_active=true;
		}
	} 

	if($is_hook_active===false){
		return '<p>'.$pacman_msg_hook.'</p>';
	}

	$allowed = true;

	$allowed = apply_filters( 'is_allowed_to_play', $allowed );

	if( $allowed == false )
		return '<p>'.$pacman_msg_limit_crossed.'</p>';
		
		wp_enqueue_script('mycred-jquery-buzz');
		wp_enqueue_script('mycred-game');
		wp_enqueue_script('mycred-tools');
		wp_enqueue_script('mycred-board');
		wp_enqueue_script('mycred-paths');
		wp_enqueue_script('mycred-bubbles');
		wp_enqueue_script('mycred-fruits');
		wp_enqueue_script('mycred-pacman');
		wp_enqueue_script('mycred-ghosts');
		wp_enqueue_script('mycred-home');
		wp_enqueue_script('mycred-sound');
		
	
		$html = '';

		if($pacman_popup_or_page == 'page'){
			wp_enqueue_script('mycred-custom-page-js');
			$html = pacman_html_for_page($pacman_button, $game_title, $ghost1, $ghost2, $ghost3, $ghost4);
		}
		else{
			wp_enqueue_script('mycred-custom-js');
			$html = pacman_html_for_popup($pacman_button, $game_title, $ghost1, $ghost2, $ghost3, $ghost4);
		}

	return $html;
}


add_shortcode( 'mycred_pacman_game', 'pacman' );


function pacman_html_for_popup($pacman_button, $game_title, $ghost1, $ghost2, $ghost3, $ghost4){

	$html='
<div class="pacman_preview">
	<div class="wp-block-button" >
		<button id="launch_pacman_btn">'.$pacman_button.'</button>
	</div>
	
  <div>
  <div id="mypacman_modal" class="modal">
	<div class="modal-content">
		
		<div class="pacman_game"><div id="pacman_id_sound"></div>
	
		<div id="pacman_help">
			<h2>'.__("Help",'mycred-pacman').'</h2>
			<table align="center" border="0" cellPadding="2" cellSpacing="0">
				<tbody>
					<tr><td>'.__("Arrow Left",'mycred-pacman').' : </td><td>'.__("Move Left",'mycred-pacman').'</td></tr>
					<tr><td>'.__("Arrow Right",'mycred-pacman').' : </td><td>'.__("Move Right",'mycred-pacman').'</td></tr>
					<tr><td>'.__("Arrow Down",'mycred-pacman').' : </td><td>'.__("Move Down",'mycred-pacman').'</td></tr>
					<tr><td>'.__("Arrow Up",'mycred-pacman').' : </td><td>'.__("Move Up",'mycred-pacman').'</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td>P : </td><td>'.__("PAUSE",'mycred-pacman').'</td></tr>
				</tbody>
			</table>
		</div>
	
		<div id="pacman_home">
			<div>
			<span class="pacman_close">×</span>
		</div>

		<h1>'.$game_title.'</h1>
			
			<canvas id="canvas-home-title-pacman"></canvas>
			<div id="pacman_presentation">
				<div id="presentation-titles">'.__("character",'mycred-pacman').' &nbsp;/&nbsp; '.__("nickname",'mycred-pacman').'</div>
				<div  class="pacman_characters">
				<canvas id="canvas-presentation-blinky"></canvas><div id="presentation-character-blinky">- '.__("shadow",'mycred-pacman').'</div><div id="presentation-name-blinky">"'.$ghost1.'"</div>
				</div>
				<div class="pacman_characters">
				<canvas id="canvas-presentation-pinky"></canvas><div id="presentation-character-pinky">- '.__("speedy",'mycred-pacman').'</div><div id="presentation-name-pinky">"'.$ghost2.'"</div>
				</div>
				<div  class="pacman_characters">
				<canvas id="canvas-presentation-inky"></canvas><div id="presentation-character-inky">- '.__("bashful",'mycred-pacman').'</div><div id="presentation-name-inky">"'.$ghost3.'"</div>
				</div>
				<div  class="pacman_characters">
				<canvas id="canvas-presentation-clyde"></canvas><div id="presentation-character-clyde">- '.__("pokey",'mycred-pacman').'</div><div id="presentation-name-clyde">"'.$ghost4.'"</div>
				</div>
			</div>
			<canvas id="pacman_trailer"></canvas>
			
		</div>

		<div id="pacman_panel">
			<div id="pacman_toolbar">
				
				<div id="pacman_score"><h2>'.__("SCORE",'mycred-pacman').'</h2><span>00</span></div>
				
				<span class="pacman_close">×</span>	
					
				<div class="help-sound">
				<div class="help-button">- '.__("help",'mycred-pacman').' -</div>
					<a class="pacman_sound" href="javascript:void(0);" data-sound="on"><img src="'.plugin_dir_url( MYCRED_PACMAN ).'/assets/img/sound-on.png" alt="" border="0"></a>
				</div>
				
			</div>
			
			<canvas id="canvas-panel-title-pacman"></canvas>
			
			<div id="pacman_board">
				<canvas id="canvas-board"></canvas>
				<canvas id="canvas-paths"></canvas>
				<canvas id="canvas-bubbles"></canvas>
				<canvas id="canvas-fruits"></canvas>
				<canvas id="canvas-pacman"></canvas>
				<canvas id="canvas-ghost-blinky"></canvas>
				<canvas id="canvas-ghost-pinky"></canvas>
				<canvas id="canvas-ghost-inky"></canvas>
				<canvas id="canvas-ghost-clyde"></canvas>
				<div id="control-up-big"></div>
				<div id="control-down-big"></div>
				<div id="control-left-big"></div>
				<div id="control-right-big"></div>
			</div>
			<div id="pacman_control">
				<div id="control-up"></div>
				<div id="control-up-second"></div>
				<div id="control-down"></div> 
				<div id="control-down-second"></div>
				<div id="control-left"></div>
				<div id="control-right"></div>
			</div>
			<canvas id="canvas-lifes"></canvas>
			<canvas id="canvas-level-fruits"></canvas>
			<div id="pacman_message"></div>
			
		</div> 
		
		</div>
	</div>
  </div>';


	return $html;

}



function pacman_html_for_page($pacman_button, $game_title, $ghost1, $ghost2, $ghost3, $ghost4){

	$html='<div class="pacman-main">
  <div id="mypacman_page">
		
		<div class="pacman_game"><div id="pacman_id_sound"></div>
	
		<div id="pacman_help">
			<h2>'.__("Help",'mycred-pacman').'</h2>
			<table align="center" border="0" cellPadding="2" cellSpacing="0">
				<tbody>
					<tr><td>'.__("Arrow Left",'mycred-pacman').' : </td><td>'.__("Move Left",'mycred-pacman').'</td></tr>
					<tr><td>'.__("Arrow Right",'mycred-pacman').' : </td><td>'.__("Move Right",'mycred-pacman').'</td></tr>
					<tr><td>'.__("Arrow Down",'mycred-pacman').' : </td><td>'.__("Move Down",'mycred-pacman').'</td></tr>
					<tr><td>'.__("Arrow Up",'mycred-pacman').' : </td><td>'.__("Move Up",'mycred-pacman').'</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td>P : </td><td>'.__("PAUSE",'mycred-pacman').'</td></tr>
				</tbody>
			</table>
		</div>
	
		<div id="pacman_home">

		<h1>'.$game_title.'</h1>
			
			<canvas id="canvas-home-title-pacman"></canvas>
			<div id="pacman_presentation">
				<div id="presentation-titles">'.__("character",'mycred-pacman').' &nbsp;/&nbsp; '.__("nickname",'mycred-pacman').'</div>
				<div  class="pacman_characters">
				<canvas id="canvas-presentation-blinky"></canvas><div id="presentation-character-blinky">- '.__("shadow",'mycred-pacman').'</div><div id="presentation-name-blinky">"'.$ghost1.'"</div>
				</div>
				<div class="pacman_characters">
				<canvas id="canvas-presentation-pinky"></canvas><div id="presentation-character-pinky">- '.__("speedy",'mycred-pacman').'</div><div id="presentation-name-pinky">"'.$ghost2.'"</div>
				</div>
				<div  class="pacman_characters">
				<canvas id="canvas-presentation-inky"></canvas><div id="presentation-character-inky">- '.__("bashful",'mycred-pacman').'</div><div id="presentation-name-inky">"'.$ghost3.'"</div>
				</div>
				<div  class="pacman_characters">
				<canvas id="canvas-presentation-clyde"></canvas><div id="presentation-character-clyde">- '.__("pokey",'mycred-pacman').'</div><div id="presentation-name-clyde">"'.$ghost4.'"</div>
				</div>
			</div>
			<canvas id="pacman_trailer"></canvas>
			
		</div>

		<div id="pacman_panel">
			<div id="pacman_toolbar">
				
				<div id="pacman_score"><h2>'.__("SCORE",'mycred-pacman').'</h2><span>00</span></div>
					
				<div class="help-sound">
				<div class="help-button">- '.__("help",'mycred-pacman').' -</div>
					<a class="pacman_sound" href="javascript:void(0);" data-sound="on"><img src="'.plugin_dir_url( MYCRED_PACMAN ).'/assets/img/sound-on.png" alt="" border="0"></a>
				</div>
				
			</div>
			
			<canvas id="canvas-panel-title-pacman"></canvas>
			
			<div id="pacman_board">
				<canvas id="canvas-board"></canvas>
				<canvas id="canvas-paths"></canvas>
				<canvas id="canvas-bubbles"></canvas>
				<canvas id="canvas-fruits"></canvas>
				<canvas id="canvas-pacman"></canvas>
				<canvas id="canvas-ghost-blinky"></canvas>
				<canvas id="canvas-ghost-pinky"></canvas>
				<canvas id="canvas-ghost-inky"></canvas>
				<canvas id="canvas-ghost-clyde"></canvas>
				<div id="control-up-big"></div>
				<div id="control-down-big"></div>
				<div id="control-left-big"></div>
				<div id="control-right-big"></div>
			</div>
			<div id="pacman_control">
				<div id="control-up"></div>
				<div id="control-up-second"></div>
				<div id="control-down"></div> 
				<div id="control-down-second"></div>
				<div id="control-left"></div>
				<div id="control-right"></div>
			</div>
			<canvas id="canvas-lifes"></canvas>
			<canvas id="canvas-level-fruits"></canvas>
			<div id="pacman_message"></div>
			</div>
			<div style="clear: both;"></div>
			</div>
		</div>
  </div>';


	return $html;

}