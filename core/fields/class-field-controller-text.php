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
	class Cheers_Forms_Field_Controller_Text extends Cheers_Forms_Field_Controller  {

		public $type = 'text';

		public function sanitize( $input ) {
			return sanitize_text_field( $input );
		}
	}
}
