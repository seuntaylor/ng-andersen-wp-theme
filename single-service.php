<?php
/**
 * Single Service Template
 *
 * Displays an individual Service CPT entry.
 * - Featured image as hero background
 * - Title as hero heading
 * - Short description as hero subtitle
 * - Long description (editor content) in the main column
 *
 * @package ng-andersen
 */

get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
    $short_desc = get_post_meta( get_the_ID(), '_service_short_description', true );
?>

<!-- Hero Section -->
<div class="section-page_hero gradient" id="page-hero">

    <div class="bg img-bg">
        <?php if ( has_post_thumbnail() ) { ?>
            <?php the_post_thumbnail( 'full', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
        <?php } else { ?>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/landing.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
        <?php } ?>
    </div>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <span class="crumb current"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Hero Text -->
    <div class="container">
        <div class="text">
            <h1><?php the_title(); ?></h1>
            <?php if ( ! empty( $short_desc ) ) { ?>
                <p><?php echo esc_html( $short_desc ); ?></p>
            <?php } ?>
        </div>
    </div>

</div>

<!-- Main Content Section -->
<div class="section-sidebar">
    <div class="container">
        <div class="grid-x grid-main">

            <!-- Left Sidebar: empty, preserves layout -->
            <div class="sidebar cell large-3">
            </div>

            <!-- Main Content: 9 columns -->
            <div class="cell large-9">
                <div class="main-column">
                    <div class="main-column--content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>