<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_PostLink extends AC_Settings_Column_Field {

	public function get_args() {
		return array(
			'type'        => 'select',
			'name'        => 'post_link_to',
			'label'       => __( 'Link To', 'codepress-admin-columns' ),
			'options'     => array(
				''            => __( 'None' ),
				'edit_post'   => __( 'Edit Post' ),
				'view_post'   => __( 'View Post' ),
				'edit_author' => __( 'Edit Post Author', 'codepress-admin-columns' ),
				'view_author' => __( 'View Public Post Author Page', 'codepress-admin-columns' ),
			),
			'description' => __( 'Page the posts should link to.', 'codepress-admin-columns' ),
		);
	}

}