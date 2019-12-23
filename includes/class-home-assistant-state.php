<?php
// Home Assistant State
class Home_Assistant_State extends Home_Assistant {
	public $attributes   = array();
	public $entity_id    = '';
	public $last_changed = '';
	public $last_updated = '';
	public $state        = '';

	public function __construct( $type, $name = null ) {
		parent::__construct();
		if ( ! $name ) {
			$this->entity_id = $type;
		} else {
			$this->entity_id = $type . '.' . $name;
		}
	}

	public static function get_types() {
		return array(
			'binary_sensor'  => __( 'Binary Sensor', 'homeassistant' ),
			'sensor'         => __( 'Sensor', 'homeassistant' ),
			'device_tracker' => __( 'Device Tracker', 'homeassistant' ),
			'media_player'   => __( 'Media Player', 'homeassistant' ),
		);
	}

	public static function type_select( $select, $echo = false ) {
		$choices = self::get_types();
		$return  = '';
		foreach ( $choices as $value => $text ) {
			$return .= sprintf( '<option value=%1s %2s>%3s</option>', $value, selected( $select, $value, false ), $text );
		}
		if ( ! $echo ) {
			return $return;
		}
		echo $return;
	}

	public function get_state() {
		return $this->state;
	}

	public function get() {
		$return = $this->fetch( 'states/' . $this->entity_id );
		if ( is_wp_error( $return ) ) {
			return $return;
		}
		$return = json_decode( $return, true );
		foreach ( $return as $key => $value ) {
				$this->$key = $value;
		}
	}

	public function get_attribute( $attribute = null ) {
		if ( ! $attribute ) {
			return $this->attributes;
		}
		if ( array_key_exists( $attribute, $this->attributes ) ) {
			return $this->attributes[ $attribute ];
		}
		return false;
	}

}
