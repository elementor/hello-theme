/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./assets/dev/js/frontend/hello-frontend.js ***!
  \**************************************************/


(function ($) {
  $(document).on('click', '.site-navigation-toggle', function (event) {
    var $menuToggle = $(event.currentTarget),
        $menuToggleHolder = $menuToggle.parent('.site-navigation-toggle-holder'),
        $dropdownMenu = $menuToggleHolder.siblings('.site-navigation-dropdown'),
        isDropdownVisible = !$menuToggleHolder.hasClass('elementor-active');
    $menuToggle.attr('aria-expanded', isDropdownVisible);
    $dropdownMenu.attr('aria-hidden', !isDropdownVisible);
    $menuToggleHolder.toggleClass('elementor-active', isDropdownVisible); // Always close all sub active items.

    $dropdownMenu.find('.elementor-active').removeClass('elementor-active');

    if (isDropdownVisible) {
      $(window).on('resize', closeItemsOnResize);
    } else {
      $(window).off('resize', closeItemsOnResize);
    }
  });
  $(document).on('click', '.site-navigation-dropdown .menu-item-has-children > a', function (event) {
    var $anchor = $(event.currentTarget),
        $parentLi = $anchor.parent('li'),
        isSubmenuVisible = $parentLi.hasClass('elementor-active');

    if (!isSubmenuVisible) {
      $parentLi.addClass('elementor-active');
    } else {
      $parentLi.removeClass('elementor-active');
    }
  });

  function closeItemsOnResize() {
    var $activeToggleHolder = $('.site-navigation-toggle-holder.elementor-active');
    console.log('closeItemsOnResize');

    if ($activeToggleHolder.length) {
      $activeToggleHolder.removeClass('elementor-active');
      $(window).off('resize', closeItemsOnResize);
    }
  }
})(jQuery);
/******/ })()
;
//# sourceMappingURL=hello-frontend.js.map