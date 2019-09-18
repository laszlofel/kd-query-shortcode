<?php

/**
 * Plugin name: KD Query Shortcode
 * Description: Query shortcode.
 * Author: Felföldi László
 * Version: 0.0.5
 * Text Domain: kd-query-shortcode
 */

class KDQueryShortcode {

	private static $instance;
	public static function getInstance() {
		if ( !( self::$instance instanceof KDQueryShortcode ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'i18n' ] );
		add_shortcode( 'kd_query_shortcode', [ $this, 'shortcode' ] );
		add_shortcode( 'kd_query_shortcode_categories', [ $this, 'shortcode_categories' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );

	}

	public function i18n() {
		load_plugin_textdomain( 'kd-query-shortcode', false, dirname( plugin_basename( __FILE__ ) ) . '/' );
	}

	public function enqueue() {
		wp_enqueue_style( 'kd_query_shortcode_style', plugins_url( 'css/style.css', __FILE__ ) );
	}

	private function strip( $content ) {

		$excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $content);
		$excerpt = apply_filters( 'the_excerpt', $excerpt );
		$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );

		return wp_strip_all_tags( $excerpt, true );

	}

	public function shortcode( $atts, $content ) {

		$atts = shortcode_atts( [
			'post_type' => 'post',
			'offset' => 0,
			'paging' => 1,
			'posts' => 10,
			'cols' => 1,
			'words' => 30,
			'read_more' => 0,
			'category' => $_REQUEST['category'] ?: false,
			'categories' => 0,
			'terms' => ''
		], $atts );

		$posts_per_page = $atts['posts'];
		$offset = $atts['offset'];
		$paged = $atts['paging'] == 0 ? 1 : max( 1, get_query_var('paged') );

		$args = [
			'post_type' => $atts['post_type'],
			'posts_per_page' => $posts_per_page,
			'offset' => ( $paged - 1 ) * $posts_per_page + $offset
		];

		if ( !empty( $atts['category'] ) ) {
			$args['category_name'] = $atts['category'];
		}

		$object = get_queried_object();
		if ( $object instanceof WP_Term ) {
			$args[ $object->taxonomy . ( $object->taxonomy == 'category' ? '_name' : '' ) ] = $object->slug;
		}

		$query = new WP_Query( $args );


		ob_start();
		include( __DIR__ . '/views/posts.php' );
		return ob_get_clean();

	}

	public function shortcode_categories( $atts ) {

		$atts = shortcode_atts( [
			'display' => 'list'
			//'images' => 0
		], $atts );

		$terms = get_categories();

		ob_start();
		include( __DIR__ . '/views/categories.php' );
		return ob_get_clean();

	}

}

KDQueryShortcode::getInstance();