<?php
defined( 'ABSPATH' ) or die();

/**
 * Custom field column, displaying the contents of meta fields.
 * Suited for all storage models supporting WordPress' default way of handling meta data.
 *
 * Supports different types of meta fields, including dates, serialized data, linked content,
 * and boolean values.
 *
 * @since 1.0
 */
abstract class AC_Column_CustomFieldAbstract extends CPAC_Column implements AC_Column_CustomFieldInterface {

	public function init() {
		parent::init();

		$this->properties['type'] = 'column-meta';
		$this->properties['label'] = __( 'Custom Field', 'codepress-admin-columns' );
		$this->properties['classes'] = 'cpac-box-metafield';
		$this->properties['group'] = __( 'Custom Field', 'codepress-admin-columns' );

		//$this->default_options['image_size'] = 'cpac-custom';
		//$this->default_options['image_size_w'] = 80;
		//$this->default_options['image_size_h'] = 80;
		//$this->default_options['excerpt_length'] = 15;

		//$fields = $this->settings()->fields();

		//$f = new AC_Settings_Column_Field_BeforeAfter( );

		//$group = new AC_Settings_Column_FieldGroup( $f );

		$section = new AC_Settings_Column_Section_Width();
		$section->width->set_default( '15' );

		$section = $this->settings()->add_section();
		$section->add_field( new AC_Settings_Column_Field_Word() );

		// Register settings field
		// TODO remove
		//$this->settings()->register_field( 'image' );
		//$this->settings()->register_field( 'link_label' );
		//$this->settings()->register_field( 'date_format' );
		//$this->settings()->register_field( 'excerpt_length' );
		//$this->settings()->add_field( new AC_Settings_Column_Field_Image() );
	}

	public function get_field_key() {
		$field = $this->get_option( 'field' );

		return substr( $field, 0, 10 ) == "cpachidden" ? str_replace( 'cpachidden', '', $field ) : $field;
	}

	/**
	 * @since 3.2.1
	 */
	public function get_field_type() {
		return $this->get_option( 'field_type' );
	}

	/**
	 * @since NEWVERSION
	 * @return bool|mixed
	 */
	public function get_field_label() {
		$field_labels = $this->get_field_labels();

		return isset( $field_labels[ $this->get_field_type() ] ) ? $field_labels[ $this->get_field_type() ] : false;
	}

	/**
	 * @since 3.2.1
	 */
	public function is_field_type( $type ) {
		return $type === $this->get_field_type();
	}

	/**
	 * @since 3.2.1
	 */
	public function is_field( $field ) {
		return $field === $this->get_field();
	}

	/**
	 * @since 3.2.1
	 */
	public function get_field() {
		return $this->get_field_key();
	}

	/**
	 * @see CPAC_Column::sanitize_options()
	 * @since 1.0
	 */
	public function sanitize_options( $options ) {
		if ( empty( $options['date_format'] ) ) {
			$options['date_format'] = get_option( 'date_format' );
		}

		return $options;
	}

	/**
	 * Get Custom FieldType Options - Value method
	 *
	 * @since 1.0
	 *
	 * @return array Custom Field types.
	 */
	public function get_field_labels() {

		$custom_field_types = array(
			'checkmark'   => __( 'Checkmark (true/false)', 'codepress-admin-columns' ),
			'color'       => __( 'Color', 'codepress-admin-columns' ),
			'count'       => __( 'Counter', 'codepress-admin-columns' ),
			'date'        => __( 'Date', 'codepress-admin-columns' ),
			'excerpt'     => __( 'Excerpt' ),
			'image'       => __( 'Image', 'codepress-admin-columns' ),
			'library_id'  => __( 'Media Library', 'codepress-admin-columns' ),
			'link'        => __( 'Url', 'codepress-admin-columns' ),
			'array'       => __( 'Multiple Values', 'codepress-admin-columns' ),
			'numeric'     => __( 'Numeric', 'codepress-admin-columns' ),
			'title_by_id' => __( 'Post Title (Post ID\'s)', 'codepress-admin-columns' ),
			'user_by_id'  => __( 'Username (User ID\'s)', 'codepress-admin-columns' ),
			'term_by_id'  => __( 'Term Name (Term ID\'s)', 'codepress-admin-columns' ),
		);

		asort( $custom_field_types );

		// Default option comes first
		$custom_field_types = array_merge( array( '' => __( 'Default', 'codepress-admin-columns' ) ), $custom_field_types );

		/**
		 * Filter the available custom field types for the meta (custom field) field
		 *
		 * @since 2.0
		 *
		 * @param array $custom_field_types Available custom field types ([type] => [label])
		 */
		$custom_field_types = apply_filters( 'cac/column/meta/types', $custom_field_types );

		return $custom_field_types;
	}

	/**
	 * @see CPAC_Column::get_raw_value()
	 * @since 2.0.3
	 */
	public function get_raw_value( $id, $single = true ) {
		$raw_value = '';

		if ( $field_key = $this->get_field_key() ) {
			$raw_value = get_metadata( $this->get_meta_type(), $id, $field_key, $single );
		}

		return apply_filters( 'cac/column/meta/raw_value', $raw_value, $id, $field_key, $this );
	}

	/**
	 * @since 2.5.6
	 */
	public function get_username_by_id( $user_id ) {
		$username = false;
		if ( $user_id && is_numeric( $user_id ) && ( $userdata = get_userdata( $user_id ) ) ) {
			$username = $userdata->display_name;
		}

		return $username;
	}

	/**
	 * @since 2.5.6
	 */
	// TODO
	/*public function get_date_by_string( $date_string ) {
		return $this->format->date( $date_string );
	}*/

	/**
	 * @see CPAC_Column::get_value()
	 * @since 1.0
	 */
	public function get_value( $id ) {
		$value = '';

		$raw_value = $this->get_raw_value( $id );
		$raw_string = ac_helper()->array->implode_recursive( ', ', $raw_value );

		switch ( $this->get_field_type() ) :
			case "image" :
			case "library_id" :
				$images = ac_helper()->string->comma_separated_to_array( $raw_string );
				$thumbnails = ac_helper()->image->get_images( $images, $this->format->image_sizes() );

				$value = implode( $thumbnails );
				break;

			case "excerpt" :
				$value = $this->settings()->get_field( 'excerpt_length' )->format( $raw_value );
				break;

			case "date" :
				$value = $this->settings()->get_field( 'date_format' )->format( $raw_value );
				break;

			case "link" :
				$value = $this->settings()->get_field( 'link_label' )->format( $raw_value );
				break;

			case "title_by_id" :
				$titles = array();
				if ( $ids = ac_helper()->string->string_to_array_integers( $raw_string ) ) {
					foreach ( (array) $ids as $id ) {
						if ( $title = ac_helper()->post->get_post_title( $id ) ) {
							$link = get_edit_post_link( $id );
							$titles[] = $link ? "<a href='" . esc_attr( $link ) . "'>{$title}</a>" : $title;
						}
					}
				}
				$value = implode( '<span class="cpac-divider"></span>', $titles );
				break;

			case "user_by_id" :
				$names = array();
				if ( $ids = ac_helper()->string->string_to_array_integers( $raw_string ) ) {
					foreach ( (array) $ids as $id ) {
						if ( $username = $this->get_username_by_id( $id ) ) {
							$link = get_edit_user_link( $id );
							$names[] = $link ? "<a href='{$link}'>{$username}</a>" : $username;
						}
					}
				}
				$value = implode( '<span class="cpac-divider"></span>', $names );
				break;

			case "term_by_id" :
				if ( is_array( $raw_value ) && isset( $raw_value['term_id'] ) && isset( $raw_value['taxonomy'] ) ) {
					$value = ac_helper()->taxonomy->display( (array) get_term_by( 'id', $raw_value['term_id'], $raw_value['taxonomy'] ) );
				}
				break;

			case "checkmark" :
				$is_true = ( ! empty( $raw_value ) && 'false' !== $raw_value && '0' !== $raw_value );

				$value = ac_helper()->icon->yes_or_no( $is_true );
				break;

			case "color" :
				$value = $raw_value && is_scalar( $raw_value ) ? ac_helper()->string->get_color_block( $raw_value ) : $this->get_empty_char();
				break;

			case "count" :
				$raw_value = $this->get_raw_value( $id, false );
				$value = $raw_value ? count( $raw_value ) : $this->get_empty_char();
				break;

			default :
				$value = $raw_string;

		endswitch;

		if ( ! $value ) {
			$value = $this->get_empty_char();
		}

		/**
		 * Filter the display value for Custom Field columns
		 *
		 * @param mixed $value Custom field value
		 * @param int $id Object ID
		 * @param object $this Column instance
		 */
		$value = apply_filters( 'cac/column/meta/value', $value, $id, $this );

		return $value;
	}

	/**
	 * @since 2.4.7
	 */
	public function get_meta_keys() {
		return $this->get_storage_model()->get_meta_keys();
	}

	private function get_grouped_field_options() {
		$grouped_options = array();

		if ( $keys = $this->get_meta_keys() ) {
			$grouped_options = array(
				'hidden' => array(
					'title'   => __( 'Hidden Custom Fields', 'codepress-admin-columns' ),
					'options' => '',
				),
				'public' => array(
					'title'   => __( 'Custom Fields', 'codepress-admin-columns' ),
					'options' => '',
				),
			);

			foreach ( $keys as $field ) {
				if ( substr( $field, 0, 10 ) == "cpachidden" ) {
					$grouped_options['hidden']['options'][ $field ] = substr( $field, 10 );
				}
				else {
					$grouped_options['public']['options'][ $field ] = $field;
				}
			}

			krsort( $grouped_options ); // public first
		}

		return $grouped_options;
	}

	/**
	 * @see CPAC_Column::display_settings()
	 * @since 1.0
	 */
	public function __display_settings() {

		// DOM can get overloaded when dropdown contains to many custom fields. Use this filter to replace the dropdown with a text input.
		if ( apply_filters( 'cac/column/meta/use_text_input', false ) ) :
			$this->settings->display_field(
				array(
					'type'        => 'text',
					'name'        => 'field',
					'label'       => __( "Custom Field", 'codepress-admin-columns' ),
					'description' => __( "Enter your custom field key.", 'codepress-admin-columns' ),
				)
			);
		else :
			$this->settings->display_field( array(
				'type'            => 'select',
				'name'            => 'field',
				'label'           => __( 'Custom Field', 'codepress-admin-columns' ),
				'description'     => __( 'Select your custom field.', 'codepress-admin-columns' ),
				'no_result'       => __( 'No custom fields available.', 'codepress-admin-columns' ) . ' ' . sprintf( __( 'Please create a %s item first.', 'codepress-admin-columns' ), '<strong>' . $this->get_storage_model()->singular_label . '</strong>' ),
				'grouped_options' => $this->get_grouped_field_options(),
			) );
		endif;

		$fields = array(
			array(
				'type'           => 'select',
				'name'           => 'field_type',
				'options'        => $this->get_field_labels(),
				'refresh_column' => true,
			),
		);

		switch ( $this->get_field_type() ) {
			case 'date' :
				$fields[] = $this->settings->date->get_args();
				break;
			case 'image' :
			case 'library_id' :
				$fields = array_merge( $fields, $this->settings->image->get_args() );
				break;
			case 'excerpt' :
				$fields[] = $this->settings->word->get_args();
				break;
			case 'link' :
				$fields[] = $this->field_settings->url_args();
				break;
		}

		$this->settings->display_fields( array(
			'label'       => __( 'Field Type', 'codepress-admin-columns' ),
			'description' => __( 'This will determine how the value will be displayed.', 'codepress-admin-columns' ) . '<em>' . __( 'Type', 'codepress-admin-columns' ) . ': ' . $this->get_field_type() . '</em>',
			'fields'      => $fields,
		) );

		$this->settings->before_after->field();
	}

	/**
	 * @since 1.0
	 *
	 * @param string $meta
	 *
	 * @return int[] Array with integers
	 */
	public function get_ids_from_meta( $meta ) {
		_deprecated_function( __METHOD__, 'AC NEWVERSION', 'ac_helper()->string->string_to_array_integers()' );

		return ac_helper()->string->string_to_array_integers( $meta );
	}

	/**
	 * Get meta by ID
	 *
	 * @since 1.0
	 *
	 * @param int $id ID
	 *
	 * @deprecated
	 * @return string Meta Value
	 */
	public function get_meta_by_id( $id ) {
		_deprecated_function( __METHOD__, 'AC NEWVERSION', 'ac_helper()->array->implode_recursive()' );

		return ac_helper()->array->implode_recursive( ', ', $this->get_raw_value( $id ) );
	}

}