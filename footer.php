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

                            <!-- Footer Widget Column 1 -->
                            <div class="cell large-3 medium-4 small-12">
                                <?php dynamic_sidebar( 'footer-column-1' ); ?>
                            </div>

                            <!-- Footer Widget Column 2 -->
                            <div class="cell large-3 medium-4 small-12">
                                <?php dynamic_sidebar( 'footer-column-2' ); ?>
                            </div>

                            <!-- Footer Widget Column 3 -->
                            <div class="cell large-3 medium-4 small-12">
                                <?php dynamic_sidebar( 'footer-column-3' ); ?>
                            </div>

                        </div>
                        <!-- / .grid-x -->

                        <!-- Footer Bottom Bar -->
                        <div class="footer-bottom">
                            <p class="footer-copyright">&copy;Andersen Tax LLC and Andersen Tax LP. Andersen Tax LP is the Nigerian member firm of Andersen Global, a Swiss verein comprised of legally separate, independent member firms located throughout the world providing services under their own name or the brand "Andersen," "Andersen Tax," or "Andersen Tax & Legal," or "Andersen Legal." Andersen Global does not provide any services and has no responsibility for any actions of the member firms, and the member firms have no responsibility for any actions of Andersen Global. Your use of this website is subject to the terms and conditions governing it. Please read these terms and conditions before using the website.</p>

                            <div class="footer-utility-menu">
                                <ul>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                </ul>
                            </div>
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