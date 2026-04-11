<?php
/**
 * Homepage Section: Services
 *
 * Currently static. Future development: convert to a Custom Post Type
 * for the firm's services. Each service item will have fields for
 * image, service title, description, and CTA link.
 *
 * @package ng-andersen
 */
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

                    <div class="item">
                        <div class="item-image">
                            <span class="img-bg">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/cta2.jpg' ); ?>" alt="">
                            </span>
                        </div>
                        <div class="item-title">
                            <h3>Service 1</h3>
                        </div>
                        <div class="item-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
                            <div class="item-text--cta">
                                <a href="#" class="button-link">Call To Action &raquo;</a>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item-image">
                            <span class="img-bg">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block5.jpg' ); ?>" alt="">
                            </span>
                        </div>
                        <div class="item-title">
                            <h3>Service 2</h3>
                        </div>
                        <div class="item-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
                            <div class="item-text--cta">
                                <a href="#" class="button-link">Call To Action &raquo;</a>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item-image">
                            <span class="img-bg">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block7.jpg' ); ?>" alt="">
                            </span>
                        </div>
                        <div class="item-title">
                            <h3>Service 3</h3>
                        </div>
                        <div class="item-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
                            <div class="item-text--cta">
                                <a href="#" class="button-link">Call To Action &raquo;</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>