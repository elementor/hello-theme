# Elementor Hello Theme [![Built with Grunt](https://cdn.gruntjs.com/builtwith.svg)](http://gruntjs.com/)



**Contributors:** [elemntor](https://profiles.wordpress.org/elemntor), [KingYes](https://profiles.wordpress.org/KingYes), [ariel.k](https://profiles.wordpress.org/ariel.k), [jzaltzberg](https://profiles.wordpress.org/jzaltzberg), [mati1000](https://profiles.wordpress.org/mati1000), [pojosh](https://profiles.wordpress.org/pojosh), [bainternet](https://profiles.wordpress.org/bainternet), [nrt.soda](https://profiles.wordpress.org/nrt.soda)  
**Requires at least:** WordPress 4.7  
**Tested up to:** WordPress 5.0  
**Stable tag:** 1.0  
**Version:** 2.0  
**License:** GNU General Public License v3 or later  
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html  
**Tags:** Elementor, ElementorPro, flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, rtl-language-support, threaded-comments, translation-ready  

The theme for Elementor.

## Description ##

A plain-vanilla theme, best suited for building your site using **Elementor** & **Elementor Pro**.
This theme resets the environment and prepare it for smooth operation of Elementor.

Please note that we do not provide support for customizing the theme (as it should not be required, for customizing your site, use **Elementor!**).

## Installation ##

1. In your admin panel, go to Appearance > Themes and click the 'Add New' button.
2. Type in 'Elementor Hello' in the search form and hit the 'Enter' key on your keyboard.
3. Click on the 'Activate' button to use your new theme right away.
4. Navigate to Elementor and start building your site.

## Customizing ##

### Hooks ###
to prevent the loading of any of the following settings, add the following code to your child-theme functions.php:

`add_filter( 'choose-from-the-list-below', '__return_false' );`

* `elementor_hello_theme_load_textdomain`               load theme's textdomain
* `elementor_hello_theme_register_menus`                register the theme's default menu location
* `elementor_hello_theme_add_theme_support`             register the various supported features
* `elementor_hello_theme_add_woocommerce_support`       register woocommerce features
* `elementor_hello_theme_enqueue_style`                 enqueue style
* `elementor_hello_theme_register_elementor_locations`  register elementor settings

### Style ###

In order to change the styling used throughout the site, use **Elementor**.

However, if for some reason there is still a need to add or change the site's css, please take into account the following:
1. files located under `reset` directory, should **NOT** be edited directly.
2. in order to change any of the values defined in `preset/variables.scss`, add your style code to `custom/pre_default.scss`.
3. any new scss files should be located under `custom/` directory, and imported in `custom/custom.scss`.

## Frequently Asked Questions ##

* Does this theme support any plugins?

Elementor Hello includes support for WooCommerce.

* Can Font Style be added thru the theme's css file?

Best practice is to use the styling capabilities in the Elementor plugin.

## Copyright ##

Elementor Hello Theme, Copyright 2018 Elementor.com
Elementor Hello Theme is distributed under the terms of the GNU GPL

Elementor Hello Theme bundles the following third-party resources:

normalize.css v8.0.0, Copyright © Nicolas Gallagher and Jonathan Neal
License:    MIT
Source:     https://github.com/necolas/normalize.css

## Changelog ##

### 1.0 ###
* Released: December 11, 2018

Initial release