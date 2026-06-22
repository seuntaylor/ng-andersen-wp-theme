<?php
/**
 * Theme Settings Page with Tabs
 *
 * Custom admin settings page for site-wide configuration with tabbed interface:
 * - Office Locations
 * - Social Media
 * - Tracking & Analytics
 * - CAPTCHA API Keys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_menu', function() {
    add_menu_page(
        'NG Andersen Settings',
        'NG Andersen',
        'manage_options',
        'ng-andersen-settings',
        'ng_andersen_render_settings_page',
        'dashicons-cog',
        58
    );
} );

add_action( 'admin_init', function() {
    // ============================================================
    // OFFICE LOCATIONS
    // ============================================================
    
    // Office 1
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_1_name' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_1_address' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_1_email' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_1_phone' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_1_map_code' );

    // Office 2
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_2_name' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_2_address' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_2_email' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_2_phone' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_2_map_code' );

    // Office 3
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_3_name' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_3_address' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_3_email' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_3_phone' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_office_3_map_code' );

    // ============================================================
    // SOCIAL MEDIA
    // ============================================================
    
    register_setting( 'ng-andersen-settings', 'ng_andersen_social_facebook' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_social_twitter' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_social_linkedin' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_social_instagram' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_social_youtube' );

    // ============================================================
    // TRACKING & ANALYTICS
    // ============================================================
    
    register_setting( 'ng-andersen-settings', 'ng_andersen_ga_tracking_id' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_ga_enabled' );

    // ============================================================
    // CAPTCHA API KEYS
    // ============================================================
    
    register_setting( 'ng-andersen-settings', 'ng_andersen_turnstile_site_key' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_turnstile_secret_key' );

    // ============================================================
    // SINGLE POST SIDEBAR
    // ============================================================

    register_setting( 'ng-andersen-settings', 'ng_andersen_single_widget_title' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_single_widget_cats', array(
        'sanitize_callback' => function( $value ) {
            if ( ! is_array( $value ) ) {
                return array();
            }
            return array_map( 'absint', $value );
        },
    ) );
    register_setting( 'ng-andersen-settings', 'ng_andersen_single_widget_count' );

    // Resources widget
    register_setting( 'ng-andersen-settings', 'ng_andersen_resources_widget_title' );
    register_setting( 'ng-andersen-settings', 'ng_andersen_resources_widget_cats', array(
        'sanitize_callback' => function( $value ) {
            if ( ! is_array( $value ) ) {
                return array();
            }
            return array_map( 'absint', $value );
        },
    ) );
    register_setting( 'ng-andersen-settings', 'ng_andersen_resources_widget_count' );

    // ============================================================
    // CATEGORY IMAGES
    // ============================================================

    // Hero images keyed by category ID — stored as array( term_id => attachment_id )
    register_setting( 'ng-andersen-settings', 'ng_andersen_category_hero_images', array(
        'sanitize_callback' => 'ng_andersen_sanitize_category_image_map',
    ) );

    // Card fallback images keyed by category ID — stored as array( term_id => attachment_id )
    register_setting( 'ng-andersen-settings', 'ng_andersen_category_card_images', array(
        'sanitize_callback' => 'ng_andersen_sanitize_category_image_map',
    ) );
} );

/**
 * Sanitize a category => attachment ID map.
 * Ensures both keys and values are positive integers; drops empties.
 */
function ng_andersen_sanitize_category_image_map( $value ) {
    if ( ! is_array( $value ) ) {
        return array();
    }
    $clean = array();
    foreach ( $value as $term_id => $attachment_id ) {
        $term_id       = absint( $term_id );
        $attachment_id = absint( $attachment_id );
        if ( $term_id > 0 && $attachment_id > 0 ) {
            $clean[ $term_id ] = $attachment_id;
        }
    }
    return $clean;
}

/**
 * Render the settings page with tabs
 */
function ng_andersen_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized' );
    }

    // Get active tab
    $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'offices';
    ?>

    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <!-- Tab Navigation -->
        <nav class="nav-tab-wrapper wp-clearfix">
            <a href="?page=ng-andersen-settings&tab=offices" class="nav-tab <?php echo $active_tab === 'offices' ? 'nav-tab-active' : ''; ?>">
                Office Locations
            </a>
            <a href="?page=ng-andersen-settings&tab=social" class="nav-tab <?php echo $active_tab === 'social' ? 'nav-tab-active' : ''; ?>">
                Social Media
            </a>
            <a href="?page=ng-andersen-settings&tab=analytics" class="nav-tab <?php echo $active_tab === 'analytics' ? 'nav-tab-active' : ''; ?>">
                Tracking & Analytics
            </a>
            <a href="?page=ng-andersen-settings&tab=captcha" class="nav-tab <?php echo $active_tab === 'captcha' ? 'nav-tab-active' : ''; ?>">
                CAPTCHA API Keys
            </a>
            <a href="?page=ng-andersen-settings&tab=single-post" class="nav-tab <?php echo $active_tab === 'single-post' ? 'nav-tab-active' : ''; ?>">
                Single Post
            </a>
            <a href="?page=ng-andersen-settings&tab=category-images" class="nav-tab <?php echo $active_tab === 'category-images' ? 'nav-tab-active' : ''; ?>">
                Category Images
            </a>
        </nav>

        <!-- Tab Content -->
        <form method="post" action="options.php">
            <?php settings_fields( 'ng-andersen-settings' ); ?>

            <!-- OFFICE LOCATIONS TAB -->
            <div class="tab-content" <?php echo $active_tab !== 'offices' ? 'style="display:none;"' : ''; ?>>
                <h2>Office Locations</h2>
                <p>Configure office information displayed on the Contact page. You can add up to 3 offices.</p>

                <?php
                for ( $i = 1; $i <= 3; $i++ ) {
                    ng_andersen_render_office_section( $i );
                }
                ?>
            </div>

            <!-- SOCIAL MEDIA TAB -->
            <div class="tab-content" <?php echo $active_tab !== 'social' ? 'style="display:none;"' : ''; ?>>
                <h2>Social Media Links</h2>
                <p>Add links to your social media profiles. Leave blank to hide.</p>

                <?php ng_andersen_render_social_media_section(); ?>
            </div>

            <!-- TRACKING & ANALYTICS TAB -->
            <div class="tab-content" <?php echo $active_tab !== 'analytics' ? 'style="display:none;"' : ''; ?>>
                <h2>Tracking & Analytics</h2>
                <p>Configure analytics and tracking services.</p>

                <?php ng_andersen_render_analytics_section(); ?>
            </div>

            <!-- CAPTCHA API KEYS TAB -->
            <div class="tab-content" <?php echo $active_tab !== 'captcha' ? 'style="display:none;"' : ''; ?>>
                <h2>CAPTCHA API Keys</h2>
                <p>Configure Cloudflare Turnstile API keys for form protection.</p>

                <?php ng_andersen_render_captcha_section(); ?>
            </div>

            <!-- SINGLE POST TAB -->
            <div class="tab-content" <?php echo $active_tab !== 'single-post' ? 'style="display:none;"' : ''; ?>>
                <h2>Single Post Sidebar</h2>
                <p>Configure the related posts widget that appears in the right column of every single post page.</p>

                <?php ng_andersen_render_single_post_section(); ?>
            </div>

            <!-- CATEGORY IMAGES TAB -->
            <div class="tab-content" <?php echo $active_tab !== 'category-images' ? 'style="display:none;"' : ''; ?>>
                <h2>Category Images</h2>
                <p>Define images per category. The <strong>Hero Image</strong> is always used on the single post hero for posts in that category (overriding the post&rsquo;s own featured image). The <strong>Card Fallback</strong> is used on the home, publications, and search card grids only when a post has no featured image of its own.</p>

                <?php ng_andersen_render_category_images_section(); ?>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>

    <style>
        .tab-content {
            margin-top: 20px;
        }
    </style>
    <?php
}

/**
 * Render office section
 */
function ng_andersen_render_office_section( $office_number ) {
    $name = get_option( "ng_andersen_office_{$office_number}_name" );
    $address = get_option( "ng_andersen_office_{$office_number}_address" );
    $email = get_option( "ng_andersen_office_{$office_number}_email" );
    $phone = get_option( "ng_andersen_office_{$office_number}_phone" );
    $map_code = get_option( "ng_andersen_office_{$office_number}_map_code" );
    ?>

    <div style="background: #f8f9fa; padding: 20px; margin: 20px 0; border-left: 4px solid #0073aa; border-radius: 4px;">
        <h3>Office <?php echo absint( $office_number ); ?></h3>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="ng_andersen_office_<?php echo absint( $office_number ); ?>_name">
                        Office Name <span style="color: red;">*</span>
                    </label>
                </th>
                <td>
                    <input
                        type="text"
                        id="ng_andersen_office_<?php echo absint( $office_number ); ?>_name"
                        name="ng_andersen_office_<?php echo absint( $office_number ); ?>_name"
                        value="<?php echo esc_attr( $name ); ?>"
                        placeholder="e.g., Lagos Office"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                    >
                    <p class="description">The name or location of this office.</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="ng_andersen_office_<?php echo absint( $office_number ); ?>_address">
                        Address <span style="color: red;">*</span>
                    </label>
                </th>
                <td>
                    <textarea
                        id="ng_andersen_office_<?php echo absint( $office_number ); ?>_address"
                        name="ng_andersen_office_<?php echo absint( $office_number ); ?>_address"
                        rows="4"
                        style="width: 100%; max-width: 600px; padding: 8px; font-family: monospace;"
                    ><?php echo esc_textarea( $address ); ?></textarea>
                    <p class="description">Full office address (street, city, postal code, country). Use line breaks for multiple lines.</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="ng_andersen_office_<?php echo absint( $office_number ); ?>_email">
                        Email
                    </label>
                </th>
                <td>
                    <input
                        type="email"
                        id="ng_andersen_office_<?php echo absint( $office_number ); ?>_email"
                        name="ng_andersen_office_<?php echo absint( $office_number ); ?>_email"
                        value="<?php echo esc_attr( $email ); ?>"
                        placeholder="office@example.com"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                    >
                    <p class="description">Contact email for this office.</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="ng_andersen_office_<?php echo absint( $office_number ); ?>_phone">
                        Phone
                    </label>
                </th>
                <td>
                    <input
                        type="tel"
                        id="ng_andersen_office_<?php echo absint( $office_number ); ?>_phone"
                        name="ng_andersen_office_<?php echo absint( $office_number ); ?>_phone"
                        value="<?php echo esc_attr( $phone ); ?>"
                        placeholder="+234 123 456 7890"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                    >
                    <p class="description">Contact phone number for this office.</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="ng_andersen_office_<?php echo absint( $office_number ); ?>_map_code">
                        Google Maps Embed Code
                    </label>
                </th>
                <td>
                    <textarea
                        id="ng_andersen_office_<?php echo absint( $office_number ); ?>_map_code"
                        name="ng_andersen_office_<?php echo absint( $office_number ); ?>_map_code"
                        rows="6"
                        style="width: 100%; max-width: 600px; padding: 8px; font-family: monospace; font-size: 12px;"
                    ><?php echo esc_textarea( $map_code ); ?></textarea>
                    <p class="description">Paste the full iframe embed code from Google Maps. <a href="https://www.google.com/maps" target="_blank">Get embed code</a></p>
                </td>
            </tr>
        </table>
    </div>

    <?php
}

/**
 * Render social media section
 */
function ng_andersen_render_social_media_section() {
    $facebook = get_option( 'ng_andersen_social_facebook' );
    $twitter = get_option( 'ng_andersen_social_twitter' );
    $linkedin = get_option( 'ng_andersen_social_linkedin' );
    $instagram = get_option( 'ng_andersen_social_instagram' );
    $youtube = get_option( 'ng_andersen_social_youtube' );
    ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="ng_andersen_social_facebook">Facebook</label>
            </th>
            <td>
                <input
                    type="url"
                    id="ng_andersen_social_facebook"
                    name="ng_andersen_social_facebook"
                    value="<?php echo esc_attr( $facebook ); ?>"
                    placeholder="https://www.facebook.com/yourpage"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Full URL to your Facebook page.</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="ng_andersen_social_twitter">Twitter / X</label>
            </th>
            <td>
                <input
                    type="url"
                    id="ng_andersen_social_twitter"
                    name="ng_andersen_social_twitter"
                    value="<?php echo esc_attr( $twitter ); ?>"
                    placeholder="https://www.twitter.com/yourhandle"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Full URL to your Twitter/X profile.</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="ng_andersen_social_linkedin">LinkedIn</label>
            </th>
            <td>
                <input
                    type="url"
                    id="ng_andersen_social_linkedin"
                    name="ng_andersen_social_linkedin"
                    value="<?php echo esc_attr( $linkedin ); ?>"
                    placeholder="https://www.linkedin.com/company/yourcompany"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Full URL to your LinkedIn company page.</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="ng_andersen_social_instagram">Instagram</label>
            </th>
            <td>
                <input
                    type="url"
                    id="ng_andersen_social_instagram"
                    name="ng_andersen_social_instagram"
                    value="<?php echo esc_attr( $instagram ); ?>"
                    placeholder="https://www.instagram.com/yourprofile"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Full URL to your Instagram profile.</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="ng_andersen_social_youtube">YouTube</label>
            </th>
            <td>
                <input
                    type="url"
                    id="ng_andersen_social_youtube"
                    name="ng_andersen_social_youtube"
                    value="<?php echo esc_attr( $youtube ); ?>"
                    placeholder="https://www.youtube.com/@yourchannel"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Full URL to your YouTube channel.</p>
            </td>
        </tr>
    </table>

    <?php
}

/**
 * Render analytics section
 */
function ng_andersen_render_analytics_section() {
    $ga_tracking_id = get_option( 'ng_andersen_ga_tracking_id' );
    $ga_enabled = get_option( 'ng_andersen_ga_enabled' );
    ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="ng_andersen_ga_enabled">Enable Google Analytics</label>
            </th>
            <td>
                <input
                    type="checkbox"
                    id="ng_andersen_ga_enabled"
                    name="ng_andersen_ga_enabled"
                    value="1"
                    <?php checked( $ga_enabled, 1 ); ?>
                >
                <p class="description">Check this box to enable Google Analytics tracking.</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="ng_andersen_ga_tracking_id">Google Analytics Tracking ID</label>
            </th>
            <td>
                <input
                    type="text"
                    id="ng_andersen_ga_tracking_id"
                    name="ng_andersen_ga_tracking_id"
                    value="<?php echo esc_attr( $ga_tracking_id ); ?>"
                    placeholder="G-XXXXXXXXXX"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Your Google Analytics 4 Measurement ID (starts with G-).</p>
            </td>
        </tr>
    </table>

    <?php
}

/**
 * Render CAPTCHA section
 */
function ng_andersen_render_captcha_section() {
    $site_key = get_option( 'ng_andersen_turnstile_site_key' );
    $secret_key = get_option( 'ng_andersen_turnstile_secret_key' );
    ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="ng_andersen_turnstile_site_key">Turnstile Site Key</label>
            </th>
            <td>
                <input
                    type="text"
                    id="ng_andersen_turnstile_site_key"
                    name="ng_andersen_turnstile_site_key"
                    value="<?php echo esc_attr( $site_key ); ?>"
                    placeholder="Your Site Key"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Cloudflare Turnstile Site Key for form protection.</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="ng_andersen_turnstile_secret_key">Turnstile Secret Key</label>
            </th>
            <td>
                <input
                    type="password"
                    id="ng_andersen_turnstile_secret_key"
                    name="ng_andersen_turnstile_secret_key"
                    value="<?php echo esc_attr( $secret_key ); ?>"
                    placeholder="Your Secret Key"
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
                <p class="description">Cloudflare Turnstile Secret Key. This is displayed as a password field for security.</p>
            </td>
        </tr>
    </table>

    <?php
}

/**
 * Helper function to retrieve office settings
 * Usage: $office = ng_andersen_get_office( 1 );
 */
function ng_andersen_get_office( $office_number ) {
    return array(
        'name'     => get_option( "ng_andersen_office_{$office_number}_name" ),
        'address'  => get_option( "ng_andersen_office_{$office_number}_address" ),
        'email'    => get_option( "ng_andersen_office_{$office_number}_email" ),
        'phone'    => get_option( "ng_andersen_office_{$office_number}_phone" ),
        'map_code' => get_option( "ng_andersen_office_{$office_number}_map_code" ),
    );
}

/**
 * Helper function to retrieve social media links
 * Usage: $socials = ng_andersen_get_social_links();
 */
function ng_andersen_get_social_links() {
    return array(
        'facebook'  => get_option( 'ng_andersen_social_facebook' ),
        'twitter'   => get_option( 'ng_andersen_social_twitter' ),
        'linkedin'  => get_option( 'ng_andersen_social_linkedin' ),
        'instagram' => get_option( 'ng_andersen_social_instagram' ),
        'youtube'   => get_option( 'ng_andersen_social_youtube' ),
    );
}

/**
 * Helper function to retrieve Turnstile API keys
 * Usage: $keys = ng_andersen_get_turnstile_keys();
 */
function ng_andersen_get_turnstile_keys() {
    return array(
        'site_key'   => get_option( 'ng_andersen_turnstile_site_key' ),
        'secret_key' => get_option( 'ng_andersen_turnstile_secret_key' ),
    );
}

/**
 * Helper function to check if GA is enabled and get tracking ID
 * Usage: $ga = ng_andersen_get_ga_settings();
 */
function ng_andersen_get_ga_settings() {
    return array(
        'enabled'      => get_option( 'ng_andersen_ga_enabled' ),
        'tracking_id'  => get_option( 'ng_andersen_ga_tracking_id' ),
    );
}

/**
 * Render single post sidebar section
 */
function ng_andersen_render_single_post_section() {
    $widget_title = get_option( 'ng_andersen_single_widget_title', 'You May Also Like' );
    $widget_count = get_option( 'ng_andersen_single_widget_count', 3 );

    $resources_title = get_option( 'ng_andersen_resources_widget_title', 'Insights & Resources' );
    $resources_count = get_option( 'ng_andersen_resources_widget_count', 3 );

    // Get saved checkbox selections
    $saved_widget_cats = get_option( 'ng_andersen_single_widget_cats', array() );
    if ( ! is_array( $saved_widget_cats ) ) {
        $saved_widget_cats = array();
    }

    $saved_resources_cats = get_option( 'ng_andersen_resources_widget_cats', array() );
    if ( ! is_array( $saved_resources_cats ) ) {
        $saved_resources_cats = array();
    }

    // Get all categories for the checkboxes
    $categories = get_categories( array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => true,
    ) );
    ?>

    <!-- Related Posts Widget (widget--news) -->
    <div style="background: #f8f9fa; padding: 20px; margin: 20px 0; border-left: 4px solid #0073aa; border-radius: 4px;">
        <h3>Related Posts Widget</h3>
        <p style="color: #666; font-size: 13px;">Displays post cards with image and title. Uses the <code>widget--news</code> style. Posts are picked randomly from the selected categories.</p>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="ng_andersen_single_widget_title">Widget Headline</label>
                </th>
                <td>
                    <input
                        type="text"
                        id="ng_andersen_single_widget_title"
                        name="ng_andersen_single_widget_title"
                        value="<?php echo esc_attr( $widget_title ); ?>"
                        placeholder="e.g., You May Also Like"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                    >
                    <p class="description">Heading displayed above the related posts widget.</p>
                </td>
            </tr>
            <tr>
                <th scope="row">Source Categories</th>
                <td>
                    <?php foreach ( $categories as $cat ) { ?>
                        <label style="display: block; margin-bottom: 6px;">
                            <input
                                type="checkbox"
                                name="ng_andersen_single_widget_cats[]"
                                value="<?php echo absint( $cat->term_id ); ?>"
                                <?php echo in_array( $cat->term_id, $saved_widget_cats ) ? 'checked' : ''; ?>
                                style="margin-right: 6px;"
                            >
                            <?php echo esc_html( $cat->name ); ?>
                            <span style="color: #999; font-size: 12px;">(<?php echo absint( $cat->count ); ?>)</span>
                        </label>
                    <?php } ?>
                    <p class="description">Posts will be picked randomly from all selected categories.</p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="ng_andersen_single_widget_count">Number of Posts</label>
                </th>
                <td>
                    <input
                        type="number"
                        id="ng_andersen_single_widget_count"
                        name="ng_andersen_single_widget_count"
                        value="<?php echo absint( $widget_count ); ?>"
                        min="1"
                        max="6"
                        style="width: 80px; padding: 8px;"
                    >
                    <p class="description">How many posts to display (1–6).</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Resources Widget (widget--resources) -->
    <div style="background: #f8f9fa; padding: 20px; margin: 20px 0; border-left: 4px solid #46b450; border-radius: 4px;">
        <h3>Resources Widget</h3>
        <p style="color: #666; font-size: 13px;">Displays a text list with category label and linked title. Uses the <code>widget--resources</code> style. Posts are picked randomly from the selected categories.</p>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="ng_andersen_resources_widget_title">Widget Headline</label>
                </th>
                <td>
                    <input
                        type="text"
                        id="ng_andersen_resources_widget_title"
                        name="ng_andersen_resources_widget_title"
                        value="<?php echo esc_attr( $resources_title ); ?>"
                        placeholder="e.g., Insights & Resources"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                    >
                    <p class="description">Heading displayed above the resources widget.</p>
                </td>
            </tr>
            <tr>
                <th scope="row">Source Categories</th>
                <td>
                    <?php
                    foreach ( $categories as $cat ) {
                        $checked = in_array( $cat->term_id, $saved_resources_cats ) ? 'checked' : '';
                        ?>
                        <label style="display: block; margin-bottom: 6px;">
                            <input
                                type="checkbox"
                                name="ng_andersen_resources_widget_cats[]"
                                value="<?php echo absint( $cat->term_id ); ?>"
                                <?php echo $checked; ?>
                                style="margin-right: 6px;"
                            >
                            <?php echo esc_html( $cat->name ); ?>
                            <span style="color: #999; font-size: 12px;">(<?php echo absint( $cat->count ); ?>)</span>
                        </label>
                        <?php
                    }
                    ?>
                    <p class="description">Posts will be picked randomly from all selected categories.</p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="ng_andersen_resources_widget_count">Number of Posts</label>
                </th>
                <td>
                    <input
                        type="number"
                        id="ng_andersen_resources_widget_count"
                        name="ng_andersen_resources_widget_count"
                        value="<?php echo absint( $resources_count ); ?>"
                        min="2"
                        max="6"
                        style="width: 80px; padding: 8px;"
                    >
                    <p class="description">How many posts to display (2–6).</p>
                </td>
            </tr>
        </table>
    </div>

    <?php
}

/**
 * Helper function to retrieve single post sidebar settings
 * Usage: $settings = ng_andersen_get_single_post_settings();
 */
function ng_andersen_get_single_post_settings() {
    $widget_cats = get_option( 'ng_andersen_single_widget_cats', array() );
    if ( ! is_array( $widget_cats ) ) {
        $widget_cats = array();
    }

    $resources_cats = get_option( 'ng_andersen_resources_widget_cats', array() );
    if ( ! is_array( $resources_cats ) ) {
        $resources_cats = array();
    }

    return array(
        'widget_title'      => get_option( 'ng_andersen_single_widget_title', 'You May Also Like' ),
        'widget_cats'       => array_map( 'absint', $widget_cats ),
        'widget_count'      => absint( get_option( 'ng_andersen_single_widget_count', 3 ) ),
        'resources_title'   => get_option( 'ng_andersen_resources_widget_title', 'Insights & Resources' ),
        'resources_cats'    => array_map( 'absint', $resources_cats ),
        'resources_count'   => absint( get_option( 'ng_andersen_resources_widget_count', 3 ) ),
    );
}

/**
 * Enqueue the WordPress media library + picker JS on the settings page only.
 */
add_action( 'admin_enqueue_scripts', function( $hook ) {
    // Only load on our settings page
    if ( 'toplevel_page_ng-andersen-settings' !== $hook && 'settings_page_ng-andersen-settings' !== $hook ) {
        // Hook suffix varies by how the menu is registered; check the request as a fallback
        if ( ! isset( $_GET['page'] ) || 'ng-andersen-settings' !== $_GET['page'] ) {
            return;
        }
    }
    wp_enqueue_media();
} );

/**
 * Render the Category Images section.
 * Lists every category with a Hero Image picker and a Card Fallback picker,
 * each showing a live preview.
 */
function ng_andersen_render_category_images_section() {
    $hero_images = get_option( 'ng_andersen_category_hero_images', array() );
    $card_images = get_option( 'ng_andersen_category_card_images', array() );
    if ( ! is_array( $hero_images ) ) {
        $hero_images = array();
    }
    if ( ! is_array( $card_images ) ) {
        $card_images = array();
    }

    $categories = get_categories( array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => false,
    ) );

    if ( empty( $categories ) ) {
        echo '<p>No categories found.</p>';
        return;
    }
    ?>

    <table class="form-table ng-category-images">
        <thead>
            <tr>
                <th style="width: 25%;">Category</th>
                <th style="width: 37.5%;">Hero Image <span style="font-weight: 400; color: #666;">(full size)</span></th>
                <th style="width: 37.5%;">Card Fallback <span style="font-weight: 400; color: #666;">(medium size)</span></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $categories as $cat ) {
                $hero_id = isset( $hero_images[ $cat->term_id ] ) ? absint( $hero_images[ $cat->term_id ] ) : 0;
                $card_id = isset( $card_images[ $cat->term_id ] ) ? absint( $card_images[ $cat->term_id ] ) : 0;

                $hero_src = $hero_id ? wp_get_attachment_image_url( $hero_id, 'medium' ) : '';
                $card_src = $card_id ? wp_get_attachment_image_url( $card_id, 'medium' ) : '';
                ?>
                <tr>
                    <td style="vertical-align: top; padding-top: 20px;">
                        <strong><?php echo esc_html( $cat->name ); ?></strong>
                        <span style="display: block; color: #999; font-size: 12px;"><?php echo absint( $cat->count ); ?> posts</span>
                    </td>

                    <!-- Hero Image -->
                    <td>
                        <div class="ng-image-field" data-target="hero" data-term="<?php echo absint( $cat->term_id ); ?>">
                            <div class="ng-image-preview" style="margin-bottom: 8px;">
                                <img src="<?php echo esc_url( $hero_src ); ?>" style="max-width: 200px; height: auto; display: <?php echo $hero_src ? 'block' : 'none'; ?>; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                            <input type="hidden"
                                name="ng_andersen_category_hero_images[<?php echo absint( $cat->term_id ); ?>]"
                                value="<?php echo $hero_id ? absint( $hero_id ) : ''; ?>"
                                class="ng-image-id">
                            <button type="button" class="button ng-image-select">Select Image</button>
                            <button type="button" class="button ng-image-remove" style="<?php echo $hero_id ? '' : 'display:none;'; ?>">Remove</button>
                        </div>
                    </td>

                    <!-- Card Fallback -->
                    <td>
                        <div class="ng-image-field" data-target="card" data-term="<?php echo absint( $cat->term_id ); ?>">
                            <div class="ng-image-preview" style="margin-bottom: 8px;">
                                <img src="<?php echo esc_url( $card_src ); ?>" style="max-width: 200px; height: auto; display: <?php echo $card_src ? 'block' : 'none'; ?>; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                            <input type="hidden"
                                name="ng_andersen_category_card_images[<?php echo absint( $cat->term_id ); ?>]"
                                value="<?php echo $card_id ? absint( $card_id ) : ''; ?>"
                                class="ng-image-id">
                            <button type="button" class="button ng-image-select">Select Image</button>
                            <button type="button" class="button ng-image-remove" style="<?php echo $card_id ? '' : 'display:none;'; ?>">Remove</button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
    (function($){
        $(document).on('click', '.ng-image-select', function(e){
            e.preventDefault();
            var $field = $(this).closest('.ng-image-field');
            var frame = wp.media({
                title: 'Select Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                // Prefer medium size for preview, fall back to full
                var previewUrl = ( attachment.sizes && attachment.sizes.medium )
                    ? attachment.sizes.medium.url
                    : attachment.url;
                $field.find('.ng-image-id').val( attachment.id );
                $field.find('.ng-image-preview img').attr('src', previewUrl).show();
                $field.find('.ng-image-remove').show();
            });
            frame.open();
        });

        $(document).on('click', '.ng-image-remove', function(e){
            e.preventDefault();
            var $field = $(this).closest('.ng-image-field');
            $field.find('.ng-image-id').val('');
            $field.find('.ng-image-preview img').attr('src', '').hide();
            $(this).hide();
        });
    })(jQuery);
    </script>
    <?php
}

/**
 * Get the hero image URL for a given post, based on its first category.
 * Always used on the single post hero (overrides featured image).
 * Falls back to landing.jpg when no category image is defined.
 *
 * @param int $post_id
 * @return string Image URL
 */
function ng_andersen_get_post_hero_image( $post_id = null ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $fallback = get_template_directory_uri() . '/assets/img/landing.jpg';

    $cats = get_the_category( $post_id );
    if ( empty( $cats ) ) {
        return $fallback;
    }

    // First assigned category wins
    $primary_cat = $cats[0]->term_id;

    $hero_images = get_option( 'ng_andersen_category_hero_images', array() );
    if ( is_array( $hero_images ) && ! empty( $hero_images[ $primary_cat ] ) ) {
        $url = wp_get_attachment_image_url( absint( $hero_images[ $primary_cat ] ), 'full' );
        if ( $url ) {
            return $url;
        }
    }

    return $fallback;
}

/**
 * Get the card image URL for a given post.
 * Uses the post's own featured image first; if none, falls back to the
 * category card image; finally to block1.jpg.
 *
 * @param int    $post_id  Post ID (defaults to current post).
 * @param string $size     WordPress image size: 'medium', 'large', 'full', etc. Default 'medium'.
 * @return string Image URL
 */
function ng_andersen_get_post_card_image( $post_id = null, $size = 'medium' ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $fallback = get_template_directory_uri() . '/assets/img/block1.jpg';

    // Featured image first
    if ( has_post_thumbnail( $post_id ) ) {
        $url = get_the_post_thumbnail_url( $post_id, $size );
        if ( $url ) {
            return $url;
        }
    }

    // Category card fallback
    $cats = get_the_category( $post_id );
    if ( ! empty( $cats ) ) {
        $primary_cat = $cats[0]->term_id;
        $card_images = get_option( 'ng_andersen_category_card_images', array() );
        if ( is_array( $card_images ) && ! empty( $card_images[ $primary_cat ] ) ) {
            $url = wp_get_attachment_image_url( absint( $card_images[ $primary_cat ] ), $size );
            if ( $url ) {
                return $url;
            }
        }
    }

    return $fallback;
}