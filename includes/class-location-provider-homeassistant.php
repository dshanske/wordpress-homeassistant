<?php

class Location_Provider_Homeassistant extends Location_Provider {

	public function __construct( $args = array() ) {
		parent::__construct( $args );
	}

	public function retrieve() {
		$HA = new Home_Assistant_State( $user );
		$properties = array( 'longitude', 'latitude', 'altitude', 'accuracy', 'heading', 'speed' );
		foreach( $properties as $property ) {
			$this->$property = $HA->get_attribute( $property );
		}
	}	


}
