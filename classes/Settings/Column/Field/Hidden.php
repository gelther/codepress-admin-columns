<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Hidden extends AC_Settings_Column_Field {

	public function __construct( array $args = array() ) {
		parent::__construct( array(
			'type' => 'hidden',
		) );

		$this->merge_args( $args );
	}

}