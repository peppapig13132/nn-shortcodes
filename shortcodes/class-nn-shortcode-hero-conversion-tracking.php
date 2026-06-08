<?php
/**
 * Conversion-tracking hero data-flow diagram mock.
 *
 * [nn-hero-conversion-tracking]
 * [nn-hero-conversion-tracking destinations="GA4,Google Ads,Meta,Microsoft,BigQuery" caption="Illustrative data flow — replace with a real tracking diagram"]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero conversion-tracking data-flow shortcode.
 */
class NN_Shortcode_Hero_Conversion_Tracking extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-conversion-tracking';
	}

	protected function defaults() {
		return array(
			'source'       => 'Your Site|& App',
			'hub'          => 'GTM +|Server-Side',
			'destinations' => 'GA4,Google Ads,Meta,Microsoft,BigQuery',
			'caption'      => 'Illustrative data flow — replace with a real tracking diagram',
			'class'        => '',
		);
	}

	protected function template() {
		return 'hero-conversion-tracking';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-hero-conversion-tracking' ),
		);
	}

	public function render( $atts, $content = null ) {
		if ( is_array( $atts ) ) {
			foreach ( $atts as $key => $value ) {
				if ( ! is_string( $value ) ) {
					continue;
				}

				// source/hub keep "+" and use "|" for line breaks — see parse_label_lines().
				if ( in_array( $key, array( 'source', 'hub' ), true ) ) {
					continue;
				}

				$atts[ $key ] = nn_normalize_shortcode_text( $value );
			}
		}

		return parent::render( $atts, $content );
	}

	protected function prepare( $atts, $content = null ) {
		$destinations = $this->parse_destinations( nn_normalize_shortcode_text( $atts['destinations'] ) );

		if ( empty( $destinations ) ) {
			return array(
				'has_content' => false,
			);
		}

		$inner   = nn_parse_shortcode_inner_parts( $content );
		$caption = nn_normalize_shortcode_text( $atts['caption'] );

		if ( '' !== $inner['caption'] ) {
			$caption = $inner['caption'];
		}

		$caption = $this->format_illustrative_caption( $caption );

		if ( '' === $caption ) {
			$caption = $this->format_illustrative_caption( $this->defaults()['caption'] );
		}

		$source_lines = $this->parse_label_lines( $atts['source'] );
		$hub_lines    = $this->parse_label_lines( $atts['hub'] );

		if ( empty( $source_lines ) ) {
			$source_lines = $this->parse_label_lines( $this->defaults()['source'] );
		}

		if ( empty( $hub_lines ) ) {
			$hub_lines = $this->parse_label_lines( $this->defaults()['hub'] );
		}

		return array(
			'has_content'  => true,
			'source_lines' => $source_lines,
			'hub_lines'    => $hub_lines,
			'destinations' => $destinations,
			'caption'      => $caption,
			'extra'        => $this->sanitize_classes( $atts['class'] ),
		);
	}

	/**
	 * Parse a node label into display lines. Pipe separates lines; preserves "+".
	 *
	 * @param string $value Raw label attribute.
	 * @return string[]
	 */
	private function parse_label_lines( $value ) {
		$value = html_entity_decode( (string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		$value = str_replace(
			array( '“', '”', '‘', '’', '&#8220;', '&#8221;', '&#8216;', '&#8217;' ),
			array( '"', '"', "'", "'", '"', '"', "'", "'" ),
			$value
		);
		$value = wp_strip_all_tags( $value );
		$value = trim( $value, "\"'" );

		if ( false !== strpos( $value, '|' ) ) {
			$lines = array_map( 'trim', explode( '|', $value ) );
			$lines = array_values(
				array_filter(
					array_map( 'nn_collapse_whitespace', $lines ),
					static function ( $line ) {
						return '' !== $line;
					}
				)
			);

			return $lines;
		}

		$line = nn_collapse_whitespace( $value );

		return '' !== $line ? array( $line ) : array();
	}

	/**
	 * Ensure illustrative footer shows bracketed copy when appropriate.
	 *
	 * @param string $caption Caption text.
	 * @return string
	 */
	private function format_illustrative_caption( $caption ) {
		$caption = nn_normalize_shortcode_text( $caption );

		if ( '' === $caption ) {
			return $caption;
		}

		if ( preg_match( '/^Illustrative\b/iu', $caption ) && '[' !== $caption[0] ) {
			return '[' . $caption . ']';
		}

		return $caption;
	}

	/**
	 * Parse comma-separated destination labels.
	 *
	 * @param string $destinations Raw destinations attribute.
	 * @return string[]
	 */
	private function parse_destinations( $destinations ) {
		$parsed = array();
		$parts  = preg_split( '/\s*,\s*/', trim( (string) $destinations ), -1, PREG_SPLIT_NO_EMPTY );

		if ( ! $parts ) {
			return $parsed;
		}

		foreach ( $parts as $part ) {
			$label = sanitize_text_field( $part );

			if ( '' !== $label ) {
				$parsed[] = $label;
			}
		}

		return $parsed;
	}
}
