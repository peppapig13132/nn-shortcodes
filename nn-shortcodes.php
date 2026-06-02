<?php
/**
 * Plugin Name:       NN Shortcodes
 * Plugin URI:        https://nn.partners
 * Description:       Custom shortcodes and section blocks for the NN Partners website.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            NN Partners
 * Author URI:        https://nn.partners
 * Text Domain:       nn-shortcodes
 * Domain Path:       /languages
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

define( 'NN_SHORTCODES_VERSION', '1.0.0' );
define( 'NN_SHORTCODES_FILE', __FILE__ );
define( 'NN_SHORTCODES_PATH', plugin_dir_path( __FILE__ ) );
define( 'NN_SHORTCODES_URL', plugin_dir_url( __FILE__ ) );

add_filter(
	'plugin_row_meta',
	static function ( $links, $plugin_file ) {
		if ( $plugin_file !== plugin_basename( __FILE__ ) ) {
			return $links;
		}

		$filtered = array_values(
			array_filter(
				(array) $links,
				static function ( $link_html ) {
					if ( ! is_string( $link_html ) ) {
						return true;
					}

					return strip_tags( $link_html ) !== __( 'Visit plugin site' );
				}
			)
		);

		return $filtered;
	},
	10,
	2
);

require_once NN_SHORTCODES_PATH . 'includes/class-nn-shortcodes-plugin.php';

/**
 * Bootstrap the plugin.
 *
 * @return NN_Shortcodes_Plugin
 */
function nn_shortcodes() {
	return NN_Shortcodes_Plugin::instance();
}

nn_shortcodes();
