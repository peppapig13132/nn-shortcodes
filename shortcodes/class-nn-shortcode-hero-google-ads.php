<?php
/**
 * Google Ads hero search-ad-preview mock.
 *
 * [nn-hero-google-ads]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero Google Ads ad-preview shortcode.
 */
class NN_Shortcode_Hero_Google_Ads extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-google-ads';
	}

	protected function defaults() {
		return array();
	}

	protected function template() {
		return 'hero-google-ads';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero-google-ads' ),
		);
	}
}
