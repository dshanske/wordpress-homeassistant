<?php

class Location_Provider_Homeassistant extends Location_Provider {

	public function __construct( $args = array() ) {
		parent::__construct( $args );
	}

	public function retrieve() {
		$HA         = new Home_Assistant_State( 'device_tracker.moto_rs' );
		$properties = array( 'longitude', 'latitude', 'altitude', 'heading', 'speed' );
		$HA->get();
		foreach ( $properties as $property ) {
			$this->$property = $HA->get_attribute( $property );
		}
		$this->accuracy = $HA->get_attribute( 'gps_accuracy' );
	}


}
