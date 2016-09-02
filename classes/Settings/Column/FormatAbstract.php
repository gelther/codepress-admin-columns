<?php

abstract class AC_Settings_Column_FormatAbstract {

	/**
	 * @var CPAC_Column
	 */
	private $column;

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;
	}

	public abstract function format();

}