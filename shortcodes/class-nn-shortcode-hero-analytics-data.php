<?php
/**
 * Analytics & Data Intelligence hero dashboard mock.
 *
 * [nn-hero-analytics-data]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

class NN_Shortcode_Hero_Analytics_Data extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-analytics-data';
	}

	protected function defaults() {
		return array();
	}

	protected function template() {
		return 'hero-analytics-data';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero-analytics-data' ),
		);
	}
}
