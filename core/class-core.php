<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Core' ) ) {

	/**
	 * Class Cheers_Forms_Core
	 */
	class Cheers_Forms_Core {

		public static $load_forms_scripts = false;

		public function __construct() {
			$this->includes();
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'wp_footer', array( $this, 'maybe_load_forms_scripts' ) );
		}

		private function includes() {
			include_once 'helpers/helpers-options.php';
			include_once 'classes/class-form.php';
			include_once 'classes/class-entry.php';
			include_once 'classes/class-taxonomies.php';
			include_once 'classes/class-field-factory.php';
			include_once 'classes/class-templates-loader.php';
		}

		public function init() {
			// Register taxonomies
			Cheers_Forms_Taxonomies::register_cform_cpt();

			do_action( 'cheers_forms_init' );
		}

		/**
		 * If a Form has been displayed we need to load the scripts
		 */
		public function maybe_load_forms_scripts() {
			if ( self::$load_forms_scripts ) {
				wp_enqueue_script( 'cforms', cheers_forms_url() . 'core/assets/js/cforms.js', array( 'backbone' ), '' );
			}

		}

	}
}
