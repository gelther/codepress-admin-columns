<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.0
 */
class AC_Column_Comment_Excerpt extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type'] = 'column-excerpt';
		$this->properties['label'] = __( 'Content', 'codepress-admin-columns' );

		// TODO: remove
		//$this->default_options['excerpt_length'] = 15;

		// Register settings field

		// TODO: remove
		//$word_limit = new AC_Settings_Column_Field_Word();
		//$this->settings()->add_field( $word_limit->set_default( 15 ) ); // Set default length to 15

		// TODO: improved syntax, keep it?
		$this->settings()->register_field( 'excerpt_length', array( 'default' => 15 ) );
	}

	public function get_value( $id ) {
		return $this->settings()->get_field( 'excerpt_length' )->format( $this->get_raw_value( $id ) );
	}

	public function get_raw_value( $id ) {
		$comment = get_comment( $id );

		return $comment ? $comment->comment_content : false;
	}

}