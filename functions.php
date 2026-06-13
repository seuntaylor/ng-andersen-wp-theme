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

// ============================================================
// 1. THEME SETUP
// ============================================================

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


// ============================================================
// 2. ENQUEUE STYLES AND SCRIPTS
// ============================================================

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

    // Custom overrides — loaded after app.css to preserve WordPress-specific fixes
    wp_enqueue_style(
        'theme-custom',
        get_template_directory_uri() . '/assets/css/custom.css',
        array( 'theme-styles' ),
        wp_get_theme()->get( 'Version' )
    );

    // --- Scripts ---

    // Main compiled JS bundle (includes Foundation and all custom JS)
    // Loaded in footer, depends on jQuery
    // On Locations page, also depends on map-bootstrap to load after all map scripts
    $theme_scripts_deps = array( 'jquery' );
    if ( is_page_template( 'templates/template-locations.php' ) ) {
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
    // SECURITY FIX: Validate URLs before using them
    $parse_countries_js = "
        function parse_countries(data) {
            var \$menu = jQuery('.locations.dropdown .menu');
            \$menu.children().remove();

            if (data && data.countries) {
                for (var i = 0; data.countries[i]; i++) {
                    var country = data.countries[i];
                    if (country.name != 'Andersen Global') {
                        // Validate URL format before using
                        var isValidUrl = country.link && /^https?:\/\/.+/.test(country.link);
                        if (isValidUrl) {
                            \$menu.append(
                                '<li><a href=\"' + country.link + '\" data-href=\"' + country.link + '\" target=\"_blank\">' + country.name + '</a></li>'
                            );
                        }
                    }
                }
            }
        }
    ";
    wp_add_inline_script( 'theme-scripts', $parse_countries_js );

    // Team script — only on team page
    if ( is_page_template( 'templates/template-teams.php' ) ) {
        wp_enqueue_script(
            'team-js',
            get_template_directory_uri() . '/assets/js/team.js',
            array( 'jquery' ),
            wp_get_theme()->get( 'Version' ),
            true
        );

        wp_localize_script( 'team-js', 'teamSearchData', array(
            'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
            'nonce'   => wp_create_nonce( 'team_search_nonce' ),
        ) );
    }

    // Publications script — single dropdown template
    if ( is_page_template( 'templates/template-publications.php' ) ) {
        wp_enqueue_script(
            'publications-js',
            get_template_directory_uri() . '/assets/js/publications.js',
            array( 'jquery' ),
            wp_get_theme()->get( 'Version' ),
            true
        );

        wp_localize_script( 'publications-js', 'publicationsData', array(
            'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
            'nonce'   => wp_create_nonce( 'publications_nonce' ),
            'pageUrl' => esc_url( get_the_permalink( get_the_ID() ) ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_assets' );


// ============================================================
// 3. PRECONNECT HINTS FOR GOOGLE FONTS
// ============================================================

function theme_preconnect_hints( $hints, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $hints[] = array( 'href' => 'https://fonts.googleapis.com' );
        $hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'theme_preconnect_hints', 10, 2 );


// ============================================================
// 4. WIDGET AREAS
// ============================================================

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


// ============================================================
// 5. BODY CLASS ADDITIONS
// ============================================================

function theme_body_classes( $classes ) {
    // Add slug-based class matching the static template's {{page}} variable
    if ( is_singular() ) {
        global $post;
        if ( $post ) {
            $classes[] = $post->post_name;
        }
    }

    return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );


// ============================================================
// 6. PAGE-SPECIFIC ASSETS — LOCATIONS MAP
// ============================================================

function theme_enqueue_locations_assets() {

    // Only load on pages using the Locations page template
    if ( ! is_page_template( 'templates/template-locations.php' ) ) {
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


// ============================================================
// 7. CUSTOM POST TYPE — HOME SLIDES
// ============================================================

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
        'show_in_rest'      => true,
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
    $button_url  = get_post_meta( $post->ID, '_home_slide_button_url', true );
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
    $button_url  = isset( $_POST['home_slide_button_url'] )  ? esc_url_raw( $_POST['home_slide_button_url'] )          : '';

    if ( ! empty( $button_text ) && ! empty( $button_url ) ) {
        update_post_meta( $post_id, '_home_slide_button_text', $button_text );
        update_post_meta( $post_id, '_home_slide_button_url',  $button_url );
    } else {
        delete_post_meta( $post_id, '_home_slide_button_text' );
        delete_post_meta( $post_id, '_home_slide_button_url' );
    }
}
add_action( 'save_post_home_slide', 'theme_save_home_slide_meta' );


// Add custom columns to Home Slides list table
function theme_add_home_slides_columns( $columns ) {
    $new_columns = array();

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


// Make featured image column sortable
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
        @media screen and (min-width: 783px) {
            .wp-list-table.posts #featured_image { width: 10%; }
            .wp-list-table.posts .column-title   { width: 60%; }
            .wp-list-table.posts .column-date    { width: 30%; }
        }

        @media screen and (max-width: 782px) {
            .wp-list-table.posts .column-date,
            .wp-list-table.posts th#date            { display: none; }
            .wp-list-table.posts th.column-title,
            .wp-list-table.posts td.column-title    { width: 100% !important; display: block !important; padding: 10px !important; border: none !important; }
            .wp-list-table.posts th#featured_image,
            .wp-list-table.posts td.featured_image  { width: 100% !important; display: block !important; padding: 10px !important; border: none !important; text-align: left; }
            .wp-list-table.posts tbody tr           { display: block !important; border: 1px solid #ddd !important; margin-bottom: 15px !important; border-radius: 4px !important; }
            .wp-list-table.posts th.check-column,
            .wp-list-table.posts td.check-column    { display: block !important; width: 100% !important; padding: 10px !important; border: none !important; }
            .wp-list-table.posts thead tr           { display: block !important; }
            .wp-list-table.posts thead th           { display: block !important; width: 100% !important; border: none !important; padding: 10px !important; margin-bottom: 0 !important; }
            .wp-list-table.posts td.featured_image img { display: block; max-width: 80px; height: auto; }
        }
    </style>
    <?php
}
add_action( 'admin_head', 'theme_home_slides_admin_styles' );


// ============================================================
// 8. CUSTOM POST TYPE — TEAM MEMBER
// ============================================================

function theme_register_team_member_cpt() {
    $labels = array(
        'name'               => 'Team Members',
        'singular_name'      => 'Team Member',
        'menu_name'          => 'Team Members',
        'all_items'          => 'All Team Members',
        'add_new'            => 'Add New Member',
        'add_new_item'       => 'Add New Team Member',
        'edit_item'          => 'Edit Team Member',
        'view_item'          => 'View Team Member',
        'search_items'       => 'Search Team Members',
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_position'     => 6,
        'menu_icon'         => 'dashicons-groups',
        'supports'          => array( 'title', 'thumbnail', 'editor' ),
        'has_archive'       => true,
        'rewrite'           => array( 'slug' => 'team-member' ),
        'show_in_rest'      => true,
    );

    register_post_type( 'team_member', $args );
}
add_action( 'init', 'theme_register_team_member_cpt' );


// Register Team Locations Taxonomy
function theme_register_team_locations_taxonomy() {
    $labels = array(
        'name'               => 'Team Locations',
        'singular_name'      => 'Team Location',
        'menu_name'          => 'Locations',
        'all_items'          => 'All Locations',
        'add_new_item'       => 'Add New Location',
        'edit_item'          => 'Edit Location',
        'search_items'       => 'Search Locations',
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => false,
        'rewrite'           => array( 'slug' => 'team-location' ),
    );

    register_taxonomy( 'team_location', 'team_member', $args );
}
add_action( 'init', 'theme_register_team_locations_taxonomy' );


// Remove team location taxonomy meta box from editor
function ng_andersen_remove_team_location_meta_box() {
    remove_meta_box( 'team_locationdiv', 'team_member', 'side' );
}
add_action( 'add_meta_boxes', 'ng_andersen_remove_team_location_meta_box' );


// Team Member custom meta boxes
function ng_andersen_add_team_member_meta_boxes() {
    add_meta_box(
        'team_member_details',
        'Team Member Details',
        'ng_andersen_render_team_member_meta_box',
        'team_member',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'ng_andersen_add_team_member_meta_boxes' );


// Render team member meta box
function ng_andersen_render_team_member_meta_box( $post ) {
    wp_nonce_field( 'team_member_nonce', 'team_member_nonce' );

    $position = get_post_meta( $post->ID, '_team_member_position', true );
    $location = get_post_meta( $post->ID, '_team_member_location', true );
    $email    = get_post_meta( $post->ID, '_team_member_email',    true );
    ?>

    <div style="margin-bottom: 20px;">
        <label for="team_member_position" style="display: block; margin-bottom: 8px; font-weight: 600;">
            Position
        </label>
        <input
            type="text"
            id="team_member_position"
            name="team_member_position"
            value="<?php echo esc_attr( $position ); ?>"
            placeholder="e.g., Managing Director, Senior Manager"
            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"
        >
        <p style="font-size: 12px; color: #666; margin-top: 5px;">
            The job title or position of this team member.
        </p>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="team_member_location" style="display: block; margin-bottom: 8px; font-weight: 600;">
            Location
        </label>
        <select
            id="team_member_location"
            name="team_member_location"
            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"
        >
            <option value="">Select a Location</option>
            <?php
            $locations = get_terms( array(
                'taxonomy'   => 'team_location',
                'hide_empty' => false,
            ) );

            if ( $locations && ! is_wp_error( $locations ) ) {
                foreach ( $locations as $loc ) {
                    ?>
                    <option value="<?php echo absint( $loc->term_id ); ?>" <?php selected( $location, $loc->term_id ); ?>>
                        <?php echo esc_html( $loc->name ); ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
        <p style="font-size: 12px; color: #666; margin-top: 5px;">
            Select the primary location for this team member.
        </p>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="team_member_email" style="display: block; margin-bottom: 8px; font-weight: 600;">
            Email <span style="color: red;">*</span>
        </label>
        <input
            type="email"
            id="team_member_email"
            name="team_member_email"
            value="<?php echo esc_attr( $email ); ?>"
            placeholder="name@example.com"
            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"
            required
        >
        <p style="font-size: 12px; color: #666; margin-top: 5px;">
            Contact email for this team member. Must be a valid email address.
        </p>
    </div>

    <p style="font-size: 12px; color: #666; margin-top: 16px;">
        <strong>Note:</strong> Use the Featured Image panel on the right to upload the team member's photo. The page content (editor above) is used as the biography.
    </p>
    <?php
}


// Save team member meta
function ng_andersen_save_team_member_meta( $post_id ) {
    if ( ! isset( $_POST['team_member_nonce'] ) || ! wp_verify_nonce( $_POST['team_member_nonce'], 'team_member_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['team_member_position'] ) ) {
        update_post_meta( $post_id, '_team_member_position', sanitize_text_field( $_POST['team_member_position'] ) );
    }

    if ( isset( $_POST['team_member_location'] ) && ! empty( $_POST['team_member_location'] ) ) {
        update_post_meta( $post_id, '_team_member_location', absint( $_POST['team_member_location'] ) );
    } else {
        delete_post_meta( $post_id, '_team_member_location' );
    }

    if ( isset( $_POST['team_member_email'] ) ) {
        $email = sanitize_email( $_POST['team_member_email'] );
        if ( is_email( $email ) ) {
            update_post_meta( $post_id, '_team_member_email', $email );
        }
    }
}
add_action( 'save_post_team_member', 'ng_andersen_save_team_member_meta' );


// ============================================================
// 9. AJAX: TEAM MEMBER SEARCH
// ============================================================

function ng_andersen_ajax_search_team_members() {
    check_ajax_referer( 'team_search_nonce', 'nonce' );

    $name     = isset( $_POST['name'] )     ? sanitize_text_field( $_POST['name'] )     : '';
    $position = isset( $_POST['position'] ) ? sanitize_text_field( $_POST['position'] ) : '';
    $location = isset( $_POST['location'] ) ? absint( $_POST['location'] )               : 0;
    $paged    = isset( $_POST['paged'] )    ? absint( $_POST['paged'] )                  : 1;

    $args = array(
        'post_type'      => 'team_member',
        'posts_per_page' => 10,
        'paged'          => $paged,
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    if ( ! empty( $name ) ) {
        $args['s'] = $name;
    }

    if ( ! empty( $position ) ) {
        $args['meta_query'][] = array(
            'key'     => '_team_member_position',
            'value'   => $position,
            'compare' => 'LIKE',
        );
    }

    if ( ! empty( $location ) ) {
        $args['meta_query'][] = array(
            'key'     => '_team_member_location',
            'value'   => $location,
            'compare' => '=',
            'type'    => 'NUMERIC',
        );
    }

    if ( isset( $args['meta_query'] ) && count( $args['meta_query'] ) > 1 ) {
        $args['meta_query']['relation'] = 'AND';
    }

    $query = new WP_Query( $args );

    ob_start();

    if ( $query->have_posts() ) {
        ?>
        <div class="people-list">
            <?php
            while ( $query->have_posts() ) {
                $query->the_post();
                $position    = get_post_meta( get_the_ID(), '_team_member_position', true );
                $location_id = get_post_meta( get_the_ID(), '_team_member_location', true );
                $location_text = '';

                if ( $location_id ) {
                    $location_term = get_term( $location_id, 'team_location' );
                    if ( $location_term && ! is_wp_error( $location_term ) ) {
                        $location_text = $location_term->name;
                    }
                }
                ?>
                <a class="item" href="<?php echo esc_url( get_permalink() ); ?>">
                    <span class="item-img">
                        <span><?php the_post_thumbnail( 'medium' ); ?></span>
                    </span>
                    <span class="item-name"><?php the_title(); ?></span>
                    <span class="item-location"><?php echo esc_html( $location_text ); ?></span>
                    <span class="item-position"><?php echo esc_html( $position ); ?></span>
                </a>
                <?php
            }
            ?>
        </div>

        <?php
        $total_pages = $query->max_num_pages;
        if ( $total_pages > 1 ) {
            ?>
            <nav aria-label="Pagination">
                <ul class="pagination text-center">
                    <?php
                    if ( $paged > 1 ) {
                        ?>
                        <li class="pagination-previous">
                            <a href="#" class="page-link" data-page="<?php echo absint( $paged - 1 ); ?>">Previous</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="pagination-previous disabled"><span>Previous</span></li>
                        <?php
                    }

                    for ( $i = 1; $i <= $total_pages; $i++ ) {
                        if ( $i <= 4 || $i > $total_pages - 2 ) {
                            if ( $i == $paged ) {
                                ?>
                                <li class="current"><span class="show-for-sr">You're on page</span> <?php echo absint( $i ); ?></li>
                                <?php
                            } else {
                                ?>
                                <li><a href="#" class="page-link" data-page="<?php echo absint( $i ); ?>" aria-label="Page <?php echo absint( $i ); ?>"><?php echo absint( $i ); ?></a></li>
                                <?php
                            }
                        } elseif ( $i == 5 && $total_pages > 7 ) {
                            ?>
                            <li class="ellipsis"><span></span></li>
                            <?php
                        }
                    }

                    if ( $paged < $total_pages ) {
                        ?>
                        <li class="pagination-next">
                            <a href="#" class="page-link" data-page="<?php echo absint( $paged + 1 ); ?>" aria-label="Next page">Next</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="pagination-next disabled"><span>Next</span></li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>
            <?php
        }
    } else {
        ?>
        <div class="people-list">
            <div class="team-no-results">
                <p>No team members match your search.</p>
            </div>
        </div>
        <?php
    }

    wp_reset_postdata();

    $output = ob_get_clean();
    wp_send_json_success( array( 'html' => $output ) );
}
add_action( 'wp_ajax_ng_andersen_search_team_members',        'ng_andersen_ajax_search_team_members' );
add_action( 'wp_ajax_nopriv_ng_andersen_search_team_members', 'ng_andersen_ajax_search_team_members' );


// ============================================================
// 10. AJAX: PUBLICATIONS
// ============================================================

function ng_andersen_publications_html( $cat = 0, $page = 1, $search = '' ) {
    $query_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 12,
        'paged'          => $page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if ( $cat > 0 ) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $cat,
            ),
        );
    }

    // Title-only search — avoids full content search for performance
    if ( ! empty( $search ) ) {
        $query_args['search_columns'] = array( 'post_title' );
        $query_args['s']              = $search;
    }

    $publications = new WP_Query( $query_args );
    $total_pages  = $publications->max_num_pages;

    ob_start();
    ?>

    <div class="section-blocks section-blocks1 section-blocks16">
        <div class="container">
            <div class="grid-x grid-padding-x" id="publications-posts">
                <?php
                if ( $publications->have_posts() ) {
                    while ( $publications->have_posts() ) {
                        $publications->the_post();
                        ?>
                        <div class="cell medium-6 large-4">
                            <div class="item">
                                <div class="image">
                                    <span class="img-bg">
                                        <img src="<?php echo esc_url( ng_andersen_get_post_card_image( get_the_ID() ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                    </span>
                                    <?php
                                    // Category badge overlaid on image
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) {
                                        ?>
                                        <span class="publication-category-badge"><?php echo esc_html( $categories[0]->name ); ?></span>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="text">
                                    <div class="text-body">
                                        <p class="publication-date"><?php echo esc_html( get_the_date() ); ?></p>
                                        <h3><?php the_title(); ?></h3>
                                        <a href="<?php the_permalink(); ?>" class="button-link">Read More &raquo;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    ?>
                    <div class="cell">
                        <p>No publications found in this category.</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ( $total_pages > 1 ) { ?>
        <nav aria-label="Publications Pagination" id="publications-pagination">
            <ul class="pagination text-center">
                <?php if ( $page > 1 ) { ?>
                    <li class="pagination-previous">
                        <a href="#" data-page="<?php echo absint( $page - 1 ); ?>">Previous</a>
                    </li>
                <?php } else { ?>
                    <li class="pagination-previous disabled"><span>Previous</span></li>
                <?php } ?>

                <?php
                // Build the set of page numbers to show:
                // Always: first 2, last 2, current page and 1 neighbour each side
                $show_pages = array();
                for ( $i = 1; $i <= $total_pages; $i++ ) {
                    if (
                        $i <= 2 ||                          // First 2
                        $i >= $total_pages - 1 ||           // Last 2
                        ( $i >= $page - 1 && $i <= $page + 1 ) // Current ± 1
                    ) {
                        $show_pages[] = $i;
                    }
                }
                $show_pages = array_unique( $show_pages );
                sort( $show_pages );

                $prev_shown = null;
                foreach ( $show_pages as $i ) {
                    // Insert ellipsis if there's a gap since the last shown page
                    if ( $prev_shown !== null && $i > $prev_shown + 1 ) {
                        ?>
                        <li class="ellipsis"><span></span></li>
                        <?php
                    }

                    if ( $i == $page ) {
                        ?>
                        <li class="current">
                            <span class="show-for-sr">You're on page</span><?php echo absint( $i ); ?>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <a href="#" data-page="<?php echo absint( $i ); ?>" aria-label="Page <?php echo absint( $i ); ?>"><?php echo absint( $i ); ?></a>
                        </li>
                        <?php
                    }

                    $prev_shown = $i;
                }
                ?>

                <?php if ( $page < $total_pages ) { ?>
                    <li class="pagination-next">
                        <a href="#" data-page="<?php echo absint( $page + 1 ); ?>">Next</a>
                    </li>
                <?php } else { ?>
                    <li class="pagination-next disabled"><span>Next</span></li>
                <?php } ?>
            </ul>
        </nav>
    <?php } ?>

    <?php
    return ob_get_clean();
}

function ng_andersen_ajax_get_publications() {
    check_ajax_referer( 'publications_nonce', 'nonce' );

    $cat    = isset( $_POST['cat'] )    ? absint( $_POST['cat'] )                        : 0;
    $page   = isset( $_POST['page'] )   ? absint( $_POST['page'] )                       : 1;
    $search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] )        : '';

    wp_send_json_success( array( 'html' => ng_andersen_publications_html( $cat, $page, $search ) ) );
}
add_action( 'wp_ajax_ng_andersen_get_publications',        'ng_andersen_ajax_get_publications' );
add_action( 'wp_ajax_nopriv_ng_andersen_get_publications', 'ng_andersen_ajax_get_publications' );


// ============================================================
// 11. FIX PAGINATION ON STATIC PAGE TEMPLATES
// ============================================================

add_filter( 'redirect_canonical', function( $redirect_url ) {
    if ( is_page() && get_query_var( 'page' ) ) {
        return false;
    }
    return $redirect_url;
} );


// ============================================================
// 11b. SEARCH RESULTS — 12 PER PAGE
// ============================================================

add_action( 'pre_get_posts', function( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
        $query->set( 'posts_per_page', 12 );
    }
} );


// ============================================================
// 12. ANDERSEN ADMIN COLOR SCHEME
// ============================================================

add_action( 'admin_init', function() {
    wp_admin_css_color(
        'andersen',
        __( 'Andersen', 'ng-andersen' ),
        get_template_directory_uri() . '/assets/css/admin-color-scheme.css',
        array(
            '#1d2327',
            '#2c3338',
            '#2271b1',
            '#72aee6',
        )
    );
} );


require_once get_template_directory() . '/theme-settings.php';