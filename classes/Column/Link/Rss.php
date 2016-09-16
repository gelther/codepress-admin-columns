<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.0
 */
class AC_Column_Link_Rss extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type']  = 'column-rss';
		$this->properties['label'] = __( 'Rss', 'codepress-admin-columns' );
	}

	function get_value( $id ) {
		$bookmark = get_bookmark( $id );

		return $this->get_shorten_url( $bookmark->link_rss );
	}

}
