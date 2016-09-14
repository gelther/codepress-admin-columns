<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field {

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
	protected $default;

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
	protected $type;

	/**
	 * @var array
	 */
	protected $options;

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
	 * Help message below input field
	 *
	 * @var string
	 */
	protected $help;

	/**
	 * When value is selected the column element will be refreshed with ajax
	 *
	 * @var bool
	 */
	protected $refresh_column;

	/**
	 * @var bool
	 */
	protected $hidden;

	/**
	 * @var string
	 */
	protected $more_link;

	/**
	 *
	 * @param string $name
	 * @param null $default
	 */
	public function __construct( $name, $default = null ) {
		$this->name = $name;
		$this->default = $default;
		$this->type = 'text';
		$this->hidden = false;
		$this->refresh_column = false;
	}

	public function set_section( AC_Settings_Column_Section $section ) {
		$this->section = $section;

		return $this;
	}

	/**
	 * @return AC_Settings_Column
	 */
	protected function get_settings() {
		return $this->section->get_settings();
	}
	
	/**
	 * Wrapper for AC_Settings_Column::format_attr
	 *
	 * @param string $attribute
	 * @param null|string $name
	 *
	 * @return bool|string
	 */
	public function format_attr( $attribute, $name = null ) {
		if ( null === $name ) {
			$name = $this->name;
		}

		return $this->get_settings()->format_attr( $attribute, $name );
	}

	public function set_default( $value ) {
		$this->default = $value;
	}

	/**
	 * Return the stored value
	 *
	 * @return string|array
	 */
	public function get_value() {
		$value = $this->get_settings()->get_value( $this->get_name() );

		if ( false === $value ) {
			$value = $this->default;
		}

		return $value;
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->name;
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
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_description( $description ) {
		$this->description = $description;

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
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_label( $label ) {
		$this->label = $label;

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
	 * @param array $options
	 *
	 * return AC_Settings_Column_Field;
	 */
	public function set_options( array $options = array() ) {
		$this->options = $options;

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
		// todo: maybe start working with exceptions here when no section is present?

		$class = sprintf( 'widefat %s column-%s', $this->type, $this->name );

		if ( $this->hidden ) {
			$class .= ' hide';
		}

		$data_trigger = $this->toggle_trigger ? $this->format_attr( 'id', $this->toggle_trigger ) : '';
		$data_handle = $this->toggle_handle ? $this->format_attr( 'id', $this->toggle_handle ) : '';

		?>

		<table class="<?php echo esc_attr( $class ); ?>" data-trigger="<?php echo esc_attr( $data_trigger ); ?>" data-handle="<?php echo esc_attr( $data_handle ); ?>" data-refresh="<?php echo esc_attr( $this->refresh_column ); ?>">
			<tr>
				<?php

				$colspan = 2;

				if ( $this->label ) {
					$colspan = 1;

					$this->display_label();
				}

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

	public function display_field() {
		ac_helper()->formfield->{$this->type}( $this->to_formfield() );
	}

	public function display_label() {
		$class = 'label';

		if ( $this->description ) {
			$class .= ' description';
		}

		?>

		<td class="<?php echo esc_attr( $class ); ?>">
			<label for="<?php esc_attr( $this->format_attr( 'id' ) ); ?>">
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

	/**
	 * Converts object to array that is suitable for using with formfields
	 *
	 */
	public function to_formfield() {
		$args = array(
			'attr_name' => $this->format_attr( 'name' ),
			'attr_id'   => $this->format_attr( 'id' ),
			'value'     => $this->get_value(),
		);

		switch ( $this->type ) {
			case 'select' :
			case 'radio' :
				$args['value'] = $this->get_value();
				$args['default_value'] = $this->default;
				$args['options'] = $this->options;

				break;
		}

		return $args;
	}

}