<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Label extends AC_Settings_Column_FieldAbstract {

	public function display_field() {

	}

	public function get_label() {
		return apply_filters( 'cac/column/settings_label', stripslashes( str_replace( '[cpac_site_url]', site_url(), $this->get_value( 'label' ) ) ), $this );
	}

}