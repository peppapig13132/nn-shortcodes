<?php
/**
 * Home hero chart — green circle, growth bars, static platform icons.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 * @var int    $chart_size
 * @var float  $center
 * @var float  $radius
 * @var array<int, array{bar: int, x: float, y: float, w: int, h: int, rx: int}> $bars
 * @var array<int, array{id: int, url: string, alt: string, width: int, height: int, angle: float}> $icons
 * @var array{id: int, url: string, alt: string, width: int, height: int}|null $hero_guy
 * @var float  $grow_delay
 * @var int    $block_width
 * @var int    $block_height
 * @var string $extra
 */

defined( 'ABSPATH' ) || exit;
?>
<div
	class="<?php echo nn_block_classes( $block, $extra ); ?>"
	aria-label="<?php echo esc_attr__( 'Growth chart with platform icons', 'nn-shortcodes' ); ?>"
	style="<?php echo esc_attr( '--nn-hero-home-size: ' . (int) $chart_size . 'px; --nn-hero-home-block-width: ' . (int) $block_width . 'px; --nn-hero-home-block-height: ' . (int) $block_height . 'px' ); ?>"
	data-grow-delay="<?php echo esc_attr( (string) $grow_delay ); ?>"
>
	<div class="<?php echo nn_class( $block, 'stage' ); ?>">
		<svg
			class="<?php echo nn_class( $block, 'chart' ); ?>"
			viewBox="<?php echo esc_attr( '0 0 ' . (int) $chart_size . ' ' . (int) $chart_size ); ?>"
			aria-hidden="true"
		>
			<circle
				class="<?php echo nn_class( $block, 'chart-bg' ); ?>"
				cx="<?php echo esc_attr( (string) $center ); ?>"
				cy="<?php echo esc_attr( (string) $center ); ?>"
				r="<?php echo esc_attr( (string) $radius ); ?>"
			/>
			<g class="<?php echo nn_class( $block, 'bars' ); ?>">
				<?php foreach ( $bars as $bar ) : ?>
					<rect
						class="<?php echo nn_class( $block, 'bar' ); ?>"
						data-bar="<?php echo esc_attr( (string) $bar['bar'] ); ?>"
						x="<?php echo esc_attr( (string) $bar['x'] ); ?>"
						y="<?php echo esc_attr( (string) $bar['y'] ); ?>"
						width="<?php echo esc_attr( (string) $bar['w'] ); ?>"
						height="<?php echo esc_attr( (string) $bar['h'] ); ?>"
						rx="<?php echo esc_attr( (string) $bar['rx'] ); ?>"
					/>
				<?php endforeach; ?>
			</g>
		</svg>
	</div>

	<?php if ( ! empty( $hero_guy ) ) : ?>
		<div class="<?php echo nn_class( $block, 'guy' ); ?>">
			<?php nn_render_media_image( $hero_guy, nn_class( $block, 'guy-img' ) ); ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $icons ) ) : ?>
		<div class="<?php echo nn_class( $block, 'icons' ); ?>" aria-hidden="true">
			<?php foreach ( $icons as $icon ) : ?>
				<div
					class="<?php echo nn_class( $block, 'icon' ); ?>"
					style="<?php echo esc_attr( '--angle: ' . $icon['angle'] . 'deg' ); ?>"
				>
					<div
						class="<?php echo nn_class( $block, 'icon-positioner' ); ?>"
						style="<?php echo esc_attr( '--angle: ' . $icon['angle'] . 'deg' ); ?>"
					>
						<?php nn_render_media_image( $icon, nn_class( $block, 'icon-img' ) ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
