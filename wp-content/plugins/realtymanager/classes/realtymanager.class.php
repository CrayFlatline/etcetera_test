<?php
/**
 * General class.
 *
 * @package RealtyManager
 */

namespace RealtyManager;

use RealtyManager\Entity;

class RealtyManager {

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
		require_once REALTYMANAGER_PLUGIN_DIR . '/classes/constants.class.php';
		require_once REALTYMANAGER_PLUGIN_DIR . '/classes/posttypes.class.php';
		require_once REALTYMANAGER_PLUGIN_DIR . '/classes/entities/entity-realty.class.php';

		require_once REALTYMANAGER_PLUGIN_DIR . '/classes/shortcodes.class.php';

		add_action( 'plugins_loaded', [$this, 'loadTextdomain'] );
		add_action( 'after_setup_theme', [$this, 'crbLoad' ] );
		add_action( 'widgets_init', [ $this, 'widgetsInit' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueScripts' ] );

		$this->cpt = PostTypes::instance();

		Entity\Realty::instance();
		ShortCodes::instance();
	}

	function widgetsInit() {
		require_once REALTYMANAGER_PLUGIN_DIR . '/classes/widget.class.php';
		require_once REALTYMANAGER_PLUGIN_DIR . '/classes/widgets/widget-realty-filter.class.php';

		register_sidebar( array(
			'name'          => __( 'Realty List Sidebar', 'rm' ),
			'id'            => 'sidebar-realty',
			'description'   => __( 'Widgets in this area will be shown on realty list.', 'rm' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );

	}


	function crbLoad() {
		require_once( ABSPATH . '/vendor/autoload.php' );
		\Carbon_Fields\Carbon_Fields::boot();
	}

	public function pluginActivate() {
		$this->cpt->registerPostTypes();
		flush_rewrite_rules();
	}

	public function pluginDeactivate() {
	}

	public function loadTextdomain() {
		load_plugin_textdomain( 'rm', FALSE, '/realtymanager/languages/' );
	}

	public function enqueueScripts() {
		wp_enqueue_script( 'rm_filter', REALTYMANAGER_PLUGIN_URL . '/assets/js/rm-filter.js', [ 'jquery' ], REALTYMANAGER_VERSION, true );

		$params = array (
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'rm_filter', 'params', $params );
	}
}