<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version: 1.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Form' ) ) {
	/**
	 * Class Cheers_Forms_Form
	 *
	 * Represents a form entity
	 */
	class Cheers_Forms_Form {

		/**
		 * The form (post) ID.
		 *
		 * @var int
		 */
		public $id = 0;

		/**
		 * $post Stores post data.
		 *
		 * @var $post WP_Post
		 */
		public $post;

		/**
		 * Last field ID for this form.
		 *
		 * Everytime a field is added, this value is incremented
		 * and the current id is assigned to the field
		 *
		 * @var int
		 */
		public $current_field_id = 0;

		/**
		 * Get a form instance
		 *
		 * @param int|object|WP_Post|Cheers_Forms_Form $form
		 *
		 * @return bool|Cheers_Forms_Form
		 */
		public static function get( $form ) {
			if ( isset( $form->ID ) ) {
				// Standard object|WP_Post
				$form = $form->ID;
			}

			if ( is_numeric( $form ) ) {
				$form = absint( $form );
				if ( ! $form ) {
					// Bad ID value
					return false;
				}

				$post = get_post( $form );
				if ( ! $post ) {
					// The post does not exist
					return false;
				}

				if ( 'cform' !== get_post_type( $post ) ) {
					// Only cform post type allowed
					return false;
				}

				return new self( $post );
			}
			elseif ( $form instanceof Cheers_Forms_Form ) {
				return $form;
			}

			return false;
		}

		/**
		 * Constructor gets the post object and sets the ID for the loaded form.
		 *
		 * @param WP_Post $post Post object
		 */
		private function __construct( $post ) {
			$this->post = get_post( $post );
			$this->id = $this->post->ID;

			$current_field_id = get_post_meta( $this->post->ID, '_current_field_id', true );
			$current_field_id = absint( $current_field_id );
			if ( empty( $current_field_id ) ) {
				$current_field_id = 1;
			}

			$this->current_field_id = $current_field_id;
		}

		/**
		 * __get function.
		 *
		 * @param string $key
		 * @return mixed
		 */
		public function __get( $key ) {

			if ( 'fields' === $key ) {
				return $this->get_fields();
			}

			if ( 'post' === $key ) {
				return $this->post;
			}

			$value = get_post_meta( $this->id, '_' . $key, true );

			if ( 'steps' === $key ) {
				$value = absint( $value ) ? absint( $value ) : 1;
			}

			if ( 'display_rules' === $key ) {
				$value = ( empty( $value ) || ! is_array( $value ) ) ? array() : $value;
			}

			if ( 'notifications' === $key ) {
				$value = ( empty( $value ) || ! is_array( $value ) ) ? array() : $value;
			}

			if ( false !== $value ) {
				$this->$key = $value;
			}

			return $value;
		}

		/**
		 * __set function
		 *
		 * @param $name
		 * @param $value
		 */
		function __set( $name, $value ) {
			update_post_meta( $this->id, '_' . $name, $value );
		}


		/**
		 * Return the fields list for this form
		 *
		 * @return array
		 */
		public function get_fields() {
			$_fields = get_post_meta( $this->id, '_fields', true );

			if ( ! is_array( $_fields ) ) {
				return array();
			}

			$fields = array();
			foreach ( $_fields as $key => $field ) {
				// Instantiate every field controller
				$type = $field->type;
				$args = (array)$field;
				$f = Cheers_Forms_Field_Factory::get_field( $type, $args );
				if ( $f ) {
					$f->id = $key;
					$fields[ $key ] = $f;
				}
			}

			return $fields;
		}

		/**
		 * Return the list of fields ordered by priority
		 *
		 * @return array
		 */
		public function get_fields_by_priority() {
			$fields = $this->get_fields();
			uasort( $fields, array( $this, '_sort_by_priority' ) );
			return $fields;
		}

		/**
		 * Return a list of fields in a step
		 *
		 * @param $step
		 * @param bool $sort If the fields must be sorted by priority
		 *
		 * @return array
		 */
		public function get_fields_in_step( $step, $sort = false ) {
			$fields = $this->get_fields();
			$fields =  wp_list_filter( $fields, array( 'step' => $step ) );
			if ( $sort ) {
				uasort( $fields, array( $this, '_sort_by_priority' ) );
			}
			return $fields;
		}


		/**
		 * Return a single Field controller based on its ID inside this form
		 *
		 * @param $id
		 *
		 * @return bool|mixed
		 */
		public function get_field( $id ) {
			$fields = $this->get_fields();
			return isset( $fields[ $id ] ) ? $fields[ $id ] : false;
		}


		/**
		 * Add a field to this form
		 *
		 * Field IDs are generated dinamically
		 *
		 * @param Cheers_Forms_Field_Controller $field
		 *
		 * @return bool|integer The field ID inside this form
		 */
		public function add_field( $field ) {
			if ( ! is_a( $field, 'Cheers_Forms_Field_Controller' ) ) {
				return false;
			}

			$field->id = $this->current_field_id;

			$fields = $this->get_fields();
			$fields[ $field->id ] = $field;
			update_post_meta( $this->post->ID, '_current_field_id', $this->current_field_id );

			$this->current_field_id++;

			$this->save_fields( $fields );

			return $field->id;
		}

		/**
		 * Remove a field
		 *
		 * @param integer $id
		 */
		public function remove_field( $id ) {
			$fields = $this->get_fields();
			if ( isset( $fields[ $id ] ) ) {
				unset( $fields[ $id ] );
				$this->save_fields( $fields );
			}
		}


		/**
		 * Save the list of fields into database
		 */
		public function save_fields( $fields ) {
			$_fields = array();
			foreach ( $fields as $key => $field ) {
				/** @var Cheers_Forms_Field_Controller $field */

				// Do not save the field view class, we don't need it in database
				$current_field_view = $field->get_field();
				$field->set_field( null );
				$_fields[ $key ] = $field;
				$field->set_field( $current_field_view );
			}

			update_post_meta( $this->post->ID, '_fields', $_fields );
		}

		/**
		 * @param array $args
		 *
		 * @return array
		 */
		public function get_entries( $args = array() ) {
			// @TODO
			$comments = get_comments( array( 'post_id' => $this->id ) );
			return array_map( 'cheers_forms_get_entry', $comments );
		}

		/**
		 * Insert a new entry for this form
		 *
		 * @param array $values List of fields values for this form
		 * @param array $args List of comment parameter. See wp_insert_comment()
		 *
		 * @return bool|Cheers_Forms_Entry
		 */
		public function add_entry( $values = array(), $args = array() ) {
			$args['comment_post_ID'] = $this->id;
			$comment_id = wp_insert_comment( $args );
			$entry = false;
			if ( $comment_id ) {
				$entry = cheers_forms_get_entry( $comment_id );
				// Set the fields values for this entry
				foreach ( $values as $field_id => $field_value ) {
					$field = $this->get_field( $field_id );
					if ( ! $field ) {
						// The field does not exist in this form
						continue;
					}
					$entry->set_entry_field_value( $field_id, $field_value );
				}
			}

			return $entry;
		}

		/**
		 * Delete a single entry
		 *
		 * @param Cheers_Forms_Entry|int|object $entry
		 */
		public function delete_entry( $entry ) {
			$entry = cheers_forms_get_entry( $entry );
			if ( ! $entry ) {
				return;
			}

			if ( $entry->form_id != $this->id ) {
				// Only deletion of entries for this form are allowed
				return;
			}

			wp_delete_comment( $entry->id, true );
		}

		/**
		 * Check if the form should be displayed in the current conditions
		 *
		 * @return bool|string Return true if the form can be displayed or a message in a string to show in front instead
		 */
		public function should_display() {
			$display_rules = $this->display_rules;
			// @TODO Check display rules
			$display = true;

			/**
			 * Filter if the current form should display in the current conditions
			 *
			 * @param bool $display
			 * @param int $id Form ID
			 * @param Cheers_Forms_Form $this Form object
			 */
			return apply_filters( 'cheers_forms_form_should_display', $display, $this->id, $this );
		}

		public function display() {
			$should_display = $this->should_display();
			if ( is_string( $should_display ) ) {
				?>
				<div class="cform-message error"><p><?php echo $should_display; ?></p></div>
				<?php
			}
			else {
				Cheers_Forms_Core::$load_forms_scripts = true;
				$this->load_js_templates();
				?>
				<form action="" method="post" class="cform cform-<?php echo $this->id; ?>" enctype="multipart/form-data">
					<input type="hidden" name="form_id" value="<?php echo $this->id; ?>">
					<?php wp_nonce_field( 'submit-form-' . $this->id, '_cform_nonce' ); ?>

					<div class="form-content form-content-<?php echo $this->id; ?>" data-form-id="<?php echo $this->id; ?>">
						Loading...
					</div>

					<?php
						/**
						 * Fires right before <form> tag is closed
						 *
						 * @var int $id Form ID
						 */
						do_action( 'cheers_forms_after_form', $this->id );
					?>
				</form>

				<?php

				$this->init_js();
			}
		}

		/**
		 * Load all needed JS templates for this form
		 */
		public function load_js_templates() {
			Cheers_Forms_Templates_Loader::load_step_template();

			$fields = $this->get_fields();
			foreach ( $fields as $field ) {
				Cheers_Forms_Templates_Loader::load_field_template( $field );
			}
		}

		/**
		 * Initializes JS stuff
		 */
		public function init_js() {
			$form_object = new stdClass();
			$form_object->id = $this->id;
			$form_object->steps = array();
			for ( $i = 1; $i <= $this->steps; $i++ ) {
				$form_object->steps = $this->get_fields_in_step( $i, true );
			}
			$json = wp_json_encode( $form_object );
			?>
			<script>
				jQuery( document ).ready( function( $ ) {
					CheersForms.Utils.initForm( <?php echo $json; ?> );
				});
			</script>

			<?php
			wp_enqueue_script( 'cforms', cheers_forms_url() . 'core/assets/js/cforms.js', array( 'backbone' ), true );
		}


		/**
		 * @internal
		 *
		 * @param $field_1
		 * @param $field_2
		 *
		 * @return int
		 */
		private function _sort_by_priority( $field_1, $field_2 ) {
			if ( $field_1->priority === $field_2->priority ) {
				return 0;
			}

			return ( $field_1->priority < $field_2->priority ) ? -1 : 1;
		}
	}
}

/**
 * Get a form object
 *
 * @param int|object|WP_Post|Cheers_Forms_Form $form
 *
 * @return bool|Cheers_Forms_Form
 */
function cheers_forms_get_form( $form ) {
	return Cheers_Forms_Form::get( $form );
}

/**
 * @param array $args see wp_insert_post()
 *
 * @return int|false Post ID, false in case of error
 */
function cheers_forms_insert_form( $args = array() ) {
	$args['post_type'] = 'cform';
	return wp_insert_post( $args );
}

/**
 * @param $form_id
 * @param array $args see wp_update_post()
 *
 * @return int
 */
function cheers_forms_update_form( $form_id, $args = array() ) {
	$args['ID'] = $form_id;
	return wp_update_post( $args );
}

/**
 * @param $form_id
 * @param bool $force_delete
 *
 * @return array|false|WP_Post
 */
function cheers_forms_delete_form( $form_id, $force_delete = true ) {
	return wp_delete_post( $form_id, $force_delete );
}
