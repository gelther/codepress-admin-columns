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

		$this->set_fields();
		$this->load_data();
	}

	/**
	 * @return $this
	 */
	protected function set_fields() {
		$fields = new AC_Settings_Column_FieldGroup();
		$fields->set_settings( $this );

		$this->fields = $fields;

		return $this;
	}

	/**
	 * @return CPAC_Column
	 */
	public function get_column() {
		return $this->column;
	}

	public function add( $field ) {
		foreach ( $field->settings() as $setting ) {

		}

		$this->fields[ $field->get_name() ] = $field;

		return $this;
	}

	/**
	 * API function to access fields
	 *
	 * @return AC_Settings_Column_FieldGroup
	 */
	// todo: maybe return the actual fields instead of the container object and use get_fields to return the fields object?
	public function fields() {
		return $this->fields;
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

	/**
	 * Access sections quickly
	 *
	 * @param $section
	 *
	 * @return AC_Settings_Column_FieldAbstract|false
	 */
	public function __get( $section ) {
		return $this->sections[ $section ];
	}

	/**
	 * Add a new section, returns the section to add fields
	 *
	 * @param array $args
	 *
	 * @return AC_Settings_Column_FieldGroup
	 */
	public function add_section( $label, $name ) {
		$section = new AC_Settings_Column_Section( $label, $name );
		$section->set_settings( $this );

		$this->sections[] = $section;

		return $section;
	}

}