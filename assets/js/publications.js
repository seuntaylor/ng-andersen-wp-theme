/**
 * Publications JavaScript
 *
 * Handles:
 * - AJAX category filtering
 * - AJAX pagination
 * - Browser history state management
 */

(function($) {
    'use strict';

    const Publications = {

        init: function() {
            this.bindEvents();

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                if (e.state) {
                    Publications.fetchPosts( e.state.cat, e.state.page, false );
                    Publications.setActiveCategory( e.state.cat );
                }
            });
        },

        bindEvents: function() {
            // Top-level "Publications" link — reset filter to show all posts
            $(document).on('click', '#publications-filter-nav > ul > li > a', function(e) {
                e.preventDefault();
                const $topItem = $(this).parent();

                // Toggle accordion open/close
                $topItem.toggleClass('is-active');
                $topItem.find('.lvl-2').toggleClass('is-active');

                // Rotate triangle indicator
                $(this).toggleClass('accordion-open');

                // Reset filter to all posts
                Publications.setActiveCategory( 0 );
                Publications.fetchPosts( 0, 1, true );
            });

            // Category filter clicks — inside the lvl-2 submenu
            $(document).on('click', '#publications-filter-nav .lvl-2 a', function(e) {
                e.preventDefault();
                const cat = $(this).data('cat');
                Publications.setActiveCategory( cat );
                Publications.fetchPosts( cat, 1, true );
            });

            // Pagination clicks
            $(document).on('click', '#publications-pagination a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                const cat  = Publications.getCurrentCat();
                Publications.fetchPosts( cat, page, true );
            });
        },

        getCurrentCat: function() {
            const $active = $('#publications-filter-nav .lvl-2 .is-active a');
            return $active.length ? parseInt( $active.data('cat') ) || 0 : 0;
        },

        setActiveCategory: function( cat ) {
            $('#publications-filter-nav .lvl-2 li').removeClass('is-active');
            if ( cat > 0 ) {
                $('#publications-filter-nav .lvl-2 a[data-cat="' + cat + '"]').parent().addClass('is-active');
            }
        },

        fetchPosts: function( cat, page, pushState ) {
            // Show loading state
            $('#publications-grid').css('opacity', '0.5');

            $.ajax({
                url:      window.publicationsData.ajaxUrl,
                type:     'POST',
                dataType: 'json',
                data: {
                    action: 'ng_andersen_get_publications',
                    nonce:  window.publicationsData.nonce,
                    cat:    cat,
                    page:   page,
                },
                success: function(response) {
                    if (response.success) {
                        $('#publications-grid').html( response.data.html );
                        $('#publications-grid').css('opacity', '1');

                        // Scroll to top of grid
                        $('html, body').animate({
                            scrollTop: $('#publications-grid').offset().top - 100
                        }, 300);

                        // Update browser URL without page reload
                        if (pushState) {
                            const state = { cat: cat, page: page };
                            let url = window.publicationsData.pageUrl;
                            if (cat > 0) {
                                url += '?publication_cat=' + cat;
                            }
                            window.history.pushState(state, '', url);
                        }
                    }
                },
                error: function() {
                    $('#publications-grid').css('opacity', '1');
                    console.error('Publications fetch failed');
                }
            });
        }
    };

    $(document).ready(function() {
        Publications.init();
    });

})(jQuery);