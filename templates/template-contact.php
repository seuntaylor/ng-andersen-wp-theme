<?php
/**
 * Template Name: Contact
 * Description: Contact page with contact form and office locations
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
<div class="section-sidebar">
    <div class="container">
        <!-- Row 1: Contact Form -->
        <div class="grid-x grid-padding-x" style="margin-bottom: 40px;">
            <div class="cell">
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

        <!-- Row 2: Office 1 -->
        <div class="grid-x grid-padding-x" style="margin-bottom: 40px;">
            <?php
            $office_1 = ng_andersen_get_office( 1 );
            if ( ! empty( $office_1['name'] ) ) {
                ?>
                <!-- Office 1 Info -->
                <div class="cell large-6">
                    <div class="office-info-box">
                        <h3><?php echo esc_html( $office_1['name'] ); ?></h3>
                        
                        <?php if ( ! empty( $office_1['address'] ) ) { ?>
                            <div class="office-detail">
                                <h5>Address</h5>
                                <p><?php echo wp_kses_post( nl2br( $office_1['address'] ) ); ?></p>
                            </div>
                        <?php } ?>

                        <?php if ( ! empty( $office_1['email'] ) ) { ?>
                            <div class="office-detail">
                                <h5>Email</h5>
                                <p><a href="<?php echo esc_url( 'mailto:' . $office_1['email'] ); ?>"><?php echo esc_html( $office_1['email'] ); ?></a></p>
                            </div>
                        <?php } ?>

                        <?php if ( ! empty( $office_1['phone'] ) ) { ?>
                            <div class="office-detail">
                                <h5>Phone</h5>
                                <p><a href="<?php echo esc_url( 'tel:' . $office_1['phone'] ); ?>"><?php echo esc_html( $office_1['phone'] ); ?></a></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Office 1 Map -->
                <div class="cell large-6">
                    <div class="office-map-wrapper">
                        <?php echo wp_kses( $office_1['map_code'], wp_kses_allowed_html( 'post' ) ); ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- Row 3: Office 2 -->
        <div class="grid-x grid-padding-x" style="margin-bottom: 40px;">
            <?php
            $office_2 = ng_andersen_get_office( 2 );
            if ( ! empty( $office_2['name'] ) ) {
                ?>
                <!-- Office 2 Info -->
                <div class="cell large-6">
                    <div class="office-info-box">
                        <h3><?php echo esc_html( $office_2['name'] ); ?></h3>
                        
                        <?php if ( ! empty( $office_2['address'] ) ) { ?>
                            <div class="office-detail">
                                <h5>Address</h5>
                                <p><?php echo wp_kses_post( nl2br( $office_2['address'] ) ); ?></p>
                            </div>
                        <?php } ?>

                        <?php if ( ! empty( $office_2['email'] ) ) { ?>
                            <div class="office-detail">
                                <h5>Email</h5>
                                <p><a href="<?php echo esc_url( 'mailto:' . $office_2['email'] ); ?>"><?php echo esc_html( $office_2['email'] ); ?></a></p>
                            </div>
                        <?php } ?>

                        <?php if ( ! empty( $office_2['phone'] ) ) { ?>
                            <div class="office-detail">
                                <h5>Phone</h5>
                                <p><a href="<?php echo esc_url( 'tel:' . $office_2['phone'] ); ?>"><?php echo esc_html( $office_2['phone'] ); ?></a></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Office 2 Map -->
                <div class="cell large-6">
                    <div class="office-map-wrapper">
                        <?php echo wp_kses( $office_2['map_code'], wp_kses_allowed_html( 'post' ) ); ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>