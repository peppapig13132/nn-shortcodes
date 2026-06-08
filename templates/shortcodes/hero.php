<?php
/**
 * Hero orbit template.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 * @var bool   $has_content
 * @var array|null $chart
 * @var array|null $hero_guy
 * @var array<int, array{id: int, url: string, alt: string, width: int, height: int, angle: float}> $icons
 * @var int    $duration
 * @var float  $guy_delay
 * @var string $extra
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $has_content ) ) {
	return;
}
?>
<section
	class="<?php echo nn_block_classes( $block, $extra ); ?>"
	aria-label="<?php echo esc_attr__( 'Hero illustration', 'nn-shortcodes' ); ?>"
	data-duration="<?php echo esc_attr( (string) $duration ); ?>"
	<?php if ( ! empty( $hero_guy ) ) : ?>
		data-guy-delay="<?php echo esc_attr( (string) $guy_delay ); ?>"
	<?php endif; ?>
>
	<div class="<?php echo nn_class( $block, 'frame' ); ?>">
		<div class="<?php echo nn_class( $block, 'stage' ); ?>">
			<?php if ( ! empty( $chart ) ) : ?>
				<?php nn_render_media_image( $chart, nn_class( $block, 'chart' ) ); ?>
			<?php endif; ?>

			<?php if ( ! empty( $icons ) ) : ?>
				<div class="<?php echo nn_class( $block, 'orbit-track' ); ?>" aria-hidden="true">
					<?php foreach ( $icons as $icon ) : ?>
						<div
							class="<?php echo nn_class( $block, 'orbit-item' ); ?>"
							style="<?php echo esc_attr( '--angle: ' . $icon['angle'] . 'deg' ); ?>"
						>
							<div class="<?php echo nn_class( $block, 'orbit-positioner' ); ?>">
								<?php nn_render_media_image( $icon, nn_class( $block, 'orbit-icon' ) ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $hero_guy ) ) : ?>
				<?php nn_render_media_image( $hero_guy, nn_class( $block, 'guy' ) ); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
