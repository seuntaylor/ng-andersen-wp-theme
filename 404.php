<?php
/**
 * 404 Error Page Template
 *
 * Displayed when a page or post cannot be found.
 * Full-width layout — no sidebar.
 *
 * @package ng-andersen
 */

get_header();
?>

<!-- Centred Content Section — no sidebar -->
<div class="section-intro_text">
    <div class="container">
        <div class="text">
            <h2>Let&rsquo;s get you back on track</h2>
            <p>Check the web address for typos, search the site below, or head back to the homepage.</p>

            <!-- Search -->
            <div class="error-search" style="max-width: 480px; margin: 30px auto;">
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="form-item">
                        <div class="form-item--field">
                            <input
                                type="search"
                                name="s"
                                placeholder="Search the site..."
                                value="<?php echo esc_attr( get_search_query() ); ?>"
                            >
                            <button type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button">Back to Homepage</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>