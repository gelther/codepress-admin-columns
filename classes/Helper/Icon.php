<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Helper_Icon {

	public function dashicon( $args = array() ) {
		$defaults = array(
			'icon'    => '',
			'title'   => '',
			'class'   => '',
			'tooltip' => '',
		);

		$data = (object) wp_parse_args( $args, $defaults );

		if ( $data->tooltip ) {
			$data->class .= ' cpac-tip';
		}

		return '<span class="dashicons dashicons-' . $data->icon . ' ' . esc_attr( trim( $data->class ) ) . '"' . ( $data->title ? ' title="' . esc_attr( $data->title ) . '"' : '' ) . '' . ( $data->tooltip ? 'data-tip="' . esc_attr( $data->tooltip ) . '"' : '' ) . '></span>';
	}

	// todo davidmosterd: I would say the yes icon just supplies 3 args but takes the same args as dashicon. Adding an option to dashicon will potentionally break all yes-no-etc. icons you plan on.
	/**
	 * @since NEWVERSION
	 * @return string
	 */
	public function yes( $tooltip = false, $title = true ) {
		if ( true === $title ) {
			$title = __( 'Yes' );
		}

		return self::dashicon( array( 'icon' => 'yes', 'class' => 'green', 'title' => $title, 'tooltip' => $tooltip ) );
	}

	/**
	 * @since NEWVERSION
	 * @return string
	 */
	public function no( $tooltip = false, $title = true ) {
		if ( true === $title ) {
			$title = __( 'No' );
		}

		return self::dashicon( array( 'icon' => 'no', 'class' => 'red', 'title' => $title, 'tooltip' => $tooltip ) );
	}

	// todo davidmosterd: rename is_true to 'test' or 'yes_if_true'? Again 2nd parameter should be args
	/**
	 * @since NEWVERSION
	 *
	 * @param bool $display
	 *
	 * @return string HTML Dashicon
	 */
	public function yes_or_no( $is_true, $tooltip = '' ) {
		return $is_true ? self::yes( $tooltip ) : self::no( $tooltip );
	}

}