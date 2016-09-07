<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.4.7
 */
class AC_Column_Comment_Post extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type'] = 'column-post';
		$this->properties['label'] = __( 'Post', 'codepress-admin-columns' );

		//$this->default_options['post_property_display'] = 'title';
		//$this->default_options['post_link_to'] = 'edit_post';

		$this->settings()->register_field( 'post_link_to', array( 'default' => 'edit_post' ) );
		$this->settings()->register_field( 'post_property_display' );
	}

	public function get_value( $comment_id ) {
		$post_id = $this->get_raw_value( $comment_id );

		//$link = false;

		// TODO cleanup
		// Get page to link to
		/*switch ( $this->get_option( 'post_link_to' ) ) {
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
		}*/

		$link = $this->settings()->get_field( 'post_link_to' )->format( $post_id );
		$label = $this->settings()->get_field( 'post_property_display' )->format( $post_id );

		// Get property of post to display
		/*switch ( $this->get_option( 'post_property_display' ) ) {
			case 'author' :
				$label = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
				break;
			case 'id' :
				$label = $post_id;
				break;
			default:
				$label = get_the_title( $post_id );
				break;
		}*/

		$value = $link ? "<a href='{$link}'>{$label}</a>" : $label;

		return $value;
	}

	public function get_raw_value( $comment_id ) {
		$comment = get_comment( $comment_id );

		return $comment ? $comment->comment_post_ID : false;
	}

	/*public function display_settings() {
		$this->field_settings->post();
		$this->field_settings->post_link_to();
	}*/

}