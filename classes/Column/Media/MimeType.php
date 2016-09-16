<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.0
 */
class AC_Column_Media_MimeType extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type']  = 'column-mime_type';
		$this->properties['label'] = __( 'Mime type', 'codepress-admin-columns' );
	}

	public function get_value( $id ) {
		return $this->get_raw_value( $id );
	}

	public function get_raw_value( $id ) {
		return get_post_field( 'post_mime_type', $id );
	}

}
