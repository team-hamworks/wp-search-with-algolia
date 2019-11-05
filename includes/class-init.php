<?php
/**
 * The file that defines the core plugin class
 *
 * @author     WebDevStudios <contact@webdevstudios.com>
 * @link       https://github.com/WebDevStudios/wp-search-with-algolia/
 * @package    WebDevStudios\WPSWA\FrontEnd
 * @since      2.0.0
 */
namespace WebDevStudios\WPSWA\Bootstrap;

/**
 * The core plugin class.
 *
 * @since      2.0.0
 */
class Init {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    2.0.0
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->public_hooks();
		global $algolia;
		$algolia = \Algolia\AlgoliaSearch\SearchClient::create( '8ZQ19EMET8', '4b5a7c95112fa616d36db7ec3ed0d2fc' );
	}

	/**
	 * Require all dependencies.
	 *
	 * @since    2.0.0
	 */
	public function load_dependencies() {
		require_once __DIR__ . '/class-wp-cli.php';
		require_once __DIR__ . '/class-options.php';
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function admin_hooks() {
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 */
	public function public_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'plugins_loaded', array( $this, 'textdomain' ) );
	}

	/**
	 * Register scripts so that they can be used in other plugins outside
	 * of the context of the core features.
	 *
	 * @since    2.0.0
	 */
	public function scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_style( 'algolia-styles', WPSWA_PLUGIN_DIR_PATH . '/css/vendor/algolia' . $suffix . '.css', array(), '2.0.0', 'all' );

		wp_register_script( 'algolia-client', WPSWA_PLUGIN_DIR_PATH . '/js/vendor/algoliasearchLite' . $suffix . '.js', array(), '3.35.1', true );
		wp_register_script( 'algolia-instant-search', WPSWA_PLUGIN_DIR_PATH . '/js/vendor/instantsearch.production' . $suffix . '.js', array( 'algolia-client' ), '4.0.0', true );
		wp_register_script( 'algolia-search', WPSWA_PLUGIN_DIR_PATH . '/js/algolia-search.js', array( 'algolia-instant-search' ), '2.0.0', true );

		wp_enqueue_style( 'algolia-styles' );
		wp_enqueue_script( 'algolia-search' );
	}

	/**
	 * Register and load translation file(s).
	 *
	 * @since    2.0.0
	 */
	public function textdomain() {
		load_plugin_textdomain( 'wp-search-with-algolia', false, WPSWA_PLUGIN_DIR_PATH . '/languages' );
	}
}