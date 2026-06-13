<?php
/**
 * Analytics dashboard mock.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="<?php echo esc_attr( $block ); ?>">
	<div class="dash-mock" role="img" aria-label="<?php echo esc_attr__( 'Analytics dashboard preview', 'nn-shortcodes' ); ?>">
		<div class="dash-bar" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="dash-body">
			<div class="dash-kpis">
				<div class="dk"><b>+30%</b><i><?php esc_html_e( 'Revenue', 'nn-shortcodes' ); ?></i></div>
				<div class="dk"><b>4:1</b><i><?php esc_html_e( 'ROAS', 'nn-shortcodes' ); ?></i></div>
				<div class="dk"><b>&minus;28%</b><i><?php esc_html_e( 'CPA', 'nn-shortcodes' ); ?></i></div>
			</div>
			<div class="dash-chart" aria-hidden="true">
				<span style="height:42%"></span>
				<span style="height:64%"></span>
				<span style="height:50%"></span>
				<span style="height:78%"></span>
				<span style="height:68%"></span>
				<span style="height:96%"></span>
			</div>
		</div>
		<div class="dash-cap"><?php esc_html_e( '[Illustrative — replace with a real dashboard screenshot]', 'nn-shortcodes' ); ?></div>
	</div>
</div>
