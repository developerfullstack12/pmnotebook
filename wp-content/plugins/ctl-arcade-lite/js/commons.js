/**
 * Created by codethislab on 20/10/15.
 */

var g_iTimeAds = 0;

jQuery(window).resize(function(){
    ctlDlgResize();
});

function __ctlDlgResizeAttachToBody( oNode ){

    if ( oNode.hasClass("ctl-arcade-lite-dlg-fixed") ){
        return;
    }

    oNode.addClass("ctl-arcade-lite-dlg-fixed");
    oNode = oNode.detach();
    jQuery("body").append(oNode);
}
function __ctlDlgResizeAttachToGameIframe( oNode ){

    if ( !oNode.hasClass("ctl-arcade-lite-dlg-fixed") ){
        return;
    }

    oNode.removeClass("ctl-arcade-lite-dlg-fixed");
    oNode = oNode.detach();
    jQuery(".ctl-arcade-lite-game-iframe-wrapper").append(oNode);
}

function ctlDlgResize(){
    var oNodeAds = jQuery(".ctl-arcade-lite-ads-dlg-wrapper");
    var oNodeShare = jQuery(".ctl-arcade-lite-share-dlg-wrapper");

    if( jQuery(".ctl-arcade-lite-game-iframe").height() <= 310 ){

        if(oNodeAds){
            __ctlDlgResizeAttachToBody(oNodeAds);
        }
        if(oNodeShare){
            __ctlDlgResizeAttachToBody(oNodeShare);
        }

    }else{

        if(oNodeAds){
            __ctlDlgResizeAttachToGameIframe(oNodeAds);
        }
        if(oNodeShare){
            __ctlDlgResizeAttachToGameIframe(oNodeShare);
        }

    }
}


function ctlArcadeLiteMakeCode() {
    var code = "";
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 32; i++ )
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    return code;
}

function ctlArcadeLiteGetUrlVar( sParam ){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
    return null;
}

function ctlArcadeLiteGetUrlVars( urlVars ) {
    urlVars = urlVars.trim();
    var oFinalData = new Array();
    var hashes = urlVars.split('&');
    for (var i = 0; i < hashes.length; i++) {
        var hash = hashes[i].split('=');
        oFinalData[hash[0]] = hash[1];
    }
    return oFinalData;
}

function ctlArcadeLiteNumberFormat(number, decimals, dec_point, thousands_sep) {

    number = (number + '')
        .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}

function ctlArcadeLiteCloseDlg( idDlg ){
    jQuery('#'+idDlg).remove();

}


function ctlArcadeLiteLoadIframe(){
    jQuery(".ctl-arcade-lite-game-iframe").attr("src",
        jQuery(".ctl-arcade-lite-game-iframe").attr("data-src") );

}

function ctlArcadeLiteShowDialog( szTitle, szMsg, aBtn, bFixed){
    var szHtml = "";
    var id = ctlArcadeLiteMakeCode();

    szHtml += "<div id='"+id+"' class='ctl-arcade-lite-dlg-wrapper " + ( bFixed == true ? "ctl-fixed" : "") + "'>";
        szHtml += "<div class='ctl-arcade-lite-dlg-block'></div>";
        szHtml += "<div class='ctl-arcade-lite-dlg-content'>";
            szHtml += "<h2>"+szTitle+"</h2>";
            szHtml += "<p>"+szMsg+"</p>";
            szHtml += "<div class='ctl-arcade-lite-dlg-close ctl-arcade-lite-icon-cancel'></div>";
            szHtml += "<div class='ctl-arcade-lite-dlg-footer'>";
            if( aBtn && aBtn.length > 0 ){
                for( var i=0; i < aBtn.length; i++){
                    szHtml += "<div onclick='" + aBtn[i].cb +
                              "(\""+id+"\");' class='ctl-arcade-lite-btn ctl-arcade-lite-btn-mini ctl-arcade-lite-btn-"+ g_szCtlArcadeColor +"'>"+
                              aBtn[i].txt+"</div>";
                }
            }
            szHtml += "</div>";
        szHtml += "</div>";
    szHtml += "</div>";


    if( bFixed == true ){
        jQuery("body").append(szHtml);
    }else{
        jQuery(".ctl-arcade-lite-game-iframe-wrapper").append(szHtml);
    }

    ctlDlgResize();

    return id;
}

function ctlArcadeLiteShowLoading(szMsg){
    var szHtml = "";
    var id = ctlArcadeLiteMakeCode();
    szHtml += "<div id='"+id+"' class='ctl-arcade-lite-loading-dlg-wrapper'>";
        szHtml += "<div class='ctl-arcade-lite-dlg-block'></div>";
        szHtml += "<div class='ctl-arcade-lite-dlg-content'>";
             szHtml += "<p>"+szMsg+"</p>";
             szHtml += "<i class='animate-spin ctl-arcade-lite-icon-arrows-cw'></i>";
        szHtml += "</div>";
    szHtml += "</div>";

    jQuery(".ctl-arcade-lite-game-iframe-wrapper").append(szHtml);

    return id;
}

jQuery(window).ready(function(){    
    
    jQuery(document).on("click", ".ctl-arcade-lite-dlg-wrapper .ctl-arcade-lite-dlg-block", function(){
        jQuery(this).closest(".ctl-arcade-lite-dlg-wrapper").remove();
    });
    jQuery(document).on("click", ".ctl-arcade-lite-dlg-wrapper .ctl-arcade-lite-dlg-close", function(){
        jQuery(this).closest(".ctl-arcade-lite-dlg-wrapper").remove();
    });


    jQuery(document).on("click", ".ctl-arcade-lite-share-dlg-wrapper .ctl-arcade-lite-dlg-block", function(){
        jQuery(this).closest(".ctl-arcade-lite-share-dlg-wrapper").remove();
    });
    jQuery(document).on("click", ".ctl-arcade-lite-share-dlg-wrapper .ctl-arcade-lite-dlg-close", function(){
        jQuery(this).closest(".ctl-arcade-lite-share-dlg-wrapper").remove();
    });
    jQuery(document).on("click", ".ctl-arcade-lite-ads-dlg-wrapper .ctl-arcade-lite-dlg-close", function(){
        jQuery(this).closest(".ctl-arcade-lite-ads-dlg-wrapper").remove();
    });
});

function _ctlArcadeLiteGoToByScroll(id){

    var iOffsetTop =  $(id).offset().top;
    iOffsetTop -= $(".navbar-fixed-top").height()+ 20;

    $('html, body').animate({ scrollTop: iOffsetTop  }, 300, function(){});
}
