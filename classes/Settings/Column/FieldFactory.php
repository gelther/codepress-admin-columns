<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_FieldFactory {

	/**
	 * Create a field based on arguments
	 *
	 * @param array $args
	 *
	 * @return false|AC_Settings_Column_Field
	 */
	public function create( array $args ) {
		$field = new AC_Settings_Column_Field( $args );

		return $field;
	}

	/**
	 * Get a predefined field based on the classname
	 *
	 * @param string name
	 * @param array $args
	 *
	 * @return false|AC_Settings_Column_FieldAbstract
	 */
	public static function get( $name, array $args = array() ) {
		$class = 'AC_Settings_Column_Field_' . implode( array_map( 'ucfirst', explode( '_', $name ) ) );
		$field = false;

		if ( class_exists( $class, true ) ) {
			$field = new $class( $args );
		}

		return $field;
	}

}