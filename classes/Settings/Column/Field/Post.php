<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Post extends AC_Settings_Column_FieldAbstract {

	public function get_args() {
		return array(
			'type'        => 'select',
			'name'        => 'post_property_display',
			'label'       => __( 'Property To Display', 'codepress-admin-columns' ),
			'options'     => array(
				'title'  => __( 'Title' ), // default
				'id'     => __( 'ID' ),
				'author' => __( 'Author' ),
			),
			'description' => __( 'Post property to display for related post(s).', 'codepress-admin-columns' ),
		);
	}

}