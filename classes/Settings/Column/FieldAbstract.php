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
	 * @var array
	 */
	private $attributes;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $label;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $help;

	/**
	 * @var string
	 */
	private $more_link;

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;

		$this->set_type( 'text' );

		$this->attributes = new AC_Settings_Column_FieldAttributes();

		$this->set_args( array(
			'type'           => 'text',
			//'name'           => '',
			//'label'          => '', // empty label will apply colspan 2
			//'description'    => '',
			'toggle_trigger' => '', // triggers a toggle event on toggle_handle
			'toggle_handle'  => '', // can be used to toggle this element
			'refresh_column' => false, // when value is selected the column element will be refreshed with ajax
			'hidden'         => false,
			//'for'            => false,
			'section'        => false,
			//'help'           => '', // help message below input field
			//'more_link'      => '', // link to more, e.g. admin page for a field
		) );
	}

	/**
	 * This method is called to display the actual field
	 */
	abstract function display_field();

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

	/**
	 * Display an attribute
	 *
	 * @param $type
	 */
	public function attr( $type ) {
		$method = 'get_attr_' . $type;

		if ( method_exists( array( $this, $method ) ) ) {
			esc_attr( $this->$method );
		}
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	protected function set_name( $name ) {
		$this->name = $name;

		return $this;
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
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_type( $type ) {
		$this->type = $type;

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
		$this->label = stripslashes( $label );

		return $this;
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
	public function get_help() {
		return $this->help;
	}

	/**
	 * @param string $help
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_help( $help ) {
		$this->help = $help;

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
	 * Converts object to array that is suitable for using with formfields
	 *
	 */
	public function to_formfield() {
		return array(
			'attr_name' => $this->get_attr_name(),
			'attr_id' => $this->get_attr_id(),
		);
	}

}