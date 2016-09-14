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

	public function __construct( $label = null ) {
		$this->label = $label;
		$this->fields = array();
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
	 * @param string $description
	 *
	 * @return AC_Settings_Column_Section
	 */
	public function set_description( $description ) {
		$this->description = $description;

		return $this;
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
	 * @param string $more_link
	 *
	 * @return AC_Settings_Column_Section
	 */
	public function set_for( $for ) {
		$this->for = $for;

		return $this;
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
	 * @return array
	 */
	public function get_value() {
		$value = array();

		foreach ( $this->fields as $field ) {
			$value[ $field->get_name() ] = $field->get_value();
		}

		// todo: maybe cast to single value when only a single value is returned

		return $value;
	}

	/**
	 * Display individual fields of this sections
	 */
	protected function display_fields() {
		foreach ( $this->fields as $field ) {
			$field->display();
		}
	}

	/**
	 * Display section wrapper
	 */
	public function display() {
		// todo: maybe start working with exceptions here when no section is present?

		$class = 'section';

		if ( $this->name ) {
			$class .= ' ' . $this->name;
		}

		?>

		<tr class="<?php echo esc_attr( $class ); ?>">
			<?php

			if ( $field = $this->get_first_field() ) {
				if ( ! $this->for ) {
					$this->for = $field->get_name();
				}

				if ( ! $this->label ) {
					$this->label = $field->get_label();
					$this->description = $field->get_description();
					$this->more_link = $field->get_more_link();
				}
			}

			$class = 'label';

			if ( $this->description ) {
				$class .= ' description';
			}

			?>

			<td class="<?php echo esc_attr( $class ); ?>">
				<label for="<?php esc_attr( $this->for ); ?>">
					<span class="label"><?php echo $this->label; ?></span>
					<?php if ( $this->more_link ) : ?>
						<a target="_blank" class="more-link" title="<?php esc_attr_e( 'View more', 'codepress-admin-columns' ); ?>" href="<?php echo esc_url( $this->more_link ); ?>">
							<span class="dashicons dashicons-external"></span>
						</a>
					<?php endif; ?>
					<?php if ( $this->description ) : ?>
						<p class="description"><?php echo $this->description; ?></p>
					<?php endif; ?>
				</label>
			</td>
			<td class="input nopadding">
				<?php $this->display_fields(); ?>
			</td>
		</tr>

		<?php
	}

}