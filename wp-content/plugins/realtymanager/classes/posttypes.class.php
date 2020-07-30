<?php
/**
 * File containing post types definitions.
 *
 * @package RealtyManager
 */

namespace RealtyManager;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


/**
 * Class PostTypes
 * @package RealtyManager\PostTypes
 */
class PostTypes {

	/**
	 * @var self
	 */
	private static $instance = null;

	/**
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'registerPostTypes' ], 0 );
		add_action( 'carbon_fields_register_fields', [$this, 'registerCustomFields'] );
	}

	/**
	 * Register all CPTs
	 */
	public function registerPostTypes() {
		if ( post_type_exists( 'realty' ) ) {
			return;
		}

		/**
		 * Post Types
		 */

		$one = __('Realty', 'rm');
		$many = __('Realty items', 'rm');
		$args = array(
		);
		$this->registerPostType('realty', 'realty', $one, $many, $args);

		$one = __('District', 'rm');
		$many = __('Districts', 'rm');
		$args = array(
			'rewrite' => array('slug' => 'districts'),
		);
		$this->registerTaxonomy('district', $one, $many, array('realty'), $args);
	}

	private function registerPostType($label, $rewrite, $one, $many, $args = array()) {
		$labels = array(
			'name' => $many,
			'singular_name' => $one,
			'menu_name' => $many,
			'parent_item_colon' => sprintf(__('Parent %s', 'rm'), $one),
			'all_items' =>  sprintf(__('All %s', 'rm'), $many),
			'add_new_item' =>  sprintf(__('Add new %s', 'rm'), $one),
			'edit_item' =>  sprintf(__('Edit %s', 'rm'), $one),
			'update_item' =>  sprintf(__('Update %s', 'rm'), $one),
			'search_items' =>  sprintf(__('Search %s', 'rm'), $many)
		);
		$defaultArgs = array(
			'label' => __($many, 'rm'),
			'labels' => $labels,
			'menu_position' => 5,
			'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions',),
			'hierarchical' => false,
			'public' => true,
			'has_archive' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
			'can_export' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'post',
			'rest_base' => $rewrite,
			'rewrite' => array(
				'slug' => $rewrite,
				'has_archive' => $rewrite,
				'pages' => true,
				'feeds' => false,
			),
		);

		$args =  array_merge( $defaultArgs, $args );

		register_post_type($label, $args);
	}

	function registerTaxonomy($label, $one, $many, $parents, $args = array()) {
		$labels = array(
			'name' => $many,
			'singular_name' => $one,
			'search_items' => sprintf(__('Search %s'), $one),
			'all_items' => sprintf(__('All %s'), $many),
			'parent_item' => sprintf(__('Parent %s'), $one),
			'parent_item_colon' => sprintf(__('Parent %s'), $one),
			'edit_item' => sprintf(__('Edit %s'), $one),
			'update_item' => sprintf(__('Update %s'), $one),
			'add_new_item' => sprintf(__('Add new %s'), $one),
			'new_item_name' => sprintf(__('New Topic %s'), $one),
			'menu_name' => sprintf(__('%s'), $many),
		);

		$defaultArgs = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
		);

		$args = array_merge($defaultArgs, $args);
		// Now register the taxonomy
		register_taxonomy($label, $parents, $args);
	}

	public function registerCustomFields() {
		$this->registerRealtyFields();
	}

	private function registerRealtyFields() {

		Container::make( 'post_meta', 'Realty Data' )
		         ->where( 'post_type', '=', 'realty' )
		         ->add_fields( array(
			         Field::make( 'text', 'rm_title', __('Building title', 'rm') ),
			         Field::make( 'text', 'rm_coordinates', __('Location', 'rm') ),
			         Field::make( 'select', 'rm_floor', __('Floors count', 'rm') )
			              ->add_options( Constants::formValuesFloors() ),
			         Field::make( 'radio', 'rm_building_type', __('Material', 'rm') )
			              ->add_options( Constants::formValuesTypes() ),
			         Field::make( 'radio', 'rm_ecological_index', __('Eco-friendliness', 'rm') )
			              ->add_options( Constants::formValuesEcologicalIndex() ),
			         Field::make( 'image', 'rm_image', __('Photo', 'rm') )
			              ->set_type('image')
			              ->set_value_type( 'id' ),
			         Field::make( 'complex', 'rm_apartment', __('Apartment', 'rm') )
				         ->set_duplicate_groups_allowed( true )
			              ->add_fields( array(
				              Field::make( 'text', 'rm_square', __('Square', 'rm') ),
				              Field::make( 'select', 'rm_rooms', __('Rooms count', 'rm') )
				                   ->add_options( Constants::formValuesRooms() ),
				              Field::make( 'radio', 'rm_balcony', __('Balcony', 'rm') )
				                   ->add_options( array(
					                   '1' => __('Yes', 'rm'),
					                   '0' => __('No','rm'),
				                   ) ),
				              Field::make( 'radio', 'rm_toilet', __('Bathroom', 'rm') )
				                   ->add_options( array(
					                   '1' => __('Yes', 'rm'),
					                   '0' => __('No','rm'),
				                   ) ),
				              Field::make( 'image', 'rm_image', __('Photo', 'rm') )
				                   ->set_type('image')
					              ->set_value_type( 'id' ),
			              ) )
		         ));
	}
}