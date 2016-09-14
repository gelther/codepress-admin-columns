<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AC_Settings_Column {

	/**
	 * @var CPAC_Column
	 */
	private $column;

	/**
	 * @var AC_Settings_Column_Section[]
	 */
	private $sections;

	/**
	 * @var array
	 */
	private $data;

	public function __construct( CPAC_Column $column ) {
		$this->column = $column;
		$this->sections = array();

		$this->load_data();
	}

	/**
	 * @return CPAC_Column
	 */
	public function get_column() {
		return $this->column;
	}

	/**
	 * Access sections quickly
	 *
	 * @param $section
	 *
	 * @return AC_Settings_Column_FieldAbstract|false
	 */
	public function __get( $section ) {
		return $this->sections[ $section ];
	}

	/**
	 * Add a new section, returns the section to add fields
	 *
	 * @param AC_Settings_Column_Section|null $section
	 *
	 * @return AC_Settings_Column_Section
	 */
	public function add_section( AC_Settings_Column_Section $section = null ) {
		if ( null === $section ) {
			$section = new AC_Settings_Column_Section();
		}

		$section->set_settings( $this );

		$this->sections[ $section->get_name() ] = $section;

		return $section;
	}

	/**
	 * Display section wrapper
	 */
	public function display() {

		foreach ( $this->sections as $section ) :

			$class = 'section';

			if ( $section->get_name() ) {
				$class .= ' ' . $section->get_name();
			}

			?>

			<tr class="<?php echo esc_attr( $class ); ?>">
				<?php

				if ( $field = $section->get_first_field() ) {
					if ( ! $section->get_for() ) {
						$section->set_for( $field->get_name() );
					}

					if ( ! $section->get_label() ) {
						$section->set_label( $field->get_label() )
						        ->set_description( $field->get_description() )
						        ->set_more_link( $field->get_more_link() );
					}
				}

				$description = $section->get_description();

				$class = 'label';

				if ( $description ) {
					$class .= ' description';
				}

				?>

				<td class="<?php echo esc_attr( $class ); ?>">
					<label for="<?php esc_attr( $section->get_for() ); ?>">
						<span class="label"><?php echo $section->get_label(); ?></span>
						<?php if ( $section->get_more_link() ) : ?>
							<a target="_blank" class="more-link" title="<?php esc_attr_e( 'View more', 'codepress-admin-columns' ); ?>" href="<?php echo esc_url( $section->get_more_link() ); ?>">
								<span class="dashicons dashicons-external"></span>
							</a>
						<?php endif; ?>
						<?php if ( $description ) : ?>
							<p class="description"><?php echo $description; ?></p>
						<?php endif; ?>
					</label>
				</td>
				<td class="input nopadding">
					<?php $section->display_fields(); ?>
				</td>
			</tr>

			<?php

		endforeach;
	}

	/**
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * @param array $data Column Settings
	 */
	public function set_data( $data ) {
		$this->data = $data;
	}

	/**
	 * Set column settings data
	 */
	private function load_data() {
		$options = $this->column->get_storage_model()->get_stored_columns();

		if ( isset( $options[ $this->column->get_name() ] ) ) {
			$this->data = $options[ $this->column->get_name() ];
		}

		// TODO: make sure export still works with URL's
		// replace urls, so export will not have to deal with them
		//if ( isset( $options['label'] ) ) {
		//	$options['label'] = stripslashes( str_replace( '[cpac_site_url]', site_url(), $options['label'] ) );
		//}

		//return $options ? array_merge( $this->default_options, $options ) : $this->default_options;
	}

	/**
	 * @param $name
	 *
	 * @return array|string|false
	 */
	public function get_value( $name ) {
		return isset( $this->data[ $name ] ) ? $this->data[ $name ] : false;
	}

	/**
	 * Format attributes like name and id in a uniform way for correct processing of options and events
	 *
	 * @param string $key
	 * @param string $value
	 *
	 * @return bool|string
	 */
	public function format_attr( $attribute, $name ) {
		switch ( $attribute ) {
			case 'id':
				return sprintf( 'cpac-%s-%s', $this->column->get_name(), $name );
			case 'name':
				return sprintf( '%s[%s]', $this->column->get_name(), $name );
		}

		return false;
	}

}