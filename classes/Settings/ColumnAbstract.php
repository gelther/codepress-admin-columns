<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class AC_Settings_ColumnAbstract {

	protected $column;

	//abstract public function get_args();
	//abstract public function field();

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;
	}

	/**
	 * @since NEWVERSION
	 */
	public function display_field( $args = array() ) {
		$defaults = array(
			'type'           => 'text',
			'name'           => '',
			'label'          => '', // empty label will apply colspan 2
			'description'    => '',
			'toggle_trigger' => '', // triggers a toggle event on toggle_handle
			'toggle_handle'  => '', // can be used to toggle this element
			'refresh_column' => false, // when value is selected the column element will be refreshed with ajax
			'hidden'         => false,
			'for'            => false,
			'section'        => false,
			'help'           => '', // help message below input field
			'more_link'      => '', // link to more, e.g. admin page for a field
		);
		$args = wp_parse_args( $args, $defaults );

		$args['current'] = $this->get_option( $args['name'] );
		$args['attr_name'] = $this->get_attr_name( $args['name'] );
		$args['attr_id'] = $this->get_attr_id( $args['name'] );

		$field = (object) $args;
		?>
		<tr class="<?php echo esc_attr( $field->type ); ?> column-<?php echo esc_attr( $field->name ); ?><?php echo esc_attr( $field->hidden ? ' hide' : '' ); ?><?php echo esc_attr( $field->section ? ' section' : '' ); ?>"<?php echo $field->toggle_handle ? ' data-handle="' . esc_attr( $this->get_attr_id( $field->toggle_handle ) ) . '"' : ''; ?><?php echo $field->refresh_column ? ' data-refresh="1"' : ''; ?>>
			<?php $this->label( array( 'label' => $field->label, 'description' => $field->description, 'for' => ( $field->for ? $field->for : $field->name ), 'more_link' => $field->more_link ) ); ?>
			<td class="input"<?php echo( $field->toggle_trigger ? ' data-trigger="' . esc_attr( $this->get_attr_id( $field->toggle_trigger ) ) . '"' : '' ); ?><?php echo empty( $field->label ) ? ' colspan="2"' : ''; ?>>
				<?php
				switch ( $field->type ) {
					case 'select' :
						ac_helper()->formfield->select( $args );
						break;
					case 'radio' :
						ac_helper()->formfield->radio( $args );
						break;
					case 'text' :
						ac_helper()->formfield->text( $args );
						break;
					case 'message' :
						ac_helper()->formfield->message( $args );
						break;
					case 'number' :
						ac_helper()->formfield->number( $args );
						break;
					case 'width' :
						$this->width_field();
						break;
				}

				if ( $field->help ) : ?>
					<p class="help-msg">
						<?php echo $field->help; ?>
					</p>
				<?php endif; ?>

			</td>
		</tr>
		<?php
	}

	protected function get_option( $name ) {
		return $this->column->get_option( $name );
	}

	/**
	 * @param string $field_name
	 */
	public function attr_name( $field_name ) {
		echo esc_attr( $this->get_attr_name( $field_name ) );
	}

	/**
	 * @param string $field_name
	 *
	 * @return string Attribute name
	 */
	public function get_attr_name( $field_name ) {
		return $this->column->get_storage_model_key() . '[' . $this->column->get_name() . '][' . $field_name . ']';
	}

	/**
	 * @param string $field_key
	 *
	 * @return string Attribute Name
	 */
	public function get_attr_id( $field_name ) {
		return 'cpac-' . $this->column->get_storage_model_key() . '-' . $this->column->get_name() . '-' . $field_name;
	}

	public function attr_id( $field_name ) {
		echo esc_attr( $this->get_attr_id( $field_name ) );
	}

	/**
	 * @since NEWVERSION
	 *
	 * @param array $args
	 */
	public function label( $args = array() ) {
		$defaults = array(
			'label'       => '',
			'description' => '',
			'for'         => '',
			'more_link'   => false,
		);

		$data = (object) wp_parse_args( $args, $defaults );

		if ( $data->label ) : ?>
			<td class="label<?php echo esc_attr( $data->description ? ' description' : '' ); ?>">
				<label for="<?php $this->attr_id( $data->for ); ?>">
					<span class="label"><?php echo stripslashes( $data->label ); ?></span>
					<?php if ( $data->more_link ) : ?>
						<a target="_blank" class="more-link" title="<?php echo esc_attr( __( 'View more' ) ); ?>" href="<?php echo esc_url( $data->more_link ); ?>"><span class="dashicons dashicons-external"></span></a>
					<?php endif; ?>
					<?php if ( $data->description ) : ?><p class="description"><?php echo $data->description; ?></p><?php endif; ?>
				</label>
			</td>
			<?php
		endif;
	}

	/**
	 * @since NEWVERSION
	 */
	private function width_field() {
		?>
		<div class="description" title="<?php echo esc_attr( __( 'default', 'codepress-admin-columns' ) ); ?>">
			<input class="width" type="text" placeholder="<?php echo esc_attr( __( 'auto', 'codepress-admin-columns' ) ); ?>" name="<?php $this->attr_name( 'width' ); ?>" id="<?php $this->attr_id( 'width' ); ?>" value="<?php echo esc_attr( $this->column->get_width() ); ?>"/>
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