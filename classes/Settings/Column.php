<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column {

	/**
	 * @var CPAC_Column
	 */
	private $column;

	/**
	 * @var AC_Settings_Column_FieldGroup
	 */
	private $fields;

	/**
	 * @var array
	 */
	private $data;

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;
		$this->fields = ( new AC_Settings_Column_FieldGroup() )->set_settings( $this );

		$this->load_data();
	}

	/**
	 * @return CPAC_Column
	 */
	public function get_column() {
		return $this->column;
	}

	/**
	 * API function to access fields
	 *
	 * @return object
	 */
	public function fields() {
		return $this->fields();
	}

	public function display() {
		foreach ( $this->fields->get_all() as $field ) {
			$field->display();
		}
	}

	/**
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * @param array $data Column Settings
	 */
	public function set_data( $data ) {
		$this->data = $data;
	}

	/**
	 * Set column settings data
	 */
	private function load_data() {
		$options = $this->column->get_storage_model()->get_stored_columns();

		if ( isset( $options[ $this->column->get_name() ] ) ) {
			$this->data = $options[ $this->column->get_name() ];
		}

		// TODO: make sure export still works with URL's
		// replace urls, so export will not have to deal with them
		//if ( isset( $options['label'] ) ) {
		//	$options['label'] = stripslashes( str_replace( '[cpac_site_url]', site_url(), $options['label'] ) );
		//}

		//return $options ? array_merge( $this->default_options, $options ) : $this->default_options;
	}

	/**
	 * @param $name
	 *
	 * @return array|string|false
	 */
	public function get_value( $name ) {
		return isset( $this->data[ $name ] ) ? $this->data[ $name ] : false;
	}

	private function register_field( $name, $args = array() ) {

		// TODO: maybe initialize all fields and use their name
		// todo: introduce a key arg that will be same like name if ommited
		switch ( $name ) {

			case 'excerpt_length' :
				$field = new AC_Settings_Column_Field_Word();
				break;

			case 'post_property_display' :
				$field = new AC_Settings_Column_Field_Post();
				break;

			case 'post_link_to' :
				$field = new AC_Settings_Column_Field_PostLink();
				break;

			case 'date_format' :
				$field = new AC_Settings_Column_Field_Date();
				break;

			case 'link_label' :
				$field = new AC_Settings_Column_Field_Url();
				break;

			case 'width' :
				$field = new AC_Settings_Column_Field_Width();
				break;

			default :
				$field = false;
		}

		if ( $field ) {
			$field->merge_args( $args );
			$this->add_field( $field );
		}
	}

}