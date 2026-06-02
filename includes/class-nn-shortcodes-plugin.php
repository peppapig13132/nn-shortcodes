<?php
/**
 * Main plugin bootstrap.
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Singleton plugin loader.
 */
final class NN_Shortcodes_Plugin {

	/**
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * @var NN_Shortcode_Registry
	 */
	private $registry;

	/**
	 * @return self
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->load_dependencies();
		$this->init_hooks();
	}

	private function load_dependencies() {
		require_once NN_SHORTCODES_PATH . 'includes/class-nn-shortcode-registry.php';
		require_once NN_SHORTCODES_PATH . 'includes/abstract-class-nn-shortcode.php';
		require_once NN_SHORTCODES_PATH . 'includes/class-nn-assets.php';
		require_once NN_SHORTCODES_PATH . 'includes/helpers.php';

		$this->registry = new NN_Shortcode_Registry();
	}

	private function init_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this->registry, 'register' ), 20 );

		$assets = new NN_Assets( $this->registry );
		$assets->init();
	}

	/**
	 * @return NN_Shortcode_Registry
	 */
	public function registry() {
		return $this->registry;
	}

	public function load_textdomain() {
		load_plugin_textdomain(
			'nn-shortcodes',
			false,
			dirname( plugin_basename( NN_SHORTCODES_FILE ) ) . '/languages'
		);
	}
}
