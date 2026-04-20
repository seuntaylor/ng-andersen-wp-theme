<?php
/**
 * Homepage Section: Blocks 1 — Three Column Posts
 *
 * Currently static. Future development: populate all three items
 * from WP Posts using a WP_Query loop. Each item will display
 * the post featured image, title, excerpt, and permalink.
 *
 * @package ng-andersen
 */
?>
<div class="section-blocks section-blocks1 bg-blue light">
    <div class="container">
        <div class="grid-x grid-padding-x">

            <div class="cell medium-4">
                <div class="item">
                    <div class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block1.jpg' ); ?>" alt="image">
                        </span>
                    </div>
                    <div class="text">
                        <div class="text-body">
                            <h3>Header One</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <a href="#" class="button-link">Read More &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cell medium-4">
                <div class="item">
                    <div class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block2.jpg' ); ?>" alt="image">
                        </span>
                    </div>
                    <div class="text">
                        <div class="text-body">
                            <h3>Header Two</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <a href="#" class="button-link">Read More &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cell medium-4">
                <div class="item">
                    <div class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block3.jpg' ); ?>" alt="image">
                        </span>
                    </div>
                    <div class="text">
                        <div class="text-body">
                            <h3>Header Three</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <a href="#" class="button-link">Read More &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>