<?php

namespace SimpleLocator\WPData;

use SimpleLocator\Repositories\PostRepository;

/**
 * Custom Meta Fields for Location Post Type
 */
class LocationPicker
{

    /**
     * Meta Data
     */
    private $meta;

    /**
     * Array of locations
     */
    private $post_repo;

    /**
     * Fields
     */
    public $fields;

    function __construct()
    {
        $this->post_repo = new PostRepository;

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
            'location' => 'wpsl_location',
        );
    }

    /**
     * Register the Meta Box
     */
    public function metaBox()
    {
        add_meta_box(
            'wpsl-location-meta-box',
            __('Location', 'wpsimplelocator'),
            array($this, 'displayMeta'),
            'page',
            'normal'
        );
    }

    /**
     * Meta Boxes for Output
     */
    public function displayMeta($post)
    {
        $this->setData($post);
        include( \SimpleLocator\Helpers::view('post-meta/page-meta') );
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
    }

    /**
     * Save the custom post meta
     */
    public function savePost( $post_id )
    {
        if ( get_post_type($post_id) == 'page' ) :
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
            if( !isset( $_POST['wpsl_location_picker_nonce'] ) || !wp_verify_nonce( $_POST['wpsl_location_picker_nonce'], 'my_wpsl_location_picker_nonce' ) ) return $post_id;

            // Save Custom Fields
            foreach ( $this->fields as $key => $field )
            {
                if ( isset($_POST[$field]) && $_POST[$field] !== "" ) update_post_meta( $post_id, $field, esc_attr( $_POST[$field] ) );
            }
        endif;
    }
}