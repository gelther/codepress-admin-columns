<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column {

	private $column;

	public $character;

	public $image;

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;
		$this->character = new AC_Settings_Column_Field_Character( $column );
		$this->image = new AC_Settings_Column_Field_Image( $column );
	}

	public function display_field( $args ) {
		$field = new AC_ColumnSettings_Field( $this->column );

		return $field->display( $args );
	}

	/**
	 * @param array $args
	 */
	public function display_fields( $args = array() ) {
		$fields = new AC_ColumnSettings_Fields( $this->column );

		return $fields->display( $args );
	}

}