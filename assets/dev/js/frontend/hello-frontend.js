( function( $ ) {
    $( document ).on( 'click', '.site-navigation-toggle', ( event ) => {
        const $menuToggle = $( event.currentTarget ),
              $menuToggleHolder = $menuToggle.parent( '.site-navigation-toggle-holder' ),
              $dropdownMenu = $menuToggleHolder.siblings( '.site-navigation-dropdown' ),
              isDropdownVisible = ! $menuToggleHolder.hasClass( 'elementor-active' );

        $menuToggle.attr( 'aria-expanded', isDropdownVisible );
        $dropdownMenu.attr( 'aria-hidden', ! isDropdownVisible );
        $menuToggleHolder.toggleClass( 'elementor-active', isDropdownVisible );

        // Always close all sub active items.
        $dropdownMenu.find( '.elementor-active' ).removeClass( 'elementor-active' );
    } );

    $( document ).on( 'click', '.site-navigation-dropdown .menu-item-has-children > a', ( event ) => {
        const $anchor = $( event.currentTarget ),
              $parentLi = $anchor.parent( 'li' ),
              isSubmenuVisible = $parentLi.hasClass( 'elementor-active' );

        if ( ! isSubmenuVisible ) {
            $parentLi.addClass( 'elementor-active' );
        } else {
            $parentLi.removeClass( 'elementor-active' );
        }
    } );

    $( window ).on( 'resize', () => {
         if ( $( '.site-navigation-dropdown' ).siblings( '.site-navigation-toggle-holder.elementor-active' ).length ) {
            $( '.site-navigation-toggle-holder.elementor-active' ).removeClass( 'elementor-active' );
        }
    } );
} )( jQuery );
