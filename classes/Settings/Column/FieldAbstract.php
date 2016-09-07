<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class AC_Settings_Column_FieldAbstract {

	/**
	 * @var CPAC_Column
	 */
	protected $column;

	/**
	 * @var AC_Settings_Column
	 */
	protected $settings;

	/**
	 * @var array
	 */
	private $attributes;

	/**
	 * @var array
	 */
	private $args;

	public function __construct() {
		$this->attributes = new AC_Settings_Column_FieldAttributes();

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
	 * This method is called to display the actual field
	 */
	abstract function display_field();

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

	public function set_arg( $key, $value ) {
		$this->args[ $key ] = $value;

		return $this;
	}

	protected function get_arg( $key ) {
		if ( ! isset( $this->args[ $key ] ) ) {
			return false;
		}

		return $this->args[ $key ];
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

	protected function get_option( $name ) {
		return $this->column->get_option( $name );
	}

	public function __call( $name, $arguments ) {
		
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->get_arg( 'name' );
	}

	/**
	 * @return string
	 */
	public function get_type() {
		return $this->get_arg( 'type' );
	}

	/**
	 * @return string
	 */
	public function get_label() {
		return stripslashes( $this->get_arg( 'label' ) );
	}

	/**
	 * @return string
	 */
	public function get_description() {
		return $this->get_arg( 'description' );
	}

	/**
	 * @return string
	 */
	public function get_help() {
		return $this->get_arg( 'help' );
	}

	/**
	 * @return string
	 */
	public function get_more_link() {
		return $this->get_arg( 'get_more_link' );
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	/*public function get_attr_name( $name = null ) {
		if ( null == $name ) {
			$name = $this->get_name();
		}

		return $this->column->get_storage_model_key() . '[' . $this->column->get_name() . '][' . $name . ']';
	}*/

	/**
	 * @param string $id
	 *
	 * @return string
	 */
	/*public function get_attr_id( $id = null ) {
		if ( null == $id ) {
			$id = $this->get_name();
		}

		return implode( '-', array( 'cpac', $this->column->get_storage_model_key(), $this->column->get_name(), $id ) );
	}*/

	/**
	 * @since NEWVERSION
	 */
	public function display() {

		// todo: refactor this, simple field properties vs get/set (hidden, trigger, etc. all attributes)
		$this
			->set_arg( 'current', $this->get_option( $this->get_name() ) )
			//->set_arg( 'attr_name', $this->get_attr_name( $this->get_name() ) )
			//->set_arg( 'attr_id', $this->get_attr_id( $this->get_name() ) )
		;

		$field = (object) $this->get_args();

		// set class attribute
		$class = "$field->type column-$field->name";

		if ( $field->hidden ) {
			$class .= ' hide';
		}

		if ( $field->section ) {
			$class .= ' section';
		}

		$data_handle = $field->toggle_handle ? $this->get_attr_id( $field->toggle_handle ) : '';
		$data_refresh = $field->refresh_column ? 1 : 0;

		?>
		<tr class="<?php echo esc( $class ); ?>" data-handle="<?php echo esc_attr( $data_handle ); ?>" data-refresh="<?php echo esc_attr( $data_refresh ); ?>">
			<?php $this->label(); ?>

			<?php

			$data_trigger = $field->toggle_trigger ? $this->get_attr_id( $field->toggle_trigger ) : '';
			$colspan = empty( $this->get_label() ) ? 2 : 1;

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

	/**
	 * @since NEWVERSION
	 *
	 * @param array $args
	 */
	public function display_label() {
		if ( ! $this->get_label() ) {
			return;
		}

		$class = 'label';

		if ( $this->get_description() ) {
			$class .= ' description';
		}

		?>
		<td class="<?php echo esc_attr( $class ); ?>">
			<label for="<?php esc_attr( $this->get_attr_id() ); ?>">
				<span class="label"><?php echo $this->get_label(); ?></span>
				<?php if ( $this->get_more_link() ) : ?>
					<a target="_blank" class="more-link" title="<?php esc_attr_e( 'View more' ); ?>" href="<?php echo esc_url( $this->get_more_link() ); ?>">
						<span class="dashicons dashicons-external"></span>
					</a>
				<?php endif; ?>
				<?php if ( $this->get_description() ) : ?>
					<p class="description"><?php echo $this->get_description(); ?></p>
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
		return array(
			'attr_name' => $this->get_attr_name(),
			'attr_id'   => $this->get_attr_id(),
		);
	}

}