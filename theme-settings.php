<?php
/**
 * Theme Settings Page
 *
 * Custom admin settings page for site-wide configuration:
 * - Office locations (up to 3)
 * - API keys (Turnstile, GA, etc.)
 * - Social media links
 * - Dashboard customization
 * - And more
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook into admin_menu to add the menu
add_action( 'admin_menu', function() {
    add_menu_page(
        'NG Andersen Settings',
        'NG Andersen',
        'manage_options',
        'ng-andersen-settings',
        function() {
            ng_andersen_render_settings_page();
        },
        'dashicons-cog',
        58
    );
} );

// Hook into admin_init to register settings
add_action( 'admin_init', function() {
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
} );

/**
 * Render the settings page
 */
function ng_andersen_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized' );
    }
    ?>

    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields( 'ng-andersen-settings' ); ?>

            <!-- Office Locations Section -->
            <h2>Office Locations</h2>
            <p>Configure office information displayed on the Contact page. You can add up to 3 offices.</p>

            <?php
            for ( $i = 1; $i <= 3; $i++ ) {
                ng_andersen_render_office_section( $i );
            }
            ?>

            <!-- Future sections can be added here -->
            <!-- API Keys Section -->
            <!-- Social Media Links Section -->
            <!-- Dashboard Customization Section -->
            <!-- etc. -->

            <?php submit_button(); ?>
        </form>
    </div>
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