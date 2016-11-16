<?php

/**
 * Class Test_Form
 *
 * @group form
 */
class Test_Form extends Cheers_Forms_UnitTestCase {

	function test_get_no_form() {
		$this->assertFalse( cheers_forms_get_form( 1 ) );
	}

	function test_insert_form() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );
		$this->assertInstanceOf( 'Cheers_Forms_Form', $form );
	}

	function test_delete_form() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		cheers_forms_delete_form( $form_id );
		$form = cheers_forms_get_form( $form_id );
		$this->assertFalse( $form );
	}

	/**
	 * @group temp
	 */
	function test_add_field_to_form() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );

		$args = array(
			'mandatory' => true,
			'default_value' => 'DEFAULT',
			'errors' => array( 'error1' => 'AN ERROR' ),
			'attributes' => array( 'size' => 50 ),
			'priority' => 20,
			'step' => 2
		);
		$new_field = Cheers_Forms_Field_Factory::get_field( 'text', $args );
		$field_id = $form->add_field( $new_field );

		$this->assertEquals( 1, $field_id );
		$this->assertCount( 1, $form->get_fields() );

		$field = $form->get_field( $field_id );
		$this->assertEquals( $args['mandatory'], $field->mandatory );
		$this->assertEquals( $args['default_value'], $field->default_value );
		$this->assertEquals( $args['errors'], $field->errors );
		$this->assertEquals( $args['attributes'], $field->attributes );
		$this->assertEquals( $args['priority'], $field->priority );
		$this->assertEquals( $args['step'], $field->step );
	}

	function test_remove_field_from_form() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );
		$new_field = Cheers_Forms_Field_Factory::get_field( 'text' );
		$field_id = $form->add_field( $new_field );
		$form->remove_field( $field_id );
		$this->assertEmpty( $form->get_fields() );
	}

	function test_fields_index() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );
		$new_field_1 = Cheers_Forms_Field_Factory::get_field( 'text' );
		$field_id_1 = $form->add_field( $new_field_1 );
		$new_field_2 = Cheers_Forms_Field_Factory::get_field( 'text' );
		$field_id_2 = $form->add_field( $new_field_2 );
		$new_field_3 = Cheers_Forms_Field_Factory::get_field( 'text' );
		$field_id_3 = $form->add_field( $new_field_3 );

		$this->assertCount( 3, $form->get_fields() );
		$this->assertEquals( 4, $form->current_field_id );

		$form->remove_field( $field_id_2 );

		// The second field is removed, so is its key, it will never used again
		$expected_keys = array( 1, 3 );
		$this->assertEquals( $expected_keys, array_keys( $form->get_fields() ) );

		$new_field_4 = Cheers_Forms_Field_Factory::get_field( 'text' );
		$field_id_4 = $form->add_field( $new_field_4 );

		$expected_keys = array( 1, 3, 4 );
		$this->assertEquals( 5, $form->current_field_id );
		$this->assertEquals( $expected_keys, array_keys( $form->get_fields() ) );

	}

	function test_get_fields_in_step() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );
		$form->steps = 3;

		$new_field_1 = Cheers_Forms_Field_Factory::get_field( 'text', array( 'step' => 2 ) );
		$field_id_1 = $form->add_field( $new_field_1 );
		$new_field_2 = Cheers_Forms_Field_Factory::get_field( 'text', array( 'step' => 2 ) );
		$field_id_2 = $form->add_field( $new_field_2 );
		$new_field_3 = Cheers_Forms_Field_Factory::get_field( 'text', array( 'step' => 1 ) );
		$field_id_3 = $form->add_field( $new_field_3 );

		$fields = $form->get_fields_in_step( 2 );
		$this->assertCount( 2, $fields );

		$fields = $form->get_fields_in_step( 1 );
		$this->assertCount( 1, $fields );

		$fields = $form->get_fields_in_step( 3 );
		$this->assertCount( 0, $fields );
	}

	function test_get_fields_by_priority() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );

		$new_field_1 = Cheers_Forms_Field_Factory::get_field( 'text', array( 'priority' => 10 ) );
		$field_id_1 = $form->add_field( $new_field_1 );
		$new_field_2 = Cheers_Forms_Field_Factory::get_field( 'text', array( 'priority' => 5 ) );
		$field_id_2 = $form->add_field( $new_field_2 );
		$new_field_3 = Cheers_Forms_Field_Factory::get_field( 'text', array( 'priority' => 101 ) );
		$field_id_3 = $form->add_field( $new_field_3 );

		$fields = $form->get_fields_by_priority();
		$this->assertEquals( array( $field_id_2, $field_id_1, $field_id_3 ), array_keys( $fields ) );
	}
}
