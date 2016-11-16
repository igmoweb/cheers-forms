<?php
/**
 * @author: Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cheers_Forms_Taxonomies' ) ) {
	/**
	 * Class Cheers_Forms_Taxonomies
	 *
	 * Register CPTs and taxonomies needed in Cheers Forms
	 */
	class Cheers_Forms_Taxonomies {

		/**
		 * Register Forms CPT
		 */
		public static function register_cform_cpt() {

			$labels = array(
				'name'                  => _x( 'Forms', 'Post Type General Name', 'cheers-forms' ),
				'singular_name'         => _x( 'Form', 'Post Type Singular Name', 'cheers-forms' ),
				'menu_name'             => __( 'Forms', 'cheers-forms' ),
				'name_admin_bar'        => __( 'Form', 'cheers-forms' ),
				'all_items'             => __( 'All Forms', 'cheers-forms' ),
				'add_new_item'          => __( 'Add New Form', 'cheers-forms' ),
				'add_new'               => __( 'Add New', 'cheers-forms' ),
				'new_item'              => __( 'New Form', 'cheers-forms' ),
				'edit_item'             => __( 'Edit Form', 'cheers-forms' ),
				'update_item'           => __( 'Update Form', 'cheers-forms' ),
				'view_item'             => __( 'View Form', 'cheers-forms' ),
				'search_items'          => __( 'Search Form', 'cheers-forms' ),
				'not_found'             => __( 'Not found', 'cheers-forms' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'cheers-forms' ),
				'insert_into_item'      => __( 'Insert into form', 'cheers-forms' ),
				'uploaded_to_this_item' => __( 'Uploaded to this form', 'cheers-forms' ),
				'items_list'            => __( 'Forms list', 'cheers-forms' ),
				'items_list_navigation' => __( 'Forms list navigation', 'cheers-forms' ),
				'filter_items_list'     => __( 'Filter forms list', 'cheers-forms' ),
			);
			$args   = array(
				'label'               => __( 'Form', 'cheers-forms' ),
				'description'         => __( 'Cheers Forms Form', 'cheers-forms' ),
				'labels'              => $labels,
				'supports'            => array( 'title' ),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-forms',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capability_type'     => 'page',
			);
			register_post_type( 'cform', $args );
		}
	}
}
