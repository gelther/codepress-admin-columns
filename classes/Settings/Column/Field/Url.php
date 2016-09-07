<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Url extends AC_Settings_Column_FieldAbstract {

	public function get_args() {
		return array(
			'type'        => 'text',
			'name'        => 'link_label',
			'label'       => __( 'Link label', 'codepress-admin-columns' ),
			'description' => __( 'Leave blank to display the url', 'codepress-admin-columns' ),
		);
	}

	public function field() {
		$this->display( $this->get_args() );
	}

}