<?php
/**
 * Homepage Template
 *
 * Used when a static front page is set in Settings > Reading.
 * Each section is a separate template part in template-parts/home/
 * to keep future development isolated per section.
 *
 * @package ng-andersen
 */

get_header();
?>

<?php get_template_part( 'template-parts/home/carousel' ); ?>
<?php get_template_part( 'template-parts/home/cta1' ); ?>
<?php get_template_part( 'template-parts/home/core-values' ); ?>
<?php get_template_part( 'template-parts/home/blocks2' ); ?>
<?php get_template_part( 'template-parts/home/callout' ); ?>
<?php get_template_part( 'template-parts/home/services' ); ?>
<?php get_template_part( 'template-parts/home/blocks8' ); ?>
<?php get_template_part( 'template-parts/home/blocks1' ); ?>

<?php get_footer(); ?>