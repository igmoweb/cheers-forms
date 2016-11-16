<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( cheers_forms_dir() . 'core/fields/abstract-field.php' );
include_once( cheers_forms_dir() . 'core/fields/abstract-field-controller.php' );

if ( ! class_exists( 'Cheers_Forms_Field_Factory' ) ) {
	/**
	 * Class Cheers_Forms_Field_Factory
	 *
	 * Instantiate fields
	 */
	class Cheers_Forms_Field_Factory {

		/**
		 * Return an instance of a field controller
		 *
		 * @param string $type
		 * @param array $args
		 *
		 * @return bool|Cheers_Forms_Field_Controller
		 */
		public static function get_field( $type, $args = array() ) {
			$type = strtolower( $type );
			$controller_classname = 'Cheers_Forms_Field_Controller_' . ucfirst( $type );
			$field_classname = 'Cheers_Forms_Field_' . ucfirst( $type );

			$fields_path = cheers_forms_dir() . 'core/fields/';
			$controller_loaded = false;
			if ( ! class_exists( $controller_classname ) ) {
				$controller_filename = 'class-field-controller-' . $type . '.php';
				if ( is_readable( $fields_path . $controller_filename ) ) {
					include_once( $fields_path . $controller_filename );
					$controller_loaded = true;
				}
			}
			else {
				$controller_loaded = true;
			}

			$field_loaded = false;
			if ( ! class_exists( $field_classname ) ) {
				$field_filename = 'class-field-' . $type . '.php';
				if ( is_readable( $fields_path . $field_filename ) ) {
					include_once( $fields_path . $field_filename );
					$field_loaded = true;
				}
			}
			else {
				$field_loaded = true;
			}

			if ( ! $controller_loaded ) {
				return false;
			}

			if ( $field_loaded ) {
				$args['field'] = new $field_classname();
			}

			return new $controller_classname( $args );
		}
	}
}
