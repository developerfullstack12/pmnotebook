jQuery(document).ready(function() {

    jQuery("#msp-btn").click(function() {
        jQuery(".mycred_ref option").each(function() {
            jQuery(this).prop('selected', true);
        });
    });
});