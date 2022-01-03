
jQuery(window).resize(function(){
    ctlArcadeLiteGalleryResize();
});

    
function _ctl_arcade_lite_write_shortcode(oGame){

    if(!oGame){
        jQuery(".ctl-arcade-lite-shortcode-game-iframe-output").val('[ctl_arcade_lite_game game="'+ jQuery(".ctl-arcade-lite-shortcode-game-iframe-gamelist-wrapper li:first-child").attr("data-game-plugin-dir") +'" mode="iframe" max-height="'+ jQuery(".ctl-arcade-lite-shortcode-game-iframe-game-max-height input").val() +'"]');
    }else{
        jQuery(".ctl-arcade-lite-shortcode-game-iframe-output").val('[ctl_arcade_lite_game game="'+ oGame.attr("data-game-plugin-dir") +'" mode="iframe" max-height="'+ jQuery(".ctl-arcade-lite-shortcode-game-iframe-game-max-height input").val() +'"]');
    }
}

function ctl_arcade_lite_shortcode_game_iframe_close(){
    top.tinymce.activeEditor.windowManager.close();
}

function ctl_arcade_lite_shortcode_game_iframe_insert(){

    if( jQuery(".ctl-arcade-lite-shortcode-game-iframe-output").val() === "" ){
        return;
    }

    top.tinymce.activeEditor.insertContent( jQuery(".ctl-arcade-lite-shortcode-game-iframe-output").val() );
    top.tinymce.activeEditor.windowManager.close();
}


jQuery(window).ready(function(){
    jQuery(".ctl-arcade-lite-img-guide").each( function(){

        jQuery(this).attr("data-size","300");
        jQuery(this).click(function(){
            if( jQuery(this).attr("data-size") === "300"){
                jQuery(this).attr("data-size","100");
                jQuery(this).find("img").addClass("ctl-arcade-lite-img-class-100");
            }else{
                jQuery(this).attr("data-size","300");
                jQuery(this).find("img").removeClass("ctl-arcade-lite-img-class-100");
            }
        });
    });
    
    
    (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.5&appId=49655289489";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        
    jQuery(".ctl-arcade-lite-installed-game-filter").on('input', function(){

    var bFound = false;
    var szKey = jQuery.trim(jQuery(this).val()).toLowerCase();

    jQuery(".ctl-arcade-lite-admin-installed-game-list .ctl-arcade-lite-admin-game-preview-box").each(function(){
        var indexTags = jQuery(this).attr("data-tags").toLowerCase().indexOf(szKey);
        var indexName = jQuery(this).find("h3").text().toLowerCase().indexOf(szKey);

        if( indexTags >= 0 || indexName >= 0){
            jQuery(this).css("display","block");
            bFound = true;
        }else{
            jQuery(this).css("display","none");
        }
    });

    if( bFound === false ){
        jQuery(".ctl-arcade-lite-admin-installed-game-list-message").text("No results with this key");
    }else{
        jQuery(".ctl-arcade-lite-admin-installed-game-list-message").text("");
    }
});
    
    jQuery(document).on('input', ".ctl-arcade-lite-shortcode-game-iframe-game-filter input", function(){
        var szKey = jQuery.trim(jQuery(this).val()).toLowerCase();
        var bFound = false;

        jQuery(".ctl-arcade-lite-shortcode-game-iframe-gamelist-wrapper li").each(function(){
            var szGame = jQuery.trim(jQuery(this).text()).toLowerCase();
            var szSrcNameGame = jQuery.trim(jQuery(this).text());

            var index = szGame.indexOf(szKey);
            if( index >= 0 ){

                var szNewString = szSrcNameGame.substr(0,index) +
                        "<strong>" +  szSrcNameGame.substr(index,szKey.length) + "</strong>" +
                    szSrcNameGame.substr(index+szKey.length, szSrcNameGame.length - (index + szKey.length));

                bFound = true;

                jQuery(this).find("span").html(szNewString);
                jQuery(this).css("display","block");
            }else{
                jQuery(this).css("display","none");
            }
        });

        if( szKey === "" || !bFound ){
            jQuery(".ctl-arcade-lite-shortcode-game-iframe-output").val('');
        }else{
            _ctl_arcade_lite_write_shortcode();
        }
    });

    jQuery(document).on("click",".ctl-arcade-lite-shortcode-game-iframe-gamelist-wrapper li", function(){
        _ctl_arcade_lite_write_shortcode(jQuery(this));
    });
    
    jQuery(".ctl-arcade-lite-admin-game-gallery").each(function(){
        var aGallery = [];
        var i = 0;
        jQuery(this).children(".ctl-arcade-lite-admin-game-gallery-item").each(function(){
            jQuery(this).attr("data-index", i);
            i++;
            aGallery.push({ srcFullSize : jQuery(this).attr("data-fullsize") })
        });
        jQuery(this).data("ctl-gallery-data", aGallery);


        jQuery(this).children(".ctl-arcade-lite-admin-game-gallery-item").each(function(){
            jQuery(this).on("click", function(){
                var aGalleryData = jQuery(this).closest(".ctl-arcade-lite-admin-game-gallery").data("ctl-gallery-data");
                var id     = ctlArcadeLiteMakeCode();
                var szHtml = '<div id="'+ id +'" class="ctl-arcade-lite-gallery-wrapper">';
                    szHtml += '<div class="ctl-arcade-lite-gallery-block"></div>';
                    szHtml += '<div class="ctl-arcade-lite-gallery-content">';
                        szHtml += '<img src="'+ jQuery(this).attr("data-fullsize") +'"/>';
                        szHtml += '<div title="left" class="ctl-arcade-lite-gallery-left ctl-arcade-lite-icon-left-open"></div>';
                        szHtml += '<div title="right" class="ctl-arcade-lite-gallery-right ctl-arcade-lite-icon-right-open"></div>';
                        szHtml += '<div title="close" class="ctl-arcade-lite-gallery-close ctl-arcade-lite-icon-cancel"></div>';
                    szHtml += '</div>';
                szHtml += '</div>';
                jQuery("body").append(szHtml);
                jQuery("#"+id).data("ctl-gallery-data", aGalleryData);
                jQuery("#"+id).data("ctl-gallery-cur-item", jQuery(this).attr("data-index"));
                jQuery("#"+id+" img").on("load",function(){
                    ctlArcadeLiteGalleryResize();
                });
            });
        });
    });

    jQuery(document).on("click", ".ctl-arcade-lite-gallery-block", function(){
        jQuery(this).closest(".ctl-arcade-lite-gallery-wrapper").remove();
    });

    jQuery(document).on("click", ".ctl-arcade-lite-gallery-close", function(){
        jQuery(this).closest(".ctl-arcade-lite-gallery-wrapper").remove();
    });

    jQuery(document).on("click", ".ctl-arcade-lite-gallery-left", function(){
        var oWrapper = jQuery(this).closest(".ctl-arcade-lite-gallery-wrapper");
        var index = oWrapper.data("ctl-gallery-cur-item");
        var aGallery = oWrapper.data("ctl-gallery-data");

        index--;
        if( index < 0 ){
            index = aGallery.length-1;
        }

        oWrapper.data("ctl-gallery-cur-item", index);
        oWrapper.find("img").attr("src", aGallery[index].srcFullSize);
    });

    jQuery(document).on("click", ".ctl-arcade-lite-gallery-right", function(){
        var oWrapper = jQuery(this).closest(".ctl-arcade-lite-gallery-wrapper");
        var index = oWrapper.data("ctl-gallery-cur-item");
        var aGallery = oWrapper.data("ctl-gallery-data");

        index++;
        if( index == aGallery.length ){
            index = 0;
        }

        oWrapper.data("ctl-gallery-cur-item", index);
        oWrapper.find("img").attr("src", aGallery[index].srcFullSize);
    });
});

function ctlArcadeLiteGalleryResize(){
    jQuery(".ctl-arcade-lite-gallery-wrapper img").each(function(){
        var rw = jQuery(this)[0].naturalWidth;
        var rh = jQuery(this)[0].naturalHeight;
        var w = window.innerWidth - 60;
        var h = window.innerHeight - 60;
        multiplier = Math.min((h / rh), (w / rw));
        var destW = rw * multiplier;
        var destH = rh * multiplier;

        if( destW > rw && destH > rh ){
            destW = rw;
            destH = rh;
        }

        jQuery(this).css("width",destW+"px");
        jQuery(this).css("height",destH+"px");

        jQuery(this).closest(".ctl-arcade-lite-gallery-content").css("width",destW+"px");
        jQuery(this).closest(".ctl-arcade-lite-gallery-content").css("height",destH+"px");
    });
}

function ctlArcadeLiteMakeCode() {
    var code = "";
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 32; i++ )
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    return code;
}
