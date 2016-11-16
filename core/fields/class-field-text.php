<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Field_Text' ) ) {
	/**
	 * Class Cheers_Forms_Field_Controller_Text
	 *
	 * A text field controller
	 */
	class Cheers_Forms_Field_Text extends Cheers_Forms_Field {

		public $type = 'text';

		public function form( $controller ) {
			// TODO: Implement form() method.
		}
	}
}
