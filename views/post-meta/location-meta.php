<?php wp_nonce_field( 'my_wpsl_meta_box_nonce', 'wpsl_meta_box_nonce' ); ?>
<div class="wpsl-meta">
	<p class="full wpsl-address-field">
		<label for="wpsl_address"><?php _e('Street Address', 'wpsimplelocator'); ?></label>
		<input type="text" name="wpsl_address" id="wpsl_address" value="<?php echo $this->meta['address']; ?>" />
	</p>
	<p class="full wpsl-address-two-field">
		<label for="wpsl_address_two"><?php _e('Street Address Line 2', 'wpsimplelocator'); ?></label>
		<input type="text" name="wpsl_address_two" id="wpsl_address_two" value="<?php echo $this->meta['address_two']; ?>" />
	</p>
	<p class="city wpsl-city-field">
		<label for="wpsl_city"><?php _e('City', 'wpsimplelocator'); ?></label>
		<input type="text" name="wpsl_city" id="wpsl_city" value="<?php echo $this->meta['city']; ?>" />
	</p>
	<p class="state wpsl-state-field">
		<label for="wpsl_state"><?php _e('State', 'wpsimplelocator'); ?></label>
		<input type="text" name="wpsl_state" id="wpsl_state" value="<?php echo $this->meta['state']; ?>" />
	</p>
	<p class="zip wpsl-zip-field">
		<label for="wpsl_zip"><?php _e('Zip/Postal Code', 'wpsimplelocator'); ?></label>
		<input type="text" name="wpsl_zip" id="wpsl_zip" value="<?php echo $this->meta['zip']; ?>" />
	</p>
	<p class="full wpsl-country-field">
		<label for="wpsl_country"><?php _e('Country', 'wpsimplelocator'); ?></label>
		<input type="text" name="wpsl_country" id="wpsl_country" value="<?php echo $this->meta['country']; ?>" />
	</p>
	<div id="wpslmap"></div>
	<hr />
	<div class="latlng">
		<span><?php _e('Geocode values will update on save. Fields are for display purpose only.', 'wpsimplelocator'); ?></span>
		<p class="wpsl-latitude-field">
			<label for="wpsl_latitude"><?php _e('Latitude', 'wpsimplelocator'); ?></label>
			<input type="text" name="wpsl_latitude" id="wpsl_latitude" value="<?php echo $this->meta['latitude']; ?>" readonly />
		</p>
		<p class="lat wpsl-longitude-field">
			<label for="wpsl_longitude"><?php _e('Longitude', 'wpsimplelocator'); ?></label>
			<input type="text" name="wpsl_longitude" id="wpsl_longitude" value="<?php echo $this->meta['longitude']; ?>" readonly />
		</p>
	</div>
	<div class="wpsl-extra-meta-fields">
		<hr />
		<p class="half wpsl-phone-field">
			<label for="wpsl_phone"><?php _e('Phone Number', 'wpsimplelocator'); ?></label>
			<input type="text" name="wpsl_phone" id="wpsl_phone" value="<?php echo $this->meta['phone']; ?>" />
		</p>
		<p class="half right wpsl-website-field">
			<label for="wpsl_website"><?php _e('Website', 'wpsimplelocator'); ?></label>
			<input type="text" name="wpsl_website" id="wpsl_website" value="<?php echo $this->meta['website']; ?>" />
		</p>


        <p class="half left wpsl-email-field">
            <label for="wpsl_email"><?php _e('Email', 'wpsimplelocator'); ?></label>
            <input type="email" name="wpsl_email" id="wpsl_email" value="<?php echo $this->meta['email']; ?>" />
        </p>
        <p class="half right wpsl-same-as-field">
            <label for="wpsl_same_as"><?php _e('Same As', 'wpsimplelocator'); ?></label>
            <input type="url" name="wpsl_same_as" id="wpsl_same_as" value="<?php echo $this->meta['same_as']; ?>" />
        </p>
        <p class="half left wpsl-price-range-field">
            <label for="wpsl_price_range"><?php _e('Price Range', 'wpsimplelocator'); ?></label>
            <input type="text" name="wpsl_price_range" id="wpsl_price_range" value="<?php echo $this->meta['price_range']; ?>" />
        </p>
        <p class="half right wpsl-payment-accepted-field">
            <label for="wpsl_payment_accepted"><?php _e('Payment Accepted', 'wpsimplelocator'); ?></label>
            <input type="text" name="wpsl_payment_accepted" id="wpsl_payment_accepted" value="<?php echo $this->meta['payment_accepted']; ?>" />
        </p>
        <p class="half left wpsl-payment-accepted-field">
            <label for="wpsl_logo"><?php _e('Logo', 'wpsimplelocator'); ?></label>
            <input type="text" name="wpsl_logo" id="wpsl_logo" value="<?php echo $this->meta['logo']; ?>" />
        </p>
        <p class="half right wpsl-areas-severed-field">
            <label for="wpsl_areas_severed"><?php _e('Areas Severed', 'wpsimplelocator'); ?></label>
            <input type="text" name="wpsl_areas_severed" id="wpsl_areas_severed" value="<?php echo $this->meta['areas_severed']; ?>" />
        </p>
        <div class="latlng">
            <p style="width: 33%;">
                <span>Mon - Fri</span>
                <label for="wpsl_hours_mf_open"><?php _e('Open', 'wpsimplelocator'); ?></label>
                <input type="time" name="wpsl_hours_mf_open" value="<?php echo $this->meta['hours_mf_open']; ?>">

                <label for="wpsl_hours_mf_close"><?php _e('Close', 'wpsimplelocator'); ?></label>
                <input type="time" name="wpsl_hours_mf_close" value="<?php echo $this->meta['hours_mf_close']; ?>">
            </p>
            <p style="width: 33%">
                <span>Saturday</span>
                <label for="wpsl_hours_mf_open"><?php _e('Open', 'wpsimplelocator'); ?></label>
                <input type="time" name="wpsl_hours_sat_open" value="<?php echo $this->meta['hours_sat_open']; ?>">

                <label for="wpsl_hours_mf_close"><?php _e('Close', 'wpsimplelocator'); ?></label>
                <input type="time" name="wpsl_hours_sat_close" value="<?php echo $this->meta['hours_sat_close']; ?>">
            </p>
            <p style="width: 33%">
                <span>Sunday</span>
                <label for="wpsl_hours_mf_open"><?php _e('Open', 'wpsimplelocator'); ?></label>
                <input type="time" name="wpsl_hours_sun_open" value="<?php echo $this->meta['hours_sun_open']; ?>">

                <label for="wpsl_hours_mf_close"><?php _e('Close', 'wpsimplelocator'); ?></label>
                <input type="time" name="wpsl_hours_sun_close" value="<?php echo $this->meta['hours_sun_close']; ?>">
            </p>
        </div>
		<hr />
		<p class="full wpsl-additional-field">
			<label for="wpsl_additionalinfo"><?php _e('Additional Info', 'wpsimplelocator'); ?></label>
			<textarea name="wpsl_additionalinfo" id="wpsl_additionalinfo"><?php echo $this->meta['additionalinfo']; ?></textarea>
		</p>
	</div>
	<input type="hidden" name="wpsl_custom_geo" id="wpsl_custom_geo" value="<?php echo $this->meta['mappinrelocated']; ?>">
</div>
<?php include('error-modal.php');?>