<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Label extends AC_Settings_Column_Field {

	public function __construct() {
		parent::__construct( 'label' );
	}

	public function format( $string ) {
		return apply_filters( 'cac/column/settings_label', stripslashes( str_replace( '[cpac_site_url]', site_url(), $string ) ), $this );
	}

}