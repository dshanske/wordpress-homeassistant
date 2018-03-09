<fieldset id="homeassistant">
	<label for="homeassistant_url">
		<input type="url" name="homeassistant_url" id="homeassistant_url" class="widefat" value="<?php echo get_option( 'homeassistant_url' ); ?>" />
		<?php _e( 'Home Assistant Base URL', 'homeassistant' ); ?>
	</label>
	<br />
	<label for="homeassistant_password">
		<input type="password" name="homeassistant_password" id="homeassistant_password" class="widefat" value="<?php echo get_option( 'homeassistant_password' ); ?>" />
		<?php _e( 'Home Assistant Password', 'homeassistant' ); ?>
	</label>
	<br />
</fieldset>
