<?php
/**
 * Hero section template.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 * @var string $title
 * @var string $subtitle
 * @var string $image
 * @var string $variant
 * @var string $extra
 */

defined( 'ABSPATH' ) || exit;

$modifier = $variant ? ' ' . nn_class( $block, '', $variant ) : '';
?>
<section class="<?php echo nn_block_classes( $block . $modifier, $extra ); ?>">
	<div class="<?php echo nn_class( $block, 'inner' ); ?>">
		<?php if ( $title ) : ?>
			<h2 class="<?php echo nn_class( $block, 'title' ); ?>"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $subtitle ) : ?>
			<p class="<?php echo nn_class( $block, 'subtitle' ); ?>"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>

		<?php if ( $image ) : ?>
			<div class="<?php echo nn_class( $block, 'media' ); ?>">
				<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image ?>
			</div>
		<?php endif; ?>
	</div>
</section>
