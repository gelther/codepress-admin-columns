<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Section {

	/**
	 * @var AC_Settings_Column
	 */
	private $settings;

	/**
	 * @var AC_Settings_Column_Field[]
	 */
	private $fields;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var for
	 */
	private $for;

	/**
	 * @var string
	 */
	private $label;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * A link to more, e.g. admin page for a field
	 *
	 * @var string
	 */
	protected $more_link;

	public function __construct( $label, $name ) {
		$this->label = $label;
		$this->name = $name;
		$this->fields = array();
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
		$field->set_settings( $this->settings );
		$field->set_column( $this->settings->get_column );

		// todo: maybe start working with exceptions here? doing it wrong!

		$this->fields[ $field->get_name() ] = $field;

		return $this;
	}

	/**
	 * Access fields quickly
	 *
	 * @param $name
	 *
	 * @return AC_Settings_Column_FieldAbstract|false
	 */
	public function __get( $name ) {
		return $this->get( $name );
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

	/**
	 * @return false|AC_Settings_Column_FieldAbstract
	 */
	public function get_first_field() {
		return reset( $this->fields );
	}

	/**
	 * Return the stored value
	 *
	 * @return string|array
	 */
	public function get_values() {
		$value = $this->settings->get_value( $this->get_name() );

		if ( false === $value ) {
			$value = $this->get_default_value();
		}

		return $value;
	}

	public function display() {
		if ( ! $this->for && $this->get_first_field() ) {
			$this->for = $this->get_first_field()->get_name();
		}

		$class = 'section';

		if ( $this->name ) {
			$class .= ' ' . $this->name;
		}

		?>

		<tr class="<?php echo esc_attr( $class ); ?>">
			<?php $this->display_label( $this->label, $this->description, $this->for, $this->more_link ); ?>

			<td class="input nopadding">
				<?php

				foreach ( $this->fields as $field ) {
					$field->display();
				}

				?>
			</td>
		</tr>

		<?php
	}

	public function display_label() {
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

		<?php
	}
}