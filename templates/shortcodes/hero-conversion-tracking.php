<?php
/**
 * Conversion-tracking data-flow diagram template.
 * Markup matches 20260530_nn-partners_conversion-tracking.html (.flow-mock).
 *
 * @package NN_Shortcodes
 *
 * @var string   $block
 * @var bool     $has_content
 * @var string[] $source_lines
 * @var string[] $hub_lines
 * @var string[] $destinations
 * @var string   $caption
 * @var string   $extra
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $has_content ) ) {
	return;
}

$source_label = implode( ' ', $source_lines );
$hub_label    = implode( ' ', $hub_lines );

$aria_label = sprintf(
	/* translators: 1: data source label, 2: hub label */
	__( 'Data flow from %1$s through %2$s to analytics destinations', 'nn-shortcodes' ),
	$source_label,
	$hub_label
);
?>
<div class="<?php echo nn_block_classes( $block, $extra ); ?>">
	<div class="flow-mock" role="img" aria-label="<?php echo esc_attr( $aria_label ); ?>">
		<div class="flow-bar" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="flow-body">
			<div class="flow-node">
				<?php foreach ( $source_lines as $index => $line ) : ?>
					<?php if ( $index > 0 ) : ?><br><?php endif; ?>
					<?php echo esc_html( $line ); ?>
				<?php endforeach; ?>
			</div>
			<div class="flow-arrow" aria-hidden="true">&rarr;</div>
			<div class="flow-hub">
				<?php foreach ( $hub_lines as $index => $line ) : ?>
					<?php if ( $index > 0 ) : ?><br><?php endif; ?>
					<?php echo esc_html( $line ); ?>
				<?php endforeach; ?>
			</div>
			<div class="flow-arrow" aria-hidden="true">&rarr;</div>
			<div class="flow-dest">
				<?php foreach ( $destinations as $destination ) : ?>
					<span class="fchip-static"><?php echo esc_html( $destination ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if ( '' !== $caption ) : ?>
			<div class="flow-cap"><?php echo esc_html( $caption ); ?></div>
		<?php endif; ?>
	</div>
</div>
