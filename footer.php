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
                                <ul class="footer-social">
                                    <li class="social-link linkedin">
                                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                                    </li>
                                    <li class="social-link twitter">
                                        <a href="#" aria-label="X (Twitter)"><i class="fa-brands fa-square-x-twitter"></i></a>
                                    </li>
                                    <li class="social-link facebook">
                                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-square-facebook"></i></a>
                                    </li>
                                </ul>
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
                            <p class="footer-copyright">&copy;Andersen Tax LLC and [INSERT LEGAL ENTITY NAME]. [INSERT LEGAL ENTITY NAME] is the [COUNTRY NAME] member firm of Andersen Global, a Swiss verein comprised of legally separate, independent member firms located throughout the world providing services under their own name or the brand "Andersen," "Andersen Tax," or "Andersen Tax &amp; Legal," or "Andersen Legal." Andersen Global does not provide any services and has no responsibility for any actions of the member firms, and the member firms have no responsibility for any actions of Andersen Global. Your use of this website is subject to the terms and conditions governing it. Please read these terms and conditions before using the website.</p>

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