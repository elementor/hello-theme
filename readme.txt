=== Hello Elementor ===

Contributors: elemntor
Requires at least: WordPress 4.7
Tested up to: WordPress 5.0
Stable tag: 1.0.0
Version: 1.0.0
Requires PHP: 5.4
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Tags: flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, rtl-language-support, threaded-comments, translation-ready

A lightweight, plain-vanilla theme for Elementor page builder.

== Description ==

A basic, plain-vanilla, lightweight theme, best suited for building your site using Elementor page builder.

This theme resets the WordPress environment and prepares it for smooth operation of Elementor.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the 'Add New' button.
2. Type in 'Hello Elementor' in the search form and hit the 'Enter' key on your keyboard.
3. Click on the 'Activate' button to use your new theme right away.
4. Navigate to Elementor and start building your site.

== Customizations ==

Most users will not need to edit the files for this theme.
To customize your site's appearance, simply use ***Elementor***.

However, if you have a particular need to adapt this theme, please read on.

= Style & Stylesheets =

All of your site's styles should be handled directly inside ***Elementor***.
You should not need to edit the SCSS files in this theme in ordinary circumstances.

However, if for some reason there is still a need to add or change the site's CSS, please pay attention to the following:

1. Files located under `reset` directory, should **NOT** be edited directly
2. In order to change any of the values defined in `preset/variables.scss`, add your style code to `custom/pre_default.scss`
3. Any new SCSS files should be located under `custom/` directory, and imported in `custom/custom.scss`

**Remember that any SCSS change requires re-generating the theme's css files.**

= Hooks =

To prevent the loading of any of the these settings, use the following as boilerplate and add the code to your child-theme `functions.php`:
```php
add_filter( 'choose-from-the-list-below', '__return_false' );
```

* `hello_elementor_load_textdomain`               load theme's textdomain
* `hello_elementor_register_menus`                register the theme's default menu location
* `hello_elementor_add_theme_support`             register the various supported features
* `hello_elementor_add_woocommerce_support`       register woocommerce features, including product-gallery zoom, swipe & lightbox features
* `hello_elementor_enqueue_style`                 enqueue style
* `hello_elementor_register_elementor_locations`  register elementor settings

== Frequently Asked Questions ==

**Does this theme support any plugins?**

Hello Elementor includes support for WooCommerce.

**Can Font Styles be added thru the theme's css file?**

Yes, ***but*** best practice is to use the styling capabilities in the Elementor plugin.

== Changelog ==

= 1.0.0 - 2019-02-14 =
* Initial Public Release
