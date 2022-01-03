<?php
if( !function_exists( 'mycred_dlr_get_setting' ) ):
function mycred_dlr_get_setting( $post_id, $key = '' )
{
    $settings = get_post_meta( $post_id, 'mycred_dlr_settings', true );

    if( empty( $key ) )
        return $settings;

    if( !empty( $settings ) && array_key_exists( $key, $settings ) )
    {
        if( $settings[$key] == 'on' )
            return true;
        else
            return $settings[$key];
    }
    else
        return false;
}
endif;

if( !function_exists( 'mycred_dlr_get_calendars' ) ):
    function mycred_dlr_get_calendars()
    {
        $args = array(
            'numberposts'   =>  -1,
            'post_type'     => 'mycred-login-reward',
            'order'         =>  'ASC'
        );

        $posts = get_posts( $args );
        
        if( empty( $posts ) )
            return false;

        return $posts;
    }
endif;

if( !function_exists( 'mycred_dlr_get_days_by_calendar' ) ):
function mycred_dlr_get_days_by_calendar( $post_id )
{
    $args = array(
        'numberposts'   =>  -1,
        'post_type'     =>  'mycred-dlr-reward',
        'post_parent'   =>  $post_id,
        'orderby'       =>  'menu_order',
        'order'         =>  'ASC',
    );

    $posts = get_posts( $args );

    if( !empty( $posts ) )
        return $posts;

    return false;
}
endif;

if( !function_exists( 'mycred_dlr_get_rank_pt' ) ):
function mycred_dlr_get_rank_pt( $rank_id )
{
    $pt = get_post_meta( $rank_id, 'ctype', true );

    if( $pt )
        return $pt;
    else
        return false;
}
endif;

if( !function_exists( 'mycred_dlr_get_day_thumbnail' ) ):
function mycred_dlr_get_day_thumbnail( $post_id )
{
    $reward = mycred_get_post_meta( $post_id, 'mycred_dlr_day' )[0];

    if( $reward )
        return wp_get_attachment_url( $reward->thumbnail );

    return false;
}
endif;

if( !function_exists( 'mycred_dlr_get_day_setting' ) ):
function mycred_dlr_get_day_setting( $post_id, $key )
{
    $reward = mycred_get_post_meta( $post_id, 'mycred_dlr_day' )[0];

    if( $reward )
        return $reward->$key;

    return false;
}
endif;

if( !function_exists( 'mycred_dlr_get_user_earned_days' ) ):
function mycred_dlr_get_user_earned_days( $user_id, $calender_id )
{
    $earned_days = mycred_get_user_meta( $user_id, "mycred_dlr_calender_{$calender_id}", '', true );

    if( $earned_days )
        return $earned_days;

    return false;
}
endif;

if( !function_exists( 'mycred_dlr_set_transient' ) ):
function mycred_dlr_set_transient( $user_id, $calender_id, $calender_day, $expiry = 0 )
{
    $transient = get_transient( "mycred_dlr_{$user_id}" );

    if( $transient )
    {
        $transient[$calender_id] = $calender_day;
    }
    else
    {
        $transient = array();

        $transient = array( 
            $calender_id    =>  $calender_day
        );
    }

    set_transient( "mycred_dlr_{$user_id}", $transient, $expiry );
}
endif;