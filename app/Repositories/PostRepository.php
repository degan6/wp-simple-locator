<?php 

namespace SimpleLocator\Repositories;

use SimpleLocator\Repositories\SettingsRepository;

class PostRepository
{

    /**
     * Settings Repo
     */
    private $settings_repo;

    public function __construct()
    {
        $this->settings_repo = new SettingsRepository;
    }

    /**
     * Get the Location Data for a Post
     * @since 1.1.0
     * @param int $post_id
     * @return array
     */
    public function getLocationData($options)
    {

        $post_id = $this->getLocationIDFromPost($options);

        $location_data['id'] = $post_id;
        $location_data['title'] = $this->getTitleRecursive($post_id);
        $location_data['latitude'] = $this->getMetaRecursive($post_id, get_option('wpsl_lat_field'));
        $location_data['longitude'] = $this->getMetaRecursive($post_id, get_option('wpsl_lng_field'));
        $location_data['address'] = $this->getMetaRecursive($post_id, 'wpsl_address');
        $location_data['address_two'] = $this->getMetaRecursive($post_id, 'wpsl_address_two');
        $location_data['city'] = $this->getMetaRecursive($post_id, 'wpsl_city');
        $location_data['state'] = $this->getMetaRecursive($post_id, 'wpsl_state');
        $location_data['zip'] = $this->getMetaRecursive($post_id, 'wpsl_zip');
        $location_data['phone'] = $this->getMetaRecursive($post_id, 'wpsl_phone');
        $location_data['website'] = $this->getMetaRecursive($post_id, 'wpsl_website');
        $location_data['same_as'] = $this->getMetaRecursive($post_id, 'wpsl_same_as');
        $location_data['price_range'] = $this->getMetaRecursive($post_id, 'wpsl_price_range');
        $location_data['payment_accepted'] = $this->getMetaRecursive($post_id, 'wpsl_payment_accepted');
        $location_data['logo'] = $this->getMetaRecursive($post_id, 'wpsl_logo');
        $location_data['areas_severed'] = $this->getMetaRecursive($post_id, 'wpsl_areas_severed');
        $location_data['email'] = $this->getMetaRecursive($post_id, 'wpsl_email');
        $location_data['phone_number'] = $this->getMetaRecursive($post_id, 'wpsl_phone_number');
        $location_data['hours_mf_open'] = $this->getMetaRecursive($post_id, 'wpsl_hours_mf_open');
        $location_data['hours_mf_close'] = $this->getMetaRecursive($post_id, 'wpsl_hours_mf_close');
        $location_data['hours_sat_open'] = $this->getMetaRecursive($post_id, 'wpsl_hours_sat_open');
        $location_data['hours_sat_close'] = $this->getMetaRecursive($post_id, 'wpsl_hours_sat_close');
        $location_data['hours_sun_open'] = $this->getMetaRecursive($post_id, 'wpsl_hours_sun_open');
        $location_data['hours_sun_close'] = $this->getMetaRecursive($post_id, 'wpsl_hours_sun_close');
        $location_data['additionalinfo'] = $this->getMetaRecursive($post_id, 'wpsl_additionalinfo');
        $location_data['hours_mf_is_closed'] = $this->getMetaRecursive($post_id, 'wpsl_hours_mf_is_closed');
        $location_data['hours_sat_is_closed'] = $this->getMetaRecursive($post_id, 'wpsl_hours_sat_is_closed');
        $location_data['hours_sun_is_closed'] = $this->getMetaRecursive($post_id, 'wpsl_hours_sun_is_closed');


        return $location_data;
    }

    /**
     * Get all locations
     * @since 1.1.0
     * @param int limit
     * @return array of object
     */
    public function allLocations($limit = '-1')
    {
        $args = array(
            'post_type' => $this->settings_repo->getLocationPostType(),
            'posts_per_page' => $limit
        );
        /**
         * @filter simple_locator_all_locations
         */
        $location_query = new \WP_Query(apply_filters('simple_locator_all_locations', $args));
        if ($location_query->have_posts()) : $c = 0;
            while ($location_query->have_posts()) : $location_query->the_post();
                $locations[$c] = new \stdClass();
                $locations[$c]->id = get_the_id();
                $locations[$c]->title = get_the_title();
                $locations[$c]->permalink = get_the_permalink();
                $locations[$c]->latitude = get_post_meta(get_the_id(), $this->settings_repo->getGeoField('lat'), true);
                $locations[$c]->longitude = get_post_meta(get_the_id(), $this->settings_repo->getGeoField('lng'), true);
                $c++;
            endwhile;
        else : return false;
        endif;
        wp_reset_postdata();
        return $locations;
    }

    /**
     * Check if a post exists
     * @param string $post_title
     * @since 1.5.3
     * @return boolean
     */
    public function postExists($post_title)
    {
        if (!$post_title) return false;
        $post_type = $this->settings_repo->getLocationPostType();
        $post = get_page_by_title($post_title, OBJECT, $post_type);
        if (!$post) return false;
        return true;
    }

    /**
     * Find the location to return from the current post
     * @param array $options From Shortcode, looks for locations
     * @since 1.5.3
     * @return int
     */
    private function getLocationIDFromPost($options)
    {
        if (!$options['location'] == 0) {
            return $options['location'];
        }

        //if current post has location, return it
        $currentPost = get_queried_object();
        $currentPostLocation = $this->getPostLocation($currentPost->ID);
        if ($currentPostLocation) {
            return $currentPostLocation;
        } else {
            //get the top parretn post in the chain and get it location data
            $topParentPost = $this->getTopParentPost($currentPost->ID);
            $topParentPostLocation = $this->getPostLocation($topParentPost->ID);
            if ($topParentPostLocation) {
                return $topParentPostLocation;
            } else {
                return get_option('wpsl_root_location');
            }
        }
    }

    /**
     * Gets the top parent of a post
     * @param post ID $post
     * @since 1.5.3
     * @return WP_POST
     */
    private function getTopParentPost($postID)
    {
        //have to work with ID because wordpress has no functions for objects to get parents
        $parentPost = wp_get_post_parent_id($postID);
        if ($parentPost == 0) {
            return get_post($postID);
        }

        return $this->getTopParentPost($parentPost);

    }

    private function getPostLocation($postID)
    {
        $postLocation = get_post_meta($postID, 'wpsl_location', true);
        if (($postLocation == 0) || $postLocation == false) {
            return false;
        }
        return $postLocation;
    }

    /**
     * Gets the meta for current post, or if blank gets info from root
     * @param $metaName
     * @return string
     */
    private function getMetaRecursive($post_id, $meta_name)
    {
        $this_post_meta = get_post_meta($post_id, $meta_name, true);
        if($this_post_meta == '') {
            return  get_post_meta(get_option('wpsl_root_location'), $meta_name, true);
        }

        return $this_post_meta;
    }

    private function getTitleRecursive($post_id)
    {
        $this_post_title = get_the_title($post_id);
        if($this_post_title == ''){
           return get_the_title(get_option('wpsl_root_location'));
        }

        return $this_post_title;
    }
}