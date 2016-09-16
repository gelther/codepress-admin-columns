<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.3.3
 */
class AC_Column_Post_EstimatedReadingTime extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type']  = 'column-estimated_reading_time';
		$this->properties['label'] = __( 'Estimated Reading Time', 'codepress-admin-columns' );

		$this->default_options['words_per_minute'] = 200;
	}

	private function get_words_per_minute() {
		return $this->get_option( 'words_per_minute' );
	}

	/**
	 * Estimate read time in readable format
	 *
	 * @see CPAC_Column::get_value()
	 * @since 2.3.3
	 */
	public function get_value( $post_id ) {
		$seconds = $this->get_raw_value( $post_id );

		return $seconds ? $this->convert_seconds_to_readable_time( $seconds ) : $this->get_empty_char();
	}

	/**
	 * Estimate read time in seconds
	 *
	 * @see CPAC_Column::get_raw_value()
	 * @since 2.3.3
	 */
	public function get_raw_value( $post_id ) {
		return $this->get_estimated_reading_time_in_seconds( get_post_field( 'post_content', $post_id ) );
	}

	/**
	 * @since 2.3.3
	 */
	public function convert_seconds_to_readable_time( $seconds ) {
		$time = 0;

		if ( $seconds ) {

			$minutes = floor( $seconds / 60 );
			$seconds = floor( $seconds % 60 );

			$time = $minutes;
			if ( $minutes && $seconds < 10 ) {
				$seconds = '0' . $seconds;
			}
			if ( '00' != $seconds ) {
				$time .= ':' . $seconds;
			}
			if ( $minutes < 1 ) {
				$time = $seconds . ' ' . _n( 'second', 'seconds', $seconds, 'codepress-admin-columns' );
			} else {
				$time .= ' ' . _n( 'minute', 'minutes', $minutes, 'codepress-admin-columns' );
			}
		}

		return $time;
	}

	/**
	 * @since 2.3.3
	 */
	public function get_estimated_reading_time_in_seconds( $content ) {
		$word_count = ac_helper()->string->word_count( $content );

		return $word_count ? (int) floor( ( $word_count / $this->get_words_per_minute() ) * 60 ) : 0;
	}

	public function apply_conditional() {
		return post_type_supports( $this->get_post_type(), 'editor' );
	}

	public function display_settings() {
		$this->field_settings->field( array(
			'type'        => 'text',
			'name'        => 'words_per_minute',
			'label'       => __( 'Words per minute', 'codepress-admin-columns' ),
			'description' => __( 'Estimated reading time in words per minute', 'codepress-admin-columns' ),
			'placeholder' => __( 'Enter words per minute. For example: 200' )
		) );
	}

}
