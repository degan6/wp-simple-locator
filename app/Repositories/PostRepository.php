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
	//if current page has no location meta set
        //lookup its parrent page
        //do recursivly
        //return first location id you find in the chain
    //if location found doesn't have feild set
        //return root location information


	public function getLocationData($options)
	{

        $post_id = $this->getLocationIDFromPost($options);

	    $location_data['title'] = get_the_title($post_id);
		$location_data['latitude'] = get_post_meta( $post_id, get_option('wpsl_lat_field'), true );
		$location_data['longitude'] = get_post_meta( $post_id, get_option('wpsl_lng_field'), true );
		$location_data['address'] = get_post_meta( $post_id, 'wpsl_address', true);
		$location_data['city'] = get_post_meta( $post_id, 'wpsl_city', true);
		$location_data['state'] = get_post_meta( $post_id, 'wpsl_state', true);
		$location_data['zip'] = get_post_meta( $post_id, 'wpsl_zip', true);
		$location_data['phone'] = get_post_meta( $post_id, 'wpsl_phone', true);
		$location_data['website'] = get_post_meta( $post_id, 'wpsl_website', true);
		$location_data['additionalinfo'] = get_post_meta( $post_id, 'wpsl_additionalinfo', true);
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
			'post_type'=> $this->settings_repo->getLocationPostType(),
			'posts_per_page' => $limit
		);
		/**
		* @filter simple_locator_all_locations
		*/
		$location_query = new \WP_Query(apply_filters('simple_locator_all_locations', $args));
		if ( $location_query->have_posts() ) : $c = 0;
			while ( $location_query->have_posts() ) : $location_query->the_post();
				$locations[$c] = new \stdClass();
				$locations[$c]->id = get_the_id();
				$locations[$c]->title = get_the_title();
				$locations[$c]->permalink = get_the_permalink();
				$locations[$c]->latitude = get_post_meta(get_the_id(), $this->settings_repo->getGeoField('lat'), true);
				$locations[$c]->longitude = get_post_meta(get_the_id(), $this->settings_repo->getGeoField('lng'), true);
			$c++;
			endwhile; 
		else : return false;
		endif; wp_reset_postdata();
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
		if ( !$post_title ) return false;
		$post_type = $this->settings_repo->getLocationPostType();
		$post = get_page_by_title($post_title, OBJECT, $post_type);
		if ( !$post ) return false;
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
        if(!$options['location'] == 0)
        {
            return $options['location'];
        }

        //if current post has location, return it
        $currentPost = get_queried_object();
        $currentPostLocation = $this->getPostLocation($currentPost->ID);
        if($currentPostLocation)
        {
            return $currentPostLocation;
        } else {
            //get the top parretn post in the chain and get it location data
            $topParentPost = $this->getTopParentPost($currentPost->ID);
            $topParentPostLocation = $this->getPostLocation($topParentPost->ID);
            if($topParentPostLocation)
            {
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
        
        if($parentPost == 0)
        {
            return get_post($postID);
        }

        return $this->getTopParentPost($parentPost);

    }

    private function getPostLocation($postID)
    {
        $postLocation = get_post_meta($postID, 'wpsl_location', true);
        if(($postLocation == 0) || $postLocation == false)
        {
            return false;
        }
        return $postLocation;
    }
}