jQuery(document).ready(function () {
    if (jQuery("input[name='mycred_pref_core[badges][progress_map_direction]']:checked").val() == 'horizontal') {
        jQuery('.vertical_visible_items_count').show();
        jQuery('.vertical-alignment').hide();

    } else {
        jQuery('.vertical_visible_items_count').hide();
        jQuery('.vertical-alignment').show();

    }

    jQuery("input[name='mycred_pref_core[badges][progress_map_direction]']").on('change', function () {
        if (jQuery("input[name='mycred_pref_core[badges][progress_map_direction]']:checked").val() == 'horizontal') {
            jQuery('.vertical_visible_items_count').show();
            jQuery('.vertical-alignment').hide();
        } else {
            jQuery('.vertical_visible_items_count').hide();
            jQuery('.vertical-alignment').show();
        }

    });
    if (jQuery("input[name='mycred_pref_core[badges][timeline_color]']").length) {
        jQuery("input[name='mycred_pref_core[badges][timeline_color]']").wpColorPicker();
        jQuery("input[name='mycred_pref_core[badges][progress_color]']").wpColorPicker();
        jQuery("input[name='mycred_pref_core[badges][timeline_text_color]']").wpColorPicker();
        jQuery("input[name='mycred_pref_core[badges][progress_text_color]']").wpColorPicker();
    }
});
