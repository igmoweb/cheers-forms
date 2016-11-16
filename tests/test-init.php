<?php

class Test_Init extends Cheers_Forms_UnitTestCase {

	function test_taxonomies() {
		$cform_post_type = get_post_type_object( 'cform' );
		$this->assertEquals( $cform_post_type->name, 'cform' );
		$this->assertFalse( $cform_post_type->public );
		$this->assertFalse( $cform_post_type->publicly_queryable );
		$this->assertFalse( $cform_post_type->has_archive );
		$this->assertFalse( $cform_post_type->rewrite );
		$this->assertTrue( $cform_post_type->exclude_from_search );
	}
}