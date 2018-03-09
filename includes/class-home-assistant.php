<?php
class Home_Assistant {
	private $password;
	private $url;
	public function __construct() {
		$this->password = get_option( 'homeassistant_password' );
		$this->url      = trailingslashit( get_option( 'homeassistant_url' ) ) . 'api/';
	}

	private function fetch( $path ) {
			$args = array(
				'timeout'    => 30,
				'headers'    => array(
					'Content-Type' => 'application/json',
					'x-ha-access'  => $this->password,
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

	public function get_state( $type = null, $name = null ) {
		if ( empty( $type ) || empty( $name ) ) {
			return $this->fetch( 'states/' );
		}
		return $this->fetch( 'states/' . $type . '.' . $name );
	}

}
