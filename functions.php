<?php
/**
 * Theme Functions
 *
 * @package ng-andersen
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
        'primary'   => __( 'Primary Navigation', 'ng-andersen' ),
        'secondary' => __( 'Secondary Navigation', 'ng-andersen' ),
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
            'name' => __( 'Footer Column 1', 'ng-andersen' ),
            'id'   => 'footer-column-1',
        ),
        array(
            'name' => __( 'Footer Column 2', 'ng-andersen' ),
            'id'   => 'footer-column-2',
        ),
        array(
            'name' => __( 'Footer Column 3', 'ng-andersen' ),
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