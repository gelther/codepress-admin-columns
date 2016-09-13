<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Width_Unit extends AC_Settings_Column_Field {

	public function __construct() {
		$this->set_name( 'width_unit' );
		$this->set_default_value( current( $this->get_width_units() ) );
	}

	/**
	 * Get valid width unit
	 *
	 * @since NEWVERSION
	 * @return array
	 */
	public function get_options() {
		return array(
			'%'  => __( '%', 'codepress-admin-columns' ),
			'px' => __( 'px', 'codepress-admin-columns' ),
		);
	}

	public function display_field() {
		$args = $this->to_formfield();

		$args['options'] = $this->get_options();
		$args['class'] = 'unit';
		$args['default_value'] = $this->get_default_value();

		ac_helper()->formfield->radio( $args );
	}

}