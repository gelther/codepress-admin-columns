<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Section_Width extends AC_Settings_Column_Section {

	public function __construct() {
		parent::__construct();

		$this->add_field( new AC_Settings_Column_Field( 'width' ) );

		$options = array(
			'%'  => __( '%', 'codepress-admin-columns' ),
			'px' => __( 'px', 'codepress-admin-columns' ),
		);

		$unit = new AC_Settings_Column_Field( 'width_unit', reset( $options ) );
		$unit
			->set_type( 'radio' )
			->set_options( $options );

		$this->add_field( $unit );
	}

	public function get_width() {
		return $this->fields[ 'width' ];
	}

	public function get_unit() {
		return $this->fields[ 'unit' ];
	}

	public function display_fields() {
		?>

		<table class="widefat">
			<tr>
				<td class="input nopadding">
					<div class="description" title="<?php esc_attr_e( 'default', 'codepress-admin-columns' ); ?>">
						<input class="width" type="text" placeholder="<?php esc_attr_e( 'auto', 'codepress-admin-columns' ); ?>" name="<?php esc_attr( $this->width->format_attr( 'name' ) ); ?>" id="<?php echo esc_attr( $this->width->format_attr( 'id' ) ); ?>" value="<?php echo esc_attr( $this->width->get_value() ); ?>">
						<span class="unit"><?php echo esc_html( $this->width_unit->get_value() ); ?></span>
					</div>
					<div class="width-slider"></div>

					<div class="unit-select">
						<?php $this->width_unit->display_field(); ?>
					</div>
				</td>
			</tr>
		</table>

		<?php
	}

}