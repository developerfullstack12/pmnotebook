var KEYDOWN = false;
var PAUSE = false;
var LOCK = false;

var HIGHSCORE = 0;
var SCORE = 0;
var SCORE_BUBBLE = 10;
var SCORE_SUPER_BUBBLE = 50;
var SCORE_GHOST_COMBO = 200;
var TOTAL_LIVES=parseInt(game.lives, 10);

var LIFES = TOTAL_LIVES>4 ? 4: TOTAL_LIVES;
LIFES = LIFES-1;
var GAMEOVER = false;
var GAMEOVER_MESSAGE = game.game_over_label;
var GAMEOVER_COLOR = game.game_over_color;
var LEVEL = 1;
var LEVEL_NEXT_TIMER = -1;
var LEVEL_NEXT_STATE = 0;

var TIME_GENERAL_TIMER = -1;
var TIME_GAME = 0;
var TIME_LEVEL = 0;
var TIME_LIFE = 0;
var TIME_FRUITS = 0;

var HELP_DELAY = 1500;
var HELP_TIMER = -1;
			
function blinkHelp() { 
	if ( jQuery('.help-button').attr("class").indexOf("yo") > -1 ) { 
		jQuery('.help-button').removeClass("yo");
	} else { 
		jQuery('.help-button').addClass("yo");
	}
}

function initGame(newgame) { 

	if (newgame) { 
		stopPresentation();
		stopTrailer();
	
		HOME = false;
		GAMEOVER = false;
		LIFES = parseInt(game.lives, 10)-1;

		jQuery('#pacman_help').fadeOut("slow");
		
		score(0);
		clearMessage();
		jQuery("#pacman_home").hide();
		jQuery("#pacman_panel").show();
		
		var ctx = null;
		var canvas = document.getElementById('canvas-panel-title-pacman');
		canvas.setAttribute('width', '38');
		canvas.setAttribute('height', '32');
		if (canvas.getContext) { 
			ctx = canvas.getContext('2d');
		}
		
		var x = 15;
		var y = 16;
		
		ctx.fillStyle = "#fff200";
		ctx.beginPath();
		ctx.arc(x, y, 14, (0.35 - (3 * 0.05)) * Math.PI, (1.65 + (3 * 0.05)) * Math.PI, false);
		ctx.lineTo(x - 5, y);
		ctx.fill();
		ctx.closePath();
		
		x = 32;
		y = 16;
		
		ctx.fillStyle = "#dca5be";
		ctx.beginPath();
		ctx.arc(x, y, 4, 0, 2 * Math.PI, false);
		ctx.fill();
		ctx.closePath();
	}

	initBoard();
	drawBoard();
	drawBoardDoor();
	
	initPaths();
	drawPaths();
	
	initBubbles();
	drawBubbles();
	
	initFruits();
	
	initPacman();
	drawPacman();
	
	initGhosts();
	drawGhosts();
	
	lifes();
	
	ready();

	if (PAUSE) { 
		pauseGame();
		PAUSE=false;
	}
	console.log(PAUSE);
}

function win() { 
	stopAllSound();

	LOCK = true;
	stopPacman();
	stopGhosts();
	stopBlinkSuperBubbles();
	stopTimes();
	
	eraseGhosts();

	setTimeout("prepareNextLevel()", 1000);

}
function prepareNextLevel(i) { 
	if ( LEVEL_NEXT_TIMER === -1 ) { 
		eraseBoardDoor();
		LEVEL_NEXT_TIMER = setInterval("prepareNextLevel()", 250);
	} else { 
		LEVEL_NEXT_STATE ++;
		drawBoard( ((LEVEL_NEXT_STATE % 2) === 0) );
		
		if ( LEVEL_NEXT_STATE > 6) { 
			LEVEL_NEXT_STATE = 0;
			clearInterval(LEVEL_NEXT_TIMER);
			LEVEL_NEXT_TIMER = -1;
			nextLevel();
		}
	}
}
function nextLevel() { 
	LOCK = false;
	
	LEVEL ++;
	
	erasePacman();
	eraseGhosts();
	
	resetPacman();
	resetGhosts();

	initGame();
	
	TIME_LEVEL = 0;
	TIME_LIFE = 0;
	TIME_FRUITS = 0;
}


function retry() { 
	stopTimes();

	erasePacman();
	eraseGhosts();
	
	resetPacman();
	resetGhosts();
	
	drawPacman();
	drawGhosts();
	
	TIME_LIFE = 0;
	TIME_FRUITS = 0;
	
	ready();
}

function ready() { 
	LOCK = true;
	message(game.ready_translation+"!");
	
	playReadySound();
	setTimeout("go()", "4100");
}
function go() { 
	playSirenSound();

	LOCK = false;
	
	startTimes();
	
	clearMessage();
	blinkSuperBubbles();

	movePacman();

	moveGhosts();
}
function startTimes() { 
	if (TIME_GENERAL_TIMER === -1) { 
		TIME_GENERAL_TIMER = setInterval("times()", 1000);
	}
}
function times() { 
	TIME_GAME ++;
	TIME_LEVEL ++;
	TIME_LIFE ++;
	TIME_FRUITS ++;
	
	fruit();
}
function pauseTimes() { 
	if (TIME_GENERAL_TIMER != -1) { 
		clearInterval(TIME_GENERAL_TIMER);
		TIME_GENERAL_TIMER = -1;
	}
	if (FRUIT_CANCEL_TIMER != null) FRUIT_CANCEL_TIMER.pause();
}
function resumeTimes() { 
	startTimes();
	if (FRUIT_CANCEL_TIMER != null) FRUIT_CANCEL_TIMER.resume();
}
function stopTimes() { 
	if (TIME_GENERAL_TIMER != -1) { 
		clearInterval(TIME_GENERAL_TIMER);
		TIME_GENERAL_TIMER = -1;
	}
	if (FRUIT_CANCEL_TIMER != null) { 
		FRUIT_CANCEL_TIMER.cancel();
		FRUIT_CANCEL_TIMER = null;
		eraseFruit();
	}
}

function pauseGame() { 

	if (!PAUSE) { 
		stopAllSound();
		PAUSE = true;
		
		message(game.pause_translation);
		
		pauseTimes();
		pausePacman();
		pauseGhosts();
		stopBlinkSuperBubbles();
	}
}
function resumeGame() { 
	if (PAUSE) { 
		testStateGhosts();

		PAUSE = false;
		
		clearMessage();
		
		resumeTimes();
		resumePacman();
		resumeGhosts();
		blinkSuperBubbles();
	}
}

function lifes(l) { 
	if (l) { 
		if ( l > 0 ) { 
			playExtraLifeSound();
		}
		LIFES += l;
	}
	
	var canvas = document.getElementById('canvas-lifes');
	canvas.setAttribute('width', '150');
	canvas.setAttribute('height', '30');
	if (canvas.getContext) { 
		var ctx = canvas.getContext('2d');
		
		ctx.clearRect(0, 0, 120, 30);
		ctx.fillStyle = "#fff200";
		for (var i = 0, imax = LIFES; (i < imax ); i ++) { 
			ctx.beginPath();
			
			var lineToX = 13;
			var lineToY = 15;
			
			ctx.arc(lineToX + (i * 30), lineToY, 13, (1.35 - (3 * 0.05)) * Math.PI, (0.65 + (3 * 0.05)) * Math.PI, false);
			ctx.lineTo(lineToX + (i * 30) + 4, lineToY);
			ctx.fill();
			ctx.closePath();
		}
	}
}

function mycred_send_user_score(user_score,admin_url)
  {
	var data = {
		'action': 'update_mypacman_user_log',
		'score': user_score,
		'pacman-nonce': game.nonce,
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(admin_url, data, function(response) {
		alert(response);
	});
  
}

function gameover() { 
	GAMEOVER = true;
	message(GAMEOVER_MESSAGE);
	stopTimes();

	erasePacman();
	eraseGhosts();
	
	resetPacman();
	resetGhosts();
	
	TIME_GAME = 0;
	TIME_LEVEL = 0;
	TIME_LIFE = 0;
	TIME_FRUITS = 0;

	
mycred_send_user_score(SCORE,game.ajax_url);
	LIFES = TOTAL_LIVES;
	LEVEL = 1;
	SCORE = 0;
}


function message(m) { 
	jQuery("#pacman_message").html(m);
	/* if (m === "game over") jQuery("#message").addClass("red"); */
	jQuery("#pacman_message").css('color', GAMEOVER_COLOR);
}
function clearMessage() { 
	jQuery("#pacman_message").html("");
	/* jQuery("#message").removeClass("red"); */
}

function score(s, type) { 

	var scoreBefore = (SCORE / 10000) | 0;
	
	SCORE += s;
	if (SCORE === 0) { 
		jQuery('#pacman_score span').html("00");
	} else { 
		jQuery('#pacman_score span').html(SCORE);
	}
	
	var scoreAfter = (SCORE / 10000) | 0;
	if (scoreAfter > scoreBefore) { 
		/* lifes( +1 ); */
	}

	
	if (SCORE > HIGHSCORE) { 
		HIGHSCORE = SCORE;
		if (HIGHSCORE === 0) { 
			jQuery('#pacman_highscore span').html("00");
		} else { 
			jQuery('#pacman_highscore span').html(HIGHSCORE);
		}
	}
	
	if (type && (type === "clyde" || type === "pinky" || type === "inky" || type === "blinky") ) { 
		erasePacman(); 
		eraseGhost(type); 
		jQuery("#pacman_board").append('<span class="combo">' + SCORE_GHOST_COMBO + '</span>');
		jQuery("#pacman_board span.combo").css('top', eval('GHOST_' + type.toUpperCase() + '_POSITION_Y - 10') + 'px');
		jQuery("#pacman_board span.combo").css('left', eval('GHOST_' + type.toUpperCase() + '_POSITION_X - 10') + 'px');
		SCORE_GHOST_COMBO = SCORE_GHOST_COMBO * 2;
	} else if (type && type === "fruit") { 
		jQuery("#pacman_board").append('<span class="fruits">' + s + '</span>');
		jQuery("#pacman_board span.fruits").css('top', (FRUITS_POSITION_Y - 14) + 'px');
		jQuery("#pacman_board span.fruits").css('left', (FRUITS_POSITION_X - 14) + 'px');
	}
}