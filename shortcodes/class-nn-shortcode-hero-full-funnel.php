<?php
/**
 * Full-funnel hero dashboard mock with GSAP count-up animation.
 *
 * One line (safest in the block editor):
 * [nn-hero-full-funnel heading="One dashboard · every channel, measured the same way" rows="Google|44|2.8,Meta|39|3.4,Microsoft|27|4.6|win|↑ scale"]
 *
 * Or put text with spaces in the body (recommended):
 * [nn-hero-full-funnel rows="Google|44|2.8,Meta|39|3.4,Microsoft|27|4.6|win|↑ scale"]
 * One dashboard · every channel, measured the same way
 * ---
 * Illustrative — your real cross-channel dashboard
 * [/nn-hero-full-funnel]
 *
 * @package NN_Shortcodes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero full-funnel dashboard shortcode.
 */
class NN_Shortcode_Hero_Full_Funnel extends NN_Shortcode {

	public function tag() {
		return 'nn-hero-full-funnel';
	}

	protected function defaults() {
		return array(
			'heading'  => 'One dashboard · every channel, measured the same way',
			'caption'  => '[Illustrative — your real cross-channel dashboard]',
			'rows'     => 'Google|44|2.8,Meta|39|3.4,Microsoft|27|4.6|win|↑ scale',
			'duration' => '2',
			'class'    => '',
		);
	}

	protected function template() {
		return 'hero-full-funnel';
	}

	public function assets() {
		return array(
			'styles'  => array( 'nn-shortcodes-hero-full-funnel' ),
			'scripts' => array( 'nn-shortcodes-hero-full-funnel' ),
		);
	}

	public function render( $atts, $content = null ) {
		if ( is_array( $atts ) ) {
			foreach ( $atts as $key => $value ) {
				if ( is_string( $value ) ) {
					$atts[ $key ] = nn_normalize_shortcode_text( $value );
				}
			}
		}

		return parent::render( $atts, $content );
	}

	protected function prepare( $atts, $content = null ) {
		$rows = $this->parse_rows( nn_normalize_shortcode_text( $atts['rows'] ) );

		if ( empty( $rows ) ) {
			return array(
				'has_content' => false,
			);
		}

		$duration   = max( 0.5, min( 10, (float) $atts['duration'] ) );
		$inner      = nn_parse_shortcode_inner_parts( $content );
		$heading    = nn_normalize_shortcode_text( $atts['heading'] );
		$caption    = nn_normalize_shortcode_text( $atts['caption'] );
		$default_h  = $this->defaults()['heading'];
		$default_c  = $this->defaults()['caption'];

		if ( '' !== $inner['heading'] ) {
			$heading = $inner['heading'];
		} elseif ( $this->heading_looks_broken( $heading, $default_h ) ) {
			$heading = $default_h;
		}

		if ( '' !== $inner['caption'] ) {
			$caption = $inner['caption'];

			// Inner body was "heading — caption" but only caption part was returned.
			if ( '' !== $heading && 0 === stripos( $caption, $heading ) ) {
				$caption = nn_normalize_shortcode_text(
					preg_replace( '/^' . preg_quote( $heading, '/' ) . '\s*[—–-]\s*/iu', '', $caption )
				);
			}
		}

		$caption = $this->format_illustrative_caption( $caption );

		if ( '' === $heading ) {
			$heading = $default_h;
		}

		if ( '' === $caption ) {
			$caption = $default_c;
		}

		return array(
			'has_content' => true,
			'heading'     => $heading,
			'caption'     => $caption,
			'rows'        => $rows,
			'duration'    => $duration,
			'extra'       => $this->sanitize_classes( $atts['class'] ),
		);
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
	 * Detect headings truncated by the block editor breaking quoted attributes.
	 *
	 * @param string $heading Parsed heading.
	 * @param string $default Default heading.
	 * @return bool
	 */
	private function heading_looks_broken( $heading, $default ) {
		if ( '' === $heading ) {
			return true;
		}

		if ( $heading === $default ) {
			return false;
		}

		return ! preg_match( '/\s/u', $heading );
	}

	/**
	 * Parse rows attribute.
	 *
	 * Format per row: Channel|cost|roas|win|note
	 * win is optional: "win" or "1" marks the highlighted row.
	 * note is optional trailing label (e.g. "↑ scale").
	 *
	 * @param string $rows Raw rows attribute.
	 * @return array<int, array{channel: string, cost: float, roas: float, win: bool, note: string}>
	 */
	private function parse_rows( $rows ) {
		$parsed = array();
		$parts  = preg_split( '/\s*,\s*/', trim( (string) $rows ), -1, PREG_SPLIT_NO_EMPTY );

		if ( ! $parts ) {
			return $parsed;
		}

		foreach ( $parts as $part ) {
			$fields = array_map( 'trim', explode( '|', $part ) );

			if ( count( $fields ) < 3 ) {
				continue;
			}

			$channel = sanitize_text_field( $fields[0] );
			$cost    = $this->parse_number( $fields[1] );
			$roas    = $this->parse_number( $fields[2] );

			if ( '' === $channel || null === $cost || null === $roas ) {
				continue;
			}

			$win  = false;
			$note = '';

			if ( isset( $fields[3] ) ) {
				$flag = strtolower( $fields[3] );
				if ( in_array( $flag, array( 'win', '1', 'yes', 'true' ), true ) ) {
					$win = true;
				} elseif ( '' !== $fields[3] ) {
					$note = sanitize_text_field( $fields[3] );
				}
			}

			if ( isset( $fields[4] ) && '' !== $fields[4] ) {
				$note = sanitize_text_field( $fields[4] );
			}

			$parsed[] = array(
				'channel' => $channel,
				'cost'    => $cost,
				'roas'    => $roas,
				'win'     => $win,
				'note'    => $note,
			);
		}

		return $parsed;
	}

	/**
	 * @param string $value Raw numeric string (may include $ or x).
	 * @return float|null
	 */
	private function parse_number( $value ) {
		$cleaned = preg_replace( '/[^0-9.]/', '', (string) $value );

		if ( '' === $cleaned || ! is_numeric( $cleaned ) ) {
			return null;
		}

		return (float) $cleaned;
	}
}
