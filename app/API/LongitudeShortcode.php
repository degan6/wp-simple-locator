<?php

namespace SimpleLocator\API;

use SimpleLocator\Repositories\PostRepository;
use SimpleLocator\Repositories\SettingsRepository;

/**
 * Shortcode for displaying a single location map
 */
class LongitudeShortcode
{

    /**
     * Shortcode Options
     * @var array
     */
    public $options;

    /**
     * Location Data
     * @var array
     */
    private $location_data;

    /**
     * Post Repository
     */
    private $post_repo;

    /**
     * Settings Repository
     */
    private $settings_repo;


    public function __construct()
    {
        $this->post_repo = new PostRepository;
        $this->settings_repo = new SettingsRepository;
        add_shortcode('wp_simple_longitude', array($this, 'renderView'));
        add_filter('widget_text', [$this, 'renderView']);
    }

    /**
     * Shortcode Options
     */
    private function setOptions($options)
    {
        $this->options = shortcode_atts([
            'location' => 0,
        ], $options);
    }

    /**
     * Set the location data for use in map
     */
    private function setLocationData()
    {
        $this->location_data = $this->post_repo->getLocationData($this->options);
    }

    /**
     * The View
     */
    public function renderView($options)
    {
        $this->setOptions($options);
        $this->setLocationData();

        return $this->location_data['longitude'];
    }

}