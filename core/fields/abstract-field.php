<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Field' ) ) {

	abstract class Cheers_Forms_Field {

		/**
		 * Field type slug
		 *
		 * @var string
		 */
		public $type = '';

		/**
		 * Value of the field. Depending on the type, this can be any type of data
		 *
		 * @var mixed
		 */
		public $value = '';

		/**
		 * Render the front-end template
		 *
		 * @param Cheers_Forms_Field_Controller $controller
		 */
		public function render_template( $controller ) {
			$template = locate_template( 'cheers-forms/field-' . $this->type );
			if ( $template ) {
				include( $template );
				return;
			}

			$default_templates_path = cheers_forms_dir() . 'core/fields/templates/';
			if ( is_readable( $default_templates_path . 'field-' . $this->type . '.php' ) ) {
				include( $default_templates_path . 'field-' . $this->type . '.php' );
				return;
			}

			do_action( 'cheers_forms_load_field_template_failed', $this->type, $controller );
		}

		/**
		 * Renders the wp-admin form for this field
		 *
		 * @param Cheers_Forms_Field_Controller $controller
		 */
		public abstract function form( $controller );

	}
}