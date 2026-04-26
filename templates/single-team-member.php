<?php
/**
 * Single Team Member Template
 *
 * Displays an individual team member's profile page.
 *
 * @package ng-andersen
 */

get_header();

// Get team member data
$position = get_post_meta( get_the_ID(), '_team_member_position', true );
$email = get_post_meta( get_the_ID(), '_team_member_email', true );
$locations = get_the_terms( get_the_ID(), 'team_location' );
$location_text = '';

if ( $locations && ! is_wp_error( $locations ) ) {
    $location_names = wp_list_pluck( $locations, 'name' );
    $location_text = implode( ', ', $location_names );
}

// Set breadcrumbs
set_query_var( 'breadcrumbs', array(
    array( 'label' => 'Our Team', 'link' => get_post_type_archive_link( 'team_member' ) ),
    array( 'label' => get_the_title() ),
) );

get_template_part( 'template-parts/page/page-hero' );
?>

<div class="main-content">
    <div class="container">
        <div class="grid-x grid-padding-x">

            <!-- Team Member Image & Info Sidebar -->
            <div class="cell medium-4 small-12">
                <div class="team-member-card">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'large', array( 'class' => 'team-member-image' ) );
                    }
                    ?>
                    <div class="team-member-info" style="margin-top: 20px;">
                        <h2><?php the_title(); ?></h2>

                        <?php if ( $position ) : ?>
                            <p class="team-member-position">
                                <strong><?php echo esc_html( $position ); ?></strong>
                            </p>
                        <?php endif; ?>

                        <?php if ( $location_text ) : ?>
                            <p class="team-member-location">
                                <?php echo esc_html( $location_text ); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( $email ) : ?>
                            <p class="team-member-email" style="margin-top: 15px;">
                                <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                    <?php echo esc_html( $email ); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Biography Content -->
            <div class="cell medium-8 small-12">
                <div class="team-member-biography">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            the_content();
                        }
                    }
                    ?>
                </div>

                <!-- Back to Team Link -->
                <div style="margin-top: 40px;">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'team_member' ) ); ?>" class="button">
                        Back to Team
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
get_footer();