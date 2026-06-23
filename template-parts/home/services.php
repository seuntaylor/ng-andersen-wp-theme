<?php
/**
 * Homepage Section: Our Services
 *
 * Displays the first three Service CPT entries (by manual menu order).
 * - Image  → service featured image
 * - <h3>   → service title
 * - <p>    → service content (trimmed)
 * - CTA    → "Read More" linking to the single service
 *
 * @package ng-andersen
 */

$home_services = new WP_Query( array(
    'post_type'      => 'service',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>
<div class="section-services">
    <div class="bg">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/Swooshes.svg' ); ?>" alt="">
    </div>
    <div class="container">
        <div class="grid-x align-middle">
            <div class="cell large-4">
                <h2>Our Services</h2>
            </div>
            <div class="cell large-8">
                <div class="services-list">
                    <?php
                    if ( $home_services->have_posts() ) {
                        while ( $home_services->have_posts() ) {
                            $home_services->the_post();
                            ?>
                            <div class="item">
                                <div class="item-image">
                                    <a href="<?php the_permalink(); ?>" class="img-bg">
                                        <?php
                                        if ( has_post_thumbnail() ) {
                                            the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) );
                                        } else {
                                            ?>
                                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/cta2.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="item-title">
                                    <h3><?php the_title(); ?></h3>
                                </div>
                                <div class="item-text">
                                    <p><?php echo esc_html( wp_trim_words( get_the_content(), 20, '&hellip;' ) ); ?></p>
                                    <div class="item-text--cta">
                                        <a href="<?php the_permalink(); ?>" class="button-link">Read More &raquo;</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
        // Link to the full services listing page — full width, centred
        $services_page = get_page_by_path( 'services-and-industries' );
        if ( $services_page ) {
            ?>
            <div class="services-list--cta">
                <a href="<?php echo esc_url( get_permalink( $services_page->ID ) ); ?>" class="button">View All Services</a>
            </div>
            <?php
        }
        ?>
    </div>
</div>