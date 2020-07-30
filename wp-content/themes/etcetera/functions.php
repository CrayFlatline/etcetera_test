<?php
/**
 * Etcetera theme functions php
 */

//add_action('wp_head', 'showTemplate');
function showTemplate() {
	global $template;
	echo ($template);
	//echo basename($template);
}


add_action( 'wp_enqueue_scripts', 'enqueueParentStyles' );

function enqueueParentStyles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/**
 * Custom excerpt function
 **/
function etcGetExcerpt($limit = 10, $post = NULL) {
	$original_excerpt = get_the_excerpt($post);
	if($limit == 0) return $original_excerpt;

	$excerpt = explode(' ', $original_excerpt, $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);

	$excerpt = wpautop($excerpt);

	return $excerpt;
}

add_action('after_setup_theme', 'etcThemeSetup' );

/**
 * Load translations for wpdocs_theme
 */
function etcThemeSetup(){
	$result = load_theme_textdomain('etc', get_stylesheet_directory() . '/languages');
}