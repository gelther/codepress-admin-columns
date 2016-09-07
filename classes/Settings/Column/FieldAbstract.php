<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class AC_Settings_Column_FieldAbstract {

	/**
	 * @var AC_Settings_Column
	 */
	protected $settings;

	/**
	 * @var array
	 */
	private $args;

	public function __construct() {
		$this->args = array(
			'type'           => 'text',
			'name'           => '',
			'label'          => '', // empty label will apply colspan 2
			'description'    => '',
			'toggle_trigger' => '', // triggers a toggle event on toggle_handle
			'toggle_handle'  => '', // can be used to toggle this element
			'refresh_column' => false, // when value is selected the column element will be refreshed with ajax
			'hidden'         => false,
			'for'            => false,
			'section'        => false,
			'help'           => '', // help message below input field
			'more_link'      => '', // link to more, e.g. admin page for a field
		);

	}

	/**
	 * This method is called to display the field
	 */
	public function display_field() {
		$args = $this->to_formfield();

		switch ( $this->get_arg( 'type' ) ) {
			case 'select' :
				ac_helper()->formfield->select( $args );
				break;
			case 'radio' :
				ac_helper()->formfield->radio( $args );
				break;
			case 'text' :
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
	 * @param AC_Settings_Column $settings
	 *
	 * @since NEWVERSION
	 * @return $this
	 */
	public function set_settings( AC_Settings_Column $settings ) {
		$this->settings = $settings;

		return $this;
	}

	public function get_arg( $key ) {
		if ( ! isset( $this->args[ $key ] ) ) {
			return false;
		}

		return $this->args[ $key ];
	}

	public function set_arg( $key, $value ) {
		$this->args[ $key ] = $value;

		return $this;
	}

	/**
	 * Merge a set of arg with the current args
	 *
	 * @param array $args
	 */
	public function merge_args( array $args ) {
		$this->args = wp_parse_args( $args, $this->args );
	}

	/**
	 * Formats value based on stored field settings
	 *
	 * @param array|string $value
	 *
	 * @return string mixed
	 */
	public function format( $value ) {
		return $value;
	}

	/**
	 * @param string|int $default
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_default( $default ) {
		return $this->set_arg( 'default', $default );
	}

	/**
	 * Return the stored value
	 *
	 * @return string|array
	 */
	public function get_value() {
		return $this->settings->get_value( $this->get_arg( 'name' ) );
	}

	public function get_attribute( $key, $name = null ) {
		if ( null == $name ) {
			$name = $this->get_name();
		}

		$column = $this->settings->get_column();

		switch ( $key ) {
			case 'id':
				return sprintf( 'cpac-%s-%s', $column->get_name(), $name );
			case 'name':
				return sprintf( '%s[%s]', $column->get_name(), $name );
		}

		return false;
	}

	/**
	 * @since NEWVERSION
	 */
	public function display() {
		$field = $this->to_object();

		$class = sprintf( '%s column-%s', $this->type, $this->name );

		if ( $field->hidden ) {
			$class .= ' hide';
		}

		if ( $field->section ) {
			$class .= ' section';
		}

		$data_handle = $field->toggle_handle ? $this->get_attribute( 'id', $field->toggle_handle ) : '';
		$data_refresh = $field->refresh_column ? 1 : 0;

		?>
		<tr class="<?php echo esc( $class ); ?>" data-handle="<?php echo esc_attr( $data_handle ); ?>" data-refresh="<?php echo esc_attr( $data_refresh ); ?>">
			<?php $this->display_label( $field ); ?>

			<?php

			$data_trigger = $field->toggle_trigger ? $this->get_attribute( 'id', $field->toggle_trigger ) : '';
			$colspan = trim( $field->label ) ? 1 : 2;

			?>

			<td class="input" data-trigger="<?php echo $data_trigger; ?>" colspan="<?php echo $colspan; ?>">
				<?php $this->display_field(); ?>

				<?php if ( $field->help ) : ?>
					<p class="help-msg">
						<?php echo $field->help; ?>
					</p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * @since NEWVERSION
	 *
	 * @param array $args
	 */
	public function display_label( $field ) {
		if ( ! $field->label ) {
			return;
		}

		$class = 'label';

		if ( $field->description ) {
			$class .= ' description';
		}

		?>
		<td class="<?php echo esc_attr( $class ); ?>">
			<label for="<?php esc_attr( $this->get_attribute( 'id' ) ); ?>">
				<span class="label"><?php echo stripslashes( $field->label ); ?></span>
				<?php if ( $field->more_link ) : ?>
					<a target="_blank" class="more-link" title="<?php esc_attr_e( 'View more' ); ?>" href="<?php echo esc_url( $field->more_link ); ?>">
						<span class="dashicons dashicons-external"></span>
					</a>
				<?php endif; ?>
				<?php if ( $field->description ) : ?>
					<p class="description"><?php echo $field->description; ?></p>
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
		return wp_parse_args( $this->args, array(
			'attr_name' => $this->get_attribute( 'name' ),
			'attr_id'   => $this->get_attribute( 'id' ),
			'current'   => $this->get_value(),
		) );
	}

	/**
	 * Convert field to object
	 *
	 * @return object
	 */
	public function to_object() {
		return (object) $this->args;
	}

}