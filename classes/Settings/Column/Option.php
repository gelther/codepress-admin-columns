<?php

class AC_Settings_Column_OptionAbstract {

	private $value;

	private $name;

	private $column;

	public function __construct( $name ) {
		$this->name = $name;
	}

	public function set_column( CPAC_Column $column ) {
		$this->column = $column;

		return $this;
	}

	public function set_value( $value ) {
		$this->value = $value;

		return $this;
	}

	public function get_value() {
		return $this->value;
	}

}