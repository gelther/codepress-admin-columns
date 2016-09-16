<?php
defined( 'ABSPATH' ) or die();

/**
 * Column displaying information about the author of a post, such as the
 * author's display name, user ID and email address.
 *
 * @since 2.0
 */
class AC_Column_Post_AuthorName extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type']  = 'column-author_name';
		$this->properties['label'] = __( 'Display Author As', 'codepress-admin-columns' );
	}

	public function get_value( $post_id ) {
		$author = $this->get_post_author( $post_id );

		// User name
		$value = $this->format->user( $author );

		// Link To
		$link = false;
		switch ( $this->get_option( 'user_link_to' ) ) {
			case 'edit_user' :
				$link = get_edit_user_link( $author );
				break;
			case 'view_user_posts' :
				$link = add_query_arg( array(
					'post_type' => ac_helper()->post->get_raw_field( 'post_type', $post_id ),
					'author'    => get_the_author_meta( 'ID' )
				), 'edit.php' );
				break;
			case 'view_author' :
				$link = get_author_posts_url( $author );
				break;
			case 'email_user' :
				$email = get_the_author_meta( 'email', $author );
				$link  = $email ? 'mailto:' . $email : false;
				break;
		}

		if ( $link ) {
			$value = '<a href="' . esc_url( $link ) . '">' . $value . '</a>';
		}

		return $value;
	}

	public function get_raw_value( $post_id ) {
		return $this->get_post_author( $post_id );
	}

	private function get_post_author( $post_id ) {
		return ac_helper()->post->get_raw_field( 'post_author', $post_id );
	}

	public function display_settings() {
		$this->field_settings->user();
		$this->field_settings->user_link_to();
	}

}
