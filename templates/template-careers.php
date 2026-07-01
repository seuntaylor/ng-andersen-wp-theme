<?php
/**
 * Template Name: Careers
 *
 * Based on the default page layout (page.php): hero, blank left sidebar,
 * page content, blank right column. Below the content section, the
 * Seamless Hiring job board widget is embedded at full width.
 *
 * The embed uses Bootstrap classes; the needed subset is reimplemented
 * in custom.css scoped to #SH_Embed to avoid Foundation conflicts.
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

<!-- Seamless Hiring Job Board — full width, outside the sidebar layout -->
<div class="section-careers-embed">
    <div class="container">
        <div id="SH_Embed"></div>
        <script src="https://andersen.seamlesshiring.com/js/embed.js"></script>
        <script type="text/javascript">document.getElementById('SH_Embed').innerHTML=SH_Embed.pull({key : 'eyJpdiI6IjlQdDhFdGtHMmZqcGloaWhoK0F2RUE9PSIsInZhbHVlIjoid1J0NVRDaXNPSWNoMjJJTEd0RGNKVW5qYzhsK2ZQRjlESXc1MnN1VDlwOEVvV3I5ajVjNFBidVo5emcyVDRGMmtBc0VLTjY1SDVUTmsyVXliTmx0TW1xYXZXTVBBaWlMZmRoL0hCZ2cxM0U9IiwibWFjIjoiOTllMGJjMWM0M2Q1ODM3ZWQ0MTcxMTczNTVjNjJkMWVhODI2MDA3ZGM0Nzc2YmE5YmI5Mjk1NzJlOGY2YTRkYiIsInRhZyI6IiJ9', base_url : 'https://andersen.seamlesshiring.com/'});</script>
    </div>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>