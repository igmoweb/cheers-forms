<?php

/**
 * Class Test_Form
 *
 * @group entry
 */
class Test_Entry extends Cheers_Forms_UnitTestCase {

	function test_get_no_entry() {
		$this->assertFalse( cheers_forms_get_entry( 1 ) );
	}

	function test_add_entry() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );

		$entry = $form->add_entry();
		$this->assertInstanceOf( 'Cheers_Forms_Entry', $entry );
	}

	function test_delete_entry() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );

		$entry = $form->add_entry();
		$form->delete_entry( $entry );

		$this->assertFalse( cheers_forms_get_entry( $entry->id ) );
	}

	function test_set_entry_values() {
		$form_id = cheers_forms_insert_form( array(
			'post_title' => 'Form title'
		) );
		$form = cheers_forms_get_form( $form_id );

		$new_field_1 = Cheers_Forms_Field_Factory::get_field( 'text' );
		$field_id_1 = $form->add_field( $new_field_1 );

		$entry = $form->add_entry( array( $field_id_1 => 'field_value' ) );

		$this->assertEquals( 'field_value', $entry->get_entry_field_value( $field_id_1 ) );

	}
}
