<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Helper_Image {

	protected $available_image_sizes = null;

	/**
	 * Resize image
	 *
	 * @param string $file
	 * @param int $max_w
	 * @param int $max_h
	 * @param bool $crop
	 * @param null|string $suffix
	 * @param null|string $dest_path
	 * @param int $jpeg_quality
	 *
	 * @return bool|string|WP_Error
	 */
	public function resize( $file, $max_w, $max_h, $crop = false, $suffix = null, $dest_path = null, $jpeg_quality = 90 ) {
		$editor = wp_get_image_editor( $file );

		if ( is_wp_error( $editor ) ) {
			return false;
		}

		$editor->set_quality( $jpeg_quality );

		$resized = $editor->resize( $max_w, $max_h, $crop );

		if ( is_wp_error( $resized ) ) {
			return false;
		}

		$dest_file = $editor->generate_filename( $suffix, $dest_path );
		$saved = $editor->save( $dest_file );

		if ( is_wp_error( $saved ) ) {
			return false;
		}

		return $dest_file;
	}

	/**
	 * @param int[]|int $ids
	 * @param array|string $size
	 *
	 * @return string HTML Images
	 */
	public function get_images_by_ids( $ids, $size ) {
		$images = array();

		$ids = is_array( $ids ) ? $ids : array( $ids );
		foreach ( $ids as $id ) {
			$images[] = $this->get_image_by_id( $id, $size );
		}

		return implode( $images );
	}

	/**
	 * @param int $id
	 * @param string|array $size
	 *
	 * @return string
	 */
	public function get_image_by_id( $id, $size ) {
		$image = false;

		if ( ! is_numeric( $id ) ) {
			return false;
		}

		// Is Image
		if ( $attributes = wp_get_attachment_image_src( $id, $size ) ) {
			$src = $attributes[0];

			if ( is_array( $size ) ) {
				$image = $this->markup_cover( $src, $size[0], $size[1] );
			}
			else {
				$image = $this->markup( $src, $attributes[1], $attributes[2] );
			}
		}
		// Is File, use icon
		else if ( $attributes = wp_get_attachment_image_src( $id, $size, true ) ) {
			$image = $this->markup( $attributes[0], $this->scale_size( $attributes[1], 0.7 ), $this->scale_size( $attributes[2], 0.7 ) );
		}

		return $image;
	}

	/**
	 * @param $size
	 * @param int $scale
	 *
	 * @return float
	 */
	private function scale_size( $size, $scale = 1 ) {
		return round( absint( $size ) * $scale );
	}

	/**
	 * @param string $url
	 * @param array|string $size
	 *
	 * @return string
	 */
	public function get_image_by_url( $url, $size ) {
		if ( is_string( $size ) ) {
			$image_size = $this->get_image_sizes_by_name( $size );
			if ( ! $image_size ) {
				return false;
			}
			$size = array( $image_size['width'], $image_size['height'] );
		}

		$image_path = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $url );

		if ( is_file( $image_path ) ) {
			// try to resize image
			if ( $resized = $this->resize( $image_path, $size[0], $size[1], true ) ) {
				$src = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $resized );

				$image = $this->markup( $src, $size[0], $size[1] );
			}
			else {

				$image = $this->markup( $url, $size[0], $size[1] );
			}
		}

		//External image
		else {
			$image = $this->markup_cover( $image_path, $size[0], $size[1] );
		}

		return $image;
	}

	/**
	 * @param $mixed
	 *
	 * @return array Array with either Image ID or Image URL
	 */
	public function string_to_image_array( $mixed ) {
		if ( empty( $mixed ) || 'false' == $mixed ) {
			return array();
		}

		$array = array();

		// turn string to array
		if ( is_string( $mixed ) || is_numeric( $mixed ) ) {
			if ( strpos( $mixed, ',' ) !== false ) {
				$array = array_filter( explode( ',', ac_helper()->string->strip_trim( str_replace( ' ', '', $mixed ) ) ) );
			}
			else {
				$array = array( $mixed );
			}
		}

		// Check if values are wither URL or ID
		foreach ( $array as $k => $value ) {
			if ( ! is_numeric( $value ) && ! ac_helper()->string->is_image_url( $value ) ) {
				unset( $array[ $k ] );
			}
		}

		return $array;
	}

	/**
	 * @param array $images
	 * @param string|array $size String or Array with width and height
	 *
	 * @return array
	 */
	public function get_thumbnails( $images, $size ) {
		$thumbnails = array();

		foreach ( $images as $value ) {
			if ( ac_helper()->string->is_image_url( $value ) ) {
				$thumbnails[] = $this->get_image_by_url( $value, $size );
			}
			// Media Attachment
			else if ( is_numeric( $value ) && wp_get_attachment_url( $value ) ) {
				$thumbnails[] = $this->get_image_by_id( $value, $size );
			}
		}

		return $thumbnails;
	}

	private function markup_cover( $src, $width, $height ) {
		return "<span class='cpac-column-value-image cpac-cover' style='width:{$width}px;height:{$height}px;background-size:cover;background-image:url({$src});background-position:center;'></span>";
	}

	private function markup( $src, $width, $height ) {
		return "<span class='cpac-column-value-image'><img style='max-width:{$width}px;max-height:{$height}px;' src='{$src}' alt=''/></span>";
	}

	/**
	 *
	 * @return array
	 */
	public function get_image_sizes() {
		global $_wp_additional_image_sizes;
		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $size ) {
			if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $size ]['width'] = get_option( "{$size}_size_w" );
				$sizes[ $size ]['height'] = get_option( "{$size}_size_h" );
			}
			elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
				$sizes[ $size ] = array(
					'width'  => $_wp_additional_image_sizes[ $size ]['width'],
					'height' => $_wp_additional_image_sizes[ $size ]['height'],
				);
			}
		}

		return $sizes;
	}

	/**
	 * @param string $name
	 *
	 * @return false|array Image sizes
	 */
	public function get_image_sizes_by_name( $name ) {
		$sizes = false;
		$available_sizes = $this->get_image_sizes();

		if ( is_scalar( $name ) && isset( $available_sizes[ $name ] ) ) {
			$sizes = $available_sizes[ $name ];
		}

		return $sizes;
	}

}