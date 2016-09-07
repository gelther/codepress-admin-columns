<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// todo: add a field interface maybe? display, add_field, get_field, get_fields?
class AC_Settings_Column {

	/**
	 * @var CPAC_Column
	 */
	private $column;

	/**
	 * @var array
	 */
	private $fields;

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;
		$this->fields = array();
	}

	public function add_field( AC_Settings_Column_FieldAbstract $field ) {
		$this->fields[ $field->get_name() ] = $field;

		return $this;
	}

	public function get_field( $name ) {
		if ( ! isset( $field[ $name ] ) ) {
			return false;
		}

		return $this->fields[ $name ];
	}

	public function get_fields() {
		return $this->fields;
	}

	public function display() {
		foreach ( $this->fields as $field ) {
			$field->display();
		}
	}

}