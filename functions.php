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
 
    // --- Scripts ---
 
    // Main compiled JS bundle (includes Foundation and all custom JS)
    // Loaded in footer, depends on jQuery
    // On Locations page, also depends on map-bootstrap to load after all map scripts
    $theme_scripts_deps = array( 'jquery' );
    if ( is_page_template( 'templates/page-locations.php' ) ) {
        $theme_scripts_deps[] = 'map-bootstrap';
    }
 
    wp_enqueue_script(
        'theme-scripts',
        get_template_directory_uri() . '/assets/js/app.js',
        $theme_scripts_deps,
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
// 7. CUSTOM POST TYPE — HOME SLIDES
// ------------------------------------------------------------
 
function theme_register_home_slides_cpt() {
    $labels = array(
        'name'               => 'Home Slides',
        'singular_name'      => 'Home Slide',
        'menu_name'          => 'Home Slides',
        'all_items'          => 'All Slides',
        'add_new'            => 'Add New Slide',
        'add_new_item'       => 'Add New Home Slide',
        'edit_item'          => 'Edit Home Slide',
        'view_item'          => 'View Home Slide',
        'search_items'       => 'Search Home Slides',
    );
 
    $args = array(
        'labels'            => $labels,
        'public'            => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_position'     => 5,
        'menu_icon'         => 'dashicons-slides',
        'supports'          => array( 'title', 'thumbnail', 'page-attributes' ),
        'has_archive'       => false,
        'rewrite'           => false,
        'show_in_rest'      => false,
    );
 
    register_post_type( 'home_slide', $args );
}
add_action( 'init', 'theme_register_home_slides_cpt' );
 
 
// Home Slides custom meta boxes
function theme_add_home_slide_meta_boxes() {
    add_meta_box(
        'home_slide_content',
        'Slide Content',
        'theme_render_home_slide_content_meta_box',
        'home_slide',
        'normal',
        'high'
    );
 
    add_meta_box(
        'home_slide_cta',
        'Call to Action (Optional)',
        'theme_render_home_slide_cta_meta_box',
        'home_slide',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'theme_add_home_slide_meta_boxes' );
 
 
// Render content meta box — body text only
function theme_render_home_slide_content_meta_box( $post ) {
    wp_nonce_field( 'home_slide_nonce', 'home_slide_nonce' );
 
    $body = get_post_meta( $post->ID, '_home_slide_body', true );
    ?>
 
    <div>
        <label for="home_slide_body" style="display: block; margin-bottom: 8px; font-weight: 600;">
            Body Text
        </label>
        <textarea
            id="home_slide_body"
            name="home_slide_body"
            rows="6"
            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: monospace;"
        ><?php echo esc_textarea( $body ); ?></textarea>
        <p style="font-size: 12px; color: #666; margin-top: 5px;">
            The subtitle or descriptive text for this slide. Set the slide image using the Featured Image panel on the right.
        </p>
    </div>
    <?php
}
 
 
// Render CTA meta box
function theme_render_home_slide_cta_meta_box( $post ) {
    $button_text = get_post_meta( $post->ID, '_home_slide_button_text', true );
    $button_url = get_post_meta( $post->ID, '_home_slide_button_url', true );
    ?>
 
    <p style="font-size: 12px; color: #666; margin-bottom: 16px;">
        Both button text and URL must be provided to display the button. Leave both empty to hide the button.
    </p>
 
    <div style="margin-bottom: 16px;">
        <label for="home_slide_button_text" style="display: block; margin-bottom: 8px; font-weight: 600;">
            Button Text
        </label>
        <input
            type="text"
            id="home_slide_button_text"
            name="home_slide_button_text"
            value="<?php echo esc_attr( $button_text ); ?>"
            placeholder="e.g., Learn More"
            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"
        >
    </div>
 
    <div>
        <label for="home_slide_button_url" style="display: block; margin-bottom: 8px; font-weight: 600;">
            Button URL
        </label>
        <input
            type="url"
            id="home_slide_button_url"
            name="home_slide_button_url"
            value="<?php echo esc_url( $button_url ); ?>"
            placeholder="https://example.com"
            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"
        >
    </div>
    <?php
}
 
 
// Save home slide meta
function theme_save_home_slide_meta( $post_id ) {
    if ( ! isset( $_POST['home_slide_nonce'] ) || ! wp_verify_nonce( $_POST['home_slide_nonce'], 'home_slide_nonce' ) ) {
        return;
    }
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
 
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
 
    // Save body
    if ( isset( $_POST['home_slide_body'] ) ) {
        update_post_meta( $post_id, '_home_slide_body', sanitize_textarea_field( $_POST['home_slide_body'] ) );
    }
 
    // Save button text — only if both text and URL are provided
    $button_text = isset( $_POST['home_slide_button_text'] ) ? sanitize_text_field( $_POST['home_slide_button_text'] ) : '';
    $button_url = isset( $_POST['home_slide_button_url'] ) ? esc_url_raw( $_POST['home_slide_button_url'] ) : '';
 
    if ( ! empty( $button_text ) && ! empty( $button_url ) ) {
        update_post_meta( $post_id, '_home_slide_button_text', $button_text );
        update_post_meta( $post_id, '_home_slide_button_url', $button_url );
    } else {
        // If either is empty, delete both
        delete_post_meta( $post_id, '_home_slide_button_text' );
        delete_post_meta( $post_id, '_home_slide_button_url' );
    }
}
add_action( 'save_post_home_slide', 'theme_save_home_slide_meta' );
 
 
// Add custom columns to Home Slides list table
function theme_add_home_slides_columns( $columns ) {
    $new_columns = array();
    
    // Insert image column after checkbox
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( $key === 'cb' ) {
            $new_columns['featured_image'] = 'Image';
        }
    }
    
    return $new_columns;
}
add_filter( 'manage_home_slide_posts_columns', 'theme_add_home_slides_columns' );
 
 
// Display featured image in custom column
function theme_display_home_slides_featured_image( $column, $post_id ) {
    if ( $column === 'featured_image' ) {
        if ( has_post_thumbnail( $post_id ) ) {
            echo get_the_post_thumbnail( $post_id, array( 60, 60 ), array( 'style' => 'border-radius: 4px;' ) );
        } else {
            echo '<span style="color: #999;">No image</span>';
        }
    }
}
add_action( 'manage_home_slide_posts_custom_column', 'theme_display_home_slides_featured_image', 10, 2 );
 
 
// Make featured image column sortable by title (or whatever makes sense)
function theme_home_slides_sortable_columns( $columns ) {
    $columns['featured_image'] = 'title';
    return $columns;
}
add_filter( 'manage_edit-home_slide_sortable_columns', 'theme_home_slides_sortable_columns' );
 
 
// Admin CSS for responsive Home Slides table
function theme_home_slides_admin_styles() {
    $screen = get_current_screen();
    
    if ( ! $screen || 'edit-home_slide' !== $screen->id ) {
        return;
    }
    
    ?>
    <style type="text/css">
        /* Desktop: Set column widths */
        @media screen and (min-width: 783px) {
            .wp-list-table.posts #featured_image {
                width: 10%;
            }
            
            .wp-list-table.posts .column-title {
                width: 60%;
            }
            
            .wp-list-table.posts .column-date {
                width: 30%;
            }
        }
        
        /* Mobile: Responsive adjustments */
        @media screen and (max-width: 782px) {
            /* Hide date column on mobile */
            .wp-list-table.posts .column-date,
            .wp-list-table.posts th#date {
                display: none;
            }
            
            /* Make title take full width */
            .wp-list-table.posts th.column-title,
            .wp-list-table.posts td.column-title {
                width: 100% !important;
                display: block !important;
                padding: 10px !important;
                border: none !important;
            }
            
            /* Make image column full width */
            .wp-list-table.posts th#featured_image,
            .wp-list-table.posts td.featured_image {
                width: 100% !important;
                display: block !important;
                padding: 10px !important;
                border: none !important;
                text-align: left;
            }
            
            /* Stack rows */
            .wp-list-table.posts tbody tr {
                display: block !important;
                border: 1px solid #ddd !important;
                margin-bottom: 15px !important;
                border-radius: 4px !important;
            }
            
            /* Checkbox column */
            .wp-list-table.posts th.check-column,
            .wp-list-table.posts td.check-column {
                display: block !important;
                width: 100% !important;
                padding: 10px !important;
                border: none !important;
            }
            
            /* Header row styling */
            .wp-list-table.posts thead tr {
                display: block !important;
            }
            
            .wp-list-table.posts thead th {
                display: block !important;
                width: 100% !important;
                border: none !important;
                padding: 10px !important;
                margin-bottom: 0 !important;
            }
            
            /* Featured image styling */
            .wp-list-table.posts td.featured_image img {
                display: block;
                max-width: 80px;
                height: auto;
            }
        }
    </style>
    <?php
}
add_action( 'admin_head', 'theme_home_slides_admin_styles' );
 
 
 
 
 
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
        array( 'ammap-core' ),
        null,
        true
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
 
    // Make $ available to map scripts that expect it (WordPress uses noConflict mode)
    wp_add_inline_script(
        'ammap-world',
        'var $ = jQuery;',
        'after'
    );
 
    // Step 3: Main map initialisation — renders the map into #mapdiv
    wp_enqueue_script(
        'map-world-init',
        'https://15fdb71145.nxcli.io/assets/global/filtered/beta/world_map.js',
        array( 'jquery', 'ammap-world' ),
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