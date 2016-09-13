<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field extends AC_Settings_Column_FieldAbstract {

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
	 * @var bool
	 */
	protected $section;

	/**
	 * Help message below input field
	 *
	 * @var string
	 */
	protected $help;

	/**
	 * @var bool|string|int
	 */
	protected $default_value;

	public function __construct() {
		$this->type = 'text';
		$this->hidden = false;
		$this->section = false;
	}

	/**
	 * Return the stored value
	 *
	 * @return string|array
	 */
	public function get_value() {
		$value = $this->settings->get_value( $this->get_name() );

		if ( false === $value ) {
			$value = $this->get_default_value();
		}

		return $value;
	}

	/**
	 * @return string
	 */
	public function get_type() {
		return $this->type;
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
	 * @return string
	 */
	public function get_toggle_trigger() {
		return $this->toggle_trigger;
	}

	/**
	 * @param string $toggle_trigger
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_toggle_trigger( $toggle_trigger ) {
		$this->toggle_trigger = $toggle_trigger;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_toggle_handle() {
		return $this->toggle_handle;
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
	 * @return string
	 */
	public function is_refresh_column() {
		return $this->refresh_column;
	}

	/**
	 * @param string $refresh_column
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_refresh_column( $refresh_column ) {
		$this->refresh_column = $refresh_column;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function is_hidden() {
		return $this->hidden;
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
	 * @return boolean
	 */
	public function is_section() {
		return $this->section;
	}

	/**
	 * @param boolean $section
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_section( $section ) {
		$this->section = $section;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_help() {
		return $this->help;
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

	/**
	 * @return bool|int|string
	 */
	public function get_default_value() {
		return $this->default_value;
	}

	/**
	 * @param bool|int|string $default_value
	 *
	 * @return AC_Settings_Column_Field
	 */
	public function set_default_value( $default_value ) {
		$this->default_value = $default_value;

		return $this;
	}

	public function display_field() {
		$args = $this->to_formfield();

		// todo: check if __get supports this chain
		//$method = $this->get_arg( 'type' );
		//if ( method_exists( ac_helper()->formfield, $this->get_arg( 'type' ) ) )

		switch ( $this->get_type() ) {
			case 'select' :
				ac_helper()->formfield->select( $args );
				break;
			case 'radio' :
				ac_helper()->formfield->radio( $args );
				break;
			case 'text' :
				ac_helper()->formfield->text( $args );
				break;
			case 'hidden' :
				ac_helper()->formfield->text( $args );
				break;
			case 'message' :
				ac_helper()->formfield->message( $args );
				break;
			case 'number' :
				ac_helper()->formfield->number( $args );
				break;
		}
	}



	/**
	 * @since NEWVERSION
	 */
	public function display() {
		$class = sprintf( '%s column-%s', $this->get_type(), $this->get_name() );

		if ( $this->is_hidden() ) {
			$class .= ' hide';
		}

		if ( $this->is_section() ) {
			$class .= ' section';
		}

		$data_handle = $this->get_toggle_handle() ? $this->get_attribute( 'id', $this->get_toggle_handle() ) : '';
		$data_refresh = $this->is_refresh_column() ? 1 : 0;

		?>

		<tr class="<?php echo esc_attr( $class ); ?>" data-handle="<?php echo esc_attr( $data_handle ); ?>" data-refresh="<?php echo esc_attr( $data_refresh ); ?>">
			<?php $this->display_label(); ?>

			<?php

			$data_trigger = $this->get_toggle_trigger() ? $this->get_attribute( 'id', $this->get_toggle_trigger() ) : '';
			$colspan = $this->get_label() ? 1 : 2;

			?>

			<td class="input" data-trigger="<?php echo $data_trigger; ?>" colspan="<?php echo $colspan; ?>">
				<?php $this->display_field(); ?>

				<?php if ( $this->get_help() ) : ?>
					<p class="help-msg">
						<?php echo $this->get_help(); ?>
					</p>
				<?php endif; ?>
			</td>
		</tr>

		<?php
	}

}