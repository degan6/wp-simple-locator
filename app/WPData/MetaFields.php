<?php

namespace SimpleLocator\WPData;

/**
* Custom Meta Fields for Location Post Type
*/
class MetaFields 
{

	/**
	* Meta Data
	*/
	private $meta;

    /**
     * Testimonials array
     */
    private $testimonials;

	/**
	* Fields
	*/
	public $fields;

	function __construct()
	{
		$this->setFields();
		add_action( 'add_meta_boxes', array( $this, 'metaBox' ));
		add_action( 'save_post', array($this, 'savePost' ));
	}

	/**
	* Set the Fields for use in custom meta
	*/
	private function setFields()
	{
		$this->fields = array(
			'latitude' => 'wpsl_latitude',
			'longitude' => 'wpsl_longitude',
			'address' => 'wpsl_address',
			'address_two' => 'wpsl_address_two',
			'city' => 'wpsl_city',
			'state' => 'wpsl_state',
			'zip' => 'wpsl_zip',
			'country' => 'wpsl_country',
			'phone' => 'wpsl_phone',
			'website' => 'wpsl_website',
			'email' => 'wpsl_email',
			'same_as' => 'wpsl_same_as',
            'payment_accepted' => 'wpsl_payment_accepted',
			'logo' => 'wpsl_logo',
			'price_range' => 'wpsl_price_range',
            'hours_mf_open' => 'wpsl_hours_mf_open',
            'hours_mf_close' => 'wpsl_hours_mf_close',
            'hours_sat_open' => 'wpsl_hours_sat_open',
            'hours_sat_close' => 'wpsl_hours_sat_close',
            'hours_sun_open' => 'wpsl_hours_sun_open',
            'hours_sun_close' => 'wpsl_hours_sun_close',
			'areas_severed' => 'wpsl_areas_severed',
			'additionalinfo' => 'wpsl_additionalinfo',
			'mappinrelocated' => 'wpsl_custom_geo',
            'hours_mf_is_closed' => 'wpsl_hours_mf_is_closed',
            'hours_sat_is_closed' => 'wpsl_hours_sat_is_closed',
            'hours_sun_is_closed' => 'wpsl_hours_sun_is_closed'
		);
	}

	/**
	* Register the Meta Box
	*/
	public function metaBox() 
	{
    	add_meta_box( 
    		'wpsl-meta-box', 
    		__('Location Information', 'wpsimplelocator'), 
    		array($this, 'displayMeta'), 
    		$this->getPostType(), 
    		'normal', 
    		'high' 
    	);
	}

	/**
	* Meta Boxes for Output
	*/
	public function displayMeta($post)
	{
		$this->setData($post);
		include( \SimpleLocator\Helpers::view('post-meta/location-meta') );
	}

	/**
	* Set the Field Data
	*/
	private function setData($post)
	{
		foreach ( $this->fields as $key=>$field )
		{
			$this->meta[$key] = get_post_meta( $post->ID, $field, true );
		}

		$t = new \SimpleLocator\Integrations\Testimonials\Testimonials();
		$this->testimonials = $t->getTestimonialsForLocation($post->ID);

	}

	/**
	* Save the custom post meta
	*/
	public function savePost( $post_id ) 
	{
		if ( get_post_type($post_id) == $this->getPostType() ) :
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
			if( !isset( $_POST['wpsl_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpsl_meta_box_nonce'], 'my_wpsl_meta_box_nonce' ) ) return $post_id;

			// Save Custom Fields
			foreach ( $this->fields as $key => $field )
			{
				if ( isset($_POST[$field]) && $_POST[$field] !== "" ) 
					update_post_meta( $post_id, $field, esc_attr( $_POST[$field] ) );
				if ( isset($_POST[$field]) && $_POST[$field] == "" )
					delete_post_meta( $post_id, $field );
			}
		endif;
	} 

	/**
	* Get the Location Post Type
	*/
	private function getPostType()
	{
		$posttype = get_option('wpsl_post_type');
		$hide_meta = get_option('wpsl_hide_default_fields');
		if ( $hide_meta == 'true' ) return ' ';
		return ( $posttype !== "" ) ? $posttype : 'location';
	}

}