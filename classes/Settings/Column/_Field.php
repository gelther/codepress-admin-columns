<?php
defined( 'ABSPATH' ) or die();

class AC_Settings_Column_Field extends AC_Settings_Column {

	/**
	 * @since NEWVERSION
	 */
	public function display( $args = array() ) {
		$this->display_field( $args );
	}

}