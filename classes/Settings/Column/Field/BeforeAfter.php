<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_BeforeAfter extends AC_Settings_Column_FieldAbstract {

	public function field() {
		$this->fields( array(
			'label'  => $this->get_label(),
			'fields' => array(
				$this->get_before_args(),
				$this->get_after_args(),
			),
		) );
	}

	public function get_before_args() {
		return array(
			'type'        => 'text',
			'name'        => 'before',
			'label'       => __( "Before", 'codepress-admin-columns' ),
			'description' => __( 'This text will appear before the column value.', 'codepress-admin-columns' ),
		);
	}

	public function get_after_args() {
		return array(
			'type'        => 'text',
			'name'        => 'after',
			'label'       => __( "After", 'codepress-admin-columns' ),
			'description' => __( 'This text will appear after the column value.', 'codepress-admin-columns' ),
		);
	}

	public function get_label() {
		return __( 'Display Options', 'codepress-admin-columns' );
	}

}