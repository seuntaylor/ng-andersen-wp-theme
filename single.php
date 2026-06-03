<?php
/**
 * Single Post Template
 *
 * Default template for all blog posts.
 * Follows the inner-sub.html structure with:
 * - Featured image as hero background
 * - Post title as hero heading
 * - Full post content in main column (9 of 9 cols)
 * - Related posts widget in right sidebar (3 of 9 cols)
 *
 * @package ng-andersen
 */

get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- Hero Section — featured image as background -->
<div class="section-page_hero gradient-diagonal" id="page-hero">

    <!-- Background: featured image or fallback -->
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
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    ?>
                    <span class="crumb">
                        <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
                            <?php echo esc_html( $categories[0]->name ); ?>
                        </a>
                    </span>
                    <?php
                }
                ?>
                <span class="crumb current"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Hero Text — post title only -->
    <div class="container">
        <div class="text">
            <h1><?php the_title(); ?></h1>
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
                    <div class="grid-x grid-padding-x main-column-sub">

                        <!-- Post Content: 9 of 9 cols -->
                        <div class="cell large-9">
                            <div class="main-column--content">
                                <?php the_content(); ?>

                                <?php
                                // Download button — only renders if meta value exists
                                $download_link = get_post_meta( get_the_ID(), 'download_link', true );
                                if ( ! empty( $download_link ) ) {
                                    ?>
                                    <div class="post-download">
                                        <a href="<?php echo esc_url( $download_link ); ?>" class="button" target="_blank" rel="noopener noreferrer">
                                            Download File
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Right Sidebar: related posts widget -->
                        <div class="cell large-3">
                            <div class="main-column-sidebar">
                                <?php
                                $single_settings  = ng_andersen_get_single_post_settings();
                                $widget_title     = $single_settings['widget_title'];
                                $widget_cats      = $single_settings['widget_cats'];
                                $widget_count     = $single_settings['widget_count'];
                                $resources_title  = $single_settings['resources_title'];
                                $resources_cats   = $single_settings['resources_cats'];
                                $resources_count  = $single_settings['resources_count'];

                                // Related Posts Widget (widget--news)
                                // Pulls random posts from admin-selected categories
                                if ( ! empty( $widget_cats ) ) {
                                    $related_query = new WP_Query( array(
                                        'post_type'      => 'post',
                                        'posts_per_page' => $widget_count,
                                        'post_status'    => 'publish',
                                        'orderby'        => 'rand',
                                        'post__not_in'   => array( get_the_ID() ),
                                        'tax_query'      => array(
                                            array(
                                                'taxonomy' => 'category',
                                                'field'    => 'term_id',
                                                'terms'    => $widget_cats,
                                                'operator' => 'IN',
                                            ),
                                        ),
                                    ) );

                                    if ( $related_query->have_posts() ) {
                                        ?>
                                        <div class="widget">
                                            <h4><?php echo esc_html( $widget_title ); ?></h4>
                                            <div class="widget--news">
                                                <div class="section-blocks1">
                                                    <?php
                                                    while ( $related_query->have_posts() ) {
                                                        $related_query->the_post();
                                                        ?>
                                                        <div class="item">
                                                            <div class="image">
                                                                <span class="img-bg">
                                                                    <?php
                                                                    if ( has_post_thumbnail() ) {
                                                                        the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) );
                                                                    } else {
                                                                        ?>
                                                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block1.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </div>
                                                            <div class="text">
                                                                <div class="text-body">
                                                                    <p><?php the_title(); ?></p>
                                                                    <a href="<?php the_permalink(); ?>" class="button-link">Read More &raquo;</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    wp_reset_postdata();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }

                                // Resources Widget (widget--resources)
                                // Pulls random posts from multiple selected categories
                                if ( ! empty( $resources_cats ) ) {
                                    $resources_query = new WP_Query( array(
                                        'post_type'      => 'post',
                                        'posts_per_page' => $resources_count,
                                        'post_status'    => 'publish',
                                        'orderby'        => 'rand',
                                        'post__not_in'   => array( get_the_ID() ),
                                        'tax_query'      => array(
                                            array(
                                                'taxonomy' => 'category',
                                                'field'    => 'term_id',
                                                'terms'    => $resources_cats,
                                                'operator' => 'IN',
                                            ),
                                        ),
                                    ) );

                                    if ( $resources_query->have_posts() ) {
                                        ?>
                                        <div class="widget">
                                            <h4><?php echo esc_html( $resources_title ); ?></h4>
                                            <div class="widget--resources">
                                                <?php
                                                while ( $resources_query->have_posts() ) {
                                                    $resources_query->the_post();
                                                    $post_cats = get_the_category();
                                                    $cat_label = ! empty( $post_cats ) ? $post_cats[0]->name : '';
                                                    ?>
                                                    <div class="item">
                                                        <?php if ( ! empty( $cat_label ) ) { ?>
                                                            <h4>
                                                                <i class="fa-regular fa-file-lines" aria-hidden="true"></i>
                                                                <?php echo esc_html( $cat_label ); ?>
                                                            </h4>
                                                        <?php } ?>
                                                        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                                    </div>
                                                    <?php
                                                }
                                                wp_reset_postdata();
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>