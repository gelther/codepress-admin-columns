<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_FieldSet extends AC_Settings_Column_FieldAbstract {

	protected $settings;

	/**
	 * @var AC_Settings_Column_FieldAbstract[]
	 */
	protected $fields;

	/**
	 * @param AC_Settings_Column_FieldAbstract $field
	 *
	 * @return AC_Settings_Column
	 */
	public function add_field( AC_Settings_Column_FieldAbstract $field ) {
		$field->set_settings( $this->settings );

		$this->fields[ $field->get_arg( 'name' ) ] = $field;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @return AC_Settings_Column_FieldAbstract|false
	 */
	public function get_field( $name ) {
		if ( ! isset( $this->fields[ $name ] ) ) {
			return false;
		}

		return $this->fields[ $name ];
	}

	/**
	 * @return AC_Settings_Column_FieldAbstract[]
	 */
	public function get_fields() {
		return $this->fields;
	}

	public function display() {
		$fields = $this->get_fields();
		$field = current( $field );

		if ( ! $this->get_arg( 'for' ) && $field instanceof AC_Settings_Column_Field ) {
			$this->set_arg( 'for', $field->get_arg( 'name' ) );
		}

		?>
		<tr class="section">
			<?php $this->display_label(); ?>

			<td class="input nopadding">
				<table class="widefat">
					<?php

					foreach ( $fields as $field ) {
						$field->display();
					}

					?>
				</table>
			</td>
		</tr>

		<?php
	}

}