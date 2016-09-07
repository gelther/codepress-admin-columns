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
	 * @var array
	 */
	private $fields;

	/**
	 * @var array
	 */
	private $data;

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;
		$this->fields = array();

		$this->load_data();
	}

	/**
	 * @return CPAC_Column
	 */
	public function get_column() {
		return $this->column;
	}

	/**
	 * @param AC_Settings_Column_FieldAbstract $field
	 *
	 * @return AC_Settings_Column
	 */
	public function add_field( AC_Settings_Column_FieldAbstract $field ) {
		$field->set_settings( $this );

		$this->fields[ $field->get_arg( 'name' ) ] = $field;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @return AC_Settings_Column_FieldAbstract|false
	 */
	public function get_field( $name ) {
		if ( ! isset( $this->fields[ $name ] ) ) {
			return false;
		}

		return $this->fields[ $name ];
	}

	/**
	 * @return AC_Settings_Column_FieldAbstract[]
	 */
	public function get_fields() {
		return $this->fields;
	}

	public function display() {
		foreach ( $this->fields as $field ) {
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
	 * @param $name
	 *
	 * @return array|string|false
	 */
	public function get_value( $name ) {
		return isset( $this->data[ $name ] ) ? $this->data[ $name ] : false;
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
	public function load_data() {
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

	public function register_field( $type, $args = array() ) {
		if ( $field = $this->get_field( $type ) ) {

			$field->merge_args( $args );

			$this->add_field( $field );
		}
	}

}