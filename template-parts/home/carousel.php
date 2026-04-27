<?php
/**
 * Homepage Section: Carousel
 *
 * Displays slides from the Home Slides custom post type,
 * ordered by the post order field set in the dashboard.
 * Each slide has title, body text, image, and optional CTA button.
 *
 * @package ng-andersen
 */

$slides = new WP_Query( array(
    'post_type'      => 'home_slide',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>

<?php if ( $slides->have_posts() ) : ?>

<div class="home-carousel orbit light" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">

    <div class="bg">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/Swooshes-hero.svg' ); ?>" alt="">
    </div>

    <ul class="orbit-container">

        <?php
        $slide_count = 0;
        while ( $slides->have_posts() ) :
            $slides->the_post();
            
            $body = get_post_meta( get_the_ID(), '_home_slide_body', true );
            $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $button_text = get_post_meta( get_the_ID(), '_home_slide_button_text', true );
            $button_url = get_post_meta( get_the_ID(), '_home_slide_button_url', true );
            $is_first = ( $slide_count === 0 );
            $slide_count++;
        ?>

        <li class="orbit-slide <?php echo $is_first ? 'is-active' : ''; ?>">
            <div class="item">
                <picture class="image">
                    <span class="img-bg">
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php else : ?>
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-1.jpg' ); ?>" alt="placeholder">
                        <?php endif; ?>
                    </span>
                </picture>
                <div class="detail-text">
                    <h1><?php the_title(); ?></h1>
                    <?php if ( $body ) : ?>
                        <p><?php echo wp_kses_post( $body ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $button_text ) && ! empty( $button_url ) ) : ?>
                        <a class="button" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </li>

        <?php endwhile; ?>

    </ul>

    <nav class="orbit-bullets">
        <?php for ( $i = 0; $i < $slide_count; $i++ ) : ?>
            <button class="<?php echo $i === 0 ? 'is-active' : ''; ?>" data-slide="<?php echo $i; ?>">
                <span class="show-for-sr">Slide <?php echo $i + 1; ?> details.</span>
                <?php if ( $i === 0 ) : ?><span class="show-for-sr">Current Slide</span><?php endif; ?>
            </button>
        <?php endfor; ?>
    </nav>

</div>

<?php
wp_reset_postdata();
else :
    // Fallback if no slides exist
    ?>

    <div class="home-carousel orbit light" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">
        <div class="bg">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/Swooshes-hero.svg' ); ?>" alt="">
        </div>
        <ul class="orbit-container">
            <li class="orbit-slide is-active">
                <div class="item">
                    <picture class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-1.jpg' ); ?>" alt="placeholder">
                        </span>
                    </picture>
                    <div class="detail-text">
                        <h1>No Slides Yet</h1>
                        <p>Create your first home slide in the WordPress dashboard under Home Slides.</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>

<?php endif; ?>