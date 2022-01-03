<?php

Class mycred_fortunewheel_MyCred_Settings {

    function __construct() {
        add_filter('fortunewheel_wheel_segments',array($this,'mycred_fortunewheel_wheel_segments'),99,3);
        add_action('wp_footer',array($this,'mycred_fortunewheel_custom_event'));
    }
    
    /**
     * After Spin
     */
    function mycred_fortunewheel_custom_event() {
        ?>
        <script>
            jQuery(document).ready(function() {
                jQuery(window).on('fortunewheel_wheel_result', function (result) {

                    if( result.win ) {

                        console.log( result );
                        // When use MyCred Points
                        var ajaxurl = fortunewheel_wheel_spin.ajax_url;
                        var data = {
                            'action': 'fortunewheel_coupon_request',
                            'request_to': 'mycred_points',
                            'mycred_log_template': result.mycred_log_template,
                            'mycred_points': result.mycred_loss_points,
                            'mycred_point_type': result.point_type,
                            'win': 'true',
                            'token': result.token,
                            'wheel_id': result.current_wheel_id,
                        };

                        jQuery.post(ajaxurl, data, function (response) {
                            if( response != '' ) {
                                jQuery('.fortunewheel-error').hide();
                                jQuery('.lds-css.ng-scope').hide();
                                jQuery('.fortunewheel-from').css('opacity','1');
                                jQuery('.fortunewheel-right').html(response);
                                jQuery('.fortunewheel-intro').hide();
                            }
                        });
                        
                    } else {
                        
                        var ajaxurl = fortunewheel_wheel_spin.ajax_url;
                        var data = {
                            'action': 'fortunewheel_coupon_request',
                            'request_to': 'mycred_points',
                            'mycred_points': result.mycred_loss_points,
                            'mycred_log_template': result.mycred_log_template,
                            'mycred_point_type': result.point_type,
                            'win': 'false',
                            'token': result.token,
                            'wheel_id': result.current_wheel_id,
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                            if( response != '' ) {
                                jQuery('.fortunewheel-error').hide();
                                jQuery('.lds-css.ng-scope').hide();
                                jQuery('.fortunewheel-from').css('opacity','1');
                                jQuery('.fortunewheel-right').html(response);
                                jQuery('.fortunewheel-intro').hide();
                            }
                        });
                        
                    }
                });
            });
        </script>
        <?php
    }

    function mycred_fortunewheel_wheel_segments( $segments_each, $sections, $section ) {

        $mycred_points = $section['fortunewheel_mycred_points'];
        $mycred_log_template = $section['fortunewheel_mycred_log_template'];
        $mycred_point_types = $section['fortunewheel_mycred_points'];

        $segments_mycred = array();
        $segments_mycred['mycred_loss_points'] = $mycred_points;
        $segments_mycred['mycred_loss_point_types'] = $mycred_point_types;
        $segments_mycred['mycred_log_template'] = $mycred_log_template;

        $segments_each = array_merge($segments_each,$segments_mycred);

        return $segments_each;

        $segments_each = array_merge($segments_each,$segments_mycred);

        return $segments_each;

    }

    // Check mycred Enabled or not
    function mycred_fortunewheel_is_mycred_emabled() {

        if( class_exists ( 'myCRED_Core' ) ) {
            return true;
        }

        return false;
    }
}