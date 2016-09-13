<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class AC_Settings_Column_FieldAbstract {

	/**
	 * @var AC_Settings_Column_Section
	 */
	protected $section;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string;
	 */
	protected $label;

	/**
	 * @var string
	 */
	protected $for;

	/**
	 * A link to more, e.g. admin page for a field
	 *
	 * @var string
	 */
	protected $more_link;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * Triggers a toggle event on toggle_handle
	 *
	 * @var string
	 */
	protected $toggle_trigger;

	/**
	 * Can be used to toggle this element
	 *
	 * @var string
	 */
	protected $toggle_handle;

	/**
	 * When value is selected the column element will be refreshed with ajax
	 *
	 * @var boolean
	 */
	protected $refresh_column;

	/**
	 * @var bool
	 */
	protected $hidden;

	/**
	 * Help message below input field
	 *
	 * @var string
	 */
	protected $help;

	/**
	 * AC_Settings_Column_FieldAbstract constructor.
	 *
	 * @param $name
	 */
	public function __construct( $name, array $defaults = array() ) {
		$this->name = $name;
		$this->defaults = $defaults;
	}

	public function set_default( $value, $key = null ) {
		if ( null === $key ) {
			$key = $this->get_name();
		}

		$this->defaults[ $key ] = $value;
	}

	public function set_defaults( array $defaults ) {
		$this->defaults = $defaults;

		return $this;
	}

	public function set_section( AC_Settings_Column_Section $section ) {
		$this->section = $section;

		return $this;
	}

	protected function get_settings() {
		return $this->section->get_settings();
	}

	protected function get_column() {
		return $this->get_settings()->get_column();
	}

	public function get_attribute( $key, $value ) {
		switch ( $key ) {
			case 'id':
				return sprintf( 'cpac-%s-%s', $this->get_column()->get_name(), $value );
			case 'name':
				return sprintf( '%s[%s]', $this->get_column()->get_name(), $value );
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param $name
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_name( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * @param string $description
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_description( $description ) {
		$this->description = $description;

		return $this;
	}

	/**
	 * @param string $label
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_label( $label ) {
		$this->label = $label;

		return $this;
	}

	/**
	 * @param string $more_link
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_more_link( $more_link ) {
		$this->more_link = $more_link;

		return $this;
	}

	/**
	 * @param boolean $hidden
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_hidden( $hidden ) {
		$this->hidden = $hidden;

		return $this;
	}

	/**
	 * @param string $refresh_column
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_refresh_column( $refresh_column ) {
		$this->refresh_column = $refresh_column ? 'true' : 'false';

		return $this;
	}

	/**
	 * @param string $type
	 *
	 * return AC_Settings_Column_Field;
	 */
	public function set_type( $type ) {
		$this->type = $type;

		return $this;
	}

	/**
	 * @param string $toggle_handle
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_toggle_handle( $toggle_handle ) {
		$this->toggle_handle = $toggle_handle;

		return $this;
	}

	/**
	 * @param string $help
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_help( $help ) {
		$this->help = $help;

		return $this;
	}

	public function display() {
		$class = sprintf( 'widefat %s column-%s', $this->get_type(), $this->get_name() );

		if ( $this->hidden ) {
			$class .= ' hide';
		}

		$data_trigger = $this->toggle_trigger ? $this->get_attribute( 'id', $this->toggle_trigger ) : '';
		$data_handle = $this->toggle_handle ? $this->get_attribute( 'id', $this->toggle_handle ) : '';

		?>

		<table class="<?php echo esc_attr( $class ); ?>" data-trigger="<?php echo esc_attr( $data_trigger ); ?>" data-handle="<?php echo esc_attr( $data_handle ); ?>" data-refresh="<?php echo esc_attr( $this->refresh_column ); ?>">
			<tr>
				<?php

				if ( $this->label ) {
					$this->section->display_label( $this->label, $this->description, $this->get_name(), $this->more_link );
				}

				$colspan = $this->get_label() ? 1 : 2;

				?>

				<td class="input" colspan="<?php echo esc_attr( $colspan ); ?>">
					<?php $this->display_field(); ?>

					<?php if ( $this->help ) : ?>
						<p class="help-msg">
							<?php echo $this->help; ?>
						</p>
					<?php endif; ?>
				</td>
			</tr>
		</table>

		<?php
	}

	/**
	 * Converts object to array that is suitable for using with formfields
	 *
	 */
	public function to_formfield() {
		return wp_parse_args( $this->args, array(
			'attr_name' => $this->get_attribute( 'name', $this->name ),
			'attr_id'   => $this->get_attribute( 'id', $this->name ),
			'value'     => $this->get_value(),
		) );
	}

}