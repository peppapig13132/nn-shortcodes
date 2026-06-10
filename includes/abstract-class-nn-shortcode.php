<?php
/**
 * Base class for all NN shortcodes.
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Abstract shortcode handler.
 */
abstract class NN_Shortcode {

	/**
	 * Shortcode tag without brackets, e.g. "nn-preheading".
	 *
	 * @return string
	 */
	abstract public function tag();

	/**
	 * Default attributes.
	 *
	 * @return array<string, mixed>
	 */
	abstract protected function defaults();

	/**
	 * Template slug relative to templates/shortcodes/, without .php.
	 *
	 * @return string
	 */
	abstract protected function template();

	/**
	 * CSS/JS handles to enqueue when this shortcode renders.
	 *
	 * @return array{styles?: string[], scripts?: string[]}
	 */
	public function assets() {
		return array();
	}

	/**
	 * Root BEM block for this shortcode, e.g. "nn-preheading".
	 * Defaults to tag with underscores replaced by hyphens.
	 *
	 * @return string
	 */
	public function block_class() {
		return $this->tag();
	}

	/**
	 * @param array<string, string>|string $atts    Shortcode attributes.
	 * @param string|null                  $content Inner content.
	 * @return string
	 */
	public function render( $atts, $content = null ) {
		$atts = shortcode_atts( $this->defaults(), $atts, $this->tag() );

		NN_Assets::flag( $this );

		$data = $this->prepare( $atts, $content );

		ob_start();
		nn_get_template(
			'shortcodes/' . $this->template(),
			array_merge(
				$data,
				array(
					'atts'    => $atts,
					'content' => $content,
					'block'   => $this->block_class(),
				)
			)
		);
		return (string) ob_get_clean();
	}

	/**
	 * Build template variables from attributes.
	 *
	 * @param array<string, mixed> $atts    Parsed attributes.
	 * @param string|null          $content Inner content.
	 * @return array<string, mixed>
	 */
	protected function prepare( $atts, $content = null ) {
		return array();
	}

	/**
	 * Sanitize a CSS class list; only allows nn-prefixed tokens.
	 *
	 * @param string $classes Space-separated classes.
	 * @return string
	 */
	protected function sanitize_classes( $classes ) {
		$allowed = array();
		$parts   = preg_split( '/\s+/', trim( (string) $classes ), -1, PREG_SPLIT_NO_EMPTY );

		foreach ( $parts as $class ) {
			if ( preg_match( '/^nn-[a-z0-9]+(?:__(?:[a-z0-9]+(?:-[a-z0-9]+)*))?(--[a-z0-9]+(?:-[a-z0-9]+)*)?$/', $class ) ) {
				$allowed[] = $class;
			}
		}

		return implode( ' ', $allowed );
	}
}
