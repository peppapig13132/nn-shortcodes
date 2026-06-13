<?php
/**
 * Meta Ads hero feed-ad-preview mock.
 *
 * [nn-hero-meta-ads]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

class NN_Shortcode_Hero_Meta_Ads extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-meta-ads';
	}

	protected function defaults() {
		return array();
	}

	protected function template() {
		return 'hero-meta-ads';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero-meta-ads' ),
		);
	}
}
