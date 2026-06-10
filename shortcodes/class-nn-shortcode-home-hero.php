<?php
/**
 * Home page hero growth chart — green circle, bars, static platform icons.
 *
 * Example:
 * [nn-home-hero icons="4417,4418,4419,4420,4421,4422,4423,4437,4439,4440,4441"]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Home hero chart shortcode.
 */
class NN_Shortcode_Home_Hero extends NN_Shortcode {

	const CHART_SIZE   = 470;
	const BAR_WIDTH    = 56;
	const BAR_RADIUS   = 14;
	const BAR_GAP      = 29;
	const BAR_HEIGHTS  = array( 71, 114, 165, 231 );

	public function tag() {
		return 'nn-home-hero';
	}

	protected function defaults() {
		return array(
			'icons' => '',
			'class' => '',
		);
	}

	protected function template() {
		return 'home-hero';
	}

	public function assets() {
		return array(
			'styles' => array( 'nn-shortcodes-home-hero' ),
		);
	}

	protected function prepare( $atts, $content = null ) {
		$size    = self::CHART_SIZE;
		$center  = $size / 2;
		$radius  = $size / 2;
		$width   = self::BAR_WIDTH;
		$gap     = self::BAR_GAP;
		$heights = self::BAR_HEIGHTS;
		$count   = count( $heights );
		$span    = ( $count * $width ) + ( ( $count - 1 ) * $gap );
		$start_x = ( $size - $span ) / 2;
		$bottom  = $center + ( max( $heights ) / 2 );
		$bars    = array();

		foreach ( $heights as $index => $height ) {
			$bars[] = array(
				'bar' => $index + 1,
				'x'   => $start_x + ( $index * ( $width + $gap ) ),
				'y'   => $bottom - $height,
				'w'   => $width,
				'h'   => $height,
				'rx'  => self::BAR_RADIUS,
			);
		}

		$icons = $this->parse_icons( $atts['icons'] );
		$step  = count( $icons ) > 0 ? 360 / count( $icons ) : 0;

		foreach ( $icons as $index => $icon ) {
			$icons[ $index ]['angle'] = $step * $index;
		}

		return array(
			'chart_size' => $size,
			'center'     => $center,
			'radius'     => $radius,
			'bars'       => $bars,
			'icons'      => $icons,
			'extra'      => $this->sanitize_classes( $atts['class'] ),
		);
	}

	/**
	 * @param string $icons Comma-separated attachment IDs or URLs.
	 * @return array<int, array{id: int, url: string, alt: string, width: int, height: int, angle: float}>
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
