<?php
/**
 * Animated hero with center chart and orbiting icons.
 *
 * Example:
 * [nn-hero chart="123" icons="101,102,103,104,105,106,107,108,109,110"]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero orbit shortcode.
 */
class NN_Shortcode_Hero extends NN_Shortcode {

	public function tag() {
		return 'nn-hero';
	}

	protected function defaults() {
		return array(
			'chart'    => '',
			'icons'    => '',
			'duration' => '28',
			'class'    => '',
		);
	}

	protected function template() {
		return 'hero';
	}

	public function assets() {
		return array(
			'styles'  => array( 'nn-shortcodes-hero' ),
			'scripts' => array( 'nn-shortcodes-hero' ),
		);
	}

	protected function prepare( $atts, $content = null ) {
		$chart = nn_resolve_media( $atts['chart'] );
		$icons = $this->parse_icons( $atts['icons'] );

		if ( ! $chart && empty( $icons ) ) {
			return array(
				'has_content' => false,
			);
		}

		$duration = max( 5, min( 120, (int) $atts['duration'] ) );
		$count    = count( $icons );
		$step     = $count > 0 ? 360 / $count : 0;

		foreach ( $icons as $index => $icon ) {
			$icons[ $index ]['angle'] = $step * $index;
		}

		return array(
			'has_content' => true,
			'chart'       => $chart,
			'icons'       => $icons,
			'duration'    => $duration,
			'extra'       => $this->sanitize_classes( $atts['class'] ),
		);
	}

	/**
	 * @param string $icons Comma-separated attachment IDs or URLs.
	 * @return array<int, array{id: int, url: string, alt: string, width: int, height: int}>
	 */
	private function parse_icons( $icons ) {
		$parsed = array();
		$parts  = preg_split( '/\s*,\s*/', trim( (string) $icons ), -1, PREG_SPLIT_NO_EMPTY );

		if ( ! $parts ) {
			return $parsed;
		}

		foreach ( $parts as $part ) {
			$image = nn_resolve_media( $part );

			if ( $image ) {
				$parsed[] = $image;
			}
		}

		return $parsed;
	}
}
