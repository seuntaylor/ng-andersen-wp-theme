<?php
/**
 * Single Team Member Template
 *
 * Displays individual team member profile with photo, contact info, and biography
 */

get_header();
?>

<!-- Hero Section matching inner-sub.html structure -->
<div class="section-page_hero gradient-diagonal" id="page-hero">
    <!-- Background Image -->
    <div class="bg img-bg">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/landing.jpg" alt="Team member hero">
    </div>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <span class="crumb"><a href="<?php echo esc_url( home_url( '/our-people/' ) ); ?>">Our People</a></span>
                <span class="crumb current"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Hero Text -->
    <div class="container">
        <div class="text">
            <h1><?php the_title(); ?></h1>
            <p><?php echo esc_html( get_post_meta( get_the_ID(), '_team_member_position', true ) ); ?></p>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="section-sidebar">
    <div class="container">
        <div class="grid-x grid-main">
            <!-- Left Sidebar with Photo -->
            <div class="sidebar cell large-3">
                <div class="widget">
                    <!-- Photo -->
                    <div class="widget--team">
                        <div class="item">
                            <div class="image">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'large' );
                                } else {
                                    echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/img/team/placeholder.jpg' ) . '" alt="' . esc_attr( get_the_title() ) . '">';
                                }
                                ?>
                            </div>
                            <div class="text">
                                <h4><?php the_title(); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area (8 columns) -->
            <div class="cell large-8">
                <div class="main-column">
                    <!-- Inner grid with content (8) and right sidebar (4) -->
                    <div class="grid-x grid-padding-x main-column-sub">
                        <!-- Main Biography Content -->
                        <div class="cell large-8">
                            <div class="main-column--content">
                                <?php
                                if ( have_posts() ) {
                                    while ( have_posts() ) {
                                        the_post();
                                        the_content();
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Right Sidebar with Member Details -->
                        <div class="cell large-4">
                            <div class="main-column-sidebar">
                                <div class="widget widget--member-details">
                                    <div class="member-details-box">
                                        <?php
                                        // Position
                                        $position = get_post_meta( get_the_ID(), '_team_member_position', true );
                                        if ( $position ) {
                                            echo '<div class="detail-item">';
                                            echo '<p>' . esc_html( get_the_title() ) . '</p>';
                                            echo '<p>' . esc_html( $position ) . '</p>';
                                            echo '</div>';
                                        }

                                        // Location
                                        $location_id = get_post_meta( get_the_ID(), '_team_member_location', true );
                                        if ( $location_id ) {
                                            $location_term = get_term( $location_id, 'team_location' );
                                            if ( $location_term && ! is_wp_error( $location_term ) ) {
                                                echo '<div class="detail-item">';
                                                echo '<h5>Location</h5>';
                                                echo '<p>' . esc_html( $location_term->name ) . '</p>';
                                                echo '</div>';
                                            }
                                        }

                                        // Email
                                        $email = get_post_meta( get_the_ID(), '_team_member_email', true );
                                        if ( $email ) {
                                            echo '<div class="detail-item">';
                                            echo '<h5>Email</h5>';
                                            echo '<p><a href="' . esc_url( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a></p>';
                                            echo '</div>';
                                        }

                                        // Phone (placeholder - will be added to CPT later)
                                        $phone = get_post_meta( get_the_ID(), '_team_member_phone', true );
                                        if ( $phone ) {
                                            echo '<div class="detail-item">';
                                            echo '<h5>Phone</h5>';
                                            echo '<p><a href="' . esc_url( 'tel:' . $phone ) . '">' . esc_html( $phone ) . '</a></p>';
                                            echo '</div>';
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
    </div>
</div>

<?php get_footer(); ?>