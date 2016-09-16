<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.0
 */
class AC_Column_Link_Target extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type']  = 'column-target';
		$this->properties['label'] = __( 'Target', 'codepress-admin-columns' );
	}

	function get_value( $id ) {
		$bookmark = get_bookmark( $id );

		return $bookmark->link_target;
	}

}
