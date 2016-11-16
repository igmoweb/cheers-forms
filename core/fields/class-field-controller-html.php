<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Field_Controller_Html' ) ) {
	/**
	 * Class Cheers_Forms_Field_Controller_Text
	 *
	 * A text field controller
	 */
	class Cheers_Forms_Field_Controller_Html extends Cheers_Forms_Field_Controller  {

		public $type = 'html';

		public function sanitize( $input ) {
			return '';
		}
	}
}
