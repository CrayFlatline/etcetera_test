<?php

namespace RealtyManager\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RealtyFilter extends WidgetAbstract {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_name        = __( 'Realty Filter', 'rm' );
		$this->widget_cssclass    = 'rm-widget';
		$this->widget_description = __( 'Display a filter', 'rm' );
		$this->widget_id          = 'rm_widget_filter';
		$this->settings           = [
			'title'     => [
				'type'  => 'text',
				'std'   => __( 'Realty filter', 'rm' ),
				'label' => __( 'Title', 'rm' ),
			],
		];

		parent::__construct();
	}

	/**
	 * Echoes the widget content.
	 *
	 * @see WP_Widget
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		$instance = array_merge( $this->get_default_instance(), $instance );
		$title     = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$contentArgs = array(
			'title' => $title,
		);


		$content = rmGetTemplate('front/widgets/filter.tpl.php', $contentArgs, '', '', false);

		echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$this->cacheWidget( $args, $content );
	}
}

register_widget( 'RealtyManager\Widgets\RealtyFilter' );
