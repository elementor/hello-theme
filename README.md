# Elementor Hello Theme 
[![Built with Grunt](http://cdn.gruntjs.com/builtwith.svg)](http://google.com.au/)

**Contributors:** [elemntor](https://profiles.wordpress.org/elemntor)  
**Requires at least:** WordPress 4.7  
**Tested up to:** WordPress 5.0  
**Stable tag:** 1.1.0  
**Version:** 1.1.0  
**License:** GNU General Public License v3 or later  
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html  
**Tags:** flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, rtl-language-support, threaded-comments, translation-ready  

A base theme for [Elementor](https://elementor.com) & [Elementor Pro](https://elementor.com/pro) plugins.

## Description ##

Elementor Hello Theme is a vanilla base theme, allowing you to build your Elementor website on excellent foundations. This theme resets the WordPress environment, and optimises it for Elementor.

## Installation ##

1. In your admin panel, go to Appearance > Themes and click the 'Add New' button.
2. Type in 'Elementor Hello' in the search form, and hit the 'Enter' key on your keyboard.
3. Click on the 'Activate' button to use your new theme right away.
4. Navigate to Elementor and start building your site.

## Should I modify this theme? ##

Most users won't need to edit the files for this theme. If you wish to customize the appearance of your site, simply use **Elementor**. However, if you have a particular need to adapt this theme, please read on.

### Hooks ###
Certain settings can be prevented from loading, by adding the following code to your child-theme's `functions.php`:

```php
add_filter( 'elementor_hello_theme_load_textdomain', '__return_false' ); // Load the theme's textdomain
add_filter( 'elementor_hello_theme_register_menus', '__return_false' ); // Register the theme's default menu location
add_filter( 'elementor_hello_theme_add_theme_support', '__return_false' ); // Register the theme's supported features
add_filter( 'elementor_hello_theme_add_woocommerce_support', '__return_false' ); // Register WooCommerce features, including product-gallery zoom, swipe & lightbox features
add_filter( 'elementor_hello_theme_enqueue_style', '__return_false' ); // Enqueue style
add_filter( 'elementor_hello_theme_register_elementor_locations', '__return_false' ); // Register elementor settings
```

### CSS / SCSS Stylesheets ###

All of your site's styles should be handled directly inside **Elementor**. You should not need to edit the CSS files in this theme in ordinary circumstances.

However, if for some reason there is still a need to add or change the site's CSS, the best strategy is as follows:
1. Files located under `reset` directory, should **NOT** be edited directly.
2. In order to change any of the values defined in `preset/variables.scss`, add your style code to `custom/pre_default.scss`.
3. Any new SCSS files should be located under `custom/` directory, and imported in `custom/custom.scss`.

## Frequently Asked Questions ##

* Does this theme support any plugins?

Elementor Hello Theme includes support for WooCommerce.

* Can font styles be added through in Elementor Hello Theme's CSS file?

Yes, but best practice is to use the styling capabilities in the Elementor plugin.

## Changelog ##

### 1.1.0 ###
* Released: December 26, 2018

* New: use scss & do thorough style reset.
* New: readme.
* New: add hooks and child-theme preparations.
* New: template parts search.
* New: translations support.
* Changed: re-write of already existing template parts.

### 1.0 ###
* Released: November 4, 2018

*Initial release*
