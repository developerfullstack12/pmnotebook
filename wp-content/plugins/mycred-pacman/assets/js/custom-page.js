		
		
			function simulateKeyup(code) { 
				var e = jQuery.Event("keyup");
				e.keyCode = code;
				//jQuery("body").trigger(e);
				game_functionality(e);
				
			}
			function simulateKeydown(code) { 
				var e = jQuery.Event("keydown");
				e.keyCode = code;
				//jQuery("body").trigger(e);
				//console.log(code);
				game_functionality(e);
			}
			
			jQuery(document).ready(function() { 
			jQuery('.pacman_game').css('background-color', assets.background_color);
			jQuery('#pacman_panel h1, #presentation-titles').css('color', assets.text_color);
			
			jQuery('#pacman_score h2, #pacman_score span, #pacman_home h1').css('color', assets.text_color);
		
				//$.mobile.loading().hide();
				loadAllSound();
				
				HELP_TIMER = setInterval("blinkHelp()", HELP_DELAY);
				
				initHome();
				
				jQuery(".pacman_sound").click(function(e) { 
					e.stopPropagation();
					
					var sound = jQuery(this).attr("data-sound");
					if ( sound === "on" ) { 
						jQuery(".pacman_sound").attr("data-sound", "off");
						jQuery(".pacman_sound").find("img").attr("src", assets.pluginsurl+"/assets/img/sound-off.png");
						GROUP_SOUND.mute();
					} else { 
						jQuery(".pacman_sound").attr("data-sound", "on");
						jQuery(".pacman_sound").find("img").attr("src", assets.pluginsurl+"/assets/img/sound-on.png");
						GROUP_SOUND.unmute();
					}
				});
				
				jQuery(".help-button, #pacman_help").click(function(e) { 
					e.stopPropagation();
					if (!PACMAN_DEAD && !LOCK && !GAMEOVER) { 
						if ( jQuery("#pacman_help").css("display") === "none") { 
							jQuery("#pacman_help").fadeIn("slow");
							jQuery(".help-button").hide();
							if ( jQuery("#pacman_panel").css("display") !== "none") { 
								pauseGame();
							}
						} else { 
							jQuery("#pacman_help").fadeOut("slow");
							jQuery(".help-button").show();
						}
					}
				});
				
				jQuery(".github,.putchu").click(function(e) { 
					e.stopPropagation();
				});
				
				jQuery("#pacman_home").on("click touchstart", function(e) { 
					if ( jQuery("#pacman_help").css("display") === "none") { 
						e.preventDefault();
						simulateKeydown(13);
					}
				});
				jQuery("#control-up, #control-up-second, #control-up-big").on("mousedown touchstart", function(e) { 
					e.preventDefault();
					simulateKeydown(38);
					simulateKeyup(13);
				});
				jQuery("#control-down, #control-down-second, #control-down-big").on("mousedown touchstart", function(e) { 
					e.preventDefault();
					simulateKeydown(40);
					simulateKeyup(13);
				});
				jQuery("#control-left, #control-left-big").on("mousedown touchstart", function(e) { 
					e.preventDefault();
					simulateKeydown(37);
					simulateKeyup(13);
				});
				jQuery("#control-right, #control-right-big").on("mousedown touchstart", function(e) { 
					e.preventDefault();
					simulateKeydown(39);
					simulateKeyup(13);
				});

				
				jQuery("body").keyup(function(e) { 
					KEYDOWN = false;
				});
				
				jQuery("body").keydown(function(e) { 
					game_functionality(e);
				});

			
			});


			function game_functionality(e){
					
					if (HOME) { 
						
						initGame(true);
						
					} else { 				
						//if (!KEYDOWN) { 
							KEYDOWN = true;
							if (PACMAN_DEAD && !LOCK) { 
								erasePacman();
								resetPacman();
								drawPacman();
								
								eraseGhosts();
								resetGhosts();
								drawGhosts();
								moveGhosts();
								
								blinkSuperBubbles();
								
							} else if (e.keyCode >= 37 && e.keyCode <= 40 && !PAUSE && !PACMAN_DEAD && !LOCK) { 
								if ( e.keyCode === 39 ) { 
									e.preventDefault();
									movePacman(1);
								} else if ( e.keyCode === 40 ) { 
									e.preventDefault();
									movePacman(2);
								} else if ( e.keyCode === 37 ) { 
									e.preventDefault();
									movePacman(3);
								} else if ( e.keyCode === 38 ) { 
									e.preventDefault();
									movePacman(4);
								}
							} else if (e.keyCode === 68 && !PAUSE) { 
								/*if ( jQuery("#canvas-paths").css("display") === "none" ) { 
									jQuery("#canvas-paths").show();
								} else { 
									jQuery("#canvas-paths").hide();
								}*/
							} else if (e.keyCode === 80 && !PACMAN_DEAD && !LOCK) { 
								if (PAUSE) { 
									resumeGame();
									PAUSE=false;
								} else { 
									pauseGame();
								}
							} else if (GAMEOVER) { 
								initHome();
							}
						//}
					}
				
			}
			


			window.addEventListener("orientationchange", function() {
				if (window.matchMedia("(orientation: landscape)").matches) {
					//resumeGame();
					
				 }
				 else{
					pauseGame();
				 }
			}, false);	
			
			jQuery(window).blur(function() {
				pauseGame();
			});
			
			jQuery(document).ready(function() { 
				
				var on_click_pause_message = document.getElementById("pacman_message");

				on_click_pause_message.onclick = function() {
					resumeGame();
				}

				// When the user clicks anywhere outside of the modal, close it
			/*	window.onclick = function(event) {
					var pacman_page = document.getElementById("mypacman_page");
					if (event.target == pacman_page) {
						resumeGame();
					} else {
						pauseGame();
					}
				}
				*/

			});