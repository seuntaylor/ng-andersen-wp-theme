<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://andersen.com/favicon.ico">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

        <!-- Mobile Off-Canvas Panel (right side) -->
        <div class="off-canvas position-right" id="offCanvas" data-off-canvas data-position="right">

            <button class="close-button" aria-label="Close menu" type="button" data-close>
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="mobile-menu">
                <ul class="vertical menu" data-accordion-menu>
                    <li class="item-1">
                        <?php
                        wp_nav_menu( array(
                            'theme_location'  => 'primary',
                            'container'       => false,
                            'items_wrap'      => '%3$s',
                            'depth'           => 2,
                            'fallback_cb'     => false,
                        ) );
                        ?>
                    </li>
                </ul>

                <ul class="secondary-nav">
                    <?php
                    wp_nav_menu( array(
                        'theme_location'  => 'secondary',
                        'container'       => false,
                        'items_wrap'      => '%3$s',
                        'depth'           => 1,
                        'fallback_cb'     => false,
                    ) );
                    ?>
                </ul>
            </div>

        </div>
        <!-- / Mobile Off-Canvas Panel -->

        <div class="off-canvas-content" data-off-canvas-content>

            <!-- Site Header -->
            <header class="navbar" data-margin-top="0" data-sticky data-off-canvas-sticky>

                <!-- Top Navigation Bar -->
                <div class="top-nav-bar">
                    <div class="grid-x align-justify align-middle large-collapse">

                        <div class="top-header-link">
                            <div class="global-link cell flex-child-auto">
                                <a href="https://global.andersen.com" target="_blank">Andersen Global</a>
                            </div>
                            <div class="cell flex-child-auto">
                                <a href="https://global.andersen.com/consulting" target="_blank">Andersen Consulting</a>
                            </div>
                        </div>

                        <nav class="top-nav cell grid-x align-middle">
                            <?php
                            wp_nav_menu( array(
                                'theme_location'  => 'language',
                                'container'       => false,
                                'menu_class'      => 'language-nav',
                                'items_wrap'      => '<ul class="language-nav">%3$s</ul>',
                                'depth'           => 1,
                                'fallback_cb'     => false,
                            ) );
                            ?>

                            <p class="location-label">Worldwide Locations:</p>

                            <ul class="locations dropdown menu" data-dropdown-menu>
                                <li>
                                    <a href="#" class="selected">
                                        <span class="inner">United States</span>
                                    </a>
                                    <!-- Populated dynamically by parse_countries() via andersen-countries script -->
                                    <ul class="menu"></ul>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
                <!-- / Top Navigation Bar -->

                <!-- Main Bar -->
                <div class="main-bar">
                    <div class="grid-x align-justify align-middle large-collapse">

                        <div class="logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo@2x.png' ); ?>"
                                    alt="<?php bloginfo( 'name' ); ?>"
                                    width="260"
                                    height="78"
                                >
                            </a>
                        </div>

                        <a href="javascript:;" class="hamburger-menu" data-toggle="offCanvas">
                            <span class="menu-button">
                                <span class="fa fa-bars" aria-hidden="true"></span>
                                <span class="fa fa-times" aria-hidden="true"></span>
                            </span>
                        </a>

                        <nav class="main-nav">
                            <div class="grid-x large-collapse">

                                <div class="search cell">
                                    <?php get_search_form(); ?>
                                </div>

                                <div class="cell secondary-nav">
                                    <?php
                                    wp_nav_menu( array(
                                        'theme_location'  => 'secondary',
                                        'container'       => false,
                                        'menu_class'      => 'menu',
                                        'items_wrap'      => '<ul class="menu">%3$s</ul>',
                                        'depth'           => 1,
                                        'fallback_cb'     => false,
                                    ) );
                                    ?>
                                </div>

                                <div class="cell primary-nav small-12">
                                    <?php
                                    wp_nav_menu( array(
                                        'theme_location'  => 'primary',
                                        'container'       => false,
                                        'menu_class'      => 'lvl-1 dropdown menu',
                                        'items_wrap'      => '<ul class="lvl-1 dropdown menu" data-dropdown-menu>%3$s</ul>',
                                        'depth'           => 2,
                                        'fallback_cb'     => false,
                                    ) );
                                    ?>
                                </div>

                            </div>
                        </nav>

                    </div>
                </div>
                <!-- / Main Bar -->

            </header>
            <!-- / Site Header -->

            <div class="main-content">