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

add_action( 'plugins_loaded', array( 'Home_Assistant_Plugin', 'plugins_loaded' ) );
add_action( 'init', array( 'Home_Assistant_Plugin', 'init' ) );

class Home_Assistant_Plugin {
	public static $version = '0.1.0';
	public static function init() {
	}
	public static function plugins_loaded() {
		load_plugin_textdomain( 'homeassistant', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

}


