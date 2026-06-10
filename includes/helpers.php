<?php
/**
 * Template and markup helpers.
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Collapse whitespace runs to a single space (keeps spaces between words).
 *
 * @param string $value Raw text.
 * @return string
 */
function nn_collapse_whitespace( $value ) {
	$value = preg_replace( '/\s+/u', ' ', (string) $value );
	return trim( $value );
}

/**
 * Strip block-editor HTML but preserve word spacing.
 *
 * @param string $value Raw HTML or text.
 * @return string
 */
function nn_normalize_shortcode_content( $value ) {
	$value = html_entity_decode( (string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$value = str_replace(
		array( '“', '”', '‘', '’', '&#8220;', '&#8221;', '&#8216;', '&#8217;' ),
		array( '"', '"', "'", "'", '"', '"', "'", "'" ),
		$value
	);
	$value = preg_replace( '#</?(?:p|div|li|h[1-6]|span)[^>]*>#i', ' ', $value );
	$value = str_replace( array( '<br>', '<br/>', '<br />' ), ' ', $value );
	$value = wp_strip_all_tags( $value );
	$value = str_replace( '+', ' ', $value );

	return nn_collapse_whitespace( $value );
}

/**
 * Normalize shortcode attribute text: smart quotes, entities, editor HTML.
 *
 * @param string $value Raw attribute or inner content.
 * @return string
 */
function nn_normalize_shortcode_text( $value ) {
	$value = nn_normalize_shortcode_content( $value );
	return trim( $value, "\"'" );
}

/**
 * Parse inner shortcode body into optional heading + caption.
 *
 * Use "---" on its own line between heading and caption when both are in the body.
 * Without "---", the whole body is treated as caption (legacy).
 *
 * @param string|null $content Inner shortcode content.
 * @return array{heading: string, caption: string}
 */
function nn_parse_shortcode_inner_parts( $content ) {
	$raw  = (string) $content;
	$text = nn_normalize_shortcode_content( $content );

	if ( '' === $text ) {
		return array(
			'heading' => '',
			'caption' => '',
		);
	}

	// Explicit: --- between heading and caption.
	if ( preg_match( '/\s+---\s+/', $text ) ) {
		$parts = preg_split( '/\s+---\s+/', $text, 2 );
		return array(
			'heading' => nn_normalize_shortcode_text( $parts[0] ?? '' ),
			'caption' => nn_normalize_shortcode_text( $parts[1] ?? '' ),
		);
	}

	// Block editor: two lines in the shortcode body.
	if ( preg_match( '/[\r\n]/', wp_strip_all_tags( $raw ) ) ) {
		$lines = preg_split( '/[\r\n]+/', $text, 2 );
		if ( isset( $lines[1] ) && '' !== trim( $lines[1] ) ) {
			return array(
				'heading' => nn_normalize_shortcode_text( $lines[0] ),
				'caption' => nn_normalize_shortcode_text( $lines[1] ),
			);
		}
	}

	// Single line merged with em/en dash before "Illustrative…".
	if ( preg_match( '/^(.+?)\s+[—–-]\s+((?:\[)?Illustrative\b.+)$/iu', $text, $matches ) ) {
		return array(
			'heading' => nn_normalize_shortcode_text( $matches[1] ),
			'caption' => nn_normalize_shortcode_text( $matches[2] ),
		);
	}

	// Caption-only body (do not treat as merged heading+caption).
	if ( preg_match( '/^(?:\[)?Illustrative\b/iu', $text ) ) {
		return array(
			'heading' => '',
			'caption' => nn_normalize_shortcode_text( $text ),
		);
	}

	return array(
		'heading' => '',
		'caption' => nn_normalize_shortcode_text( $text ),
	);
}

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
 * @param string $block   Root block, e.g. "nn-preheading".
 * @param string $element Optional element, e.g. "text" → nn-preheading__text.
 * @param string $modifier Optional modifier, e.g. "dark" → nn-preheading--dark or nn-preheading__text--large.
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
