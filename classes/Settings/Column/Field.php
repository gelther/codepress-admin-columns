<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field extends AC_Settings_Column_FieldAbstract {

	public function __construct( array $args = array() ) {
		parent::__construct( $args );

		$this->merge_args( array(
			'type'           => 'text',
			'name'           => '',
			'toggle_trigger' => '', // triggers a toggle event on toggle_handle
			'toggle_handle'  => '', // can be used to toggle this element
			'refresh_column' => false, // when value is selected the column element will be refreshed with ajax
			'hidden'         => false,
			'for'            => false,
			'section'        => false,
			'help'           => '', // help message below input field
			'more_link'      => '', // link to more, e.g. admin page for a field
		) );
	}

	/**
	 * Return the stored value
	 *
	 * @return string|array
	 */
	public function get_value() {
		$value = $this->settings->get_value( $this->get_arg( 'name' ) );

		if ( false === $value ) {
			$value = $this->get_arg( 'default' );
		}

		return $value;
	}

	public function display_field() {
		$args = $this->to_formfield();

		// todo: check if __get supports this chain
		//$method = $this->get_arg( 'type' );
		//if ( method_exists( ac_helper()->formfield, $this->get_arg( 'type' ) ) )

		switch ( $this->get_arg( 'type' ) ) {
			case 'select' :
				ac_helper()->formfield->select( $args );
				break;
			case 'radio' :
				ac_helper()->formfield->radio( $args );
				break;
			case 'text' :
				ac_helper()->formfield->text( $args );
				break;
			case 'message' :
				ac_helper()->formfield->message( $args );
				break;
			case 'number' :
				ac_helper()->formfield->number( $args );
				break;
		}
	}


}