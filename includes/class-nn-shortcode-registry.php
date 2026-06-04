<?php
/**
 * Discovers and registers all shortcode classes.
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode registry.
 */
class NN_Shortcode_Registry {

	/**
	 * Map of tag => shortcode instance.
	 *
	 * @var array<string, NN_Shortcode>
	 */
	private $shortcodes = array();

	/**
	 * Register shortcodes on init.
	 */
	public function register() {
		$this->load_shortcode_classes();

		foreach ( $this->shortcodes as $tag => $shortcode ) {
			add_shortcode( $tag, array( $shortcode, 'render' ) );
		}
	}

	/**
	 * Load every PHP file in shortcodes/ and instantiate classes extending NN_Shortcode.
	 */
	private function load_shortcode_classes() {
		$dir = NN_SHORTCODES_PATH . 'shortcodes/';

		if ( ! is_dir( $dir ) ) {
			return;
		}

		$files = glob( $dir . 'class-nn-shortcode-*.php' );

		if ( ! $files ) {
			return;
		}

		foreach ( $files as $file ) {
			require_once $file;

			$class = $this->class_name_from_file( $file );

			if ( ! class_exists( $class ) || ! is_subclass_of( $class, 'NN_Shortcode' ) ) {
				continue;
			}

			/** @var NN_Shortcode $instance */
			$instance = new $class();
			$this->shortcodes[ $instance->tag() ] = $instance;
		}
	}

	/**
	 * @param string $file Absolute path to shortcode class file.
	 * @return string
	 */
	private function class_name_from_file( $file ) {
		$basename = basename( $file, '.php' );
		$prefix   = 'class-nn-shortcode-';

		if ( 0 === strpos( $basename, $prefix ) ) {
			$slug = substr( $basename, strlen( $prefix ) );
			$slug = str_replace( '-', ' ', $slug );
			$slug = str_replace( ' ', '_', ucwords( $slug ) );
			return 'NN_Shortcode_' . $slug;
		}

		$parts = explode( '-', $basename );
		$parts = array_map( 'ucfirst', $parts );
		return implode( '_', $parts );
	}

	/**
	 * @return array<string, NN_Shortcode>
	 */
	public function all() {
		return $this->shortcodes;
	}

	/**
	 * @param string $tag Shortcode tag.
	 * @return NN_Shortcode|null
	 */
	public function get( $tag ) {
		return isset( $this->shortcodes[ $tag ] ) ? $this->shortcodes[ $tag ] : null;
	}
}
