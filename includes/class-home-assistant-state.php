<?php
// Home Assistant State
class Home_Assistant_State extends Home_Assistant {
	public function __construct() {
		parent::__construct();
	}

	public static function get_types() {
		return array(
			'binary_sensor'  => __( 'Binary Sensor', 'homeassistant' ),
			'sensor'         => __( 'Sensor', 'homeassistant' ),
			'device_tracker' => __( 'Device Tracker', 'homeassistant' ),
		);
	}

	public static function type_select( $select, $echo = false ) {
		$choices = Home_Assistant::get_types();
		$return  = '';
		foreach ( $choices as $value => $text ) {
			$return .= sprintf( '<option value=%1s %2s>%3s</option>', $value, selected( $select, $value, false ), $text );
		}
		if ( ! $echo ) {
			return $return;
		}
		echo $return;
	}

	public function get_state( $type = null, $name = null ) {
		if ( empty( $type ) && empty( $name ) ) {
			return $this->fetch( 'states/' );
		}
		if ( empty( $name ) ) {
			return $this->fetch( 'states/' . $type );
		}
		return $this->fetch( 'states/' . $type . '.' . $name );
	}

	public function get_state_attribute( $type = null, $name = null, $attribute = null ) {
		if ( empty( $type ) && empty( $name ) && empty( $attribute ) ) {
			return null;
		}
		else {
			$state = $this->get_state( $type, $name );
			if ( ! is_array( $state ) ) {
				return null;
			}
			return isset( $state['attribute'][$attribute] ) ? $state['attribute'][$attribute] : null;
		}

	}

}
