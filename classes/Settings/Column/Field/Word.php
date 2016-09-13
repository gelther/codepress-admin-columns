<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Word extends AC_Settings_Column_Field {

	public function __construct( $name ) {
		parent::__construct( $name );

		$this->type = 'number';
		$this->label = __( 'Word Limit', 'codepress-admin-columns' );
		$this->description = __( 'Maximum number of words', 'codepress-admin-columns' ) . '<em>' . __( 'Leave empty for no limit', 'codepress-admin-columns' ) . '</em>';
	}

	public function format( $string ) {
		$limit = $this->get_value();

		return $limit ? wp_trim_words( $string, $limit ) : $string;
	}

}

