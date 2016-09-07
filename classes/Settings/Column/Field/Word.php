<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Word extends AC_Settings_Column_FieldAbstract {

	public function __construct() {
		parent::__construct();

		$this->merge_args( array(
			'type'        => 'number',
			'name'        => 'excerpt_length',
			'label'       => __( 'Word Limit', 'codepress-admin-columns' ),
			'description' => __( 'Maximum number of words', 'codepress-admin-columns' ) . '<em>' . __( 'Leave empty for no limit', 'codepress-admin-columns' ) . '</em>',
		) );
	}

	public function format( $string ) {
		$limit = $this->column->get_option( $this->get_name() );

		return $limit ? wp_trim_words( $string, $limit ) : $string;
	}

}

