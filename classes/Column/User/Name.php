<?php
defined( 'ABSPATH' ) or die();

/**
 * @since NEWVERSION
 */
class AC_Column_User_Name extends AC_Column_Default {

	public function init() {
		parent::init();

		$this->properties['type'] = 'name';
	}

}
