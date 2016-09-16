<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.0
 */
class AC_Column_Post_Formats extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type']  = 'column-post_formats';
		$this->properties['label'] = __( 'Post Format', 'codepress-admin-columns' );
	}

	function apply_conditional() {
		return post_type_supports( $this->get_post_type(), 'post-formats' );
	}

	function get_value( $post_id ) {
		$format = $this->get_raw_value( $post_id );

		return $format ? esc_html( get_post_format_string( $format ) ) :  __( 'Standard', 'Post format' );
	}

	/**
	 * @see CPAC_Column::get_raw_value()
	 * @since 2.0.3
	 */
	function get_raw_value( $post_id ) {
		$format = get_post_format( $post_id );

		return $format ? $format : false;
	}

}
