<?php

add_action( 'admin_init', array( 'HA_Config', 'register' ) );
add_action( 'admin_init', array( 'HA_Config', 'admin_init' ) );
add_action( 'admin_menu', array( 'HA_Config', 'admin_menu' ) );
add_action( 'rest_api_init', array( 'HA_Config', 'register_routes' ) );

// The HA_Config class sets up the Settings Page for the plugin
class HA_Config {

	/**
	 * Register the Route.
	 */
	public static function register_routes() {
		register_rest_route(
			'home_assistant/1.0',
			'/state',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( 'HA_Config', 'read' ),
					'args'                => array(
						'name' => array(
							'required'          => true,
							'sanitize_callback' => 'sanitize_text_field',
						),
						'type' => array(
							'required'          => true,
							'sanitize_callback' => 'sanitize_text_field',
						),
					),
					'permission_callback' => function () {
						return current_user_can( 'read' );
					},
				),
			)
		);
	}

	public static function read( $request ) {
		$type = $request->get_param( 'type' );
		$name = $request->get_param( 'name' );
		$HA   = new Home_Assistant_State( $type, $name );
		$HA->get();
		return $HA->get_attribute();
	}

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
			'homeassistant_token', // option name
			array(
				'type'         => 'string',
				'description'  => 'Home Assistant Long Lived Token',
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
		<?php if ( WP_DEBUG ) { ?>
		<div>
		<h2><?php _e( 'Home Assistant Debugger', 'homeassistant' ); ?></h2>
		<form method="get" action="<?php echo esc_url( rest_url( '/home_assistant/1.0/state/' ) ); ?> ">
			<p><label for="type"><?php esc_html_e( 'Type', 'indieweb-post-kinds' ); ?></label><input type="text" class="widefat" name="type" id="type" /></p>
			<p><label for="name"><?php esc_html_e( 'Name', 'indieweb-post-kinds' ); ?></label><input type="text" class="widefat" name="name" id="name" /></p>
			<?php wp_nonce_field( 'wp_rest' ); ?>
			<?php submit_button( __( 'Lookup', 'homeassistant' ) ); ?>
</form>
		</div>
			<?php
		}
	}

	public static function settings_callback() {
		load_template( plugin_dir_path( __DIR__ ) . 'templates/settings.php' );
	}
} // End Class


