<?php wp_nonce_field( 'my_wpsl_location_picker_nonce', 'wpsl_location_picker_nonce' ); ?>
    <div class="wpsl-meta">
        <p class="full wpsl-location-picker">
            <label for="wpsl-location-picker"><?php _e('Location', 'wpsimplelocator'); ?></label>
            <select name="wpsl_location" id="wpsl_location">

                <?php
                if(($this->meta['location'] == NULL) || ($this->meta['location'] == 0)){
                    echo '<option selected value="0">No Location Selected</option>';
                } else {
                    echo '<option value="0">No Location</option>';
                }

                foreach ($this->post_repo->allLocations() as $location){
                    if($location->id == $this->meta['location']){
                        echo '<option selected value="' . $location->id . '">' . $location->title . '</option>';
                    } else {
                        echo '<option value="' . $location->id . '">' . $location->title . '</option>';
                    }
                }
                ?>
            </select>
        </p>
    </div>