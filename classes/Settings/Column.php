<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// todo: add a field interface maybe? display, add_field, get_field, get_fields?
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

	public function add_field( AC_Settings_Column_FieldAbstract $field ) {
		$this->fields[ $field->get_name() ] = $field;

		return $this;
	}

	public function get_field( $name ) {
		if ( ! isset( $field[ $name ] ) ) {
			return false;
		}

		return $this->fields[ $name ];
	}

	public function get_fields() {
		return $this->fields;
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	public function get_attr_name( $name ) {
		return $this->column->get_name() . '[' . $name . ']';
	}

	/**
	 * @param string $id
	 *
	 * @return string
	 */
	public function get_attr_id( $id ) {
		return implode( '-', array( 'cpac', $this->column->get_storage_model_key(), $this->column->get_name(), $id ) );
	}

	public function display() {
		foreach ( $this->fields as $field ) {
			$field->display();
		}
	}

	public function get_data() {
		return $this->data;
	}

	public function get_value( $name ) {
		return isset( $this->data[ $name ] ) ? $this->data[ $name ] : false;
	}

	/**
	 * @param array $data Column Settings
	 */
	public function set_data( $data ) {
		$this->data = $data;
	}

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

	/**
	 * Factory method for creating fields on the fly
	 *
	 * @param array $args
	 */
	public function create_field( $args = array() ) {
		$args = (object) $args;
		$type = isset( $args->type ) ? $args->type : false;
		$field = false;
		
		if ( empty( $args->name ) ) {
			return false;
		}

		// predefined class
		if ( $type ) {
			$class = 'AC_Settings_Column_Field_' . implode( array_map( 'ucfirst', explode( '_', $type ) ) );

			if ( class_exists( $class, true ) ) {
				$field = new $class;
			}
		}

		if ( ! $field ) {
			$field = new AC_Settings_Column_Field();
		}

		$field->set_settings( $this );

		foreach( $args as $key => $value ) {
			$field->set_arg( $key, $value );
		}

		$this->add_field( $field );
	}

}