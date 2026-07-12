</div>
            <!-- / .main-content -->

            <!-- Site Footer -->
            <footer class="footer" id="footer">
                <div class="container">
                    <div class="footer-columns">

                        <div class="footer-door">
                            <img
                                src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/Door-White.png' ); ?>"
                                alt="door"
                            >
                        </div>

                        <div class="grid-x grid-padding-x">

                            <!-- Logo and Social -->
                            <div class="cell large-3 medium-12 small-12">
                                <div class="footer-logo">
                                    <img
                                        src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/footer-logo.png' ); ?>"
                                        width="278"
                                        height="68"
                                        alt="<?php bloginfo( 'name' ); ?>"
                                    >
                                </div>
                                <?php
                                $social_links = ng_andersen_get_social_links();

                                // Define icons and labels in display order
                                $social_icons = array(
                                    'linkedin'  => array(
                                        'class' => 'fa-brands fa-linkedin',
                                        'label' => 'LinkedIn',
                                    ),
                                    'twitter'   => array(
                                        'class' => 'fa-brands fa-square-x-twitter',
                                        'label' => 'X (Twitter)',
                                    ),
                                    'facebook'  => array(
                                        'class' => 'fa-brands fa-square-facebook',
                                        'label' => 'Facebook',
                                    ),
                                    'instagram' => array(
                                        'class' => 'fa-brands fa-square-instagram',
                                        'label' => 'Instagram',
                                    ),
                                    'youtube'   => array(
                                        'class' => 'fa-brands fa-square-youtube',
                                        'label' => 'YouTube',
                                    ),
                                );

                                // Only show the social list if at least one URL exists
                                $has_socials = false;
                                foreach ( $social_icons as $key => $icon ) {
                                    if ( ! empty( $social_links[ $key ] ) ) {
                                        $has_socials = true;
                                        break;
                                    }
                                }

                                if ( $has_socials ) {
                                    ?>
                                    <ul class="footer-social">
                                        <?php
                                        foreach ( $social_icons as $key => $icon ) {
                                            if ( ! empty( $social_links[ $key ] ) ) {
                                                ?>
                                                <li class="social-link <?php echo esc_attr( $key ); ?>">
                                                    <a href="<?php echo esc_url( $social_links[ $key ] ); ?>" aria-label="<?php echo esc_attr( $icon['label'] ); ?>" target="_blank" rel="noopener noreferrer">
                                                        <i class="<?php echo esc_attr( $icon['class'] ); ?>"></i>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                }
                                ?>
                            </div>

                            <!-- Footer Menu Column 1 (two sub-columns) -->
                            <?php ng_andersen_footer_menu_column( 'footer-col-1', true ); ?>

                            <!-- Footer Menu Column 2 (two sub-columns) -->
                            <?php ng_andersen_footer_menu_column( 'footer-col-2', true ); ?>

                            <!-- Footer Menu Column 3 (single column) -->
                            <?php ng_andersen_footer_menu_column( 'footer-col-3', false ); ?>

                        </div>
                        <!-- / .grid-x -->

                        <!-- Footer Bottom Bar -->
                        <div class="footer-bottom">
                            <?php
                            $ng_legal_fallback = "\u{00A9}Andersen Tax LLC and Andersen Nigeria Limited. Andersen Nigeria Limited is the Nigerian member firm of Andersen Global, a Swiss verein comprised of legally separate, independent member firms located throughout the world providing services under their own name or the brand \u{201C}Andersen,\u{201D} \u{201C}Andersen Tax,\u{201D} or \u{201C}Andersen Tax & Legal,\u{201D} or \u{201C}Andersen Legal.\u{201D} Andersen Global does not provide any services and has no responsibility for any actions of the member firms, and the member firms have no responsibility for any actions of Andersen Global. Your use of this website is subject to the terms and conditions governing it. Please read these terms and conditions before using the website.";
                            $ng_legal_text = get_option( 'ng_andersen_home_legal_text', $ng_legal_fallback );
                            ?>
                            <p class="footer-copyright"><?php echo esc_html( $ng_legal_text ); ?></p>

                            <?php
                            if ( has_nav_menu( 'footer-utility' ) ) {
                                ?>
                                <div class="footer-utility-menu">
                                    <?php
                                    wp_nav_menu( array(
                                        'theme_location' => 'footer-utility',
                                        'container'      => false,
                                        'menu_class'     => 'footer-utility-list',
                                        'depth'          => 1,
                                        'fallback_cb'    => false,
                                    ) );
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- / Footer Bottom Bar -->

                    </div>
                    <!-- / .footer-columns -->
                </div>
                <!-- / .container -->
            </footer>
            <!-- / Site Footer -->

        </div>
        <!-- / .off-canvas-content -->

    </div>
    <!-- / .off-canvas-wrapper-inner -->
</div>
<!-- / .off-canvas-wrapper -->

<?php wp_footer(); ?>

</body>
</html>