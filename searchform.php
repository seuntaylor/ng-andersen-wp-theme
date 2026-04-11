<?php
/**
 * Custom Search Form
 *
 * Overrides the default WordPress search form output.
 * Called via get_search_form() in header.php.
 *
 * @package ng-andersen
 */
?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input
        type="text"
        name="s"
        value="<?php echo esc_attr( get_search_query() ); ?>"
        placeholder="<?php esc_attr_e( 'Search', 'ng-andersen' ); ?>"
        class="q"
    />
    <button type="submit">
        <img
            src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/search.svg' ); ?>"
            alt="<?php esc_attr_e( 'Search', 'ng-andersen' ); ?>"
        >
    </button>
</form>