<?php
defined( 'ABSPATH' ) or die();

class AC_ColumnSettings_Fields extends AC_ColumnSettingsAbstract {

	public function display( $args = array() ) {
		$defaults = array(
			'label'       => '',
			'description' => '',
			'fields'      => array(),
		);
		$args = wp_parse_args( $args, $defaults );

		if ( $fields = array_filter( $args['fields'] ) ) : ?>
			<tr class="section">
				<?php $this->label( $args ); ?>
				<td class="input nopadding">
					<table class="widefat">
						<?php foreach ( $fields as $field_args ) {
							$this->display_field( $field_args );
						} ?>
					</table>
				</td>
			</tr>
			<?php
		endif;
	}

}