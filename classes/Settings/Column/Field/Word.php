<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Word extends AC_Settings_Column_Field {

	public function get_args() {
		return array(
			'type'        => 'number',
			'name'        => 'excerpt_length',
			'label'       => __( 'Word Limit', 'codepress-admin-columns' ),
			'description' => __( 'Maximum number of words', 'codepress-admin-columns' ) . '<em>' . __( 'Leave empty for no limit', 'codepress-admin-columns' ) . '</em>',
		);
	}

	public function field() {
		$this->display( $this->get_args() );
	}

	public function format( $string ) {
		$limit = $this->column->get_option( 'excerpt_length' );

		return $limit ? wp_trim_words( $string, $limit ) : $string;
	}

}