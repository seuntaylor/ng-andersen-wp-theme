<?php
/**
 * Homepage Section: Blocks 2 — Featured Posts
 *
 * Currently static. Future development: the featured item (large left column)
 * will be driven by a manually selected or sticky post. The four smaller items
 * in the right column will be populated by the most recent WP Posts,
 * excluding the featured post.
 *
 * @package ng-andersen
 */
?>
<div class="section-blocks section-blocks2 bg-black light">
    <div class="container">
        <div class="grid-x grid-padding-x">

            <!-- Featured Post -->
            <div class="cell large-7">
                <div class="item item-featured">
                    <div class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block4.jpg' ); ?>" alt="image">
                        </span>
                    </div>
                    <div class="text">
                        <h3>Headline Text Goes Here</h3>
                        <div class="text-body">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <a href="#" class="button">Call to action</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="cell large-5">

                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block5.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</a></h3>
                            <p class="text-meta">7 min read</p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block6.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</a></h3>
                            <p class="text-meta">7 min read</p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block7.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</a></h3>
                            <p class="text-meta">7 min read</p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block8.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</a></h3>
                            <p class="text-meta">7 min read</p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <a href="#" class="image">
                        <span class="img-bg">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/block9.jpg' ); ?>" alt="image">
                        </span>
                    </a>
                    <div class="text">
                        <div class="text-body">
                            <h3><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</a></h3>
                            <p class="text-meta">7 min read</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>