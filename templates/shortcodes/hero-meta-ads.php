<?php
/**
 * Meta Ads feed-ad-preview mock.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="<?php echo esc_attr( $block ); ?>">
	<div class="fbmock" role="img" aria-label="<?php echo esc_attr__( 'Meta feed ad preview', 'nn-shortcodes' ); ?>">
		<div class="fb-bar" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="fb-body">
			<div class="fb-ad">
				<div class="fb-head">
					<span class="fb-avatar" aria-hidden="true"></span>
					<div>
						<div class="fb-name">nn.partners</div>
						<div class="fb-spon"><?php esc_html_e( 'Sponsored', 'nn-shortcodes' ); ?></div>
					</div>
				</div>
				<div class="fb-text"><?php esc_html_e( 'Scaling Meta on numbers you can\'t trust? We feed Meta clean server-side data, then scale the creative that actually converts.', 'nn-shortcodes' ); ?></div>
				<div class="fb-creative"><?php esc_html_e( '[Ad creative]', 'nn-shortcodes' ); ?></div>
				<div class="fb-foot">
					<div>
						<div class="h"><?php esc_html_e( 'Meta Ads That Reconcile With the Bank', 'nn-shortcodes' ); ?></div>
						<div class="sub">nn.partners · <?php esc_html_e( 'Free audit', 'nn-shortcodes' ); ?></div>
					</div>
					<span class="fb-btn"><?php esc_html_e( 'Learn More', 'nn-shortcodes' ); ?></span>
				</div>
			</div>
			<div class="fb-kpis">
				<div class="fbk"><b>4.2x</b><i><?php esc_html_e( 'ROAS', 'nn-shortcodes' ); ?></i></div>
				<div class="fbk"><b>&minus;29%</b><i><?php esc_html_e( 'Cost / acq.', 'nn-shortcodes' ); ?></i></div>
				<div class="fbk"><b>+41%</b><i><?php esc_html_e( 'Conv. tracked', 'nn-shortcodes' ); ?></i></div>
			</div>
		</div>
		<div class="fb-cap"><?php esc_html_e( '[Illustrative — replace with a real ad + account results]', 'nn-shortcodes' ); ?></div>
	</div>
</div>
