<?php
/**
 * Template Name: Contact
 * Description: Contact page with offices/maps on left and CF7 form on right
 *
 * @package ng-andersen
 */

get_header();
?>

<!-- Hero Section -->
<div class="section-page_hero gradient-diagonal" id="page-hero">
    <!-- Background Image -->
    <div class="bg img-bg">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/landing.jpg" alt="Contact page hero">
    </div>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <span class="crumb current"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Hero Text -->
    <div class="container">
        <div class="text">
            <h1><?php the_title(); ?></h1>
            <p><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="section-sidebar" style="padding-top: 60px;">
    <div class="container">
        <div class="grid-x grid-padding-x">
            
            <!-- LEFT COLUMN: Office Addresses & Maps -->
            <div class="cell large-6">
                <?php
                // Loop through offices 1, 2, and 3
                for ( $i = 1; $i <= 3; $i++ ) {
                    $office = ng_andersen_get_office( $i );
                    
                    // Only display if office has a name
                    if ( ! empty( $office['name'] ) ) {
                        ?>
                        <!-- Office <?php echo absint( $i ); ?> Address -->
                        <div class="office-info-box" style="margin-bottom: 20px;">
                            <h3><?php echo esc_html( $office['name'] ); ?></h3>
                            
                            <?php if ( ! empty( $office['address'] ) ) { ?>
                                <div class="office-detail">
                                    <h5>Address</h5>
                                    <p><?php echo wp_kses_post( nl2br( $office['address'] ) ); ?></p>
                                </div>
                            <?php } ?>

                            <?php if ( ! empty( $office['email'] ) ) { ?>
                                <div class="office-detail">
                                    <h5>Email</h5>
                                    <p><a href="<?php echo esc_url( 'mailto:' . $office['email'] ); ?>"><?php echo esc_html( $office['email'] ); ?></a></p>
                                </div>
                            <?php } ?>

                            <?php if ( ! empty( $office['phone'] ) ) { ?>
                                <div class="office-detail">
                                    <h5>Phone</h5>
                                    <p><a href="<?php echo esc_url( 'tel:' . $office['phone'] ); ?>"><?php echo esc_html( $office['phone'] ); ?></a></p>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Office <?php echo absint( $i ); ?> Map -->
                        <?php if ( ! empty( $office['map_code'] ) ) { ?>
                            <div class="office-map-wrapper" style="margin-bottom: 40px;">
                                <?php
                                // Allow iframes for Google Maps embeds
                                $allowed_html = array(
                                    'iframe' => array(
                                        'src'             => true,
                                        'width'           => true,
                                        'height'          => true,
                                        'style'           => true,
                                        'allowfullscreen' => true,
                                        'loading'         => true,
                                        'referrerpolicy'  => true,
                                        'frameborder'     => true,
                                    ),
                                );
                                echo wp_kses( $office['map_code'], $allowed_html );
                                ?>
                            </div>
                        <?php } ?>
                        <?php
                    }
                }
                ?>
            </div>

            <!-- RIGHT COLUMN: Contact Form -->
            <div class="cell large-6">
                <div class="contact-form-wrapper">
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

        </div>
    </div>
</div>

<?php get_footer(); ?>