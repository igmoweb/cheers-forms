<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Admin' ) ) {

	/**
	 * Class Cheers_Forms_Admin
	 *
	 * Manages the admin side of the plugin
	 */
	class Cheers_Forms_Admin {

		/**
		 * Save a list of Cheers_Forms_Admin_Page instances
		 * @var array
		 */
		public $pages = array();

		public function __construct() {
			$this->includes();

			add_action( 'admin_menu', array( $this, 'register_menus' ) );
		}

		private function includes() {
			include_once( 'functions-admin.php' );
			include_once( 'classes/class-admin-page.php' );
		}

		/**
		 * Register the admin menus
		 *
		 * Use $this->pages for this purpose
		 */
		public function register_menus() {
			//
		}

		/**
		 * Load an admin view inside views folder
		 *
		 * @param string $path path to the view file with no extension. Can be something like 'subset/subfolder/my-view'
		 * @param array $args List of variables to be passed to the view file
		 * @param bool $echo If return or render the content
		 *
		 * @return string
		 */
		public function view( $path, $args = array(), $echo = true ) {
			$file = cheers_forms_dir() . "admin/views/$path.php";
			$content = '';

			if ( is_file ( $file ) ) {

				ob_start();

				extract( $args );

				include( $file );

				$content = ob_get_clean();
			}

			if ( ! $echo ) {
				return $content;
			}

			echo $content;
		}
	}
}
