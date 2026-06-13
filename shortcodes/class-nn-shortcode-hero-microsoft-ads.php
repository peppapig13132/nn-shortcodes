<?php
/**
 * Microsoft Ads hero LinkedIn targeting mock.
 *
 * [nn-hero-microsoft-ads]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

class NN_Shortcode_Hero_Microsoft_Ads extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-microsoft-ads';
	}

	protected function defaults() {
		return array();
	}

	protected function template() {
		return 'hero-microsoft-ads';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero-microsoft-ads' ),
		);
	}
}
