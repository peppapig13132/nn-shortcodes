<?php
/**
 * Template and markup helpers.
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load a template from templates/ with extracted args.
 *
 * @param string               $slug Template path without .php, relative to templates/.
 * @param array<string, mixed> $args Variables for the template.
 */
function nn_get_template( $slug, $args = array() ) {
	$path = NN_SHORTCODES_PATH . 'templates/' . $slug . '.php';

	if ( ! file_exists( $path ) ) {
		return;
	}

	if ( ! empty( $args ) && is_array( $args ) ) {
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- scoped template vars.
		extract( $args, EXTR_SKIP );
	}

	include $path;
}

/**
 * Build a BEM class string for an NN block.
 *
 * @param string $block   Root block, e.g. "nn-hero".
 * @param string $element Optional element, e.g. "title" → nn-hero__title.
 * @param string $modifier Optional modifier, e.g. "dark" → nn-hero--dark or nn-hero__title--large.
 * @return string
 */
function nn_class( $block, $element = '', $modifier = '' ) {
	$class = $block;

	if ( $element ) {
		$class .= '__' . sanitize_html_class( $element );
	}

	if ( $modifier ) {
		$class .= '--' . sanitize_html_class( $modifier );
	}

	return esc_attr( $class );
}

/**
 * Merge block class with optional extra nn-* classes.
 *
 * @param string $block   Root BEM block.
 * @param string $extra   Additional nn-* classes (space-separated).
 * @return string
 */
function nn_block_classes( $block, $extra = '' ) {
	$classes = array( $block );

	if ( $extra ) {
		$classes = array_merge( $classes, preg_split( '/\s+/', trim( $extra ), -1, PREG_SPLIT_NO_EMPTY ) );
	}

	return esc_attr( implode( ' ', array_unique( $classes ) ) );
}
