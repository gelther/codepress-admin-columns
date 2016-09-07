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

	public function format( $url ) {
		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) || ! preg_match( '/[^\w.-]/', $url ) ) {
			return false;
		}

		$label = $this->get_value();

		if ( ! $label ) {
			$label = $url;
		}

		return '<a href="' . esc_url( $url ) . '">' . $label . '</a>';
	}

}