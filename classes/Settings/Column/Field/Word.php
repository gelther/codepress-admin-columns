<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Word extends AC_Settings_Column_FieldAbstract {

	public function __construct( CPAC_Column $column ) {
		parent::__construct( $column );

		$this
			->set_type( 'number ') // todo: only for css class??
			->set_name( 'excerpt_length' )
			->set_label( __( 'Word Limit', 'codepress-admin-columns' ) )
			->set_description( __( 'Maximum number of words', 'codepress-admin-columns' ) . '<em>' . __( 'Leave empty for no limit', 'codepress-admin-columns' ) . '</em>' );
	}

	// todo: type vs this display, it is equally good only this is more readable
	public function display_field() {
		$args = $this->to_formfield();

		AC()->helper->formfield->number( $args );
	}

	public function format( $string ) {
		$limit = $this->column->get_option( $this->get_name() );

		return $limit ? wp_trim_words( $string, $limit ) : $string;
	}

}

