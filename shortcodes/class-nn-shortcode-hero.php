<?php
/**
 * Example: [nn_hero title="..." subtitle="..." image="123" variant="dark"]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero section shortcode.
 */
class NN_Shortcode_Hero extends NN_Shortcode {

	public function tag() {
		return 'nn_hero';
	}

	protected function defaults() {
		return array(
			'title'    => '',
			'subtitle' => '',
			'image'    => '',
			'variant'  => '', // BEM modifier: dark | light | compact
			'class'    => '', // Extra nn-* utility classes only
		);
	}

	protected function template() {
		return 'hero';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero' ),
		);
	}

	protected function prepare( $atts, $content = null ) {
		$image_id = absint( $atts['image'] );
		$variant  = sanitize_key( $atts['variant'] );

		return array(
			'title'    => sanitize_text_field( $atts['title'] ),
			'subtitle' => sanitize_text_field( $atts['subtitle'] ),
			'image'    => $image_id ? wp_get_attachment_image( $image_id, 'large', false, array( 'class' => nn_class( $this->block_class(), 'media' ) ) ) : '',
			'variant'  => $variant,
			'extra'    => $this->sanitize_classes( $atts['class'] ),
		);
	}
}
