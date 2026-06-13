<?php
/**
 * Search Results Template
 *
 * Displays search results as a paginated 4-column card grid.
 * Follows the section-blocks1 bg-gray pattern from index.html.
 *
 * @package ng-andersen
 */

get_header();

global $wp_query;
$total_results = $wp_query->found_posts;
$search_term   = get_search_query();
?>

<!-- Hero Section -->
<div class="section-page_hero gradient" id="page-hero">
    <div class="bg img-bg">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/landing.jpg" alt="Search results">
    </div>

    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <span class="crumb current">Search Results</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="text">
            <h1>Search Results for:<br><em><?php echo esc_html( $search_term ); ?></em></h1>
        </div>
    </div>
</div>

<!-- Results Section -->
<div class="section-blocks section-blocks1 bg-gray">
    <div class="container">

        <?php if ( have_posts() ) : ?>

            <div class="grid-x grid-padding-x">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="cell large-3 medium-6">
                        <div class="item">
                            <div class="image">
                                <span class="img-bg">
                                    <?php if ( 'post' === get_post_type() ) { ?>
                                        <img src="<?php echo esc_url( ng_andersen_get_post_card_image( get_the_ID() ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                    <?php } elseif ( has_post_thumbnail() ) { ?>
                                        <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
                                    <?php } else { ?>
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block1.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                    <?php } ?>
                                </span>
                            </div>
                            <div class="text">
                                <div class="text-body">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 55, '&hellip;' ) ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="button-link">Read More &raquo;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php
            $total_pages = $wp_query->max_num_pages;
            if ( $total_pages > 1 ) {
                $current_page = max( 1, get_query_var( 'paged' ) );
                ?>
                <nav aria-label="Search Results Pagination" id="search-pagination">
                    <ul class="pagination text-center">
                        <?php if ( $current_page > 1 ) { ?>
                            <li class="pagination-previous">
                                <a href="<?php echo esc_url( get_pagenum_link( $current_page - 1 ) ); ?>">Previous</a>
                            </li>
                        <?php } else { ?>
                            <li class="pagination-previous disabled"><span>Previous</span></li>
                        <?php } ?>

                        <?php
                        // Build the set of page numbers to show:
                        // Always: first 2, last 2, current page and 1 neighbour each side
                        $show_pages = array();
                        for ( $i = 1; $i <= $total_pages; $i++ ) {
                            if (
                                $i <= 2 ||
                                $i >= $total_pages - 1 ||
                                ( $i >= $current_page - 1 && $i <= $current_page + 1 )
                            ) {
                                $show_pages[] = $i;
                            }
                        }
                        $show_pages = array_unique( $show_pages );
                        sort( $show_pages );

                        $prev_shown = null;
                        foreach ( $show_pages as $i ) {
                            if ( $prev_shown !== null && $i > $prev_shown + 1 ) {
                                ?>
                                <li class="ellipsis"><span></span></li>
                                <?php
                            }

                            if ( $i == $current_page ) {
                                ?>
                                <li class="current">
                                    <span class="show-for-sr">You're on page</span><?php echo absint( $i ); ?>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li>
                                    <a href="<?php echo esc_url( get_pagenum_link( $i ) ); ?>" aria-label="Page <?php echo absint( $i ); ?>"><?php echo absint( $i ); ?></a>
                                </li>
                                <?php
                            }

                            $prev_shown = $i;
                        }
                        ?>

                        <?php if ( $current_page < $total_pages ) { ?>
                            <li class="pagination-next">
                                <a href="<?php echo esc_url( get_pagenum_link( $current_page + 1 ) ); ?>">Next</a>
                            </li>
                        <?php } else { ?>
                            <li class="pagination-next disabled"><span>Next</span></li>
                        <?php } ?>
                    </ul>
                </nav>
                <?php
            }
            ?>

        <?php else : ?>

            <div class="grid-x">
                <div class="cell">
                    <p class="search-no-results">We&rsquo;re sorry, your search query yielded no results. Please try a different word or phrase.</p>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>