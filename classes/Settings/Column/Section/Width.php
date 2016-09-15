<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Section_Width extends AC_Settings_Column_Section {

	public function __construct() {
		parent::__construct();

		$this->set_name( 'width' );
		$this->set_label( __( 'Width', 'codepress-admin-columns' ) );

		$this->add_field( new AC_Settings_Column_Field( 'width' ) );

		$unit = new AC_Settings_Column_Field( 'width_unit', '%' );
		$unit
			->set_type( 'radio' )
			->set_options( array(
				'%'  => __( '%', 'codepress-admin-columns' ),
				'px' => __( 'px', 'codepress-admin-columns' ),
			) );

		$this->add_field( $unit );
	}

	public function display() {
		// todo: test if esc_attr_e is parsed by gulp - wpPot
		?>

		<table class="widefat">
			<tr>
				<td class="input nopadding">
					<div class="description" title="<?php esc_attr_e( 'default', 'codepress-admin-columns' ); ?>">
						<input class="width" type="text" placeholder="<?php esc_attr_e( 'auto', 'codepress-admin-columns' ); ?>" name="<?php esc_attr( $this->width->format_attr( 'name' ) ); ?>" id="<?php echo esc_attr( $this->width->format_attr( 'id' ) ); ?>" value="<?php echo esc_attr( $this->width->get_value() ); ?>">
						<span class="unit"><?php echo esc_html( $this->get_value( 'width_unit' ) ); ?></span>
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