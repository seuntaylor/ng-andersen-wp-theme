<?php
/**
 * Template Part: Global Presence Content
 *
 * Contains the intro text section and the v2 orbit carousel
 * specific to the Global Presence page.
 *
 * Permanently hardcoded. Any content changes must be made
 * directly in this template file.
 *
 * @package ng-andersen
 */
?>

<!-- Intro Text -->
<div class="section-intro_text">
    <div class="container">
        <div class="text">
            <p>Andersen is the Nigeria member firm of Andersen Global<sup>&reg;</sup>, an international association of member-firms comprised of tax, legal, and valuation professionals worldwide.</p>
        </div>
    </div>
</div>

<!-- Global Presence Carousel (v2) -->
<div class="carousel-v2 orbit" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">

    <div class="bg">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/Swooshes.svg' ); ?>" alt="">
    </div>

    <ul class="orbit-container">

        <li class="orbit-slide is-active">
            <div class="item">
                <picture class="image">
                    <span class="img-bg">
                        <img srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-2.jpg' ); ?>" alt="image">
                    </span>
                </picture>
                <div class="detail-text">
                    <h2>Global Reach</h2>
                    <p>Andersen Global<sup>&reg;</sup> is an association of legally separate, independent member firms, comprised of <span id="num-people-qualifier">more than</span> <span id="num-people">5000</span> professionals worldwide, <span id="num-partners-qualifier">over</span> <span id="num-partners">700</span> global partners, and a presence in <span id="num-locations-qualifier">over</span> <span id="num-locations">400</span> locations in <span id="num-countries-qualifier">more than</span> <span id="num-countries">170</span> countries worldwide. Our growth is a byproduct of the outstanding client service delivered by our people, the best professionals in the industry. Our objective isn't to be the biggest firm, it is to provide best-in-class client services in seamless fashion across the globe.</p>
                </div>
            </div>
        </li>

        <li class="orbit-slide">
            <div class="item">
                <picture class="image">
                    <span class="img-bg">
                        <img srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-3.jpg' ); ?>" alt="image">
                    </span>
                </picture>
                <div class="detail-text">
                    <h2>Client Service</h2>
                    <p>Our professionals share a common background and vision and are selected based on quality, like-mindedness, and commitment to client service. Outstanding client service has and will continue to be our top priority.</p>
                </div>
            </div>
        </li>

        <li class="orbit-slide">
            <div class="item">
                <picture class="image">
                    <span class="img-bg">
                        <img srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-4.jpg' ); ?>" alt="image">
                    </span>
                </picture>
                <div class="detail-text">
                    <h2>Shared Values</h2>
                    <p>Each and every one of the professionals that are a part of Andersen Global share our core values ensuring the delivery of best-in-class service in a seamless and consistent manner worldwide.</p>
                </div>
            </div>
        </li>

        <li class="orbit-slide">
            <div class="item">
                <picture class="image">
                    <span class="img-bg">
                        <img srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/slider-5.jpg' ); ?>" alt="image">
                    </span>
                </picture>
                <div class="detail-text">
                    <h2>One Firm</h2>
                    <p>We are building Andersen Global to create an enduring place &mdash; ONE FIRM where clients across the globe are afforded the best, most comprehensive tax, legal and valuation services provided by skilled staff with the highest standards.</p>
                </div>
            </div>
        </li>

    </ul>

    <nav class="orbit-bullets">
        <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
        <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
        <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
        <button data-slide="3"><span class="show-for-sr">Fourth slide details.</span></button>
    </nav>

</div>