<?php
/**
 * Example:
 * [nn-preheading text="PPC Management + Data Intelligence"]
 * [nn-preheading]PPC Management + Data Intelligence[/nn-preheading]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Preheading line shown above headings.
 */
class NN_Shortcode_Preheading extends NN_Shortcode {

	public function tag() {
		return 'nn-preheading';
	}

	protected function defaults() {
		return array(
			'text'  => '',
			'class' => '', // Extra nn-* utility classes only
		);
	}

	protected function template() {
		return 'preheading';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-preheading' ),
		);
	}

	protected function prepare( $atts, $content = null ) {
		return array(
			'text'  => sanitize_text_field( $atts['text'] ),
			'extra' => $this->sanitize_classes( $atts['class'] ),
		);
	}
}

