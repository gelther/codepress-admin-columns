<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AC_Helper
 *
 * Implements __call to work around any keyword restrictions for PHP versions > 7
 *
 * @property AC_Helper_Array array
 * @property AC_Helper_Date date
 * @property AC_Helper_Image image
 * @property AC_Helper_Post post
 * @property AC_Helper_String string
 * @property AC_Helper_Taxonomy taxonomy
 * @property AC_Helper_User user
 * @property AC_Helper_Icon icon
 * @property AC_Helper_FormField formfield
 */
class AC_Helper {

	public function __get( $helper ) {
		$class = 'AC_Helper_' . ucfirst( $helper );

		if ( class_exists( 'AC_Helper_' . ucfirst( $helper ) ) ) {
			return new $class;
		}

		return false;
	}

}