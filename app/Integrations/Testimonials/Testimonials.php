<?php

namespace SimpleLocator\Integrations\Testimonials;

use SimpleLocator\Repositories\SettingsRepository;

class Testimonials
{
    public function __construct()
    {

    }

    /**
     * Find the location to return from the current post
     * @param int $post_id
     * @return array
     */
    public function gettTestimonialFromID($post_id)
    {

    }

    /**
     * Find all testimonials for location
     * @param int $location_id_id
     * @return array of WP_POST objects
     */
    public function getTestimonialsForLocation($location_id)
    {
        $args = array(
            'meta_query' => array(
                array(
                    'key' => 'location',
                    'value' => $location_id,
                    'compare' => '=',
                )
            ),
            'post_type' => 'tmls',
        );
        $query = new \WP_Query($args);

        return $query->get_posts();
    }



}


