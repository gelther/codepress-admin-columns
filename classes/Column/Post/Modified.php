<?php
defined( 'ABSPATH' ) or die();

/**
 * @since 2.0
 */
class AC_Column_Post_Modified extends CPAC_Column {

	public function init() {
		parent::init();

		$this->properties['type'] = 'column-modified';
		$this->properties['label'] = __( 'Last modified', 'codepress-admin-columns' );

		//$this->default_options['date_format'] = '';

		// todo: remove
		//$this->settings()->register_field( 'date_format' );
	}

	public function get_value( $post_id ) {
		$modified = $this->get_raw_value( $post_id );

		$date = $this->settings()->get_field( 'date_format' )->format( $modified );

		if ( ! $date ) {
			$date = ac_helper()->date->date( $modified ) . ' ' . ac_helper()->date->time( $modified );
		}

		return $date;
	}

	public function get_raw_value( $post_id ) {
		return get_post_field( 'post_modified', $post_id );
	}

	/*function display_settings() {


		$this->field_settings->date();
	}*/

}