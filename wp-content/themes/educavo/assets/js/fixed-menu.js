(function($) {
    $.fn.menumaker = function(options) {
      
      var fixedmenus = $(this), settings = $.extend({
        format: "dropdown",
        sticky: false
      }, options);

        return this.each(function() {
        fixedmenus.find('li ul').parent().addClass('has-sub');
        multiTg = function() {
            fixedmenus.find(".has-sub").prepend('<span class="submenu-button"></span>');
            fixedmenus.find('.submenu-button').on('click', function() {
                $(this).toggleClass('submenu-opened');
                if ($(this).siblings('ul').hasClass('open-sub')) {
                    $(this).siblings('ul').removeClass('open-sub').hide();
                    $(this).siblings('ul').slideToggle().hide();                                     
                }
                else {
                    $(this).siblings('ul').addClass('open-sub').hide();
                    $(this).siblings('ul').slideToggle().show();
                }

            });
        };

        if (settings.format === 'multitoggle') multiTg();
        else fixedmenus.addClass('dropdown');
        if (settings.sticky === true) fixedmenus.css('position', 'fixed');
        resizeFix = function() {
            if ($( window ).width() > 991) {
                fixedmenus.find('ul').show();
                fixedmenus.find('ul.sub-menu').hide();
            }          
        };
        resizeFix();
        return $(window).on('resize', resizeFix);
        });
    };
})(jQuery);

(function($){
$(document).ready(function(){

$("#fixedmenus").menumaker({
   format: "multitoggle"
});

});
})(jQuery);
