<?php
/**
 * Preheading template.
 *
 * @package NN_Shortcodes
 *
 * @var string $block
 * @var string $text
 * @var string $extra
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( $text ) : ?>
	<div class="<?php echo nn_block_classes( $block, $extra ); ?>">
		<span class="<?php echo nn_class( $block, 'dash' ); ?>" aria-hidden="true"></span>
		<span class="<?php echo nn_class( $block, 'text' ); ?>"><?php echo esc_html( $text ); ?></span>
	</div>
<?php endif; ?>

