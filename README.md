# Elementor Hello Theme [![Built with Grunt](https://cdn.gruntjs.com/builtwith.svg)](http://gruntjs.com/)



**Contributors:** [elemntor](https://profiles.wordpress.org/elemntor)  
**Requires at least:** WordPress 4.7  
**Tested up to:** WordPress 5.0  
**Stable tag:** 1.1.0  
**Version:** 1.1.0  
**License:** GNU General Public License v3 or later  
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html  
**Tags:** flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, rtl-language-support, threaded-comments, translation-ready  

The theme for Elementor plugin.

## Description ##

A plain-vanilla theme, best suited for building your site using Elementor plugin.
This theme resets the environment and prepares it for smooth operation of Elementor.

If you wish to customize your theme & site, just use **Elementor!**.

### Hooks ###

to prevent the loading of any of the following settings, add the following code to your child-theme functions.php:

`add_filter( 'choose-from-the-list-below', '__return_false' );`

* `elementor_hello_theme_load_textdomain`               load theme's textdomain
* `elementor_hello_theme_register_menus`                register the theme's default menu location
* `elementor_hello_theme_add_theme_support`             register the various supported features
* `elementor_hello_theme_add_woocommerce_support`       register woocommerce features, including product-gallery zoom, swipe & lightbox features
* `elementor_hello_theme_enqueue_style`                 enqueue style
* `elementor_hello_theme_register_elementor_locations`  register elementor settings

### Style ###

In order to change the styling used throughout the site, use **Elementor**.

However, if for some reason there is still a need to add or change the site's css, please take into account the following:
1. files located under `reset` directory, should **NOT** be edited directly.
2. in order to change any of the values defined in `preset/variables.scss`, add your style code to `custom/pre_default.scss`.
3. any new scss files should be located under `custom/` directory, and imported in `custom/custom.scss`.

## Installation ##

1. In your admin panel, go to Appearance > Themes and click the 'Add New' button.
2. Type in 'Elementor Hello' in the search form and hit the 'Enter' key on your keyboard.
3. Click on the 'Activate' button to use your new theme right away.
4. Navigate to Elementor and start building your site.

## Frequently Asked Questions ##

* Does this theme support any plugins?

Elementor Hello includes support for WooCommerce.

* Can Font Style be added thru the theme's css file?

Best practice is to use the styling capabilities in the Elementor plugin.

## Changelog ##

### 1.0 ###
* Released: November 4, 2018

Initial release

### 1.1.0 ###
* Released: December 26, 2018

* New: use scss & do thorough style reset.
* New: readme.
* New: add hooks and child-theme preparations.
* New: template parts search.
* New: translations support.
* Changed: re-write of already existing template parts.
