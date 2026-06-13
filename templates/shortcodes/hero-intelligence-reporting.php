<?php
/**
 * Intelligence Reporting reconciled report mock.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="<?php echo esc_attr( $block ); ?>">
	<div class="irmock" role="img" aria-label="<?php echo esc_attr__( 'Reconciled ROAS report preview', 'nn-shortcodes' ); ?>">
		<div class="ir-bar" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="ir-body">
			<div class="ir-h"><span class="gdot" aria-hidden="true"></span><?php esc_html_e( 'ROAS · platform-reported vs reconciled to revenue', 'nn-shortcodes' ); ?></div>
			<table class="ir-table">
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e( 'Channel', 'nn-shortcodes' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Reported', 'nn-shortcodes' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Reconciled', 'nn-shortcodes' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php esc_html_e( 'Google', 'nn-shortcodes' ); ?></td>
						<td><span class="ir-rep">4.1x</span></td>
						<td><span class="ir-rec">2.8x</span></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Meta', 'nn-shortcodes' ); ?></td>
						<td><span class="ir-rep">5.2x</span></td>
						<td><span class="ir-rec">3.4x</span></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Microsoft', 'nn-shortcodes' ); ?></td>
						<td><span class="ir-rep">3.0x</span></td>
						<td><span class="ir-rec">2.6x</span></td>
					</tr>
				</tbody>
			</table>
			<div class="ir-badge">&#10003; <?php esc_html_e( 'Reconciled to revenue & CRM', 'nn-shortcodes' ); ?></div>
		</div>
		<div class="ir-cap"><?php esc_html_e( '[Illustrative — your real one-screen reconciled dashboard]', 'nn-shortcodes' ); ?></div>
	</div>
</div>
