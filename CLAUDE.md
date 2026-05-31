# CLAUDE.md - NG Andersen WordPress Theme

This file provides context and guidelines for AI assistants working on the ng-andersen WordPress theme project.

## Project Overview

This is a custom WordPress theme called `ng-andersen` being developed for Andersen in Nigeria. It is a conversion of a static HTML/CSS/JS site (built with ZURB Foundation, Gulp, and Panini) into a fully-featured WordPress theme.

## Tech Stack

- **WordPress** (PHP-based CMS)
- **ZURB Foundation 6** (CSS framework - uses `cell` not `column`)
- **Font Awesome** (icons - uses `fa-brands` for social media)
- **Contact Form 7 (CF7)** (contact form plugin)
- **jQuery** (for AJAX and DOM manipulation)
- **Google Fonts**: Roboto Condensed, Roboto, Work Sans

## Development Workflow

- **Local Development**: Local by Flywheel at `/Users/seuntaylor/Local Sites/andersen-in-nigeria/app/public/wp-content/themes/ng-andersen`
- **UAT**: cPanel Git Version Control pulls from GitHub `uat` branch
- **Source Control**: GitHub with `developer` and `uat` branches
- **Deployment Flow**: `developer` → merge into `uat` → push to GitHub → cPanel pulls `uat`
- **IDE**: VS Code with Git integration

## File Structure

```
ng-andersen/
├── assets/
│   ├── css/
│   │   ├── app.css              (compiled SCSS - DO NOT EDIT DIRECTLY)
│   │   ├── custom.css           (WordPress overrides - SAFE TO EDIT)
│   │   └── admin-color-scheme.css (Admin dashboard styling)
│   ├── img/
│   └── js/
│       ├── app.js               (compiled JS)
│       ├── team.js              (team search, filters, pagination)
│       └── publications.js      (publications AJAX filtering and pagination)
├── template-parts/
│   ├── home/                    (homepage sections)
│   └── page/                    (page-specific parts)
├── templates/
│   ├── page-team.php
│   ├── page-locations.php
│   ├── page-global-presence.php
│   └── template-contact.php     (Contact page template)
├── functions.php                (main theme functions)
├── theme-settings.php           (custom admin settings page)
├── header.php
├── footer.php
├── front-page.php
├── index.php
├── page.php
├── single-team_member.php       (CPT single template)
├── searchform.php
├── style.css
└── CLAUDE.md
```

## CSS Architecture - CRITICAL

The CSS load order is intentional and must be preserved:

1. `google-fonts` (Google Fonts CDN)
2. `theme-styles` (app.css - compiled SCSS)
3. `theme-custom` (custom.css - WordPress overrides, ALWAYS LAST)

**Why this matters**: `custom.css` loads AFTER `app.css`, so it can override styles without using `!important`. When overrides fail, increase specificity rather than reaching for `!important`.

## Custom Post Types

### Home Slides (`home_slide`)
- Slug: `home_slide`
- Public: false
- Supports: title, thumbnail, page-attributes
- Meta fields: Body text, Button text, Button URL

### Team Member (`team_member`)
- Slug: `team_member`, rewrite: `team-member`
- Public: true
- Supports: title, thumbnail, editor
- Meta fields: Position, Location (term_id), Email
- Single template: `single-team_member.php` (note underscore in filename)

### Team Location Taxonomy (`team_location`)
- Taxonomy for team_member CPT
- Hierarchical: false
- Stored as term_id in `_team_member_location` meta key
- Standard taxonomy meta box is removed - location is selected via custom meta field dropdown

## NG Andersen Settings Admin Page

Custom settings page accessible via WordPress Admin > NG Andersen.

### Tabs:
1. **Office Locations** - 3 offices with Name, Address, Email, Phone, Map Embed Code
2. **Social Media** - Facebook, Twitter/X, LinkedIn, Instagram, YouTube URLs
3. **Tracking & Analytics** - Google Analytics ID and enable toggle
4. **CAPTCHA API Keys** - Cloudflare Turnstile Site/Secret keys

### Helper Functions:
```php
ng_andersen_get_office( $number )       // Get office data array
ng_andersen_get_social_links()           // Get social media URLs
ng_andersen_get_turnstile_keys()         // Get CAPTCHA keys
ng_andersen_get_ga_settings()            // Get GA settings
```

### Settings Page Pattern
All tabs render in the DOM but inactive tabs are hidden with `display:none;`. This ensures all field values are submitted with every save, preventing data loss when switching tabs.

## Custom Admin Color Scheme

The theme registers an "Andersen" admin color scheme available at Users > Profile > Administration Colour Scheme.

Colors: `#1d2327`, `#2c3338`, `#2271b1`, `#72aee6`

CSS file: `assets/css/admin-color-scheme.css`

## Page Templates

Custom page templates use the `Template Name:` comment block pattern:

```php
<?php
/**
 * Template Name: Contact
 */
```

Templates are stored in `/templates/` folder and selected via WordPress page editor's Template dropdown.

### Existing Templates:
- `template-contact.php` - 2-column contact page (offices+maps left, CF7 form right)
- Team and Locations templates in `/templates/`

## CF7 Form Layout (Foundation Grid)

CF7 forms use Foundation 6 `cell` classes (NOT `column`):

```html
<div class="grid-x grid-padding-x">
    <div class="cell large-6 medium-6 small-12">
        <label>Field Label
        [field-shortcode]</label>
    </div>
    <div class="cell large-6 medium-6 small-12">
        <label>Another Field
        [field-shortcode]</label>
    </div>
</div>
```

## Key WordPress Patterns Used

### Image Sanitization for iframes
Maps and embeds need explicit iframe permissions:
```php
$allowed_html = array(
    'iframe' => array(
        'src' => true, 'width' => true, 'height' => true,
        'style' => true, 'allowfullscreen' => true,
        'loading' => true, 'referrerpolicy' => true,
        'frameborder' => true,
    ),
);
echo wp_kses( $map_code, $allowed_html );
```

### Object-Fit for Team Photos
Team listing uses clip-path mask with object-position to control which part of portraits shows:
```css
.item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 15%;
}
```

### AJAX Team Search
The team page uses AJAX search with debounced input (250ms). Script: `team.js`. Endpoints:
- `wp_ajax_ng_andersen_search_team_members` (public)
- `wp_ajax_nopriv_ng_andersen_search_team_members` (public)

Nonce: `team_search_nonce`

### AJAX Publications
The publications page uses AJAX for category filtering and pagination. Script: `publications.js`. Endpoints:
- `wp_ajax_ng_andersen_get_publications` (public)
- `wp_ajax_nopriv_ng_andersen_get_publications` (public)

Nonce: `publications_nonce`

## Security Standards

- All user input is sanitized (`sanitize_text_field`, `sanitize_email`, `absint`, `esc_url_raw`)
- All output is escaped (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`)
- Nonces verified for all form submissions and AJAX requests
- Capability checks (`current_user_can`) on all editing operations
- iframe allowance scoped specifically to map embeds only

## Coding Conventions

- **Function prefix**: `ng_andersen_` or `theme_`
- **Meta keys**: prefixed with underscore (private), e.g., `_team_member_position`
- **Option names**: prefixed with `ng_andersen_`
- **Hook priorities**: default unless specifically needed
- **PHP**: WordPress coding standards
- **Indentation**: 4 spaces
- **Comments**: section dividers using `// ===` style for major sections

## Common Issues & Solutions

### Issue: 404 on CPT single pages
**Solution**: Settings > Permalinks > Save Changes (flushes rewrite rules)

### Issue: CSS rule not applying
**Solution**: Increase specificity by tracing parent path. Avoid `!important`.

### Issue: Settings page menu not showing
**Solution**: Check that `theme-settings.php` is required in `functions.php` and that you're viewing the correct environment (local vs UAT).

### Issue: Iframes/maps not displaying
**Solution**: Use explicit `wp_kses` allowed_html array with iframe permissions.

### Issue: Tab data lost when switching settings tabs
**Solution**: All tabs must render in the DOM (use `display:none` for inactive tabs, not PHP conditionals).

## Commit Message Convention

Present tense imperative:
- "Add front-page.php and homepage template parts"
- "Update team member template with sidebar layout"
- "Fix breadcrumb capitalization on inner pages"

## Future Development Notes

- Featured post on homepage `blocks2.php` should be dynamic (currently static)
- Office order in settings could be reorderable (currently fixed 1, 2, 3)
- Sticky sidebar widget on team member pages (attempted but not working - to be revisited)
- Add image size registration for consistent team photos
- Cloudflare Turnstile integration with CF7 forms
- Google Analytics output to header