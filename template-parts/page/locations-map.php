<?php
/**
 * Template Part: Locations Map
 *
 * Full interactive world map section powered by amCharts and
 * external scripts from 15fdb71145.nxcli.io. Includes country
 * filter dropdown and firm type toggle switches.
 *
 * All scripts and stylesheets for this section are enqueued
 * conditionally via functions.php only on the Locations page
 * template, not globally. No inline script tags in this file.
 *
 * Permanently hardcoded. Any changes must be made directly
 * in this template file.
 *
 * @package ng-andersen
 */
?>
<div id="map-container">
 
    <div class="breadcrumbs-section">
        <div class="container">
            <div class="breadcrumbs">
                <span class="crumb home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                <span class="crumb current">Locations</span>
            </div>
        </div>
    </div>
 
    <div class="map-filter-form">
        <label style="color:transparent" id="map-filter">Country Location Map
            <form name="map-filter" id="map-filter-form">
                <h3>Select a Country</h3>
                <p>This will display all member firms and collaborating firms of Andersen Global<sup><span style="font-size:100%;">&reg;</span></sup> and Andersen Consulting in the selected country.</p>
                <p>
                    <select name="country" id="country_select" aria-label="Select a Country">
                        <option value="">Choose</option>
                    </select>
                    <input type="submit" name="submit" aria-label="Submit form to filter locations to selected country" class="hide-submit-button">
                </p>
 
                <p style="margin-bottom:0; padding-bottom:0;"><strong>Please click pins below to hide or show locations</strong></p>
 
                <div id="maplegend">
 
                    <div class="legend memberfirms">
                        <br>
                        <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" id="redFlags" name="redFlags" checked="checked" onChange="javascript:changeMapPoints()">
                                <span class="slider round map-toggle firms"></span>
                            </label>
                        </div>
                        <div class="firm-type-container">
                            <span>Member Firms of Andersen Global</span>
                        </div>
                    </div>
 
                    <div class="legend collabfirms">
                        <br>
                        <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" id="grayFlags" name="grayFlags" checked="checked" onChange="javascript:changeMapPoints()">
                                <span class="slider round map-toggle collaborating"></span>
                            </label>
                        </div>
                        <div class="firm-type-container">
                            <span>Collaborating Firms of Andersen Global</span>
                        </div>
                    </div>
 
                    <div class="legend consultfirms">
                        <br>
                        <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" id="blueFlags" name="blueFlags" checked="checked" onChange="javascript:changeMapPoints()">
                                <span class="slider round map-toggle consulting"></span>
                            </label>
                        </div>
                        <div class="firm-type-container">
                            <span>Andersen Consulting</span>
                        </div>
                    </div>
 
                    <div class="legend consultcolabfirms">
                        <br>
                        <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" id="greenFlags" name="greenFlags" checked="checked" onChange="javascript:changeMapPoints()">
                                <span class="slider round map-toggle consultingcollab"></span>
                            </label>
                        </div>
                        <div class="firm-type-container">
                            <span>Andersen Consulting Collaborating Firms</span>
                        </div>
                    </div>
 
                </div>
 
            </form>
        </label>
    </div>
 
    <div id="mapdiv"></div>
 
    <form name="formx">
        <input type="hidden" id="start_country" value="">
    </form>
 
    <div id="individual_offices"></div>
 
</div>
 
<script type="text/javascript">
/**
 * Initialise map dropdown filter and individual offices list.
 * These external scripts load in footer but don't auto-initialise,
 * so we need to manually hook them up to DOM events.
 */
jQuery(document).ready(function() {
    
    // Wait a bit for all map scripts to fully execute
    setTimeout(function() {
        
        // Get the country select element
        var $countrySelect = jQuery('#country_select');
        
        if ($countrySelect.length) {
            
            // If selectArea function exists (from map-dropdown-filter.js),
            // bind it to the select change event
            if (typeof window.selectArea === 'function') {
                $countrySelect.on('change', function() {
                    window.selectArea(this);
                });
            }
            
            // Try to trigger map initialisation if a function exists
            if (typeof window.initMap === 'function') {
                window.initMap();
            }
            
            // If there's an initialisation function from indiv_offices scripts
            if (typeof window.getOffices === 'function') {
                window.getOffices();
            }
            
            // Some map scripts use onchange handlers, try firing the change event
            // to trigger any handlers that were set up
            var event = new Event('change', { bubbles: true });
            $countrySelect[0].dispatchEvent(event);
        }
        
    }, 500); // 500ms delay to ensure all scripts are ready
    
});
</script>