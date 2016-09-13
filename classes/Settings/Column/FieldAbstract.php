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
	}

	public function get_value() {

	}

	public function display_field() {

	}

	public function display_group() {

	}

	public function display_label() {

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

	public function get_attribute( $key, $value ) {
		$column = $this->settings->get_column();

		switch ( $key ) {
			case 'id':
				return sprintf( 'cpac-%s-%s', $column->get_name(), $value );
			case 'name':
				return sprintf( '%s[%s]', $column->get_name(), $value );
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
	 * @return string
	 */
	public function get_description() {
		return trim( $this->description );
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
		return trim( stripslashes( $this->label ) );
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
	public function get_for() {
		return trim( $this->for );
	}

	/**
	 * @param string $for
	 *
	 * @return AC_Settings_Column_FieldAbstract
	 */
	public function set_for( $for ) {
		$this->for = $for;

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


	protected function display_label() {
		if ( ! $this->get_label() ) {
			return;
		}

		$description = $this->get_description();
		$more_link = $this->get_more_link();

		$class = 'label';

		if ( $description ) {
			$class .= ' description';
		}

		if ( ! $this->get_for() ) {
			$this->set_for( $this->get_name() );
		}

		?>

		<td class="<?php echo esc_attr( $class ); ?>">
			<label for="<?php esc_attr( $this->get_attribute( 'id', $this->get_for() ) ); ?>">
				<span class="label"><?php echo $this->get_label(); ?></span>
				<?php if ( $more_link ) : ?>
					<a target="_blank" class="more-link" title="<?php esc_attr_e( 'View more' ); ?>" href="<?php echo esc_url( $more_link ); ?>">
						<span class="dashicons dashicons-external"></span>
					</a>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p class="description"><?php echo $description; ?></p>
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
			'value'     => $this->get_value(),
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