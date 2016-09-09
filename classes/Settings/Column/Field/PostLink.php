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

	public function format( $post_id ) {
		switch ( $this->get_value() ) {
			case 'edit_post' :
				$link = get_edit_post_link( $post_id );
				break;
			case 'view_post' :
				$link = get_permalink( $post_id );
				break;
			case 'edit_author' :
				$link = get_edit_user_link( get_post_field( 'post_author', $post_id ) );
				break;
			case 'view_author' :
				$link = get_author_posts_url( get_post_field( 'post_author', $post_id ) );
				break;
			default :
				$link = false;
		}

		return $link;
	}

}