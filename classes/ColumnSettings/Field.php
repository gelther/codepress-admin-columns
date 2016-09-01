<?php
defined( 'ABSPATH' ) or die();

class AC_ColumnSettings_Field extends AC_ColumnSettingsAbstract {

	/**
	 * @since NEWVERSION
	 */
	public function display( $args = array() ) {
		$this->display_field( $args );
	}

}