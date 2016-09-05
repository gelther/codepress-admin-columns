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
		$this->date = new AC_Settings_Column_Field_Date( $column );
		$this->word = new AC_Settings_Column_Field_Word( $column );
		$this->before_after = new AC_Settings_Column_Field_BeforeAfter( $column );

		// General fields
		$this->field = new AC_Settings_Column_Field( $column );
		$this->fields = new AC_Settings_Column_Fields( $column );
	}

	public function display_field( $args ) {
		$this->field->display( $args );
	}

	public function display_fields( $args ) {
		$this->fields->display( $args );
	}

}