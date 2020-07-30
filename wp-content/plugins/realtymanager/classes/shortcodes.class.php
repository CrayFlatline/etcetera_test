<?php
/**
 * File containing shortcodes definitions.
 *
 * @package RealtyManager
 */

namespace RealtyManager;

class ShortCodes {
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

	public function __construct() {
		add_shortcode('rm_search_filter', [$this, 'searchFilter']);
	}

	function searchFilter() {
		global $wp;
		$formArgs = array(
			'page' => ( get_query_var( 'paged' ) ?: 1),
			'currentUrl' => home_url(add_query_arg(array(), $wp->request)),
			'submitUrl' => admin_url('admin-post.php')
		);
		$contentArgs = array(
			'form' => rmGetTemplate('front/forms/filter.tpl.php', $formArgs, '', '', false),
		);
		return rmGetTemplate('front/shortcodes/realty-filter.tpl.php', $contentArgs, '', '', false);
	}
}