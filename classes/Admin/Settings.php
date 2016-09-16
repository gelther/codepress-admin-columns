<?php
defined( 'ABSPATH' ) or die();

class AC_Admin_Settings {

	public function display() {?>
		<table class="form-table cpac-form-table settings">
			<tbody>
			<tr class="general">
				<th scope="row">
					<h3><?php _e( 'General Settings', 'codepress-admin-columns' ); ?></h3>
					<p><?php _e( 'Customize your Admin Columns settings.', 'codepress-admin-columns' ); ?></p>
				</th>
				<td class="padding-22">
					<div class="cpac_general">
						<form method="post" action="options.php">
							<?php settings_fields( 'cpac-general-settings' ); ?>
							<?php $options = get_option( 'cpac_general_options' ); ?>
							<p>
								<label for="show_edit_button">
									<input name="cpac_general_options[show_edit_button]" type="hidden" value="0">
									<input name="cpac_general_options[show_edit_button]" id="show_edit_button" type="checkbox" value="1" <?php checked( ! isset( $options['show_edit_button'] ) || ( '1' == $options['show_edit_button'] ) ); ?>>
									<?php _e( "Show \"Edit Columns\" button on admin screens. Default is <code>on</code>.", 'codepress-admin-columns' ); ?>
								</label>
							</p>

							<?php do_action( 'cac/settings/general', $options ); ?>

							<p>
								<input type="submit" class="button" value="<?php _e( 'Save' ); ?>"/>
							</p>
						</form>
					</div>
				</td>
			</tr>

			<?php

			/** Allow plugins to add their own custom settings to the settings page. */
			if ( $groups = apply_filters( 'cac/settings/groups', array() ) ) {

				foreach ( $groups as $id => $group ) {

					$title       = isset( $group['title'] ) ? $group['title'] : '';
					$description = isset( $group['description'] ) ? $group['description'] : '';

					?>
					<tr>
						<th scope="row">
							<h3><?php echo esc_html( $title ); ?></h3>

							<p><?php echo $description; ?></p>
						</th>
						<td class="padding-22">
							<?php

							/** Use this Hook to add additional fields to the group */
							do_action( 'cac/settings/groups/row=' . $id );

							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<tr class="restore">
				<th scope="row">
					<h3><?php _e( 'Restore Settings', 'codepress-admin-columns' ); ?></h3>
					<p><?php _e( 'This will delete all column settings and restore the default settings.', 'codepress-admin-columns' ); ?></p>
				</th>
				<td class="padding-22">
					<form method="post">
						<?php wp_nonce_field( 'restore-all', '_cpac_nonce' ); ?>
						<input type="hidden" name="cpac_action" value="restore_all"/>
						<input type="submit" class="button" name="cpac-restore-defaults" value="<?php echo esc_attr( __( 'Restore default settings', 'codepress-admin-columns' ) ); ?>" onclick="return confirm('<?php echo esc_js( __( "Warning! ALL saved admin columns data will be deleted. This cannot be undone. 'OK' to delete, 'Cancel' to stop", 'codepress-admin-columns' ) ); ?>');"/>
					</form>
				</td>
			</tr>

			</tbody>
		</table>

		<?php
	}

}
