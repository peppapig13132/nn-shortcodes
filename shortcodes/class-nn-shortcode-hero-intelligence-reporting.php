<?php
/**
 * Intelligence Reporting hero reconciled report mock.
 *
 * [nn-hero-intelligence-reporting]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

class NN_Shortcode_Hero_Intelligence_Reporting extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-intelligence-reporting';
	}

	protected function defaults() {
		return array();
	}

	protected function template() {
		return 'hero-intelligence-reporting';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero-intelligence-reporting' ),
		);
	}
}
