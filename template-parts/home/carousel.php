<?php
/**
 * Homepage Section: Carousel
 *
 * Currently static. Future development: convert to a Custom Post Type
 * with fields for slide image, headline, body text, button label,
 * button URL, and order of appearance.
 *
 * @package ng-andersen
 */
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
                        <img srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-1.jpg' ); ?>" alt="image">
                    </span>
                </picture>
                <div class="detail-text">
                    <h1>Headline Text Goes Here</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <a class="button" href="#">Learn More</a>
                </div>
            </div>
        </li>

        <li class="orbit-slide">
            <div class="item">
                <picture class="image">
                    <span class="img-bg">
                        <img srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-1.jpg' ); ?>" alt="image">
                    </span>
                </picture>
                <div class="detail-text">
                    <h2>Lorem Ipsum</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <a class="button" href="#">Learn More</a>
                </div>
            </div>
        </li>

        <li class="orbit-slide">
            <div class="item">
                <picture class="image">
                    <span class="img-bg">
                        <img srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-1.jpg' ); ?>" alt="image">
                    </span>
                </picture>
                <div class="detail-text">
                    <h2>Lorem Ipsum Dolor Sit Amet</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <a class="button" href="#">Learn More</a>
                </div>
            </div>
        </li>

    </ul>

    <nav class="orbit-bullets">
        <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
        <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
        <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
    </nav>

</div>