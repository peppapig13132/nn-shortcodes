<?php
/**
 * Full-funnel hero dashboard mock template.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 * @var bool   $has_content
 * @var string $heading
 * @var string $caption
 * @var array<int, array{channel: string, cost: float, roas: float, win: bool, note: string}> $rows
 * @var float  $duration
 * @var string $extra
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $has_content ) ) {
	return;
}
?>
<div
	class="<?php echo nn_block_classes( $block, $extra ); ?>"
	data-duration="<?php echo esc_attr( (string) $duration ); ?>"
	role="img"
	aria-label="<?php echo esc_attr( $heading ); ?>"
>
	<div class="<?php echo nn_class( $block, 'mock' ); ?>">
		<div class="<?php echo nn_class( $block, 'bar' ); ?>" aria-hidden="true">
			<span></span><span></span><span></span>
		</div>
		<div class="<?php echo nn_class( $block, 'body' ); ?>">
			<div class="<?php echo nn_class( $block, 'heading' ); ?>">
				<span class="<?php echo nn_class( $block, 'dot' ); ?>" aria-hidden="true"></span>
				<span class="<?php echo nn_class( $block, 'heading-text' ); ?>"><?php echo esc_html( $heading ); ?></span>
			</div>
			<table class="<?php echo nn_class( $block, 'table' ); ?>">
				<thead>
					<tr>
						<th scope="col"><?php echo esc_html__( 'Channel', 'nn-shortcodes' ); ?></th>
						<th scope="col"><?php echo esc_html__( 'Cost / lead', 'nn-shortcodes' ); ?></th>
						<th scope="col"><?php echo esc_html__( 'ROAS', 'nn-shortcodes' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<tr class="<?php echo $row['win'] ? esc_attr( nn_class( $block, 'row', 'win' ) ) : esc_attr( nn_class( $block, 'row' ) ); ?>">
							<td>
								<?php echo esc_html( $row['channel'] ); ?>
								<?php if ( ! empty( $row['note'] ) ) : ?>
									<span class="<?php echo nn_class( $block, 'inline-up' ); ?>"><?php echo esc_html( $row['note'] ); ?></span>
								<?php endif; ?>
							</td>
							<td>
								<span
									class="<?php echo nn_class( $block, 'count' ); ?>"
									data-nn-count
									data-nn-target="<?php echo esc_attr( (string) $row['cost'] ); ?>"
									data-nn-prefix="$"
									data-nn-decimals="0"
								>0</span>
							</td>
							<td>
								<span
									class="<?php echo nn_class( $block, 'count' ); ?>"
									data-nn-count
									data-nn-target="<?php echo esc_attr( (string) $row['roas'] ); ?>"
									data-nn-suffix="x"
									data-nn-decimals="1"
								>0</span>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php if ( '' !== $caption ) : ?>
			<div class="<?php echo nn_class( $block, 'caption' ); ?>"><?php echo esc_html( $caption ); ?></div>
		<?php endif; ?>
	</div>
</div>
