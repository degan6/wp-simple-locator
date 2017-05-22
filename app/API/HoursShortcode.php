<?php

namespace SimpleLocator\API;

use SimpleLocator\Repositories\PostRepository;
use SimpleLocator\Repositories\SettingsRepository;

/**
 * Shortcode for displaying a single location map
 */
class HoursShortcode
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
        add_shortcode('wp_simple_locator_hours', array($this, 'renderView'));
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

        $rv =  '<p>' . $this->location_data['title'] . '</p>';
        $rv .= '<ul style="list-style-type: none;">';

        if (!$this->location_data['hours_mf_is_closed'])
        {
            $rv .= '<li class="no-margin" >M-F ' . date("g:i a", strtotime($this->location_data['hours_mf_open'])) . ' - ' .
                date("g:i a", strtotime($this->location_data['hours_mf_close'])) . '</li>';
        } else {
            $rv .= '<li class="no-margin" >M-F Closed';
        }

        if (!$this->location_data['hours_sat_is_closed'])
        {
            $rv .= '<li class="no-margin"> Sat ' . date("g:i a", strtotime($this->location_data['hours_sat_open'])) . ' - ' .
                date("g:i a", strtotime($this->location_data['hours_sat_close'])) . '</li>';
        } else {
            $rv .= '<li class="no-margin"> Sat Closed';
        }


        if (!$this->location_data['hours_sun_is_closed'])
        {
            $rv .= '<li class="no-margin"> Sun ' . date("g:i a", strtotime($this->location_data['hours_sun_open'])) . ' - ' .
                date("g:i a", strtotime($this->location_data['hours_sun_close'])) . '</li>';
        } else {
            $rv .= '<li class="no-margin"> Sun Closed';
        }


        $rv .= '</ul>';


        return $rv;
    }

}