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
} );

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
        </nav>

        <!-- Tab Content -->
        <form method="post" action="options.php">
            <?php settings_fields( 'ng-andersen-settings' ); ?>

            <!-- OFFICE LOCATIONS TAB -->
            <?php if ( $active_tab === 'offices' ) { ?>
                <div class="tab-content">
                    <h2>Office Locations</h2>
                    <p>Configure office information displayed on the Contact page. You can add up to 3 offices.</p>

                    <?php
                    for ( $i = 1; $i <= 3; $i++ ) {
                        ng_andersen_render_office_section( $i );
                    }
                    ?>
                </div>
            <?php } ?>

            <!-- SOCIAL MEDIA TAB -->
            <?php if ( $active_tab === 'social' ) { ?>
                <div class="tab-content">
                    <h2>Social Media Links</h2>
                    <p>Add links to your social media profiles. Leave blank to hide.</p>

                    <?php ng_andersen_render_social_media_section(); ?>
                </div>
            <?php } ?>

            <!-- TRACKING & ANALYTICS TAB -->
            <?php if ( $active_tab === 'analytics' ) { ?>
                <div class="tab-content">
                    <h2>Tracking & Analytics</h2>
                    <p>Configure analytics and tracking services.</p>

                    <?php ng_andersen_render_analytics_section(); ?>
                </div>
            <?php } ?>

            <!-- CAPTCHA API KEYS TAB -->
            <?php if ( $active_tab === 'captcha' ) { ?>
                <div class="tab-content">
                    <h2>CAPTCHA API Keys</h2>
                    <p>Configure Cloudflare Turnstile API keys for form protection.</p>

                    <?php ng_andersen_render_captcha_section(); ?>
                </div>
            <?php } ?>

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
                    <p class="description">Full office address. Use line breaks for multiple lines.</p>
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
                    placeholder="Full URL to your Facebook page."
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
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
                    placeholder="Full URL to your Twitter/X profile."
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
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
                    placeholder="Full URL to your LinkedIn company page."
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
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
                    placeholder="Full URL to your Instagram profile."
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
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
                    placeholder="Full URL to your YouTube channel."
                    style="width: 100%; max-width: 400px; padding: 8px;"
                >
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