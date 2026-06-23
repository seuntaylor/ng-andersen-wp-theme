<?php
/**
 * Homepage Section: Blocks 2 — Featured Posts
 *
 * Featured slot (large-7): the most recent sticky post, or the latest post
 * overall if no sticky posts exist.
 *
 * List slot (large-5): the next 5 posts — remaining sticky posts first
 * (after the featured one), then topped up with the latest non-sticky
 * posts by date. The featured post is always excluded.
 *
 * @package ng-andersen
 */

// Build an ordered list of post IDs: stickies (newest first), then latest by date.
$sticky_ids = get_option( 'sticky_posts', array() );
if ( ! is_array( $sticky_ids ) ) {
    $sticky_ids = array();
}

$ordered_ids = array();

// 1. Sticky posts, newest first
if ( ! empty( $sticky_ids ) ) {
    $sticky_query = new WP_Query( array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'post__in'            => $sticky_ids,
        'orderby'             => 'date',
        'order'               => 'DESC',
        'posts_per_page'      => -1,
        'ignore_sticky_posts' => true,
    ) );
    if ( $sticky_query->have_posts() ) {
        foreach ( $sticky_query->posts as $sticky_post ) {
            $ordered_ids[] = $sticky_post->ID;
        }
    }
    wp_reset_postdata();
}

// 2. Top up with latest non-sticky posts (need 6 total: 1 featured + 5 list)
if ( count( $ordered_ids ) < 6 ) {
    $fill_query = new WP_Query( array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 6 - count( $ordered_ids ),
        'orderby'             => 'date',
        'order'               => 'DESC',
        'post__not_in'        => ! empty( $ordered_ids ) ? $ordered_ids : array(),
        'ignore_sticky_posts' => true,
    ) );
    if ( $fill_query->have_posts() ) {
        foreach ( $fill_query->posts as $fill_post ) {
            $ordered_ids[] = $fill_post->ID;
        }
    }
    wp_reset_postdata();
}

// Split into featured (first) and list (next 5)
$featured_id = ! empty( $ordered_ids ) ? $ordered_ids[0] : 0;
$list_ids    = array_slice( $ordered_ids, 1, 5 );
?>
<div class="section-blocks section-blocks2 bg-black light">
    <div class="container">
        <div class="grid-x grid-padding-x">

            <!-- Featured Post -->
            <div class="cell large-7">
                <?php
                if ( $featured_id ) {
                    $featured_post = get_post( $featured_id );
                    setup_postdata( $GLOBALS['post'] = $featured_post );
                    ?>
                    <div class="item item-featured">
                        <a href="<?php the_permalink(); ?>" class="image">
                            <span class="img-bg">
                                <img src="<?php echo esc_url( ng_andersen_get_post_card_image( get_the_ID(), 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                            </span>
                        </a>
                        <div class="text">
                            <h3><?php the_title(); ?></h3>
                            <div class="text-body">
                                <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 40, '&hellip;' ) ); ?></p>
                                <a href="<?php the_permalink(); ?>" class="button">Read More</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                }
                ?>
            </div>

            <!-- Recent Posts -->
            <div class="cell large-5">
                <?php
                if ( ! empty( $list_ids ) ) {
                    $list_query = new WP_Query( array(
                        'post_type'           => 'post',
                        'post_status'         => 'publish',
                        'post__in'            => $list_ids,
                        'orderby'             => 'post__in', // preserve our sticky-first ordering
                        'posts_per_page'      => 5,
                        'ignore_sticky_posts' => true,
                    ) );

                    if ( $list_query->have_posts() ) {
                        while ( $list_query->have_posts() ) {
                            $list_query->the_post();
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
                    }
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