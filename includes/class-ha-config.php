<?php

add_action( 'admin_init', array( 'HA_Config', 'register' ) );
add_action( 'admin_init', array( 'HA_Config', 'admin_init' ) );
add_action( 'admin_menu', array( 'HA_Config', 'admin_menu' ) );

// The HA_Config class sets up the Settings Page for the plugin
class HA_Config {
	public static function register() {
		register_setting(
			'ha', // group
			'homeassistant_url', // option name
			array(
				'type'         => 'string',
				'description'  => 'Home Assistant URL',
				'show_in_rest' => true,
				'default'      => '',
			)
		);
		register_setting(
			'ha', // group
			'homeassistant_password', // option name
			array(
				'type'         => 'string',
				'description'  => 'Home Assistant Password',
				'show_in_rest' => false,
				'default'      => '',
			)
		);
	}

	public static function admin_menu() {
		add_options_page(
			'',
			'Home Assistant',
			'manage_options',
			'homeassistant',
			array( 'HA_Config', 'homeassistant_page' )
		);
	}

	public static function admin_init() {
		add_settings_section(
			'ha-general',
			__( 'Home Assistant Settings', 'homeassistant' ),
			array( 'HA_Config', 'settings_callback' ),
			'homeassistant',
			'default'
		);
	}

	public static function homeassistant_page() {
		?>
		 <div class="wrap">
		<h2><?php _e( 'Home Assistant', 'homeassistant' ); ?></h2>
		<form action="options.php" method="POST">
		<?php settings_fields( 'ha' ); ?>
		<?php do_settings_sections( 'homeassistant' ); ?>
		<?php submit_button(); ?>
			  </form>
		</div>
		<?php
	}

	public static function settings_callback() {
		load_template( plugin_dir_path( __DIR__ ) . 'templates/settings.php' );
	}
} // End Class


