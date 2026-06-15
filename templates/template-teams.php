<?php
/**
 * Template Name: Team Members
 *
 * Custom page template for displaying team members with search and filtering.
 *
 * @package ng-andersen
 */

get_header();
?>

<div class="main-content">
    <div class="section-page_hero gradient" id="page-hero">
        <div class="bg img-bg">
            <?php
            // Hero background image — use page's featured image
            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'full', array( 'alt' => 'Our People' ) );
            } else {
                // Fallback image if no featured image set
                $fallback_image = get_template_directory_uri() . '/assets/img/our-people.jpg';
                ?>
                <img src="<?php echo esc_url( $fallback_image ); ?>" alt="Our People">
                <?php
            }
            ?>
        </div>
        
        <div class="breadcrumbs-section">
            <div class="container">
                <div class="breadcrumbs">
                    <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                    <span class="crumb current">Our People</span>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="text">
                <h1>Our People</h1>
                <div class="page-subtitle">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="section-our_people">
        <div class="container">
            <div class="grid-x grid-padding-x">
                
                <!-- Left Sidebar: Filters -->
                <div class="cell large-4">
                    <div class="block-filters">
                        <div class="text">
                            <h2>Find an Andersen advisor who meets your needs.</h2>
                            <p>Search by specialization and location, and/or use the search field to find someone by name.</p>
                        </div>
                        
                        <form id="team-search-form">
                            <!-- Name Search -->
                            <div class="form-item">
                                <label for="team-search-name">Name Search</label>
                                <div class="form-item--field">
                                    <input 
                                        type="text" 
                                        id="team-search-name"
                                        name="name" 
                                        placeholder="Search by Name"
                                        class="team-search-input"
                                        data-filter="name"
                                    >
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div class="form-item">
                                <label for="team-search-location">Location</label>
                                <div class="form-item--field">
                                    <select 
                                        id="team-search-location"
                                        name="location"
                                        class="team-search-input"
                                        data-filter="location"
                                    >
                                        <option value="">All Locations</option>
                                        <?php
                                        // Get all team locations
                                        $locations = get_terms( array(
                                            'taxonomy'   => 'team_location',
                                            'hide_empty' => false,
                                        ) );

                                        if ( $locations && ! is_wp_error( $locations ) ) {
                                            foreach ( $locations as $location ) {
                                                ?>
                                                <option value="<?php echo esc_attr( $location->term_id ); ?>">
                                                    <?php echo esc_html( $location->name ); ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Position/Title Filter -->
                            <div class="form-item">
                                <label for="team-search-position">All Titles</label>
                                <div class="form-item--field">
                                    <select 
                                        id="team-search-position"
                                        name="position"
                                        class="team-search-input"
                                        data-filter="position"
                                    >
                                        <option value="">All</option>
                                        <?php
                                        // Get unique positions from team members
                                        global $wpdb;
                                        $positions = $wpdb->get_col( "
                                            SELECT DISTINCT pm.meta_value
                                            FROM {$wpdb->postmeta} pm
                                            JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                                            WHERE pm.meta_key = '_team_member_position'
                                            AND p.post_type = 'team_member'
                                            AND p.post_status = 'publish'
                                            ORDER BY pm.meta_value ASC
                                        " );

                                        if ( $positions ) {
                                            foreach ( $positions as $pos ) {
                                                if ( ! empty( $pos ) ) {
                                                    ?>
                                                    <option value="<?php echo esc_attr( $pos ); ?>">
                                                        <?php echo esc_html( $pos ); ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Reset Button -->
                            <div class="form-reset">
                                <input 
                                    type="reset" 
                                    id="team-search-reset"
                                    value="Reset"
                                >
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Content: Results -->
                <div class="cell large-8">
                    <div class="search-results-summary" id="team-results-summary">
                        <p><strong>Search Results:</strong> All Locations / All Services / All Positions</p>
                    </div>

                    <div id="team-results-container">
                        <?php
                        // Initial load — show first 10 team members
                        $args = array(
                            'post_type'      => 'team_member',
                            'posts_per_page' => 10,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
                        );

                        $query = new WP_Query( $args );

                        if ( $query->have_posts() ) {
                            ?>
                            <div class="people-list">
                                <?php
                                while ( $query->have_posts() ) {
                                    $query->the_post();
                                    $position = get_post_meta( get_the_ID(), '_team_member_position', true );
                                    $locations = get_the_terms( get_the_ID(), 'team_location' );
                                    $location_text = '';

                                    if ( $locations && ! is_wp_error( $locations ) ) {
                                        $location_names = wp_list_pluck( $locations, 'name' );
                                        $location_text = implode( ', ', $location_names );
                                    }
                                    ?>
                                    <a class="item" href="<?php echo esc_url( get_permalink() ); ?>">
                                        <span class="item-img">
                                            <span><?php the_post_thumbnail( 'medium' ); ?></span>
                                        </span>
                                        <span class="item-name"><?php the_title(); ?></span>
                                        <span class="item-location">
                                            <?php
                                            // Get location name from term ID
                                            $location_id = get_post_meta( get_the_ID(), '_team_member_location', true );
                                            if ( $location_id ) {
                                                $location_term = get_term( $location_id, 'team_location' );
                                                if ( $location_term && ! is_wp_error( $location_term ) ) {
                                                    echo esc_html( $location_term->name );
                                                }
                                            }
                                            ?>
                                        </span>
                                        <span class="item-position"><?php echo esc_html( $position ); ?></span>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>

                            <?php
                            // Pagination
                            $total_pages = $query->max_num_pages;
                            if ( $total_pages > 1 ) {
                                ?>
                                <nav aria-label="Pagination">
                                    <ul class="pagination text-center">
                                        <?php
                                        // Previous button
                                        if ( 1 > 1 ) {
                                            ?>
                                            <li class="pagination-previous">
                                                <a href="#" class="page-link" data-page="0">Previous</a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li class="pagination-previous disabled">Previous</li>
                                            <?php
                                        }

                                        // Page numbers — show up to 7 page links or with ellipsis
                                        for ( $i = 1; $i <= $total_pages; $i++ ) {
                                            // Show first 4 pages, ellipsis if needed, then last 2 pages
                                            if ( $i <= 4 || $i > $total_pages - 2 ) {
                                                if ( $i == 1 ) {
                                                    ?>
                                                    <li class="current"><span class="show-for-sr">You're on page</span> <?php echo $i; ?></li>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <li><a href="#" class="page-link" data-page="<?php echo $i; ?>" aria-label="Page <?php echo $i; ?>"><?php echo $i; ?></a></li>
                                                    <?php
                                                }
                                            } elseif ( $i == 5 && $total_pages > 7 ) {
                                                // Show ellipsis
                                                ?>
                                                <li class="ellipsis"></li>
                                                <?php
                                            }
                                        }

                                        // Next button
                                        if ( 1 < $total_pages ) {
                                            ?>
                                            <li class="pagination-next">
                                                <a href="#" class="page-link" data-page="2" aria-label="Next page">Next</a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li class="pagination-next disabled">
                                                <a href="#" aria-label="Next page">Next</a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </nav>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="people-list">
                                <div class="team-no-results">
                                    <p>No team members found.</p>
                                </div>
                            </div>
                            <?php
                        }

                        wp_reset_postdata();
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
get_footer();