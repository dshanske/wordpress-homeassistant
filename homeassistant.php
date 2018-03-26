<?php
/**
 * Plugin Name: Home Assistant Integration for WordPress
 * Plugin URI: https://github.com/dshanske/wordpress-homeassistant
 * Description: Integrate Home Assistant into your WordPress Installation
 * Version: 0.1.0
 * Author: David Shanske
 * Author URI: https://david.shanske.com
 * Text Domain: homeassistant
 * Domain Path:  /languages
 */
if ( ! defined( 'ISO8601U' ) ) {
		define( 'ISO8601U', 'Y-m-d\TH:i:s.uO' );
}

add_action( 'plugins_loaded', array( 'Home_Assistant_Plugin', 'plugins_loaded' ) );
add_action( 'init', array( 'Home_Assistant_Plugin', 'init' ) );

class Home_Assistant_Plugin {
	public static $version = '0.1.0';
	public static function init() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-ha-config.php';
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-home-assistant.php';
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-home-assistant-state.php';
		if ( WP_DEBUG ) {
			require_once plugin_dir_path( __FILE__ ) . '/includes/class-ha-debugger.php';
			new HA_Debugger();
		}
		if ( class_exists( 'Simple_Location_Plugin' ) ) {
			require_once plugin_dir_path( __FILE__ ) . '/includes/class-location-provider-homeassistant.php';
			add_filter( 'geolocation_providers', array( 'Home_Assistant_Plugin', 'geolocation_providers' ) );
		}
	}

	public static function geolocation_providers( $return ) {
		$return[ 'Homeassistant' ] = __( 'Home Assistant', 'homeassistant' );
		return $return;
	}

	public static function plugins_loaded() {
		load_plugin_textdomain( 'homeassistant', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

}


