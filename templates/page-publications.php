<?php
/**
 * Template Name: Publications
 * Description: Displays all blog posts with AJAX category filtering and pagination
 *
 * @package ng-andersen
 */

get_header();

// Get initial category from URL for server-side render on first load
$current_cat = isset( $_GET['publication_cat'] ) ? absint( $_GET['publication_cat'] ) : 0;

// Get all categories with posts for sidebar
$categories = get_categories( array(
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => true,
) );
?>

<!-- Hero Section -->
<div class="section-page_hero gradient-diagonal" id="page-hero">
    <div class="bg img-bg">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/landing.jpg" alt="Publications hero">
    </div>

    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <span class="crumb current"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="text">
            <h1><?php the_title(); ?></h1>
            <p><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="section-sidebar">
    <div class="container">
        <div class="grid-x grid-main">

            <!-- Sidebar: Accordion Category Filter -->
            <div class="sidebar cell large-3">
                <nav id="publications-filter-nav">
                    <ul class="lvl-1 vertical menu accordion-menu" data-accordion-menu>
                        <li class="is-active">
                            <a href="<?php echo esc_url( get_permalink() ); ?>" data-cat="0">
                                Publications
                            </a>
                            <ul class="lvl-2 vertical nested is-active">
                                <?php foreach ( $categories as $cat ) { ?>
                                    <li class="<?php echo $current_cat === $cat->term_id ? 'is-active' : ''; ?>">
                                        <a href="<?php echo esc_url( add_query_arg( 'publication_cat', $cat->term_id, get_permalink() ) ); ?>" data-cat="<?php echo absint( $cat->term_id ); ?>">
                                            <?php echo esc_html( $cat->name ); ?>
                                            <span class="cat-count">(<?php echo absint( $cat->count ); ?>)</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="cell large-9">
                <div class="main-column">
                    <!-- Posts grid and pagination updated via AJAX -->
                    <!-- Initial render uses the same function as the AJAX handler -->
                    <div id="publications-grid">
                        <?php echo ng_andersen_publications_html( $current_cat, 1 ); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>