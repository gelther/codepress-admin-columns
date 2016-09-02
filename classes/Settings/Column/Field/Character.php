<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Character extends AC_Settings_Column_Field {

	public function get_args() {
		return array(
			'type'        => 'number',
			'name'        => 'character_limit',
			'label'       => __( 'Character Limit', 'codepress-admin-columns' ),
			'description' => __( 'Maximum number of characters', 'codepress-admin-columns' ) . '<em>' . __( 'Leave empty for no limit', 'codepress-admin-columns' ) . '</em>',
		);
	}

	public function field() {
		$this->display( $this->get_args() );
	}

	public function value( $string ) {
		$limit = $this->column->get_option( 'character_limit' );

		return is_numeric( $limit ) && 0 < $limit && strlen( $string ) > $limit ? substr( $string, 0, $limit ) . __( '&hellip;' ) : $string;
	}

}