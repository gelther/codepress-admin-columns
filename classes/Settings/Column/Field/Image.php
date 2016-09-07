<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Image extends AC_Settings_Column_FieldAbstract {

	public function display_field() {

	}

	public function get_args() {
		return array(
			array(
				'label'           => $this->get_label(),
				'type'            => 'select',
				'name'            => 'image_size',
				'grouped_options' => $this->get_grouped_image_sizes(),
			),
			$this->get_width_args(),
			$this->get_height_args(),
		);
	}

	public function field() {
		$args = $this->get_args();

		unset( $args['label'] );

		$this->display( array(
			'label'  => $this->get_label(),
			'fields' => $args,
		) );
	}

	public function format( $attachment_ids ) {
		return ac_helper()->image->get_images_by_ids( $attachment_ids, $this->image_sizes() );
	}

	// Helpers
	/**
	 * @return array|false|string
	 */
	private function image_sizes() {

		// TODO
		$size = $this->column->get_option( 'image_size' );

		if ( 'cpac-custom' == $size ) {
			$size = array(
				$this->column->get_option( 'image_size_w' ),
				$this->column->get_option( 'image_size_h' ),
			);
		}

		return $size;
	}

	private function get_label() {
		return __( 'Image Size', 'codepress-admin-columns' );
	}

	private function get_width_args() {
		return array(
			'type'          => 'text',
			'name'          => 'image_size_w',
			'label'         => __( "Width", 'codepress-admin-columns' ),
			'description'   => __( "Width in pixels", 'codepress-admin-columns' ),
			'toggle_handle' => 'image_size_w',
			'hidden'        => 'cpac-custom' !== $this->get_option( 'image_size' ),
		);
	}

	private function get_height_args() {
		return array(
			'type'          => 'text',
			'name'          => 'image_size_h',
			'label'         => __( "Height", 'codepress-admin-columns' ),
			'description'   => __( "Height in pixels", 'codepress-admin-columns' ),
			'toggle_handle' => 'image_size_h',
			'hidden'        => 'cpac-custom' !== $this->get_option( 'image_size' ),
		);
	}

	/**
	 * @since 1.0
	 * @return array Image Sizes.
	 */
	private function get_grouped_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array(
			'default' => array(
				'title'   => __( 'Default', 'codepress-admin-columns' ),
				'options' => array(
					'thumbnail' => __( "Thumbnail", 'codepress-admin-columns' ),
					'medium'    => __( "Medium", 'codepress-admin-columns' ),
					'large'     => __( "Large", 'codepress-admin-columns' ),
				),
			),
		);

		$all_sizes = get_intermediate_image_sizes();

		if ( ! empty( $all_sizes ) ) {
			foreach ( $all_sizes as $size ) {
				if ( 'medium_large' == $size || isset( $sizes['default']['options'][ $size ] ) ) {
					continue;
				}

				if ( ! isset( $sizes['defined'] ) ) {
					$sizes['defined']['title'] = __( "Others", 'codepress-admin-columns' );
				}

				$sizes['defined']['options'][ $size ] = ucwords( str_replace( '-', ' ', $size ) );
			}
		}

		// add sizes
		foreach ( $sizes as $key => $group ) {
			foreach ( array_keys( $group['options'] ) as $_size ) {

				$w = isset( $_wp_additional_image_sizes[ $_size ]['width'] ) ? $_wp_additional_image_sizes[ $_size ]['width'] : get_option( "{$_size}_size_w" );
				$h = isset( $_wp_additional_image_sizes[ $_size ]['height'] ) ? $_wp_additional_image_sizes[ $_size ]['height'] : get_option( "{$_size}_size_h" );
				if ( $w && $h ) {
					$sizes[ $key ]['options'][ $_size ] .= " ({$w} x {$h})";
				}
			}
		}

		// last
		$sizes['default']['options']['full'] = __( "Full Size", 'codepress-admin-columns' );

		$sizes['custom'] = array(
			'title'   => __( 'Custom', 'codepress-admin-columns' ),
			'options' => array( 'cpac-custom' => __( 'Custom Size', 'codepress-admin-columns' ) . '..' ),
		);

		return $sizes;
	}

}