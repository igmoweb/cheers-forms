<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Field_Controller_Text' ) ) {
	/**
	 * Class Cheers_Forms_Field_Controller_Text
	 *
	 * A text field controller
	 */
	class Cheers_Forms_Field_Controller_Radio extends Cheers_Forms_Field_Controller  {

		public $type = 'radio';

		public $radio_values = array();

		public function sanitize( $input ) {
			if ( ! in_array( $input, $this->radio_values ) ) {
				return false;
			}

			return $input;
		}
	}
}
