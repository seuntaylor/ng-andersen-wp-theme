<?php
/**
 * Template Name: Locations
 *
 * Static page template for the Locations page.
 * Select this template in the WordPress editor under Page Attributes.
 * No page content from the editor is used — all content is hardcoded
 * in the template part below.
 *
 * The map scripts and stylesheets are enqueued conditionally via
 * functions.php only when this template is active, not globally.
 *
 * Sections:
 * - Interactive world map with country filter and firm type toggles
 *   (template-parts/page/locations-map.php)
 *
 * @package ng-andersen
 */

get_header();

get_template_part( 'template-parts/page/locations-map' );

get_footer();