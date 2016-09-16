<?php
defined( 'ABSPATH' ) or die();

/**
 * Base class for columns containing action links for items.
 *
 * @since 2.2.6
 */
abstract class AC_Column_ActionsAbstract extends CPAC_Column {

	/**
	 * Get a list of action links for an item (e.g. post) ID.
	 *
	 * @since 2.2.6
	 *
	 * @param int $id Item ID to get the list of actions for.
	 *
	 * @return array List of actions ([action name] => [action link]).
	 */
	abstract public function get_actions( $id );

	/**
	 * @see CPAC_Column::init()
	 * @since 2.2.6
	 */
	public function init() {
		parent::init();

		$this->properties['type']  = 'column-actions';
		$this->properties['label'] = __( 'Actions', 'codepress-admin-columns' );

		$this->default_options['use_icons'] = false;
	}

	/**
	 * @see CPAC_Column::get_value()
	 * @since 2.2.6
	 */
	public function get_value( $id ) {
		$actions = $this->get_raw_value( $id );

		if ( ! $actions ) {
			return false;
		}

		if ( $this->get_option( 'use_icons' ) ) {
			return implode( '', $this->convert_actions_to_icons( $actions ) );
		}

		$i           = 0;
		$num_actions = count( $actions );

		foreach ( $actions as $class => $action ) {
			$actions[ $class ] = '<span class="' . esc_attr( $class ) . '">' . $action . ( $i < $num_actions - 1 ? ' | ' : '' ) . '</span>';
			$i++;
		}

		return implode( '', $actions );
	}

	/**
	 * @see CPAC_Column::get_value()
	 * @since 2.2.6
	 */
	public function get_raw_value( $id ) {
		/**
		 * Filter the action links for the actions column
		 *
		 * @since 2.2.9
		 *
		 * @param array $actions List of actions ([action name] => [action link]).
		 * @param AC_Column_Actions $column_instance Column object.
		 * @param int $id Post/User/Comment ID
		 */
		return apply_filters( 'cac/column/actions/action_links', $this->get_actions( $id ), $this, $id );
	}

	/**
	 * @see CPAC_Column::display_settings()
	 * @since 2.2.6
	 */
	public function display_settings() {
		parent::display_settings();

		// Use icons
		$this->field_settings->field( array(
			'type'        => 'radio',
			'name'        => 'use_icons',
			'label'       => __( 'Use icons?', 'codepress-admin-columns' ),
			'description' => __( 'Use icons instead of text for displaying the actions.', 'codepress-admin-columns' ),
			'options'     => array(
				'1' => __( 'Yes' ),
				''  => __( 'No' ),
			),
			'default'     => '',
		) );
	}

	/**
	 * Convert items from a list of action links to icons (if they have an icon).
	 *
	 * @since 2.2.6
	 *
	 * @param array $actions List of actions ([action name] => [action link]).
	 *
	 * @return array List of actions ([action name] => [action icon link]).
	 */
	public function convert_actions_to_icons( $actions ) {
		$icons = $this->get_actions_icons();

		foreach ( $actions as $action => $link ) {
			$action1  = $action;
			$spacepos = $spacepos = strpos( $action1, ' ' );

			if ( $spacepos !== false ) {
				$action1 = substr( $action1, 0, $spacepos );
			}

			if ( isset( $icons[ $action1 ] ) ) {
				// Add mandatory "class" HTML attribute
				if ( strpos( $link, 'class=' ) === false ) {
					$link = str_replace( '<a ', '<a class="" ', $link );
				}

				// Add icon and tooltip classes
				$link = preg_replace( '/class=["\'](.*?)["\']/', 'class="$1 cpac-tip button cpac-button-action dashicons hide-content dashicons-' . $icons[ $action1 ] . '"', $link, 1 );

				// Add tooltip title
				$link = preg_replace_callback( '/>(.*?)<\/a>/', array( $this, 'add_link_tooltip' ), $link );

				$actions[ $action ] = $link;
			}
		}

		return $actions;
	}

	/**
	 * Add the tooltip data attribute to the link
	 * Callback for preg_replace_callback
	 *
	 * @since 2.2.6.1
	 *
	 * @param array $matches Matches information from preg_replace_callback
	 *
	 * @return string Link part with tooltip attribute
	 */
	public function add_link_tooltip( $matches ) {
		return ' data-tip="' . esc_attr( $matches[1] ) . '">' . $matches[1] . '</a>';
	}

	/**
	 * Get a list of action names and their corresponding dashicons.
	 *
	 * @since 2.2.6
	 *
	 * @return array List of actions and icons ([action] => [dashicon]).
	 */
	public function get_actions_icons() {
		return array(
			'edit'      => 'edit',
			'delete'    => 'trash',
			'untrash'   => 'undo',
			'unspam'    => 'undo',
			'view'      => 'visibility',
			'inline'    => 'welcome-write-blog',
			'quickedit' => 'welcome-write-blog',
			'approve'   => 'yes',
			'unapprove' => 'no',
			'reply'     => 'testimonial',
			'trash'     => 'trash',
			'spam'      => 'welcome-comments',
		);
	}

}
