<?php
/**
 * Home page hero growth chart — green circle, bars, static platform icons.
 *
 * Example:
 * [nn-hero-home]
 * [nn-hero-home hero-guy="1500" icons="1216"]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Home hero chart shortcode.
 */
class NN_Shortcode_Hero_Home extends NN_Shortcode {

	const CHART_SIZE         = 470;
	const BAR_WIDTH          = 56;
	const BAR_RADIUS         = 14;
	const BAR_GAP            = 29;
	const BAR_HEIGHTS        = array( 71, 114, 165, 231 );
	const DEFAULT_HERO_GUY   = '1500';
	const DEFAULT_ICON       = '1216';
	const DEFAULT_ICON_COUNT = 11;
	const BLOCK_WIDTH        = 566;
	const BLOCK_HEIGHT       = 716;

	public function tag() {
		return 'nn-hero-home';
	}

	protected function defaults() {
		return array(
			'hero-guy'   => self::DEFAULT_HERO_GUY,
			'icons'      => '',
			'grow-delay' => '0.8',
			'class'      => '',
		);
	}

	protected function template() {
		return 'hero-home';
	}

	public function assets() {
		return array(
			'styles'  => array( 'nn-shortcodes-hero-home' ),
			'scripts' => array( 'nn-shortcodes-hero-home' ),
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

		if ( empty( $icons ) ) {
			$icons = $this->default_icons();
		} elseif ( 1 === count( $icons ) ) {
			$icons = array_fill( 0, self::DEFAULT_ICON_COUNT, $icons[0] );
		}

		$step = count( $icons ) > 0 ? 360 / count( $icons ) : 0;

		foreach ( $icons as $index => $icon ) {
			$icons[ $index ]['angle'] = $step * $index;
		}

		$hero_guy = nn_resolve_media( $atts['hero-guy'] );
		$extra    = $this->sanitize_classes( $atts['class'] );

		if ( $hero_guy ) {
			$extra = trim( $extra . ' nn-hero-home--has-guy' );
		}

		return array(
			'chart_size'   => $size,
			'center'       => $center,
			'radius'       => $radius,
			'bars'         => $bars,
			'icons'        => $icons,
			'hero_guy'     => $hero_guy,
			'grow_delay'   => max( 0, min( 5, (float) $atts['grow-delay'] ) ),
			'block_width'  => self::BLOCK_WIDTH,
			'block_height' => self::BLOCK_HEIGHT,
			'extra'        => $extra,
		);
	}

	/**
	 * @return array<int, array{id: int, url: string, alt: string, width: int, height: int, angle: float}>
	 */
	private function default_icons() {
		$image = nn_resolve_media( self::DEFAULT_ICON );

		if ( ! $image ) {
			return array();
		}

		$icons = array();

		for ( $i = 0; $i < self::DEFAULT_ICON_COUNT; $i++ ) {
			$icons[] = $image;
		}

		return $icons;
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
