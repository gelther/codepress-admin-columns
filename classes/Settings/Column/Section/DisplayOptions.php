<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Section_DisplayOptions extends AC_Settings_Column_Section {

	public function __construct() {
		parent::__construct();



		$before_field = new AC_Settings_Column_Field( 'before' );
		$before_field->set_label( __( "Before", 'codepress-admin-columns' ) );
		$before_field->set_description( __( 'This text will appear before the column value.', 'codepress-admin-columns' ) );

		$this->add_field( $before_field );

		$before_field = new AC_Settings_Column_Field( 'after' );
		$before_field->set_label( __( "After", 'codepress-admin-columns' ) );
		$before_field->set_description( __( 'This text will appear after the column value.', 'codepress-admin-columns' ) );

		$this->add_field( $before_field );
	}

	public function display_fields() {



	}

}