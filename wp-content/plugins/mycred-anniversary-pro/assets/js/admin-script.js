jQuery(document).ready(function () {
    jQuery(document).on( 'click', '.mycred-add-anniversary-pro-hook', function(event) {

        var hook = jQuery(this).closest('.repeater-hook-instance').clone();
        hook.find('input.mycred-anniversary-pro-creds').val(10);
        hook.find('input.mycred-anniversary-pro-log');
        hook.find('input.mycred-anniversary-pro-anniversary').val('');
        jQuery(this).closest('.repeater-hook-instance').after( hook );

        repeater_fields_btn();
    }); 

    jQuery(document).on( 'click', '.widget.open .mycred-remove-anniversary-pro-hook', function() {
        var container = jQuery(this).closest('.repeater-hook-instance');

       if ( jQuery('.widget.open .repeater-hook-instance').length > 1 ) {
            var dialog = confirm("Are you sure you want to remove this hook?");
            if (dialog == true) {
                jQuery(this).closest('.repeater-hook-instance').remove();
            }
        }
        
        repeater_fields_btn();
    });

});

function repeater_fields_btn() {

    if( jQuery('.widget.open .repeater-hook-instance').length > 1 ) {
            jQuery('.widget.open .mycred-remove-anniversary-pro-hook').show();
    } else {
        jQuery('.widget.open .mycred-remove-anniversary-pro-hook').hide();
    }
}