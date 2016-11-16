<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version: 1.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Entry' ) ) {
	/**
	 * Class Cheers_Forms_Entry
	 *
	 * Represents a form entity
	 */
	class Cheers_Forms_Entry {

		/**
		 * The entry (comment) ID.
		 *
		 * @var int
		 */
		public $id = 0;

		/**
		 * The form (post) ID where this entry belongs.
		 *
		 * @var int
		 */
		public $form_id = 0;

		/**
		 * $comment Stores comment data.
		 *
		 * @var $comment WP_Comment
		 */
		public $comment = null;

		/**
		 * Get an entry instance
		 *
		 * @param int|object|WP_Comment|Cheers_Forms_Entry $entry
		 *
		 * @return bool|Cheers_Forms_Entry
		 */
		public static function get( $entry ) {
			if ( isset( $entry->comment_ID ) ) {
				// Standard object|WP_Comment
				$entry = $entry->comment_ID;
			}

			if ( is_numeric( $entry ) ) {
				$entry = absint( $entry );
				if ( ! $entry ) {
					// Bad ID value
					return false;
				}

				$comment = get_comment( $entry );
				if ( ! $comment ) {
					// The comment does not exist
					return false;
				}

				if ( 'cform' !== get_post_type( $comment->comment_post_ID ) ) {
					// Only cform post type allowed
					return false;
				}

				return new self( $comment );
			}
			elseif ( $entry instanceof Cheers_Forms_Entry ) {
				return $entry;
			}

			return false;
		}

		/**
		 * Constructor gets the post object and sets the ID for the loaded form.
		 *
		 * @param WP_Comment $comment Post object
		 */
		private function __construct( $comment ) {
			$this->comment = get_comment( $comment );
			$this->id      = $this->comment->comment_ID;
			$this->form_id = $this->comment->comment_post_ID;
		}

		/**
		 * __get function.
		 *
		 * @param string $key
		 * @return mixed
		 */
		public function __get( $key ) {
			$value = get_comment_meta( $this->id, '_' . $key, true );

			if ( false !== $value ) {
				$this->$key = $value;
			}

			return $value;
		}

		/**
		 * Return the Form object where this entry belongs
		 *
		 * @return bool|Cheers_Forms_Entry
		 */
		public function get_form() {
			return cheers_forms_get_form( $this->form_id );
		}

		/**
		 * Get the values of the form fields on this entry
		 *
		 * @return array
		 */
		public function get_entry_fields_values() {
			$form = cheers_forms_get_form( $this->form_id );
			if ( ! $form ) {
				return array();
			}

			$fields = $form->get_fields();

			$values = array();
			foreach ( $fields as $field ) {
				/** @var Cheers_Forms_Field_Controller $field */
				$entry_field_value = get_comment_meta( $this->id, '_field_' . $field->id, true );
				$values[ $field->id ] = $entry_field_value;
			}

			return $values;
		}

		/**
		 * Get the value for a single field
		 *
		 * @param $field_id
		 *
		 * @return mixed|string
		 */
		public function get_entry_field_value( $field_id ) {
			$values = $this->get_entry_fields_values();
			return isset( $values[ $field_id ] ) ? $values[ $field_id ] : '';
		}

		/**
		 * Set a value for a field
		 *
		 * @param $field_id
		 * @param $value
		 */
		public function set_entry_field_value( $field_id, $value ) {
			if ( '' !== $value ) {
				update_comment_meta( $this->id, '_field_' . $field_id, $value );
			}
			else {
				// Keep database clean
				delete_comment_meta( $this->id, '_field_' . $field_id );
			}

		}
	}
}

/**
 * Get a form object
 *
 * @param int|object|WP_Comment|Cheers_Forms_Entry $entry
 *
 * @return bool|Cheers_Forms_Entry
 */
function cheers_forms_get_entry( $entry ) {
	return Cheers_Forms_Entry::get( $entry );
}

/**
 * @param $entry
 * @param array $args see wp_update_post()
 *
 * @return int
 */
function cheers_forms_update_entry( $entry, $args = array() ) {
	$entry = cheers_forms_get_entry( $entry );
	if ( ! $entry ) {
		return false;
	}

	$args['comment_ID'] = $entry->id;
	return wp_update_comment( $args );
}

/**
 * @param $entry
 * @param bool $force_delete
 *
 * @return array|false|WP_Comment
 */
function cheers_forms_delete_entry( $entry, $force_delete = true ) {
	$entry = cheers_forms_get_entry( $entry );
	if ( ! $entry ) {
		return false;
	}
	return wp_delete_comment( $entry->id, $force_delete );
}

/**
 * Get a list of entries for a form
 *
 * @param int $form_id
 * @param array $args
 *
 * @return array
 */
function cheers_forms_get_form_entries( $form_id, $args = array() ) {
	$form = cheers_forms_get_form( $form_id );
	if ( ! $form ) {
		return array();
	}

	return $form->get_entries( $args );
}