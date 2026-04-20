<?php
/**
 * Homepage Section: Blocks 8 — Three Column Posts
 *
 * Currently static. Future development: populate all three items
 * from WP Posts using a WP_Query loop. Each item will display
 * the post featured image, title, excerpt, and permalink.
 *
 * @package ng-andersen
 */
?>
<div class="section-blocks section-blocks8 bg-black">
    <div class="container">
        <div class="grid-x grid-padding-x">

            <div class="cell large-4">
                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block4.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3>Headline One Goes Here</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a href="#" class="button-link">Read More &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cell large-4">
                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block5.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3>Headline Two Goes Here</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a href="#" class="button-link">Read More &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cell large-4">
                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block6.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3>Headline Three Goes Here</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a href="#" class="button-link">Read More &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>