<?php
/**
 * Template Name: Global Presence
 *
 * Static page template for the Global Presence page.
 * Select this template in the WordPress editor under Page Attributes.
 * No page content from the editor is used — all content is hardcoded
 * in the template parts below.
 *
 * Sections:
 * - Page hero with breadcrumb (template-parts/page/page-hero.php)
 * - Intro text and v2 carousel (template-parts/page/global-presence-content.php)
 *
 * @package ng-andersen
 */

get_header();

set_query_var( 'hero_image', 'slider-inner-reach.jpg' );
set_query_var( 'hero_title', 'Global Presence' );
set_query_var( 'hero_intro', 'Andersen Global<sup>&reg;</sup> was established in 2013 as the international entity surrounding the development of a seamless professional services model providing best in class tax, legal, and valuation services around the world.' );
set_query_var( 'breadcrumbs', array(
    array( 'label' => 'Global Presence' ),
) );

get_template_part( 'template-parts/page/page-hero' );
get_template_part( 'template-parts/page/global-presence-content' );

get_footer();