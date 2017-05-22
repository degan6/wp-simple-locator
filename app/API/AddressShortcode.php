<?php

namespace SimpleLocator\API;

use SimpleLocator\Repositories\PostRepository;
use SimpleLocator\Repositories\SettingsRepository;

/**
 * Shortcode for displaying a single location map
 */
class AddressShortcode
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
        add_shortcode('wp_simple_locator_address', array($this, 'renderView'));
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

        $rv = $this->location_data['address'] . '<br>';

        if(!empty($this->location_data['address_2']))
        {
            $rv .= $this->location_data['address_2'] . '<br>';
        }
        $rv .= $this->location_data['city'] . ' ' . $this->location_data['state'] . ', ' . $this->location_data['zip'];

        return $rv;
    }

}