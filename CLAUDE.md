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

## Source / Reference Files

These static HTML, CSS, and JS files are the original design templates. Upload them at the start of any session where layout or styling decisions need to be made.

- `index.html` — Homepage
- `inner-landing.html` — Inner landing page (sidebar + 4-column post grid)
- `inner-sub.html` — Inner sub page (sidebar nav + main content + right widget column)
- `our-people.html` — Team listing page
- `app.css` — Compiled SCSS (Foundation 6 + theme styles, DO NOT EDIT)
- `app.js` — Compiled JS (Foundation 6 + theme scripts, DO NOT EDIT)

## File Structure

```
ng-andersen/
├── assets/
│   ├── css/
│   │   ├── app.css                  (compiled SCSS - DO NOT EDIT DIRECTLY)
│   │   ├── custom.css               (WordPress overrides - SAFE TO EDIT)
│   │   └── admin-color-scheme.css   (Admin dashboard colour scheme)
│   ├── img/
│   └── js/
│       ├── app.js                   (compiled JS - DO NOT EDIT DIRECTLY)
│       ├── team.js                  (team search, filters, AJAX pagination)
│       └── publications.js          (publications AJAX filtering and pagination)
├── template-parts/
│   ├── home/                        (homepage section partials)
│   │   ├── blocks2.php              (featured + latest posts section - sticky-aware)
│   │   └── services.php             (homepage "Our Services" - first 3 services + View All button)
│   └── page/
├── templates/                       (all custom page templates use template-{name}.php)
│   ├── template-teams.php           (Team Members listing page)
│   ├── template-locations.php       (Locations map page)
│   ├── template-global-presence.php (Global Presence page)
│   ├── template-contact.php         (Contact page - offices + CF7 form)
│   ├── template-publications.php    (Publications listing - search + category dropdown, AJAX)
│   ├── template-services.php        (Services listing - cards, manual order)
│   └── template-inner-sub.php       (OPTIONAL - same layout as page.php; can be removed)
├── functions.php                    (main theme functions)
├── theme-settings.php               (custom admin settings page)
├── header.php
├── footer.php                       (dynamic social icons + footer menus from menu locations)
├── front-page.php
├── index.php
├── page.php                         (DEFAULT page template - inner-sub layout, blank sidebars)
├── single.php                       (default single post template)
├── single-team_member.php           (CPT single template - note underscore)
├── single-service.php               (Service CPT single template)
├── search.php                       (search results - 4-col card grid, 12 per page, post-type/category badge)
├── 404.php                          (full-width, no sidebar, search + home button)
├── searchform.php
├── style.css
└── CLAUDE.md
```

## CSS Architecture - CRITICAL

The CSS load order is intentional and must be preserved:

1. `google-fonts` (Google Fonts CDN)
2. `theme-styles` (app.css - compiled SCSS)
3. `theme-custom` (custom.css - WordPress overrides, ALWAYS LAST)

**Why this matters**: `custom.css` loads AFTER `app.css`, so it can override styles without using `!important`. When overrides fail, increase specificity by tracing the parent DOM path rather than reaching for `!important`.

## Custom Post Types

### Home Slides (`home_slide`)
- Slug: `home_slide`
- Public: false
- Supports: title, thumbnail, page-attributes
- Meta fields: `_home_slide_body`, `_home_slide_button_text`, `_home_slide_button_url`

### Team Member (`team_member`)
- Slug: `team_member`, rewrite: `team-member`
- Public: true
- Supports: title, thumbnail, editor, page-attributes
- Meta fields: `_team_member_position`, `_team_member_location` (term_id), `_team_member_email`
- Single template: `single-team_member.php` (note underscore in filename)
- **Ordering**: uses `page-attributes` (the "Order" field). Both the AJAX search and the listing template order by `menu_order` ASC with `title` ASC as tiebreaker. Lower numbers appear first; default 0 falls back to alphabetical.
- Flush rewrite rules after any CPT change: Settings > Permalinks > Save

### Team Location Taxonomy (`team_location`)
- Taxonomy for `team_member` CPT
- Hierarchical: false
- Location stored as term_id in `_team_member_location` meta key
- Standard taxonomy meta box removed — location selected via custom dropdown in meta box

### Service (`service`)
- CPT key: `service`, rewrite slug: `service` (singles at `/service/service-name/`)
- Public: true, `has_archive => false`
- Supports: title, editor (long formatted description), thumbnail, page-attributes (manual ordering)
- Meta field: `_service_short_description` (plain textarea, used in cards/listings)
- Single template: `single-service.php` — hero (featured image) + short description as subtitle + `the_content()` as the long description
- Listing: `template-services.php` — cards ordered by `menu_order` ASC; also surfaced on the homepage via `template-parts/home/services.php` (first 3 services + "View All Services" button)

## Post Meta Fields

Registered on standard WordPress `post` post type (Section 13 in `functions.php`).

| Meta Key | Type | Description |
|---|---|---|
| `download_link` | URL | Link to downloadable file or resource (no underscore prefix — confirmed from DB) |
| `release` | Date (Y-m-d) | Release date of the content (no underscore prefix — confirmed from DB) |

Note: these two keys are stored WITHOUT the underscore prefix (confirmed against the live database), unlike most theme meta keys. `single.php` reads `download_link` to render the "Download File" button.

## NG Andersen Settings Admin Page

Accessible via **WordPress Admin > NG Andersen**. Defined in `theme-settings.php`, loaded via `require_once` at the bottom of `functions.php`.

**IMPORTANT**: All tabs render in the DOM simultaneously but inactive tabs are hidden with `display:none`. This prevents data loss when switching tabs — all field values are always submitted.

### Tabs:
1. **Office Locations** — 3 offices, each with: Name, Address, Email, Phone, Google Maps embed code
2. **Social Media** — Facebook, Twitter/X, LinkedIn, Instagram, YouTube URLs (icons appear in footer only if URL is provided)
3. **Tracking & Analytics** — Google Analytics ID and enable/disable toggle
4. **CAPTCHA API Keys** — Cloudflare Turnstile Site Key and Secret Key
5. **Single Post** — Two sidebar widgets, each with: headline, source category, post count
   - **Related Posts** (`widget--news`) — image card style, count 1–6
   - **Resources** (`widget--resources`) — text list style with category label, count 2–6
6. **Category Images** — Per-category image management. Each category has a **Hero Image** (full size) and a **Card Fallback** (medium size), chosen via the WordPress media library picker with live previews. Stored as `array( term_id => attachment_id )`.

### Helper Functions:
```php
ng_andersen_get_office( $number )            // Returns array: name, address, email, phone, map_code
ng_andersen_get_social_links()               // Returns array: facebook, twitter, linkedin, instagram, youtube
ng_andersen_get_turnstile_keys()             // Returns array: site_key, secret_key
ng_andersen_get_ga_settings()               // Returns array: enabled, tracking_id
ng_andersen_get_single_post_settings()       // Returns array: widget_title, widget_cats[], widget_count, resources_title, resources_cats[], resources_count
ng_andersen_get_post_hero_image( $post_id )  // Category hero image (full); always overrides featured image on single post hero; falls back to landing.jpg
ng_andersen_get_post_card_image( $post_id )  // Featured image (medium) → category card fallback → block1.jpg
```

Note: `widget_cats` and `resources_cats` are ARRAYS of category IDs (multi-select checkboxes), saved via `register_setting` with a sanitize callback that runs `array_map( 'absint', ... )`.

### Category Images — how they apply:
- **Hero** (single post): `ng_andersen_get_post_hero_image()` ALWAYS uses the category hero (full size), overriding the post's own featured image — this was a deliberate decision to escape blurry low-res featured images on the large hero. Falls back to `landing.jpg`.
- **Cards** (home, publications, search): `ng_andersen_get_post_card_image()` uses the post's featured image first (medium), then the category card fallback, then `block1.jpg`.
- **Multi-category posts**: the FIRST assigned category wins for both image types.
- **Pages** are untouched — they keep using their own featured image for hero and cards.

## Custom Admin Color Scheme

Registers an "Andersen" option in Users > Profile > Administration Colour Scheme.

- Colors: `#1d2327`, `#2c3338`, `#2271b1`, `#72aee6`
- CSS file: `assets/css/admin-color-scheme.css`

## Page Templates

**Naming convention:** ALL custom page templates use the `template-{name}.php` format and are selected manually via the WordPress page editor's Template dropdown. The theme does NOT rely on WordPress's slug-based template hierarchy (`page-{slug}.php` auto-binding) — templates are always chosen explicitly. Every template file must include a `Template Name:` comment block to appear in the dropdown:

```php
<?php
/**
 * Template Name: Contact
 */
```

**Important:** When renaming a template file, the page-to-template association breaks (WordPress stores the old filename). After any rename, re-select the template on each affected page and update `is_page_template()` checks in `functions.php`.

### Existing Templates:
- `template-contact.php` — 2-column: offices/maps (left) + CF7 form (right)
- `template-teams.php` — Team members listing with AJAX search and filters
- `template-locations.php` — Locations map (external scripts)
- `template-global-presence.php` — Global Presence page
- `template-publications.php` — Publications listing: search box (title-only) + category dropdown, AJAX filtering and pagination. This is the SINGLE publications template (the earlier accordion-sidebar variant was retired in favour of the dropdown version).
- `template-services.php` — Services listing (Service CPT cards, manual order)
- `template-careers.php` — Default page layout (hero + blank sidebars + content) with the Seamless Hiring job board widget embedded after `the_content()` inside the `cell large-9` content column. The embed uses Bootstrap 4 classes which conflict with Foundation 6; a scoped subset of Bootstrap rules is reimplemented in `custom.css` section 14, all inside `#SH_Embed`, so Foundation is untouched site-wide.
- `template-inner-sub.php` — OPTIONAL. Same layout as `page.php` (hero + blank sidebars + content). Kept only if the layout also needs to be selectable by name; otherwise it can be removed since `page.php` provides this layout by default.

### Default Page Template (`page.php`)
`page.php` IS the default for any page that does not select a template from the dropdown. It uses the inner-sub.html layout: hero (featured image, falls back to `inner-sub.jpg`), breadcrumbs (built from page ancestors), an intentionally BLANK left sidebar (`cell large-3`), the page content in `cell large-9` within `main-column-sub`, and an intentionally BLANK right column (`cell large-3`). Because it has no `Template Name:` header, it is the hierarchy default, not a selectable template. Pages needing other layouts pick their own template and bypass it. The hero `<p>` under the `<h1>` is intentionally left empty.

## Search Results (`search.php`)

4-column card grid (`large-3 medium-6`), 12 results per page, following the `section-blocks1 bg-gray` pattern. Includes both posts and pages. Each card has a badge overlaid top-right on the image:
- **Posts** show their first category name (e.g. "Articles", "Newsletters")
- **Other post types** (page, team_member, service) show the post type's singular label (e.g. "Page", "Team Member", "Service")

The badge reuses the `.publication-category-badge` class; its CSS in `custom.css` is scoped to both `.section-blocks16` (publications) and `.section-blocks1` (search). Post cards use `ng_andersen_get_post_card_image()`; pages/other types use their featured image or `block1.jpg`.

## Category Archive Redirects

Category archive URLs (`/category/{slug}/`) are redirected (301) to the Publications page, pre-filtered to that category via `?publication_cat={term_id}`. Implemented in `functions.php` section 11c on `template_redirect`. The Publications page is located by its template (`_wp_page_template` = `templates/template-publications.php`), so it works regardless of the page slug. Falls back to the homepage if no publications page is found. Use a 302 instead of 301 while testing to avoid browser-cached redirects.

## Single Post Template (`single.php`)

Default template for all blog posts. Structure:
- Hero: uses `ng_andersen_get_post_hero_image()` (category hero image, NOT the featured image), post title as `<h1>`, no subtitle
- Breadcrumbs: Home → Category → Post title
- Left sidebar (3 cols) — empty, preserved for layout
- Main content (9 cols) containing:
  - Content column (9 of 9) — `the_content()` inside `.main-column--content`, followed by a "Download File" button if the `download_link` meta is set
  - Right column (3 of 9) — Related Posts widget (`widget--news`) and Resources widget (`widget--resources`)

### Related Posts Widget
- Configured via **NG Andersen > Single Post** settings tab
- Uses `widget--news` style (image card with title and Read More link)
- Pulls posts from defined categories (multi-select), excluding the current post, random order
- Card images use `ng_andersen_get_post_card_image()` and link to the post
- Only renders if categories are configured and posts are found

### Resources Widget
- Also configured via **NG Andersen > Single Post** settings tab
- Uses `widget--resources` style (text list with category label + linked title)
- Category label comes from the post's first assigned category, prefixed with a Font Awesome `fa-file-lines` icon
- Multi-select categories, random order, count 2–6
- Only renders if categories are configured and posts are found
- Both widgets use `post__not_in => array( get_the_ID() )` to exclude current post

## Footer (`footer.php`)

**Social icons** are dynamic — pulled from the Social Media tab in NG Andersen Settings. Display order: LinkedIn → Twitter/X → Facebook → Instagram → YouTube. An icon only shows if a URL is provided. Uses Font Awesome `fa-brands` classes.

**Footer link columns** are driven by nav menu locations (registered in `theme_setup()`), NOT widgets — the old footer widget areas were removed. Locations:
- `footer-col-1` ("Footer Column 1") — rendered with `menu-2cols` (splits into 2 sub-columns)
- `footer-col-2` ("Footer Column 2") — rendered with `menu-2cols` (splits into 2 sub-columns)
- `footer-col-3` ("Footer Column 3") — single column
- `footer-utility` ("Footer Utility (Bottom Bar)") — the bottom-bar links (Terms, Privacy, etc.), separated by `|` via CSS (`li + li::before`)

Each column is rendered by `ng_andersen_footer_menu_column( $location, $two_cols )`, which outputs a `<nav>` cell with the menu's NAME as the `<h5>` heading and the menu links below. Renders nothing if no menu is assigned to the location. A menu's name (and assignment) can be changed freely without affecting its links.

## Homepage Services (`template-parts/home/services.php`)

Displays the first 3 Service CPT entries by `menu_order` (manual ordering). Each item: linked featured image (falls back to `cta2.jpg`), title (`<h3>`), content trimmed to 20 words via `wp_trim_words()`, and a "Read More »" link. Below the items, a full-width centred "View All Services" button links to the page with slug `services` (via `get_page_by_path( 'services' )`); the button only renders if that page exists.

## Homepage Featured Posts (`template-parts/home/blocks2.php`)

Sticky-aware featured + latest posts section. Builds an ordered list of post IDs, then splits it: the first is the featured post (`large-7`), the next 5 fill the list (`large-5`).

Ordering logic:
1. Sticky posts first, newest first (via `get_option( 'sticky_posts' )`)
2. Topped up with the latest non-sticky posts (by date) until there are 6 total
3. Featured = first ID; list = next 5 IDs

Behaviour by scenario:
- **No sticky posts:** featured = latest post; list = posts 2–6 by date
- **6+ sticky posts:** featured = newest sticky; list = next 5 stickies
- **1–5 sticky posts:** featured + remaining stickies first, then topped up with latest non-sticky posts to fill all 5 list slots (this is "Option A" — always fills the layout, honours stickiness)

Key implementation details:
- The list query uses `'orderby' => 'post__in'` to preserve the sticky-first-then-by-date ordering (a plain date sort would undo it)
- All queries use `'ignore_sticky_posts' => true` so WordPress's default sticky-injection doesn't interfere with the manual ordering
- The featured post is sliced off the front, so it never duplicates in the list
- Both featured and list images use `ng_andersen_get_post_card_image()` and link to the post

## CF7 Form Layout (Foundation Grid)

Always use `cell` (not `column`). Wrap fields in `grid-x grid-padding-x`:

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
Team listing uses clip-path mask. Control visible portion with:
```css
.item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 15%; /* adjust % to shift which part shows */
}
```

### AJAX Team Search
Script: `team.js`. Debounced input (250ms).
- Action: `ng_andersen_search_team_members`
- Nonce: `team_search_nonce`
- Localized as: `teamSearchData.ajaxUrl`, `teamSearchData.nonce`

### AJAX Publications
Script: `publications.js`. Search (title-only) + category dropdown filter + pagination via AJAX. Shared renderer function `ng_andersen_publications_html( $cat, $page, $search )` used for both initial server-side load and AJAX responses.
- Action: `ng_andersen_get_publications`
- Nonce: `publications_nonce`
- Localized as: `publicationsData.ajaxUrl`, `publicationsData.nonce`, `publicationsData.pageUrl`
- Category `<select>` (`#publication-category`) bound via a native `addEventListener('change')` — jQuery delegation alone was unreliable because Foundation interferes with the select. The native listener is the binding that works.
- Search box (`#publication-search`) uses debounced keyup (300ms); magnifying glass button submits the form.
- `publications.js` contains TWO objects: `Publications` (legacy accordion, retained but unused) and `PublicationsDropdown` (active). Each guards on its own DOM element so the file is safe to load anywhere.
- IMPORTANT: the `is_page_template()` enqueue check must match the actual template filename exactly. A filename mismatch silently prevents the script from loading (this caused a hard-to-spot bug previously).

## Security Standards

- All user input sanitized: `sanitize_text_field`, `sanitize_email`, `absint`, `esc_url_raw`
- All output escaped: `esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`
- Nonces verified on all form submissions and AJAX requests
- Capability checks (`current_user_can`) on all editing operations
- iframe allowance scoped specifically to map embeds only
- Date fields validated with `DateTime::createFromFormat` before saving

## Coding Conventions

- **Function prefix**: `ng_andersen_` or `theme_`
- **Meta keys**: underscore-prefixed (private), e.g., `_team_member_position`
- **Option names**: prefixed with `ng_andersen_`
- **Hook calls**: `add_action` / `add_filter` placed outside functions, not inside
- **No `if ( ! function_exists() )` guards** — not used in this codebase
- **PHP**: WordPress coding standards, 4-space indentation
- **Section headers**: `// ===` divider style with number and title
- **JS**: IIFE pattern `(function($){...})(jQuery)` or object literal pattern

## Common Issues & Solutions

### Issue: 404 on CPT single pages
**Solution**: Settings > Permalinks > Save Changes (flushes rewrite rules)

### Issue: CSS rule not applying
**Solution**: Inspect element, find the conflicting rule in app.css, increase specificity by tracing the full DOM path in custom.css

### Issue: Foundation blue highlight on active menu items
**Solution**: Target with `#publications-filter-nav .menu .is-active > a { background: transparent; }`

### Issue: Settings page data lost when switching tabs
**Solution**: All tabs must render in the DOM simultaneously — use `display:none` on inactive tabs, not PHP `if` conditionals

### Issue: Iframes/maps not displaying
**Solution**: Use explicit `wp_kses` `allowed_html` array with iframe attribute permissions

### Issue: Pagination not working on static page templates
**Solution**: Use `get_query_var( 'page' )` not `$_GET['paged']`. Also ensure `redirect_canonical` filter is in `functions.php`

### Issue: Category filter conflicting with WP query vars
**Solution**: Use `publication_cat` not `cat` as the URL parameter. Use `tax_query` not `'cat'` in `WP_Query` args

### Issue: Template-specific script (publications/team) not loading at all
**Solution**: Check the `is_page_template()` path in `functions.php` matches the ACTUAL template filename exactly. After renaming template files, these checks must be updated or the script silently never enqueues. Verify by viewing page source for the script tag.

### Issue: `<select>` change event not firing on AJAX filter
**Solution**: Foundation can interfere with jQuery's delegated `change` on selects. Bind a native `document.getElementById(...).addEventListener('change', ...)` after DOM ready instead.

### Issue: Page reverts to "Default template" after renaming a template file
**Solution**: Renaming breaks the stored page-template association. Re-select the template in the page editor and update. Expected behaviour, not a bug.

## Commit Message Convention

Present tense imperative:
- "Add single.php post template"
- "Update publications page with AJAX pagination"
- "Fix Foundation active menu highlight on publications sidebar"

## Future Development Notes

- Sticky sidebar widget on single team member pages — attempted, not working, to be revisited
- Cloudflare Turnstile integration with CF7 forms (keys stored in settings, implementation pending)
- Google Analytics tag output to `<head>` (ID stored in settings, implementation pending)
- Phone number field not yet added to Team Member CPT (placeholder exists in `single-team_member.php`)
- Image size registration for consistent team photo dimensions

## Optional Enhancements (no code required)

- **Drag-and-drop ordering** for Team Members and Services: the free "Simple Page Ordering" plugin works automatically with any CPT that supports `page-attributes` (both do). Lets the client reorder by dragging in the admin list instead of typing Order numbers.