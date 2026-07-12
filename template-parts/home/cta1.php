<?php
/**
 * Homepage Section: CTA 1
 *
 * Background image, heading, text, and CTA button are editable via
 * NG Andersen Settings → Home Page → CTA 1 Section.
 *
 * @package ng-andersen
 */

$ng_cta1_image_id  = absint( get_option( 'ng_andersen_cta1_image', 0 ) );
$ng_cta1_image_url = $ng_cta1_image_id
    ? wp_get_attachment_image_url( $ng_cta1_image_id, 'full' )
    : get_template_directory_uri() . '/assets/img/cta1.jpg';

$ng_cta1_heading     = get_option( 'ng_andersen_cta1_heading', 'About Us' );
$ng_cta1_text        = get_option( 'ng_andersen_cta1_text', 'We provide specialist Tax, Corporate and Commercial Advisory, Regulatory and Transactional Services, Transfer Pricing and business advisory services to resident and non-resident companies doing business in Nigeria, West Africa and globally. The firm consists of professionals with many years of experience in taxation, transfer pricing, accounting advisory and transactional services both at local and international levels.' );
$ng_cta1_btn_text    = get_option( 'ng_andersen_cta1_button_text', 'More About Us' );
$ng_cta1_btn_url     = get_option( 'ng_andersen_cta1_button_url', '/about-us/' );
$ng_cta1_btn_new_tab = (bool) get_option( 'ng_andersen_cta1_button_new_tab', false );
?>
<div class="section-cta1">
    <div class="bg img-bg">
        <img src="<?php echo esc_url( $ng_cta1_image_url ); ?>" alt="">
    </div>
    <div class="container">
        <div class="text">
            <?php if ( $ng_cta1_heading ) : ?>
                <h2><?php echo esc_html( $ng_cta1_heading ); ?></h2>
            <?php endif; ?>
            <p><?php echo esc_html( $ng_cta1_text ); ?></p>
            <?php if ( $ng_cta1_btn_text && $ng_cta1_btn_url ) : ?>
                <a href="<?php echo esc_url( $ng_cta1_btn_url ); ?>" class="button"<?php if ( $ng_cta1_btn_new_tab ) echo ' target="_blank" rel="noopener noreferrer"'; ?>><?php echo esc_html( $ng_cta1_btn_text ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>