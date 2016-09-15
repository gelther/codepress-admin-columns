<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Section_Label extends AC_Settings_Column_Section {

	public function __construct( $placeholder = null ) {
		parent::__construct();

		$this->set_name( 'label' );
		$this->set_label( __( 'Label', 'codepress-admin-columns' ) );
		$this->set_description( __( 'This is the name which will appear as the column header.', 'codepress-admin-columns' ) );

		$field = new AC_Settings_Column_Field_Label();
		$field->set_placeholder( $placeholder );

		$this->add_field( $field );
	}

}