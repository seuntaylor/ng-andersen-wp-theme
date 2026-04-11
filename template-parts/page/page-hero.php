<?php
/**
 * Template Part: Page Hero
 *
 * Reusable page hero section with breadcrumbs, background image,
 * headline and intro text. Used across all inner page templates.
 *
 * Variables are passed via set_query_var() in the calling template
 * and retrieved here via get_query_var():
 *
 * hero_image   — filename of the hero background image from assets/img/
 *                e.g. 'slider-inner-reach.jpg'
 * hero_title   — the page h1 headline
 * hero_intro   — the intro paragraph text (optional)
 * breadcrumbs  — array of crumbs, each with 'label' and optional 'url'
 *                the last item is always the current page (no url needed)
 *
 * @package ng-andersen
 */

$hero_image  = get_query_var( 'hero_image',  '' );
$hero_title  = get_query_var( 'hero_title',  '' );
$hero_intro  = get_query_var( 'hero_intro',  '' );
$breadcrumbs = get_query_var( 'breadcrumbs', array() );
?>
<div class="section-page_hero gradient-diagonal" id="page-hero">

    <div class="bg img-bg">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/' . $hero_image ); ?>" alt="">
    </div>

    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <?php foreach ( $breadcrumbs as $crumb ) : ?>
                    <?php if ( ! empty( $crumb['url'] ) ) : ?>
                        <span class="crumb"><a href="<?php echo esc_url( $crumb['url'] ); ?>"><?php echo esc_html( $crumb['label'] ); ?></a></span>
                    <?php else : ?>
                        <span class="crumb current"><?php echo esc_html( $crumb['label'] ); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="text">
            <h1><?php echo esc_html( $hero_title ); ?></h1>
            <?php if ( ! empty( $hero_intro ) ) : ?>
                <p><?php echo wp_kses_post( $hero_intro ); ?></p>
            <?php endif; ?>
        </div>
    </div>

</div>