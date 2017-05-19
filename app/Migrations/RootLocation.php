<?php

namespace SimpleLocator\Migrations;

/**
 * Create Root Location
 */
class RootLocation
{
    /**
     * Create Root Location
     */
    public static function create()
    {
        return \wp_insert_post([
            'post_author' => wp_get_current_user()->id,
            'post_title' => __('Root Post', 'wpsimplelocator'),
            'post_status' => 'publish',
            'post_type' => get_option('wpsl_post_type'),
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => __('Root Post', 'wpsimplelocator'),
        ]);
    }
}