<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Date extends AC_Settings_Column_FieldAbstract {

	public function get_args() {
		return array(
			'type'        => 'text',
			'name'        => 'date_format',
			'label'       => __( 'Date Format', 'codepress-admin-columns' ),
			'placeholder' => __( 'Example:', 'codepress-admin-columns' ) . ' d M Y H:i',
			'description' => __( 'This will determine how the date will be displayed.', 'codepress-admin-columns' ),
			'help'        => sprintf( __( "Leave empty for WordPress date format, change your <a href='%s'>default date format here</a>.", 'codepress-admin-columns' ), admin_url( 'options-general.php' ) . '#date_format_custom_radio' ) . " <a target='_blank' href='http://codex.wordpress.org/Formatting_Date_and_Time'>" . __( 'Documentation on date and time formatting.', 'codepress-admin-columns' ) . "</a>",
		);
	}

	public function field() {
		$this->display( $this->get_args() );
	}

	public function format( $date ) {
		return ac_helper()->date->date( $date, $this->column->get_option( 'date_format' ) );
	}

}