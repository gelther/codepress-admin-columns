<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Width extends AC_Settings_Column_FieldAbstract {

	/**
	 * @var string
	 */
	private $unit;

	/**
	 * @var int
	 */
	private $width;

	public function __construct( CPAC_Column $column ) {
		parent::__construct( $column );

		$this
			->set_unit( current( $this->get_options() ) )
			->set_name( 'width' )
			->set_label(  )
			->set_description(  );
	}

	public function get_options() {
		return array(
			'%'  => __( '%', 'codepress-admin-columns' ),
			'px' => __( 'px', 'codepress-admin-columns' ),
		);
	}

	/**
	 * @return mixed
	 */
	public function get_unit() {
		return $this->unit;
	}

	/**
	 * @param mixed $unit
	 */
	public function set_unit( $unit ) {
		$valid = $this->get_options();

		if ( ! in_array( $unit, $valid ) ) {
			$unit = current( $valid );
		}

		$this->unit = $unit;

		return $this;
	}

	/**
	 * @param int $width
	 *
	 * @return $this
	 */
	public function set_width( $width ) {
		$this->width = absint( $width );

		return $this;
	}

	/**
	 * @return int|false
	 */
	public function get_width() {
		return $this->width;

		// todo: lookup this semi-strange way of dealing with it
		return $this->width > 0 ? $this->width : false;
	}

	public function display() {
		?>

		<div class="description" title="<?php esc_attr_e( 'default', 'codepress-admin-columns' ); ?>">
			<input class="width" type="text" placeholder="<?php esc_attr_e( 'auto', 'codepress-admin-columns' ); ?>" name="<?php esc_attr( $this->get_attr_name() ); ?>" id="<?php echo esc_attr( $this->get_attr_id() ); ?>" value="<?php echo esc_attr( $this->column->get_width() ); ?>">
			<span class="unit"><?php echo esc_html( $this->column->get_width_unit() ); ?></span>
		</div>
		<div class="width-slider"></div>

		<div class="unit-select">
			<?php

			$unit = $this->column->get_width_unit();

			if ( ! $unit ) {
				$unit = '%';
			}

			ac_helper()->formfield->radio( array(
				'attr_id'   => $this->get_attr_id( 'width_unit' ),
				'attr_name' => $this->get_attr_name( 'width_unit' ),
				'options'   => array(
					'px' => 'px',
					'%'  => '%',
				),
				'class'     => 'unit',
				'default'   => $unit,
			) );

			?>
		</div>

		<?php

	}

}