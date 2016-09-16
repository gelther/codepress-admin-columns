<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.0
 */
class AC_Column_Comment_AuthorEmail extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type']  = 'column-author_email';
		$this->properties['label'] = __( 'Author email', 'codepress-admin-columns' );
	}

	public function get_value( $id ) {
		$email = $this->get_raw_value( $id );

		return '<a href="' . $email . '">' . $email . '</a>';
	}

	public function get_raw_value( $id ) {
		$comment = get_comment( $id );

		return $comment->comment_author_email;
	}

}
