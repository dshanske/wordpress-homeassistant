<?php
// Home Assistant Base Class
class Home_Assistant {
	private $password;
	private $url;
	public function __construct() {
		$this->token = get_option( 'homeassistant_token' );
		$this->url   = trailingslashit( get_option( 'homeassistant_url' ) ) . 'api/';
	}

		/**
		 * If set, return otherwise false.
		 *
		 * @param type $var Check if set.
		 * @return $var|false Return either $var or $return.
		 */
	public static function ifset( $var, $return = false ) {

			return isset( $var ) ? $var : $return;
	}

	protected function fetch( $path ) {
			$args = array(
				'timeout'    => 30,
				'headers'    => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $this->token,
				),
				// Use an explicit user-agent for this
				'user-agent' => 'WP/' . get_bloginfo( 'version' ) . '); ' . get_bloginfo( 'url' ),
			);

			$response      = wp_safe_remote_get( $this->url . $path, $args );
			$response_code = wp_remote_retrieve_response_code( $response );

		if ( is_wp_error( $response ) ) {
				return $response;
		}
		switch ( $response_code ) {
			case 200:
			case 201:
				break;
			default:
				return new WP_Error( 'api_error', wp_remote_retrieve_response_message( $response ), array( 'status' => $response_code ) );
		}
			return wp_remote_retrieve_body( $response );
	}
}
