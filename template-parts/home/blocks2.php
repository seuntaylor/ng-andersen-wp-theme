<?php
/**
 * Homepage Section: Blocks 2 — Featured Posts
 *
 * Left column displays a static featured item.
 * Right column displays the 5 latest published blog posts dynamically.
 *
 * Future development: the featured item (large left column) will be driven
 * by a manually selected or sticky post, and the recent posts query will
 * exclude that featured post.
 *
 * @package ng-andersen
 */
?>
<div class="section-blocks section-blocks2 bg-black light">
    <div class="container">
        <div class="grid-x grid-padding-x">

            <!-- Featured Post (Static) -->
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

            <!-- Recent Posts (Dynamic) -->
            <div class="cell large-5">
                <?php
                $latest_posts = new WP_Query( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 5,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ) );

                if ( $latest_posts->have_posts() ) {
                    while ( $latest_posts->have_posts() ) {
                        $latest_posts->the_post();
                        ?>
                        <div class="item">
                            <a href="<?php the_permalink(); ?>" class="image">
                                <span class="img-bg">
                                    <img src="<?php echo esc_url( ng_andersen_get_post_card_image( get_the_ID() ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                </span>
                            </a>
                            <div class="text">
                                <div class="text-body">
                                    <p class="text-meta post-date"><?php echo esc_html( get_the_date() ); ?></p>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) {
                                        ?>
                                        <p class="text-meta post-category"><?php echo esc_html( $categories[0]->name ); ?></p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    ?>
                    <div class="item">
                        <div class="text">
                            <div class="text-body">
                                <p>No blog posts found.</p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
</div>