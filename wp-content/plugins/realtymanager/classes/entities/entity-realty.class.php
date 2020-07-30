<?php
/**
 * File containing the Realty Entity methods.
 *
 * @package RealtyManager
 */

namespace RealtyManager\Entity;

use RealtyManager\Constants;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Entity class.
 * @abstract
 */

class Realty {
	protected $queryArgs = array();
	protected $action = 'faceted_filter';
	protected $entityName = 'realty';
	protected $fields = array();

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
		add_action( 'wp_ajax_nopriv_' . $this->action, [$this, 'processFacetedQuery'] );
		add_action( 'wp_ajax_' . $this->action, [$this, 'processFacetedQuery'] );
		add_action( 'admin_post_nopriv_' . $this->action, [$this, 'processFacetedQuery'] );
		add_action( 'admin_post_' . $this->action, [$this, 'processFacetedQuery'] );
		add_action( 'pre_get_posts', [$this, 'changePostsQuery'], 1 );
		$this->fillFields();
	}

	private function fillFields(){
		if(count($this->fields)) return;

		$this->fields = array(
			'rm_title' => '',
			'rm_building_type' => '',
			'rm_ecological_index' => '',
			'rm_square' => 'rm_apartment/',
			'rm_rooms' => 'rm_apartment/',
			'rm_balcony' => 'rm_apartment/',
			'rm_toilet' => 'rm_apartment/'
		);
	}

	public function getList($args = array()) {
		global $wp_query;

		$queryArgs = array(
			'post_type' => $this->entityName,
			'posts_per_page' => Constants::$searchItemsLimit,
			'paged' => ( get_query_var( 'paged' ) ?: 1),
			'post_status' => 'publish',
		);

		$additionalArgs = array();

		if(count($args)) {
			$additionalArgs = $this->prepareFilterArgs($args);
		}

		$this->queryArgs = array_merge($this->queryArgs, $queryArgs, $additionalArgs);
		return new \WP_Query($this->queryArgs);
	}

	public function prepareFilterArgs($queryVars) {

		$args = array(
			'meta_query' => array(),
			'tax_query' => array()
		);

		if( isset($queryVars['paged']) && $queryVars['paged'] > 0 ) {
			$args['paged'] = $queryVars['paged'];
		}

		$fieldsKeys = array_keys($this->fields);

		foreach ($queryVars as $key => $var) {
			if(in_array($key, $fieldsKeys) && $var > "") {
				$args['meta_query'][] = array(
					'key' => $this->fields[$key] . $key,
					'value' => $var
				);
			}
		}

		return $args;
	}

	public function changePostsQuery( $query ) {
		// || is_post_type_archive('realty')
		if ( is_admin() || ! $query->is_main_query() || $query->get('post_type') != "realty"){
			return $query;
		}
		$query->set('meta_key', '_rm_ecological_index');
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );

		return $query;
	}

	public function processFacetedQuery() {
		global $wp_query;

		$postArgs = $_POST;

		$result = array();


		$list = $this->getList($postArgs);

		ob_start();
		while ( $list->have_posts() ) : $list->the_post();
			get_template_part( 'template-parts/content-' . $this->entityName . '-search', get_post_format() );
		endwhile;
		$result['list'] =  ob_get_clean();

		$tmpRequestUri = $_SERVER['REQUEST_URI'];

		$_SERVER['REQUEST_URI'] = str_replace(get_site_url(), '', $_POST['current_url']);

		$navArgs = array(
			'paged' => $_POST['paged']
		);

		$result['nav'] = rmPostNavigation($navArgs, $list);

		$_SERVER['REQUEST_URI'] = $tmpRequestUri;

		wp_send_json($result);
		wp_die();
	}

}