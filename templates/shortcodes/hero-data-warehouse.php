<?php
/**
 * Data Warehouse pipeline mock.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="<?php echo esc_attr( $block ); ?>">
	<div class="dwmock" role="img" aria-label="<?php echo esc_attr__( 'Data warehouse pipeline preview', 'nn-shortcodes' ); ?>">
		<div class="dw-bar" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="dw-body">
			<div class="dw-lab"><?php esc_html_e( 'Your marketing data, scattered', 'nn-shortcodes' ); ?></div>
			<div class="dw-srcs">
				<span class="dw-chip"><?php esc_html_e( 'Google Ads', 'nn-shortcodes' ); ?></span>
				<span class="dw-chip"><?php esc_html_e( 'Meta', 'nn-shortcodes' ); ?></span>
				<span class="dw-chip"><?php esc_html_e( 'Microsoft', 'nn-shortcodes' ); ?></span>
				<span class="dw-chip"><?php esc_html_e( 'GA4', 'nn-shortcodes' ); ?></span>
				<span class="dw-chip"><?php esc_html_e( 'CRM', 'nn-shortcodes' ); ?></span>
				<span class="dw-chip"><?php esc_html_e( 'Calls', 'nn-shortcodes' ); ?></span>
			</div>
			<div class="dw-arrow" aria-hidden="true">&darr;</div>
			<div class="dw-core">
				<?php esc_html_e( 'BigQuery · your cloud', 'nn-shortcodes' ); ?>
				<small><?php esc_html_e( 'one queryable source of truth you own', 'nn-shortcodes' ); ?></small>
			</div>
			<div class="dw-arrow" aria-hidden="true">&darr;</div>
			<div class="dw-outs">
				<span class="dw-out"><?php esc_html_e( 'Attribution', 'nn-shortcodes' ); ?></span>
				<span class="dw-out"><?php esc_html_e( 'Reporting', 'nn-shortcodes' ); ?></span>
				<span class="dw-out"><?php esc_html_e( 'Forecasting', 'nn-shortcodes' ); ?></span>
			</div>
		</div>
		<div class="dw-cap"><?php esc_html_e( '[Illustrative — your sources, modeled into one warehouse]', 'nn-shortcodes' ); ?></div>
	</div>
</div>
