jQuery(document).ready(function($) {
  get_logs();
});

function popup_alert( title, description, img ) {

    setTimeout(function() {
        jQuery('.mycred-popup-alert').html('<div class="mpa-alert '+mycred_popup.theme+' '+mycred_popup.border_style+'"><div class="mpa-left"><div class="mpa-avatar"><img src="'+img+'" width="50px"/></div></div><div class="mpa-right"><div class="mpa-title">'+title+'</div><div class="mpa-description">'+description+'</div></div></div>');
        jQuery(".mycred-popup-alert").animate({bottom: "5%"},1000);
        jQuery(".mycred-popup-alert").show();

        setTimeout(function() {
            mpa_hide_popup();
        },mycred_popup.on_screen_time);
    },mycred_popup.interval);
}
function mpa_hide_popup() {
    jQuery(".mycred-popup-alert").animate({bottom: "-50%"},1000,function() {
        jQuery(".mycred-popup-alert").hide();
    });
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}