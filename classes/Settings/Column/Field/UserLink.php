<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_UserLink extends AC_Settings_Column_Field {

	public function get_args() {
		return array(
			'type'        => 'select',
			'name'        => 'user_link_to',
			'label'       => __( 'Link To', 'codepress-admin-columns' ),
			'options'     => array(
				''                => __( 'None' ),
				'edit_user'       => __( 'Edit User Profile' ),
				'view_user_posts' => __( 'View User Posts' ),
				'view_author'     => __( 'View Public Author Page', 'codepress-admin-columns' ),
				'email_user'      => __( 'User Email' ),
			),
			'description' => __( 'Page the author name should link to.', 'codepress-admin-columns' ),
		);
	}

}