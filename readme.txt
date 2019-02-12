=== Hello Elementor ===

Contributors: elemntor
Requires at least: WordPress 4.7
Tested up to: WordPress 5.0
Stable tag: 1.2.0
Version: 1.2.0
Requires PHP: 5.4
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Tags: flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, rtl-language-support, threaded-comments, translation-ready

A plain-vanilla & lightweight theme for Elementor page builder.

== Description ==

A plain-vanilla & lightweight theme, best suited for building your site using Elementor page builder.

This theme resets the environment and prepares it for smooth operation of Elementor.

If you wish to customize your site, just use **Elementor!**.

= Hooks =

To prevent the loading of any of the following settings, add the following code to your child-theme functions.php:

`add_filter( 'choose-from-the-list-below', '__return_false' );`

* `elementor_hello_theme_load_textdomain`               load theme's textdomain
* `elementor_hello_theme_register_menus`                register the theme's default menu location
* `elementor_hello_theme_add_theme_support`             register the various supported features
* `elementor_hello_theme_add_woocommerce_support`       register woocommerce features, including product-gallery zoom, swipe & lightbox features
* `elementor_hello_theme_enqueue_style`                 enqueue style
* `elementor_hello_theme_register_elementor_locations`  register elementor settings

= Style =

In order to change the styling used throughout the site, use **Elementor**.

However, if for some reason there is still a need to add or change the site's CSS, please take into account the following:

1. Files located under `reset` directory, should **NOT** be edited directly
2. In order to change any of the values defined in `preset/variables.scss`, add your style code to `custom/pre_default.scss`
3. Any new SCSS files should be located under `custom/` directory, and imported in `custom/custom.scss`

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the 'Add New' button.
2. Type in 'Elementor Hello' in the search form and hit the 'Enter' key on your keyboard.
3. Click on the 'Activate' button to use your new theme right away.
4. Navigate to Elementor and start building your site.

== Frequently Asked Questions ==

**Does this theme support any plugins?**

Elementor Hello Theme includes support for WooCommerce.

**Can Font Style be added thru the theme's css file?**

Best practice is to use the styling capabilities in the Elementor plugin.

== Changelog ==

= 1.2.0 - 2019-02-12 =
* New: Added editor-style.css for Classic editor
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
