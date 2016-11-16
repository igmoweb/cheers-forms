<?php
/*
Plugin Name:    Cheers Forms
Plugin URI:
Description:
Version:        1.0
Author:         igmoweb
Author URI:
License:        GPL2
License URI:    https://www.gnu.org/licenses/gpl-2.0.html
Domain Path:    /languages
Text Domain:    cheers-forms
*/

/**
 * @author: Ignacio Cruz (igmoweb)
 * @version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the plugin current version
 *
 * @return string
 */
function cheers_forms_version() {
	return '1.0';
}

if ( ! class_exists( 'Cheers_Forms_Loader' ) ) {
	/**
	 * Class Cheers_Forms_Loader
	 *
	 * The plugin main loader. Initializes the plugin
	 */
	class Cheers_Forms_Loader {

		private static $instance;

		/**
		 * @var Cheers_Forms_Loader|null
		 */
		public $admin;

		/**
		 * @var Cheers_Forms_Core
		 */
		public $core;

		/**
		 * Singleton Pattern
		 *
		 * Gets the instance of the class
		 *
		 * @since 1.0
		 */
		public static function get_instance() {
			if ( empty( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			$this->includes();
			$this->init();

			add_action( 'init', array( $this, 'maybe_upgrade' ) );
		}

		private function includes() {
			if ( is_admin() ) {
				include_once 'admin/class-admin.php';
			}

			include_once 'core/class-core.php';
		}

		/**
		 * Initializes the plugin
		 */
		private function init() {
			if ( is_admin() ) {
				// Load admin only when we are in admin
				$this->admin = new Cheers_Forms_Admin();
			}

			$this->core = new Cheers_Forms_Core();
		}

		public function maybe_upgrade() {
			$saved_version = cheers_forms_get_option( 'version' );
			if ( $saved_version === cheers_forms_version() ) {
				// Nothing to upgrade
				return;
			}

			include_once( 'core/classes/class-activator.php' );

			if ( false === $saved_version ) {
				// The plugin has not been activated.
				// This usually happens on a multisite when the plugin
				// is network activated
				Cheers_Forms_Activator::activate();
				return;
			}

			Cheers_Forms_Activator::upgrade();
		}


	}

}



/**
 * Return the plugin unique instance
 *
 * @return Cheers_Forms_Loader
 */
function cheers_forms() {
	return Cheers_Forms_Loader::get_instance();
}
add_action( 'plugins_loaded', 'cheers_forms' );


/**
 * Return the plugin name slug
 *
 * @return string
 */
function cheers_forms_slug() {
	return 'cheers-forms';
}



/**
 * Return the plugin URL
 *
 * @return string
 */
function cheers_forms_url() {
	return trailingslashit( plugin_dir_url( __FILE__ ) );
}


/**
 * Return the plugin absolute path
 *
 * @return string
 */
function cheers_forms_dir() {
	return trailingslashit( plugin_dir_path( __FILE__ ) );
}

/**
 * Activate the plugin
 */
function cheers_forms_activate() {
	include_once( 'core/classes/class-activator.php' );
	Cheers_Forms_Activator::activate();
}
register_activation_hook( __FILE__, 'cheers_forms_activate' );

/**
 * Deactivate the plugin
 */
function cheers_forms_deactivate() {
	include_once( 'core/classes/class-activator.php' );
	Cheers_Forms_Activator::deactivate();
}
register_deactivation_hook( __FILE__, 'cheers_forms_activate' );

/**
 * Uninstall the plugin
 */
function cheers_forms_uninstall() {
	include_once( 'core/classes/class-activator.php' );
	Cheers_Forms_Activator::uninstall();
}
register_uninstall_hook( __FILE__, 'cheers_forms_uninstall' );