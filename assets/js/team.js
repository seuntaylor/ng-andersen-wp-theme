/**
 * Team JavaScript
 *
 * Handles:
 * - Team Member Search with filters and pagination
 */

(function($) {
    'use strict';

    // ============================================================
    // TEAM MEMBER SEARCH
    // ============================================================

    const TeamSearch = {
        debounceTimer: null,
        debounceDelay: 250,

        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            // Name search — debounced
            $(document).on('keyup', '#team-search-name', function() {
                TeamSearch.debounceSearch();
            });

            // Location dropdown — immediate
            $(document).on('change', '#team-search-location', function() {
                TeamSearch.performSearch(1);
            });

            // Position (All Titles) dropdown — immediate
            $(document).on('change', '#team-search-position', function() {
                TeamSearch.performSearch(1);
            });

            // Form submit — prevent default and perform search
            $(document).on('submit', '#team-search-form', function(e) {
                e.preventDefault();
                TeamSearch.performSearch(1);
            });

            // Pagination links
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                TeamSearch.performSearch(page);
            });

            // Reset button
            $(document).on('click', '#team-search-reset', function(e) {
                e.preventDefault();
                TeamSearch.resetSearch();
            });
        },

        debounceSearch: function() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(function() {
                TeamSearch.performSearch(1);
            }, this.debounceDelay);
        },

        performSearch: function(page = 1) {
            const name     = $('#team-search-name').val();
            const position = $('#team-search-position').val();
            const location = $('#team-search-location').val();

            // Get location name for summary
            let locationName = 'All Locations';
            if (location) {
                locationName = $('#team-search-location option:selected').text();
            }

            // Update results summary
            const summaryParts = [];
            summaryParts.push(locationName);
            summaryParts.push(position ? position : 'All Positions');
            $('#team-results-summary').html('<p><strong>Search Results:</strong> ' + summaryParts.join(' / ') + '</p>');

            // Show loading state
            $('#team-results-container').css('opacity', '0.6');

            $.ajax({
                url: window.teamSearchData.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'ng_andersen_search_team_members',
                    nonce:  window.teamSearchData.nonce,
                    name:     name,
                    position: position,
                    location: location,
                    paged:    page,
                },
                success: function(response) {
                    if (response.success) {
                        $('#team-results-container').html(response.data.html);
                        $('#team-results-container').css('opacity', '1');
                    }
                },
                error: function() {
                    $('#team-results-container').css('opacity', '1');
                    console.error('Team search failed');
                }
            });
        },

        resetSearch: function() {
            $('#team-search-name').val('');
            $('#team-search-position').val('');
            $('#team-search-location').val('');
            this.performSearch(1);
        }
    };

    $(document).ready(function() {
        TeamSearch.init();
    });

})(jQuery);