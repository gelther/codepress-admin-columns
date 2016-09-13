<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column_FieldGroup extends AC_Settings_Column_FieldAbstract {

	/**
	 * @var AC_Settings_Column_FieldAbstract[]
	 */
	protected $fields;

	/**
	 * @param AC_Settings_Column_FieldAbstract $field
	 *
	 * @return AC_Settings_Column_FieldGroup
	 */
	public function add( AC_Settings_Column_Field $field ) {
		$this->fields[ $field->get_name() ] = $field;

		return $this;
	}

	/**
	 * Access fields quickly
	 *
	 * @param $name
	 *
	 * @return AC_Settings_Column_FieldAbstract|false
	 */
	public function __get( $name ) {
		return $this->get( $name );
	}

	/**
	 * @param string $name
	 *
	 * @return AC_Settings_Column_FieldAbstract|false
	 */
	public function get( $name ) {
		if ( ! isset( $this->fields[ $name ] ) ) {
			return false;
		}

		return $this->fields[ $name ];
	}

	/**
	 * @return AC_Settings_Column_FieldAbstract[]
	 */
	public function get_all() {
		return $this->fields;
	}

	public function display() {
		$fields = $this->get_all();
		$field = current( $field );

		if ( ! $this->get_for() && $field instanceof AC_Settings_Column_Field ) {
			$this->set_for( $field->get_name() );
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