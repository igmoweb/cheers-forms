<?php

/**
 * Class Test_Field_Factory
 *
 * @group field
 * @group factory
 */
class Test_Field_Factory extends Cheers_Forms_UnitTestCase {

	function test_get_field() {
		$controller = Cheers_Forms_Field_Factory::get_field( 'text', array() );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Controller_Text', $controller );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Text', $controller->get_field() );

		$controller = Cheers_Forms_Field_Factory::get_field( 'checkbox', array() );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Controller_Checkbox', $controller );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Checkbox', $controller->get_field() );

		$controller = Cheers_Forms_Field_Factory::get_field( 'radio', array() );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Controller_Radio', $controller );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Radio', $controller->get_field() );

		$controller = Cheers_Forms_Field_Factory::get_field( 'text', array() );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Controller_Html', $controller );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Html', $controller->get_field() );

		$controller = Cheers_Forms_Field_Factory::get_field( 'text', array() );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Controller_Text', $controller );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Text', $controller->get_field() );

		$controller = Cheers_Forms_Field_Factory::get_field( 'text', array() );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Controller_Text', $controller );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Text', $controller->get_field() );

		$controller = Cheers_Forms_Field_Factory::get_field( 'text', array() );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Controller_Text', $controller );
		$this->assertInstanceOf( 'Cheers_Forms_Field_Text', $controller->get_field() );
	}
}