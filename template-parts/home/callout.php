<?php
/**
 * Homepage Section: Callout
 *
 * Background image, text, and CTA button are editable via
 * NG Andersen Settings → Home Page → Callout Section.
 *
 * @package ng-andersen
 */

$ng_callout_image_id  = absint( get_option( 'ng_andersen_callout_image', 0 ) );
$ng_callout_image_url = $ng_callout_image_id
    ? wp_get_attachment_image_url( $ng_callout_image_id, 'full' )
    : get_template_directory_uri() . '/assets/img/bg_callout.webp';

$ng_callout_text     = get_option( 'ng_andersen_callout_text', 'Andersen is an independent tax and business advisory firm with a worldwide presence through the member firms and collaborating firms of Andersen Global.' );
$ng_callout_btn_text = get_option( 'ng_andersen_callout_button_text', 'Learn More' );
$ng_callout_btn_url  = get_option( 'ng_andersen_callout_button_url', '/about-us/' );
$ng_callout_btn_new_tab = (bool) get_option( 'ng_andersen_callout_button_new_tab', false );
?>
<div class="callout">
    <div class="bg img-bg">
        <img src="<?php echo esc_url( $ng_callout_image_url ); ?>" alt="">
    </div>
    <div class="container">
        <div class="text text-center">
            <p><?php echo esc_html( $ng_callout_text ); ?></p>
            <?php if ( $ng_callout_btn_text && $ng_callout_btn_url ) : ?>
                <a href="<?php echo esc_url( $ng_callout_btn_url ); ?>" class="button"<?php if ( $ng_callout_btn_new_tab ) echo ' target="_blank" rel="noopener noreferrer"'; ?>><?php echo esc_html( $ng_callout_btn_text ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>