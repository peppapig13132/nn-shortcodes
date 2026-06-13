<?php
/**
 * Data Warehouse hero pipeline mock.
 *
 * [nn-hero-data-warehouse]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

class NN_Shortcode_Hero_Data_Warehouse extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-data-warehouse';
	}

	protected function defaults() {
		return array();
	}

	protected function template() {
		return 'hero-data-warehouse';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero-data-warehouse' ),
		);
	}
}
