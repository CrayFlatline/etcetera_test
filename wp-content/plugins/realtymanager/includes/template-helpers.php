<?php
/**
 * File containing template helpers.
 *
 * @package RealtyManager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rmGetTemplate( $template_name, $args = array(), $tempate_path = '', $default_path = '', $echo = true) {

	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
	endif;

	$template_file = rmLocateTemplate( $template_name, $tempate_path, $default_path );


	if ( ! file_exists( $template_file ) ) :
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), REALTYMANAGER_VERSION );
		return "";
	endif;

	if($echo == false) {
		ob_start();
		include $template_file;
		return ob_get_clean();
	} else {
		include $template_file;
	}
}

function rmLocateTemplate( $template_name, $template_path = '', $default_path = '' ) {

	// Set variable to search in woocommerce-plugin-templates folder of theme.
	if ( ! $template_path ) :
		$template_path = 'headhunter/';
	endif;

	// Set default plugin templates path.
	if ( ! $default_path ) :
		$default_path = REALTYMANAGER_PLUGIN_DIR . '/views/'; // Path to the template folder
	endif;

	// Search template file in theme folder.
	$template = locate_template( array(
		$template_path . $template_name,
		$template_name
	) );

	// Get plugins template file.
	if ( ! $template ) :
		$template = $default_path . $template_name;
	endif;

	return apply_filters( 'rm_locate_template', $template, $template_name, $template_path, $default_path );
}

function rmPostNavigation($args = array(), $customQuery = null) {
	$navigation = '';

	$query = $customQuery ?: $GLOBALS['wp_query'];

	// Don't print empty markup if there's only one page.
	if ( $query->max_num_pages > 1 ) {
		// Make sure the nav element has an aria-label attribute: fallback to the screen reader text.
		if ( ! empty( $args['screen_reader_text'] ) && empty( $args['aria_label'] ) ) {
			$args['aria_label'] = $args['screen_reader_text'];
		}

		$paged = isset($args['paged']) ? $args['paged'] : get_query_var('paged');
		$max_page = $query->max_num_pages;

		$args = wp_parse_args(
			$args,
			array(
				'paged' => $paged,
				'current' => max( 1, $paged ),
				'total' => $max_page,
				'mid_size' => 1,
				'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i><span class="screen-reader-text">' . __( 'Previous Page', 'pool' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next Page', 'pool' ) . '</span><i class="fa fa-arrow-right" aria-hidden="true"></i>',
				'screen_reader_text' => __( 'Posts navigation' ),
				'aria_label'         => __( 'Posts' ),
			)
		);

		// Make sure we get a string back. Plain is the next best thing.
		if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
			$args['type'] = 'plain';
		}

		// Set up paginated links.
		$links = paginate_links( $args );
		if ( $links ) {
			$navigation = _navigation_markup( $links, 'pagination', $args['screen_reader_text'], $args['aria_label'] );

		}
	}
	return $navigation;
}