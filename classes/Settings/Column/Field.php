<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field extends AC_Settings_Column_FieldAbstract {

	/**
	 * Factory method to create a field based on parameters
	 *
	 * @param array $args
	 *
	 * @return AC_Settings_Column_Field
	 */
	public static function create( array $args ) {
		$field = new self();

		// todo: check here if arguments are valid

		foreach ( $args as $key => $value ) {
			$field->set_arg( $key, $value );
		}

		return $field;
	}

}