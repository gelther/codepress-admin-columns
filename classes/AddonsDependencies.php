<?php
defined( 'ABSPATH' ) or die();

class AC_AddonsDependencies {

	/**
	 * @var array
	 */
	protected $dependencies = array();

	function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		add_action( 'admin_notices', array( $this, 'show_admin_notices' ), 9 );
	}

	public function init() {
		$dependencies = array(
			'cac-addon-acf'         => '2',
			'cac-addon-woocommerce' => '2',
		);
		$plugins = get_plugins();

		foreach ( $dependencies as $plugin => $min_version ) {
			$basename = cpac()->addons()->get_installed_addon_plugin_basename( $plugin );
			$version = cpac()->addons()->get_installed_addon_plugin_version( $plugin );

			if ( version_compare( $version, $min_version, 'lt' ) ) {
				if ( is_plugin_active( $basename ) ) {
					deactivate_plugins( WP_PLUGIN_DIR . "/" . cpac()->addons()->get_installed_addon_plugin_basename( $plugin ) );
					wp_redirect( $_SERVER['PHP_SELF'] );
				}
				$this->add_dependency( $plugins[ $basename ]['Name'] );
			}
		}
	}

	public function add_dependency( $name ) {
		$this->dependencies[] = wp_kses( $name, array(
			'a' => array(
				'class' => true,
				'data'  => true,
				'href'  => true,
				'id'    => true,
				'title' => true,
			),
		) );
	}

	/**
	 * @return boolean
	 */
	public function has_dependencies_missing() {
		return ! empty( $this->dependencies );
	}

	public function show_admin_notices() {
		if ( ! $this->has_dependencies_missing() ) {
			return;
		}

		$screen = get_current_screen();
		if ( 'plugins' != $screen->base ) {
			return;
		}

		foreach ( $this->dependencies as $plugin ) {
			$plugin_name = '<strong>' . $plugin . '</strong>';
			cpac_admin_message( sprintf( __( 'The plugin %s is not compatible with this version of Admin Columns Pro and has been deactivated. Please update the addon', 'codepress-admin-columns' ), $plugin_name ), 'error' );
		}
	}

}