/**
 * Publications JavaScript
 *
 * Handles two template variants:
 *
 * 1. Publications (Accordion) — page-publications.php
 *    - Accordion sidebar category filter
 *    - AJAX pagination
 *    - Browser history state
 *
 * 2. Publications (Dropdown) — page-publication_dropdown.php
 *    - Search input with 300ms debounce
 *    - Category dropdown filter
 *    - AJAX pagination
 *    - Results summary update
 *    - Browser history state
 */

(function($) {
    'use strict';

    // ============================================================
    // ACCORDION VARIANT — page-publications.php
    // ============================================================

    const Publications = {

        init: function() {
            if ( ! $('#publications-filter-nav').length ) return;

            this.bindEvents();

            window.addEventListener('popstate', function(e) {
                if (e.state) {
                    Publications.fetchPosts( e.state.cat, e.state.page, false );
                    Publications.setActiveCategory( e.state.cat );
                }
            });
        },

        bindEvents: function() {
            // Top-level "Publications" link — reset filter + toggle accordion
            $(document).on('click', '#publications-filter-nav > ul > li > a', function(e) {
                e.preventDefault();
                const $topItem = $(this).parent();
                $topItem.toggleClass('is-active');
                $topItem.find('.lvl-2').toggleClass('is-active');
                $(this).toggleClass('accordion-open');
                Publications.setActiveCategory( 0 );
                Publications.fetchPosts( 0, 1, true );
            });

            // Category clicks inside lvl-2
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

                        if (pushState) {
                            try {
                                const state = { cat: cat, page: page };
                                let url = window.publicationsData.pageUrl;
                                if ( cat > 0 ) url += '?publication_cat=' + cat;
                                window.history.pushState( state, '', url );
                            } catch(e) {
                                console.warn('pushState failed:', e);
                            }
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


    // ============================================================
    // DROPDOWN VARIANT — page-publication_dropdown.php
    // Category dropdown is the only filter
    // ============================================================

    const PublicationsDropdown = {
        searchTimer: null,

        init: function() {
            const catSelect = document.getElementById('publication-category');
            if ( ! catSelect ) return;

            // Category change — fetch immediately
            catSelect.addEventListener('change', function() {
                PublicationsDropdown.fetchPosts( 1 );
            });

            // Search input — debounced keyup (300ms)
            const searchInput = document.getElementById('publication-search');
            if ( searchInput ) {
                searchInput.addEventListener('keyup', function() {
                    clearTimeout( PublicationsDropdown.searchTimer );
                    PublicationsDropdown.searchTimer = setTimeout(function() {
                        PublicationsDropdown.fetchPosts( 1 );
                    }, 300);
                });
            }

            // Form submit (magnifying glass / Enter)
            $(document).on('submit', '#publications-filter-form', function(e) {
                e.preventDefault();
                PublicationsDropdown.fetchPosts( 1 );
            });

            // Pagination clicks
            $(document).on('click', '#publications-grid .pagination a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                PublicationsDropdown.fetchPosts( page );
            });
        },

        fetchPosts: function( page ) {
            const cat    = $('#publication-category').val();
            const search = $('#publication-search').val() || '';

            // Update results summary
            let catLabel = 'All Categories';
            if ( cat && cat !== '0' ) {
                catLabel = $('#publication-category option:selected').text().replace(/\s*\(\d+\)\s*$/, '').trim();
            }
            let summary = '<strong>Showing:</strong> ' + catLabel;
            if ( search ) {
                summary += ' &mdash; &ldquo;' + $('<span>').text(search).html() + '&rdquo;';
            }
            $('#publications-results-summary').html('<p>' + summary + '</p>');

            // Loading state
            $('#publications-grid').css('opacity', '0.5');

            $.ajax({
                url: window.publicationsData.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'ng_andersen_get_publications',
                    nonce:  window.publicationsData.nonce,
                    cat:    cat,
                    search: search,
                    page:   page,
                },
                success: function(response) {
                    if (response.success) {
                        $('#publications-grid').html( response.data.html );
                        $('#publications-grid').css('opacity', '1');
                    }
                },
                error: function() {
                    $('#publications-grid').css('opacity', '1');
                    console.error('Publications fetch failed');
                }
            });
        }
    };


    // ============================================================
    // INIT
    // ============================================================

    $(document).ready(function() {
        Publications.init();
        PublicationsDropdown.init();
    });

})(jQuery);