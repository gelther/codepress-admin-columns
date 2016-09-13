<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_Field_Width extends AC_Settings_Column_FieldGroup {

	public function __construct() {
		$width = new AC_Settings_Column_Field();
		$width->set_name( 'width' );

		$this->add( $width );
		$this->add( new AC_Settings_Column_Field_Width_Unit() );

		$this->for = $width->get_name();
		$this->label = __( 'Width', 'codepress-admin-columns' );
	}

	public function display() {
		$width = $this->get( 'width' );
		$unit = $this->get( 'unit' );

		?>
		<tr class="section">
			<?php $this->display_label(); ?>

			<td class="input nopadding">

				----

				<div class="description" title="<?php esc_attr_e( 'default', 'codepress-admin-columns' ); ?>">
					<input class="width" type="text" placeholder="<?php esc_attr_e( 'auto', 'codepress-admin-columns' ); ?>" name="<?php esc_attr( $this->get_attribute( 'name', $width->get_name() ) ); ?>" id="<?php echo esc_attr( $this->get_attribute( 'id', $width->get_name() ) ); ?>" value="<?php echo esc_attr( $width->get_value() ); ?>">
					<span class="unit"><?php echo esc_html( $unit->get_value() ); ?></span>
				</div>
				<div class="width-slider"></div>

				<div class="unit-select">
					<?php $unit->display_field(); ?>
				</div>

				----
			</td>
		</tr>

		<?php
	}

}