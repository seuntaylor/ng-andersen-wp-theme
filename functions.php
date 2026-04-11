<?php
/**
 * Theme Functions
 *
 * @package ng-andersen
 * @version 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ------------------------------------------------------------
// 1. THEME SETUP
// ------------------------------------------------------------

function theme_setup() {
    // Allow WordPress to manage the document title
    add_theme_support( 'title-tag' );

    // Enable post thumbnail support
    add_theme_support( 'post-thumbnails' );

    // Enable HTML5 markup for core elements
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Register navigation menus
    register_nav_menus( array(
        'primary'   => __( 'Primary Navigation', 'your-theme-name' ),
        'secondary' => __( 'Secondary Navigation', 'your-theme-name' ),
    ) );
}
add_action( 'after_setup_theme', 'theme_setup' );


// ------------------------------------------------------------
// 2. ENQUEUE STYLES AND SCRIPTS
// ------------------------------------------------------------

function theme_enqueue_assets() {

    // --- Styles ---

    // Google Fonts: Roboto Condensed, Roboto, Work Sans
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        null
    );

    // Main compiled stylesheet
    wp_enqueue_style(
        'theme-styles',
        get_template_directory_uri() . '/assets/css/app.css',
        array( 'google-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // Custom overrides — loaded after app.css
    wp_enqueue_style(
        'theme-custom',
        get_template_directory_uri() . '/assets/css/custom.css',
        array( 'theme-styles' ),
        wp_get_theme()->get( 'Version' )
    );

    // --- Scripts ---

    // Main compiled JS bundle (includes Foundation and all custom JS)
    // Loaded in footer, depends on jQuery
    wp_enqueue_script(
        'theme-scripts',
        get_template_directory_uri() . '/assets/js/app.js',
        array( 'jquery' ),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // External: countries dropdown data
    wp_enqueue_script(
        'andersen-countries',
        'https://15fdb71145.nxcli.io/assets/countries_dropdown/countries.js',
        array( 'theme-scripts' ),
        null,
        true
    );

    // External: office reach data
    wp_enqueue_script(
        'andersen-reach-data',
        'https://15fdb71145.nxcli.io/offices/reach-data',
        array( 'andersen-countries' ),
        null,
        true
    );

    // Inline: parse_countries() function
    // Must load after theme-scripts (jQuery available) and before the external data scripts
    $parse_countries_js = "
        function parse_countries(data) {
            var \$menu = jQuery('.locations.dropdown .menu');
            \$menu.children().remove();

            if (data && data.countries) {
                for (var i = 0; data.countries[i]; i++) {
                    var country = data.countries[i];
                    if (country.name != 'Andersen Global') {
                        \$menu.append(
                            '<li><a href=\"' + country.link + '\" data-href=\"' + country.link + '\" target=\"_blank\">' + country.name + '</a></li>'
                        );
                    }
                }
            }
        }
    ";
    wp_add_inline_script( 'theme-scripts', $parse_countries_js );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_assets' );


// ------------------------------------------------------------
// 3. PRECONNECT HINTS FOR GOOGLE FONTS
// ------------------------------------------------------------

function theme_preconnect_hints( $hints, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $hints[] = array( 'href' => 'https://fonts.googleapis.com' );
        $hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'theme_preconnect_hints', 10, 2 );


// ------------------------------------------------------------
// 4. WIDGET AREAS
// ------------------------------------------------------------

function theme_register_widget_areas() {
    $footer_columns = array(
        array(
            'name' => __( 'Footer Column 1', 'your-theme-name' ),
            'id'   => 'footer-column-1',
        ),
        array(
            'name' => __( 'Footer Column 2', 'your-theme-name' ),
            'id'   => 'footer-column-2',
        ),
        array(
            'name' => __( 'Footer Column 3', 'your-theme-name' ),
            'id'   => 'footer-column-3',
        ),
    );

    foreach ( $footer_columns as $column ) {
        register_sidebar( array(
            'name'          => $column['name'],
            'id'            => $column['id'],
            'before_widget' => '<div class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5>',
            'after_title'   => '</h5>',
        ) );
    }
}
add_action( 'widgets_init', 'theme_register_widget_areas' );


// ------------------------------------------------------------
// 5. BODY CLASS ADDITIONS
// ------------------------------------------------------------

function theme_body_classes( $classes ) {
    // Add slug-based class matching the static template's {{page}} variable
    if ( is_singular() ) {
        global $post;
        $classes[] = $post->post_name;
    }

    return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );


// ------------------------------------------------------------
// 6. PAGE-SPECIFIC ASSETS — LOCATIONS MAP
// ------------------------------------------------------------

function theme_enqueue_locations_assets() {

    // Only load on pages using the Locations page template
    if ( ! is_page_template( 'templates/page-locations.php' ) ) {
        return;
    }

    // --- Stylesheets ---

    wp_enqueue_style(
        'atmap-styles',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/atmap.css',
        array(),
        null
    );

    wp_enqueue_style(
        'ammap-styles',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/ammap_3.20.17/ammap/ammap.css',
        array(),
        null
    );

    wp_enqueue_style(
        'map-legend-styles',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/map-legend-styles.css',
        array(),
        null
    );

    // --- Scripts ---
    // Load order mirrors the static template exactly.
    // Data scripts load in the <head> (false = not in footer).
    // Rendering scripts load in the footer (true = in footer).

    // Step 1: Data scripts — must be available before map renders
    wp_enqueue_script(
        'map-us-offices',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/us_offices.js',
        array(),
        null,
        false
    );

    wp_enqueue_script(
        'map-markers',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/mapmarkers.js',
        array( 'map-us-offices' ),
        null,
        false
    );

    wp_enqueue_script(
        'map-countries-list',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/countries_list.js',
        array( 'map-markers' ),
        null,
        false
    );

    wp_enqueue_script(
        'ammap-responsive',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/ammap_3.20.17/ammap/plugins/responsive/responsive.min.js',
        array( 'map-countries-list' ),
        null,
        false
    );

    // Step 2: amCharts core library and world map data
    wp_enqueue_script(
        'ammap-core',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/ammap_3.20.17/ammap/ammap.js',
        array( 'jquery' ),
        null,
        true
    );

    wp_enqueue_script(
        'ammap-world',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/ammap_3.20.17/ammap/maps/js/worldLow.js',
        array( 'ammap-core' ),
        null,
        true
    );

    // Step 3: Main map initialisation — renders the map into #mapdiv
    wp_enqueue_script(
        'map-world-init',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/world_map.js',
        array( 'ammap-world' ),
        null,
        true
    );

    // Step 4: Dropdown filter — populates #country_select and handles
    // zoom-to-country behaviour. Must load after map is initialised.
    wp_enqueue_script(
        'map-dropdown-filter',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/mapc/map-dropdown-filter.js',
        array( 'map-world-init' ),
        null,
        true
    );

    // Step 5: Individual offices — populates #individual_offices only
    // when a country is selected. Must load after dropdown filter.
    wp_enqueue_script(
        'map-indiv-offices',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/mapc/indiv_offices.js',
        array( 'map-dropdown-filter' ),
        null,
        true
    );

    wp_enqueue_script(
        'map-indiv-offices-2',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/mapc/indiv_offices2.js',
        array( 'map-indiv-offices' ),
        null,
        true
    );

    // Step 6: Bootstrap — UI components for office detail panels
    wp_enqueue_script(
        'map-bootstrap',
        'https://15fdb71145.nxcli.io/vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
        array( 'map-indiv-offices-2' ),
        null,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_locations_assets' );