
jQuery(window).ready(function(){
    ctlArcadeResize();

    jQuery(".ctl-arcade-lite-stars span").each(function(){

        jQuery(this).on("click", function() {

            var oNodeContainer = jQuery(this).parents(".ctl-arcade-lite-rating-container");
            var iNumStars = parseInt(jQuery(this).attr("data-rate"));
            var szGame = jQuery(this).parents(".ctl-arcade-lite-rating-container").attr("data-game");
            var user_id = jQuery(this).parents(".ctl-arcade-lite-rating-container").attr("data-user-id");

            if( user_id === 0 ){
                ctlArcadeShowDialog("Attention","You can't vote without login first!", [ { "txt" : "continue", "cb" : "ctlArcadeCloseDlg"}], true);
                return;
            }

            jQuery.ajax({
                url: g_szCtlArcadeLiteAjax,
                type: "post",
                data: {
                    "action" : "give-rating",
                    "game_rating" : iNumStars,
                    "game_plugin_dir" : szGame,
                    "user_id" : user_id
                }
            }).done(function (data) {
                data = ctlArcadeGetUrlVars(data);

                if (data.status == "true"){

                    var iNumVotes   = parseInt(oNodeContainer.attr("data-num-votes")) + 1;
                    var iValueVotes = parseInt(oNodeContainer.attr("data-value-votes")) + iNumStars;

                    oNodeContainer.attr("data-num-votes", "" + iNumVotes);
                    oNodeContainer.attr("data-value-votes", "" + iValueVotes);

                    ctlArcadeResetStars(oNodeContainer);
                }else if(data.code == "useralreadyvoted"){
                    ctlArcadeShowDialog("Attention!","You can't vote a game twice!", [ { "txt" : "continue", "cb" : "ctlArcadeCloseDlg"}], true);
                }

            }).fail(function (jqXHR, textStatus) {
                console.log( jqXHR);
            });
        });

        jQuery(this).on("mouseover", function(){
            var iNumStars = parseInt(jQuery(this).attr("data-rate"));

            for( var i = 1; i < (iNumStars+1); i++ ){
                jQuery(".ctl-arcade-lite-stars span:nth-child("+ (i) +") i").attr("class", "ctl-arcade-lite-icon-star");
            }
            for( var i = (iNumStars+1); i < 6; i++ ){
                jQuery(".ctl-arcade-lite-stars span:nth-child("+ (i) +") i").attr("class", "ctl-arcade-lite-icon-star-empty");
            }
        });
    });

    jQuery(".ctl-arcade-lite-rating-container").each(function(){
        ctlArcadeResetStars(jQuery(this));
        jQuery(this).on("mouseleave", function(){
            ctlArcadeResetStars(jQuery(this));
        });
    });
});


jQuery(window).scroll(function () {

});

jQuery(window).resize(function() {
    ctlArcadeResize();
});


function ctlArcadeResize(){
    jQuery(".ctl-arcade-lite-game-iframe").each(function(){

        var aValues = jQuery(this).attr("data-aspect-ratio").split(":");
        var w = aValues[0];
        var h = aValues[1];
        var iNewH = Math.floor(jQuery(this).parents(".ctl-arcade-lite-game-iframe-wrapper").width() * (h/w));
        if( jQuery(this).attr("data-max-height")  ){
            var iMaxHeight = parseInt(jQuery(this).attr("data-max-height"));
            if( iNewH > iMaxHeight ){
                iNewH = iMaxHeight;
            }
        }

        if( iNewH > jQuery(window).height()-30){
            iNewH = jQuery(window).height()-30;
        }

        jQuery(this).css( "height" , iNewH + "px");
    });
}


function ctlArcadeResetStars( oNode ){

    var oNodeVotes = oNode.find(".ctl-arcade-lite-num-votes");

    var iNumVotes      = parseInt( oNode.attr("data-num-votes") );
    var iRatingAverage = parseFloat(
        ctlArcadeNumberFormat(
            parseFloat( oNode.attr("data-value-votes") )/
            parseFloat(iNumVotes),
            1)
    );

    var iStars = Math.floor(iRatingAverage);
    var iHalfStar = (iRatingAverage - iStars > 0 ? 1 : 0);

    for( var i = 1; i < (iStars+1); i++ ){
        oNode.find("span:nth-child("+ (i) +") i").attr("class", "ctl-arcade-lite-icon-star");
    }

    if(iHalfStar == 1){
        oNode.find("span:nth-child("+ (iStars+1) +") i").attr("class", "ctl-arcade-lite-icon-star-half-alt");
        iStars++;
    }

    for( var i = (iStars+1); i < 6; i++ ){
        oNode.find("span:nth-child("+ (i) +") i").attr("class", "ctl-arcade-lite-icon-star-empty");
    }

    if ( iNumVotes == 1 ){
        oNodeVotes.text(iNumVotes + " VOTE");
    }else{
        oNodeVotes.text(iNumVotes + " VOTES");
    }

}
