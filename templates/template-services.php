<?php
/**
 * Template Name: Services
 * Description: Lists all Service CPT entries as cards, ordered by manual menu order.
 *
 * @package ng-andersen
 */

get_header();
?>

<!-- Hero Section -->
<div class="section-page_hero gradient" id="page-hero">
    <div class="bg img-bg">
        <?php if ( has_post_thumbnail() ) { ?>
            <?php the_post_thumbnail( 'full', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
        <?php } else { ?>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/landing.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
        <?php } ?>
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
            <p>Our goal is to create opportunities and provide solutions to help you attain your vision through customized solutions.</p>
        </div>
    </div>
</div>

<!-- Services Listing -->
<div class="section-subcategories">
    <div class="container">

        <?php
        // Optional intro from the page content
        if ( get_the_content() ) {
            ?>
            <div class="block-text">
                <?php the_content(); ?>
            </div>
            <?php
        }

        $services = new WP_Query( array(
            'post_type'      => 'service',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );

        if ( $services->have_posts() ) {
            ?>
            <div class="grid-x grid-padding-x">
                <?php
                while ( $services->have_posts() ) {
                    $services->the_post();
                    $short_desc = get_post_meta( get_the_ID(), '_service_short_description', true );
                    ?>
                    <div class="cell medium-6">
                        <div class="item">
                            <a href="<?php the_permalink(); ?>" class="image">
                                <span class="img-bg">
                                    <?php
                                    if ( has_post_thumbnail() ) {
                                        the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) );
                                    } else {
                                        ?>
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block6.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                        <?php
                                    }
                                    ?>
                                </span>
                            </a>
                            <div class="text">
                                <h3><?php the_title(); ?></h3>
                                <div class="text-body">
                                    <?php if ( ! empty( $short_desc ) ) { ?>
                                        <p><?php echo esc_html( $short_desc ); ?></p>
                                    <?php } ?>
                                    <a href="<?php the_permalink(); ?>" class="button">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php
        } else {
            ?>
            <p>No services found.</p>
            <?php
        }
        ?>

    </div>
</div>

<?php get_footer(); ?>