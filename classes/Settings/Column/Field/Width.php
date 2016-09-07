<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Width extends AC_Settings_Column_FieldAbstract {

	public function get_width() {
		$width = $this->settings->get_value( 'width' );

		return $width > 0 ? $width : false;
	}

	public function get_width_unit() {
		$unit = $this->settings->get_value( 'width' );

		return 'px' === $unit ? 'px' : '%';
	}

	public function display_field() {
		?>
		<div class="description" title="<?php esc_attr_e( 'default', 'codepress-admin-columns' ); ?>">
			<input class="width" type="text" placeholder="<?php esc_attr_e( 'auto', 'codepress-admin-columns' ); ?>" name="<?php esc_attr( $this->get_attribute( 'name', 'width' ) ); ?>" id="<?php echo esc_attr( $this->get_attribute( 'id', 'width' ) ); ?>" value="<?php echo esc_attr( $this->get_width() ); ?>">
			<span class="unit"><?php echo esc_html( $this->get_width_unit() ); ?></span>
		</div>
		<div class="width-slider"></div>

		<div class="unit-select">
			<?php
			ac_helper()->formfield->radio( array(
				'attr_id'   => $this->get_attribute( 'id', 'width_unit' ),
				'attr_name' => $this->get_attribute( 'name', 'width_unit' ),
				'options'   => array(
					'px' => 'px',
					'%'  => '%',
				),
				'class'     => 'unit',
				'default'   => $this->get_width_unit(),
			) );
			?>
		</div>
		<?php
	}

}