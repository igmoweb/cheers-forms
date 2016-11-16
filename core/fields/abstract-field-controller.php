<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Field_Controller' ) ) {
	abstract class Cheers_Forms_Field_Controller {

		/**
		 * Field type slug
		 *
		 * @var string
		 */
		public $type = '';

		/**
		 * A human readable name.
		 *
		 * It does not need to be the field label
		 * but something to show in admin
		 *
		 * @var string
		 */
		public $name = '';

		/**
		 * The field ID inside the form
		 *
		 * @var int
		 */
		public $id = 0;

		/**
		 * If the field is mandatory
		 *
		 * @var bool
		 */
		public $mandatory = false;

		/**
		 * Default value for this field
		 *
		 * @var mixed
		 */
		public $default_value = '';

		/**
		 * Error mapping array. It will be used to identify the errors
		 *
		 * @var array
		 */
		public $errors = array();

		/**
		 * Extra attributes for the field
		 *
		 * @var array
		 */
		public $attributes = array();

		/**
		 * Priority for this field
		 *
		 * @var int
		 */
		public $priority = 10;

		/**
		 * The form step number where this
		 * field will be displayed
		 */
		public $step = 1;

		/**
		 * The field class
		 *
		 * @var Cheers_Forms_Field
		 */
		private $field = false;

		public function __construct( $args = array() ) {
			foreach ( $args as $key => $value ) {
				// We don't want to overwrite type
				if ( 'type' === $key ) {
					continue;
				}

				if ( isset( $this->$key ) ) {
					$this->$key = $value;
				}
			}
		}

		/**
		 * Set the field attached to this controller
		 *
		 * @param Cheers_Forms_Field $field
		 */
		public function set_field( $field ) {
			$this->field = $field;
		}

		/**
		 * Get the field attached to this controller
		 *
		 * @return Cheers_Forms_Field|false
		 */
		public function get_field() {
			if ( is_a( $this->field, 'Cheers_Forms_Field' ) ) {
				return $this->field;
			}
			return false;
		}

		/**
		 * Get the current field value
		 *
		 * @return mixed
		 */
		public function get_value() {
			$field = $this->get_field();
			if ( $field && ! is_null( $field->value ) ) {
				return $field->value;
			}
			return $this->default_value;
		}

		/**
		 * Set the current field value
		 *
		 * @param $value
		 */
		public function set_value( $value ) {
			$field = $this->get_field();
			if ( $field ) {
				$field->value = $value;
			}
		}

		/**
		 * Render the field admin form
		 */
		public function render_form() {
			$field = $this->get_field();
			if ( $field ) {
				$field->form( $this );
			}
		}

		/**
		 * Render the field front-end template
		 */
		public function render_template() {
			$field = $this->get_field();
			if ( $field ) {
				$field->render_template( $this );
			}
		}


		/**
		 * Return the default attributes values
		 *
		 * @return array
		 */
		public function get_default_attributes() {
			return array();
		}

		/**
		 * Sanitizes the input coming from submission
		 *
		 * @param mixed $input
		 *
		 * @return mixed
		 */
		public abstract function sanitize( $input );

	}
}
