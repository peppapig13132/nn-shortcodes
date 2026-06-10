<?php
/**
 * Conditional asset loading for shortcodes present on the page.
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Asset manager.
 */
class NN_Assets {

	/**
	 * Shortcodes that rendered during this request.
	 *
	 * @var array<string, NN_Shortcode>
	 */
	private static $queued = array();

	/**
	 * @var NN_Shortcode_Registry
	 */
	private $registry;

	/**
	 * @param NN_Shortcode_Registry $registry Registry instance.
	 */
	public function __construct( NN_Shortcode_Registry $registry ) {
		$this->registry = $registry;
	}

	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_shared' ), 5 );
		add_action( 'wp_footer', array( $this, 'enqueue_flagged' ), 5 );
	}

	/**
	 * Register global plugin styles/scripts (always available to shortcodes).
	 */
	public function register_shared() {
		wp_register_style(
			'nn-shortcodes',
			NN_SHORTCODES_URL . 'assets/css/nn-shortcodes.css',
			array(),
			NN_SHORTCODES_VERSION
		);

		wp_register_style(
			'nn-shortcodes-preheading',
			NN_SHORTCODES_URL . 'assets/css/nn-shortcodes-preheading.css',
			array( 'nn-shortcodes' ),
			NN_SHORTCODES_VERSION
		);

		wp_register_style(
			'nn-shortcodes-home-hero',
			NN_SHORTCODES_URL . 'assets/css/nn-shortcodes-home-hero.css',
			array( 'nn-shortcodes' ),
			NN_SHORTCODES_VERSION
		);

		wp_register_style(
			'nn-shortcodes-hero-full-funnel',
			NN_SHORTCODES_URL . 'assets/css/nn-shortcodes-hero-full-funnel.css',
			array( 'nn-shortcodes' ),
			NN_SHORTCODES_VERSION
		);

		wp_register_style(
			'nn-shortcodes-hero-conversion-tracking',
			NN_SHORTCODES_URL . 'assets/css/nn-shortcodes-hero-conversion-tracking.css',
			array( 'nn-shortcodes' ),
			NN_SHORTCODES_VERSION
		);

		wp_register_script(
			'gsap',
			'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js',
			array(),
			'3.12.7',
			true
		);

		wp_register_script(
			'nn-shortcodes-hero-full-funnel',
			NN_SHORTCODES_URL . 'assets/js/nn-shortcodes-hero-full-funnel.js',
			array( 'gsap' ),
			NN_SHORTCODES_VERSION,
			true
		);
	}

	/**
	 * Mark a shortcode as used so its assets load in the footer.
	 *
	 * @param NN_Shortcode $shortcode Shortcode instance.
	 */
	public static function flag( NN_Shortcode $shortcode ) {
		self::$queued[ $shortcode->tag() ] = $shortcode;
	}

	/**
	 * Enqueue assets for shortcodes that actually rendered.
	 */
	public function enqueue_flagged() {
		if ( empty( self::$queued ) ) {
			return;
		}

		wp_enqueue_style( 'nn-shortcodes' );

		foreach ( self::$queued as $shortcode ) {
			$this->enqueue_for( $shortcode );
		}
	}

	/**
	 * @param NN_Shortcode $shortcode Shortcode instance.
	 */
	private function enqueue_for( NN_Shortcode $shortcode ) {
		$assets = $shortcode->assets();

		if ( ! empty( $assets['styles'] ) ) {
			foreach ( (array) $assets['styles'] as $handle ) {
				wp_enqueue_style( $handle );
			}
		}

		if ( ! empty( $assets['scripts'] ) ) {
			foreach ( (array) $assets['scripts'] as $handle ) {
				wp_enqueue_script( $handle );
			}
		}
	}
}
