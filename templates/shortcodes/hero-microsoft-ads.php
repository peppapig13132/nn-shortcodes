<?php
/**
 * Microsoft Ads LinkedIn targeting mock.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="<?php echo esc_attr( $block ); ?>">
	<div class="msmock" role="img" aria-label="<?php echo esc_attr__( 'Microsoft Advertising targeting preview', 'nn-shortcodes' ); ?>">
		<div class="ms-bar" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="ms-body">
			<div class="ms-title"><span class="gdot" aria-hidden="true"></span><?php esc_html_e( 'Microsoft Advertising · target by LinkedIn profile', 'nn-shortcodes' ); ?></div>
			<div class="ms-row">
				<span class="lbl"><?php esc_html_e( 'Industry', 'nn-shortcodes' ); ?></span>
				<span class="ms-chips">
					<span class="ms-chip"><?php esc_html_e( 'SaaS', 'nn-shortcodes' ); ?></span>
					<span class="ms-chip"><?php esc_html_e( 'Finance', 'nn-shortcodes' ); ?></span>
					<span class="ms-chip"><?php esc_html_e( 'Healthcare', 'nn-shortcodes' ); ?></span>
				</span>
			</div>
			<div class="ms-row">
				<span class="lbl"><?php esc_html_e( 'Company size', 'nn-shortcodes' ); ?></span>
				<span class="ms-chips"><span class="ms-chip">200&ndash;1,000</span></span>
			</div>
			<div class="ms-row">
				<span class="lbl"><?php esc_html_e( 'Job function', 'nn-shortcodes' ); ?></span>
				<span class="ms-chips">
					<span class="ms-chip"><?php esc_html_e( 'Director+', 'nn-shortcodes' ); ?></span>
					<span class="ms-chip"><?php esc_html_e( 'Marketing', 'nn-shortcodes' ); ?></span>
				</span>
			</div>
			<div class="ms-kpis">
				<div class="msk"><b>&minus;38%</b><i><?php esc_html_e( 'cost / lead vs Google', 'nn-shortcodes' ); ?></i></div>
				<div class="msk"><b><?php esc_html_e( 'B2B', 'nn-shortcodes' ); ?></b><i><?php esc_html_e( 'LinkedIn intent', 'nn-shortcodes' ); ?></i></div>
				<div class="msk"><b><?php esc_html_e( 'Desktop', 'nn-shortcodes' ); ?></b><i><?php esc_html_e( 'higher-income', 'nn-shortcodes' ); ?></i></div>
			</div>
		</div>
		<div class="ms-cap"><?php esc_html_e( '[Illustrative — replace with real targeting + account results]', 'nn-shortcodes' ); ?></div>
	</div>
</div>
