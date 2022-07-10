=== Hello Elementor ===

Contributors: elemntor, KingYes, ariel.k, jzaltzberg, mati1000, bainternet
Requires at least: 4.7
Tested up to: 5.9
Stable tag: 2.6.0
Version: 2.6.0
Requires PHP: 5.6
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A lightweight, plain-vanilla theme for Elementor page builder.

== Description ==

A basic, plain-vanilla, lightweight theme, best suited for building your site using Elementor page builder.

This theme resets the WordPress environment and prepares it for smooth operation of Elementor.

Screenshot's images & icons are licensed under: Creative Commons (CC0), https://creativecommons.org/publicdomain/zero/1.0/legalcode

== Installation ==

1. In your site's admin panel, go to Appearance > Themes and click `Add New`.
2. Type "Hello Elementor" in the search field.
3. Click `Install` and then `Activate` to start using the theme.
4. Navigate to Appearance > Customize in your admin panel and customize to your needs.
5. A notice box may appear, recommending you to install Elementor Page Builder Plugin. You can either use it or any other editor.
6. Create a new page, click `Edit with Elementor`.
7. Once the Elementor Editor is launched, click on the library icon, pick one of the many ready-made templates and click `Insert`.
8. Edit the page content as you wish, you can add, remove and manipulate any of the elements.
9. Enjoy :)

== Customizations ==

Most users will not need to edit the files for customizing this theme.
To customize your site's appearance, simply use ***Elementor***.

However, if you have a particular need to adapt this theme, please read on.

= Style & Stylesheets =

All of your site's styles should be handled directly inside ***Elementor***.
You should not need to edit the SCSS files in this theme in ordinary circumstances.

However, if for some reason there is still a need to add or change the site's CSS, please use a child theme.

= Hooks =

To prevent the loading of any of the these settings, use the following as boilerplate and add the code to your child-theme `functions.php`:
```php
add_filter( 'choose-from-the-list-below', '__return_false' );
```

* `hello_elementor_enqueue_style`                 enqueue style
* `hello_elementor_enqueue_theme_style`           load theme-specific style (default: load)
* `hello_elementor_load_textdomain`               load theme's textdomain
* `hello_elementor_register_menus`                register the theme's default menu location
* `hello_elementor_add_theme_support`             register the various supported features
* `hello_elementor_add_woocommerce_support`       register woocommerce features, including product-gallery zoom, swipe & lightbox features
* `hello_elementor_register_elementor_locations`  register elementor settings
* `hello_elementor_content_width`                 set default content width to 800px
* `hello_elementor_page_title`                    show\hide page title (default: show)
* `hello_elementor_viewport_content`              modify `content` of `viewport` meta in header

== Frequently Asked Questions ==

**Does this theme support any plugins?**

Hello Elementor includes support for WooCommerce.

**Can Font Styles be added thru the theme's css file?**

Yes, ***but*** best practice is to use the styling capabilities in the Elementor plugin.

== Copyright ==

This theme, like WordPress, is licensed under the GPL.
Use it as your springboard to building a site with ***Elementor***.

Hello Elementor bundles the following third-party resources:

Font Awesome icons for theme screenshot
License: SIL Open Font License, version 1.1.
Source: https://fontawesome.com/v4.7.0/

Image for theme screenshot, Copyright Jason Blackeye
License: CC0 1.0 Universal (CC0 1.0)
Source: https://stocksnap.io/photo/4B83RD7BV9

== Changelog ==

= 2.6.0 - 2022-07-10 =
* Tweak: Added `theme_support` for `script` and `style` to avoid validation warnings ([#184](https://github.com/elementor/hello-theme/issues/184))
* Tweak: Sanitized content for allowed HTML tags in post title ([#118](https://github.com/elementor/hello-theme/issues/118))
* Tweak: Changed the containers to `max-width: 1140px` instead of `960px` to align with the header-footer width
* Tweak: Centering the page title for better consistency in all cases
* Tweak: Added link between the customizer to Elementor global settings
* Fix: Added output escaping in several places ([#194](https://github.com/elementor/hello-theme/issues/194))
* Fix: Post Password Form Submit button alignment (Props [@romanbondar](https://github.com/romanbondar))
* Fix: Fatal error when kit doesn't exist or needs to be recreated ([#175](https://github.com/elementor/hello-theme/issues/175))

= 2.5.0 - 2022-01-26 =
* Tweak: Added keyboard navigation to Hello theme menus
* Tweak: Added Skip Links and `#content` for the main wrapper for better accessibility ([#133](https://github.com/elementor/hello-theme/issues/133))
* Tweak: Added underline for text links in Post Content for better accessibility
* Tweak: Removed `outline: none` from inputs for better accessibility
* Fix: Footer menu location is not being presented on sites that are not running Elementor

= 2.4.2 - 2021-12-20 =
* Tweak: Use HTTPS in XFN profile link to prevent mixed content error ([Topic](https://wordpress.org/support/topic/url-scheme-in-xfn-profile-link/))
* Tweak: Remove comments in `style.min.css` output ([#179](https://github.com/elementor/hello-theme/issues/179))
* Tweak: Promoted Hello Theme Header & Footer experiment status to Stable
* Tweak: Added compatibility for upcoming WordPress version 5.9

= 2.4.1 - 2021-07-07 =
* Fix: Hello Theme Header & Footer experiment should be inactive for existing sites

= 2.4.0 - 2021-06-29 =
* New: Introducing Header and Footer site elements as an Elementor Experiment
* Tweak: Updated Elementor admin notices UI

= 2.3.1 - 2020-12-28 =
* Tweak: Improved UI for table elements
* Tweak: Added support for Gutenberg Wide and Full image formats (Props [@ramiy](https://github.com/ramiy))
* Tweak: Added font smoothing
* Tweak: Update `Tested Up to 5.6`
* Tweak: Update `Requires PHP: 5.6`
* Fix: Adjusted font-family in `code`, `pre`, `kbd` and `samp` elements (Props [@75th](https://github.com/75th))

= 2.3.0 - 2020-04-19 =
* Tweak: Removed caption centering by default to allow alignment using Elementor (Props [@cirkut](https://github.com/cirkut))
* Tweak: Removed `text-align` property from table elements to avoid alignment issue in RTL websites (Props [@ramiy](https://github.com/ramiy))
* Tweak: Added `input[type="url"]` to CSS reset rules ([#109](https://github.com/elementor/hello-theme/issues/109))
* Tweak: Update `Tested Up to 5.4`

= 2.2.2 - 2019-12-23 =
* Fix: Conflicts with minifier `cssnano` and CSS animations (Props [@CeliaRozalenM](https://github.com/CeliaRozalenM))
* Fix: Max-width propety is missing in `_archive.scss` (Props [@redpik](https://github.com/redpik))

= 2.2.1 - 2019-09-10 =
* Tweak: Added max width to `wp-caption` ([#91](https://github.com/elementor/hello-theme/issues/91))
* Tweak: Added support of `wp_body_open`

= 2.2.0 - 2019-07-22 =
* Tweak: Added viewport content filter ([#49](https://github.com/elementor/hello-theme/issues/49))
* Tweak: Added support Hide Title in Elementor
* Tweak: Adhere to TRT's Theme Sniffer

= 2.1.2 - 2019-06-19 =
* Tweak: Added theme version to enqueued styles
* Tweak: Remove header tags with `hello_elementor_page_title` filter

= 2.1.1 - 2019-06-13 =
* Tweak: Rename `Install Elementor Now` button to `Install Elementor`

= 2.1.0 - 2019-06-12 =
* New: Added basic theme styling
* New: Added tagline under the site name in header
* New: Added `hello_elementor_page_title` filter for show\hide page title
* New: Added `hello_elementor_enqueue_theme_style` filter for enqueue theme-specific style
* Tweak: Hide site name & tagline if logo file is exist
* Tweak: Hide default page list when there is no primary menu
* Tweak: Removed `#main` in `archive.php`, `single.php`, `search.php` & `404.php` files
* Tweak: Removed `#site-header` in `header.php` file
* Tweak: Replaced `#top-menu` with `.site-navigation`
* Tweak: Removed custom SCSS directory, it is recommended to use child theme instead of editing parent theme

= 2.0.7 - 2019-06-04 =
* Tweak: Added nextpage support to `single.php`
* Tweak: Keep both original and minified css files
* Tweak: Removed `flexible-header`, `custom-colors`, `editor-style` tags

= 2.0.6 - 2019-05-08 =
* Tweak: Removed irrelevant font family from `$font-family-base`
* Fix: Minified `style.css` for better optimization

= 2.0.5 - 2019-05-21 =
* New: Inroducing [Hello Theme Child](https://github.com/elementor/hello-theme-child)
* Tweak: Enqueue only parent theme stylesheet
* Tweak: Added admin notice box for recommending Elementor plugin

= 2.0.4 - 2019-05-20 =
* Tweak: Removed `accessibility-ready` tag from `style.css`

= 2.0.3 - 2019-05-19 =
* Tweak: Removed `accessibility-ready` tag

= 2.0.2 - 2019-05-13 =
* Tweak: Added `hello_elementor_content_width` filter, as per WordePress best practice

= 2.0.1 - 2019-05-12 =
* Tweak: Updated theme screenshot (following comment by WP Theme Review team)

= 2.0.0 - 2019-05-12 =
* Tweak: Updated theme screenshot (following comment by WP Theme Review team)
* Tweak: Add Copyright & Image and Icon License sections in readme (following comment by WP Theme Review team)
* Tweak: Remove duplicated call to `add_theme_support( 'custom-logo')`
* Tweak: Readme file grammar & spelling
* Tweak: Update `Tested Up to 5.2`
* Tweak: Change functions.php methods names prefix from `hello_elementor_theme_` to `hello_elementor_`
* Tweak: Change hook names to fit theme's name. Old hooks are deprecated, users are urged to update their code where needed
* Tweak: Update style for `img`, `textarea`, 'label'

= 1.2.0 - 2019-02-12 =
* New: Added classic-editor.css for Classic editor
* Tweak: A lot of changes to match theme review guidelines
* Tweak: Updated theme screenshot

= 1.1.1 - 2019-01-28 =
* Tweak: Removed padding reset for lists

= 1.1.0 - 2018-12-26 =
* New: Added SCSS & do thorough style reset
* New: Added readme file
* New: Added `elementor_hello_theme_load_textdomain` filter for load theme's textdomain
* New: Added `elementor_hello_theme_register_menus` filter for register the theme's default menu location
* New: Added `elementor_hello_theme_add_theme_support` filter for register the various supported features
* New: Added `elementor_hello_theme_add_woocommerce_support` filter for register woocommerce features, including product-gallery zoom, swipe & lightbox features
* New: Added `elementor_hello_theme_enqueue_style` filter for enqueue style
* New: Added `elementor_hello_theme_register_elementor_locations` filter for register elementor settings
* New: Added child-theme preparations
* New: Added template part search
* New: Added translation support
* Tweak: Re-write of already existing template parts

= 1.0.0 - 2018-03-19 =
* Initial Public Release
