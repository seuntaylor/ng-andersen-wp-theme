<?php
/**
 * Template Name: Publications (Dropdown)
 * Description: Publications with search + category dropdown filter sidebar
 *
 * @package ng-andersen
 */

get_header();

// Get initial category from URL for server-side render on first load
$current_cat = isset( $_GET['publication_cat'] ) ? absint( $_GET['publication_cat'] ) : 0;

// Get all categories with posts for dropdown
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
<div class="section-our_people">
    <div class="container">
        <div class="grid-x grid-padding-x">

            <!-- Sidebar: Search + Category Filter -->
            <div class="cell large-3">
                <div class="block-filters">
                    <form id="publications-filter-form" action="#">

                        <!-- Search Input -->
                        <div class="form-item">
                            <label for="publication-search">Search</label>
                            <div class="form-item--field">
                                <input
                                    type="text"
                                    id="publication-search"
                                    name="publication_search"
                                    placeholder="Search publications..."
                                    autocomplete="off"
                                >
                                <button type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="form-item">
                            <label for="publication-category">Category</label>
                            <div class="form-item--field">
                                <select id="publication-category" name="publication_cat">
                                    <option value="0">All Categories</option>
                                    <?php foreach ( $categories as $cat ) { ?>
                                        <option value="<?php echo absint( $cat->term_id ); ?>" <?php selected( $current_cat, $cat->term_id ); ?>>
                                            <?php echo esc_html( $cat->name ); ?> (<?php echo absint( $cat->count ); ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Results -->
            <div class="cell large-9">
                <div id="publications-results-summary" class="search-results-summary">
                    <?php $summary_cat = $current_cat > 0 ? get_cat_name( $current_cat ) : 'All Categories'; ?>
                    <p><strong>Showing:</strong> <?php echo esc_html( $summary_cat ); ?></p>
                </div>

                <!-- Posts grid and pagination updated via AJAX -->
                <div id="publications-grid">
                    <?php echo ng_andersen_publications_html( $current_cat, 1 ); ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>