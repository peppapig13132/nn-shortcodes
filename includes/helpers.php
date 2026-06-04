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

/**
 * Resolve a media library attachment ID or image URL for shortcode attributes.
 *
 * @param string $value Attachment ID or absolute URL.
 * @return array{id: int, url: string, alt: string, width: int, height: int}|null
 */
function nn_resolve_media( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return null;
	}

	if ( ctype_digit( $value ) ) {
		$id  = (int) $value;
		$url = wp_get_attachment_image_url( $id, 'full' );

		if ( ! $url ) {
			return null;
		}

		$meta = wp_get_attachment_metadata( $id );

		return array(
			'id'     => $id,
			'url'    => $url,
			'alt'    => (string) get_post_meta( $id, '_wp_attachment_image_alt', true ),
			'width'  => isset( $meta['width'] ) ? (int) $meta['width'] : 0,
			'height' => isset( $meta['height'] ) ? (int) $meta['height'] : 0,
		);
	}

	$url = esc_url_raw( $value );

	if ( ! $url ) {
		return null;
	}

	return array(
		'id'     => 0,
		'url'    => $url,
		'alt'    => '',
		'width'  => 0,
		'height' => 0,
	);
}

/**
 * Render an image from nn_resolve_media() output.
 *
 * @param array{id: int, url: string, alt: string, width: int, height: int}|null $image   Resolved image data.
 * @param string                                                                 $class   CSS class for the img element.
 * @param string                                                                 $size    Attachment image size.
 */
function nn_render_media_image( $image, $class = '', $size = 'full' ) {
	if ( empty( $image ) || empty( $image['url'] ) ) {
		return;
	}

	$attrs = array(
		'class'    => $class,
		'decoding' => 'async',
	);

	if ( ! empty( $image['id'] ) ) {
		echo wp_get_attachment_image( (int) $image['id'], $size, false, $attrs );
		return;
	}

	$attr_string = '';
	foreach ( $attrs as $key => $value ) {
		if ( '' !== $value ) {
			$attr_string .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
		}
	}

	if ( ! empty( $image['width'] ) && ! empty( $image['height'] ) ) {
		printf(
			'<img src="%1$s" alt="%2$s" width="%3$d" height="%4$d"%5$s>',
			esc_url( $image['url'] ),
			esc_attr( $image['alt'] ),
			(int) $image['width'],
			(int) $image['height'],
			$attr_string
		);
		return;
	}

	printf(
		'<img src="%1$s" alt="%2$s"%3$s>',
		esc_url( $image['url'] ),
		esc_attr( $image['alt'] ),
		$attr_string
	);
}
