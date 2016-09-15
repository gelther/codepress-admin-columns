<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Section {

	/**
	 * @var AC_Settings_Column
	 */
	protected $settings;

	/**
	 * @var AC_Settings_Column_Field[]
	 */
	protected $fields;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var for
	 */
	protected $for;

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * A link to more, e.g. admin page for a field
	 *
	 * @var string
	 */
	protected $more_link;

	public function __construct() {
		$this->fields = array();
	}

	/**
	 * @param AC_Settings_Column_FieldAbstract $field
	 *
	 * @return AC_Settings_Column_FieldGroup
	 */
	public function add_field( AC_Settings_Column_Field $field ) {
		$field->set_section( $this );

		$this->fields[ $field->get_name() ] = $field;

		return $this;
	}

	/**
	 * Access fields quickly
	 *
	 * @param $name
	 *
	 * @return AC_Settings_Column_Field|false
	 */
	public function __get( $name ) {
		return $this->get_field( $name );
	}

	/**
	 *
	 * @return AC_Settings_Column
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * @param AC_Settings_Column $settings
	 *
	 * @return $this
	 */
	public function set_settings( AC_Settings_Column $settings ) {
		$this->settings = $settings;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return $this;
	 */
	public function set_name( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * @param string $label
	 *
	 * @return AC_Settings_Column_Section
	 */
	public function set_label( $label ) {
		$this->label = $label;

		return $this;
	}

	/**
	 * @return for
	 */
	public function get_for() {
		return $this->for;
	}

	/**
	 * @param string $for
	 *
	 * @return AC_Settings_Column_Section
	 */
	public function set_for( $for ) {
		$this->for = $for;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * @param string $description
	 *
	 * @return AC_Settings_Column_Section
	 */
	public function set_description( $description ) {
		$this->description = $description;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_more_link() {
		return $this->more_link;
	}

	/**
	 * @param string $more_link
	 *
	 * @return AC_Settings_Column_Section
	 */
	public function set_more_link( $more_link ) {
		$this->more_link = $more_link;

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
	 * @return AC_Settings_Column_Field[]
	 */
	public function get_fields() {
		return $this->fields;
	}

	/**
	 * @return false|AC_Settings_Column_Field
	 */
	public function get_first_field() {
		return reset( $this->fields );
	}

	/**
	 * Return the stored settings for this section
	 *
	 * @return array|false
	 */
	public function get_value( $field_name = null ) {
		$value = array();

		foreach ( $this->fields as $field ) {
			$value[ $field->get_name() ] = $field->get_value();
		}

		if ( $field_name ) {
			return isset( $value[ $field_name ] ) ? $value[ $field_name ] : false;
		}

		if ( count( $value ) === 1 ) {
			return reset( $value );
		}

		return $value;
	}

	/**
	 * Display individual fields of this sections
	 */
	public function display() {
		foreach ( $this->fields as $field ) {
			$field->display();
		}
	}

}