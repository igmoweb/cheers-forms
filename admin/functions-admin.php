<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @see Cheers_Forms_Admin::view()
 */
function cheers_forms_load_admin_view( $path, $args = array(), $echo = true ) {
	$plugin = cheers_forms();
	$plugin->admin->view( $path, $args, $echo );
}