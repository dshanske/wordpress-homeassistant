<fieldset id="homeassistant">
	<label for="homeassistant_url">
		<input type="url" name="homeassistant_url" id="homeassistant_url" class="widefat" value="<?php echo get_option( 'homeassistant_url' ); ?>" />
		<?php _e( 'Home Assistant Base URL', 'homeassistant' ); ?>
	</label>
	<br />
	<label for="homeassistant_token">
		<input type="password" name="homeassistant_token" id="homeassistant_token" class="widefat" value="<?php echo get_option( 'homeassistant_token' ); ?>" />
		<?php _e( 'Home Assistant Token', 'homeassistant' ); ?>
	</label>
	<br />
</fieldset>
