<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_FieldAttributes {

	private $attributes;

	public function __construct() {

	}

	public function set( $attribute, $value ) {
		$this->attributes[ $attribute ] = $value;

		return $this;
	}

	public function get( $attribute ) {
		return $this->attributes[ $attribute ];
	}

	public function get_class() {
		return $this->get( 'class' );
	}

	public function set_class( $class ) {
		$this->attributes['class'] = explode( ' ', $class );

		return $this;
	}

	public function add_class( $class ) {
		$_class = $this->get_class();
		$_class[] = $class;

		return $this->set_class( $_class );
	}

	public function set_data( $attribute, $value ) {
		$this->set( 'data-' . $attribute, $value );

		return $this;
	}

	public function display( $attribute ) {
		esc_attr( $this->attributes[ $attribute ] );
	}

}