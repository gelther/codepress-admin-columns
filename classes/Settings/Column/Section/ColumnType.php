<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Section_ColumnType extends AC_Settings_Column_Section {

	public function __construct() {
		parent::__construct();

		$this->set_name( 'label' );
		$this->set_label( __( 'Type', 'codepress-admin-columns' ) );
		$this->set_description( __( 'Choose a column type.', 'codepress-admin-columns' ) . '<em>' . __( 'Type', 'codepress-admin-columns' ) . ': ' . $column->get_type() . '</em><em>' . __( 'Name', 'codepress-admin-columns' ) . ': ' . $column->get_name() . '</em>' );

		$field = new AC_Settings_Column_Field( 'type' );


		// TODO:  Add grouped options $column->get_storage_model()->get_grouped_columns()
		$field->set_options( array() );

		$this->add_field( $field );
	}

}