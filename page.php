<?php
/**
 * Default Page Template (page.php)
 *
 * The default template for all WordPress Pages that do not have a
 * specific template selected from the editor's Template dropdown.
 *
 * Layout (based on inner-sub.html):
 * - Hero with featured image (falls back to inner-sub.jpg), breadcrumbs, title
 * - section-sidebar > grid-main:
 *     - Left sidebar (cell large-3) — intentionally blank
 *     - Main area (cell large-9) > main-column-sub:
 *         - Page content (cell large-9)
 *         - Right column (cell large-3) — intentionally blank
 *
 * Pages needing a different layout (full-width, publications, contact, etc.)
 * select their own template from the dropdown and bypass this file.
 *
 * @package ng-andersen
 */

get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- Hero Section -->
<div class="section-page_hero gradient-diagonal" id="page-hero">
    <div class="bg img-bg">
        <?php if ( has_post_thumbnail() ) { ?>
            <?php the_post_thumbnail( 'full', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
        <?php } else { ?>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/inner-sub.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
        <?php } ?>
    </div>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <?php
                // Show parent pages in the breadcrumb trail, if any
                $ancestors = get_post_ancestors( get_the_ID() );
                if ( ! empty( $ancestors ) ) {
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor_id ) {
                        ?>
                        <span class="crumb"><a href="<?php echo esc_url( get_permalink( $ancestor_id ) ); ?>"><?php echo esc_html( get_the_title( $ancestor_id ) ); ?></a></span>
                        <?php
                    }
                }
                ?>
                <span class="crumb current"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Hero Text -->
    <div class="container">
        <div class="text">
            <h1><?php the_title(); ?></h1>
            <p></p>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="section-sidebar">
    <div class="container">
        <div class="grid-x grid-main">

            <!-- Left Sidebar: intentionally blank -->
            <div class="sidebar cell large-3">
            </div>

            <!-- Main Content -->
            <div class="cell large-9">
                <div class="main-column">
                    <div class="grid-x grid-padding-x main-column-sub">

                        <!-- Page content -->
                        <div class="cell large-9">
                            <div class="main-column--content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- Right column: intentionally blank -->
                        <div class="cell large-3">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>