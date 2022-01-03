/**
 * Created by codethislab on 13/10/15.
 */
(function() {
    tinymce.create('tinymce.plugins.ctl_arcade_lite_shortcode_buttons', {
        init : function(ed, url) {

            ed.addButton('ctl_arcade_lite_shortcode_add_game_iframe', {
                title : 'Add Game Widget - CTL Arcade Lite',
                classes : 'ctl-arcade-lite-icon-gamepad',
                cmd : 'ctl_arcade_lite_shortcode_add_game_iframe'
            });
 
            ed.addCommand('ctl_arcade_lite_shortcode_add_game_iframe', function() {

                jQuery.post(
                    ajaxurl,
                    {
                        'action': 'ctl-arcade-lite'
                    }).done(
                    function(response){
                        ed.windowManager.open( {
                            width : 300,
                            height : 300,
                            title: 'Insert a Game Widget'
                        });
                        
                        tinymce.activeEditor.windowManager.windows[0]["$el"].find(".mce-window-body").html(response);
                        tinymce.activeEditor.windowManager.windows[0]["$el"].find(".mce-foot").remove();
                    }
                ).fail( function(){
                    alert("Ooops! Something Went Wrong!");
                });
                
   
            });

        }
    });
    // Register plugin
    tinymce.PluginManager.add( 'ctl_arcade_lite_shortcode_buttons', tinymce.plugins.ctl_arcade_lite_shortcode_buttons );
})();