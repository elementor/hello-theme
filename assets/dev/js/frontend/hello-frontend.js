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

        if ( isDropdownVisible ) {
            $( window ).on( 'resize', closeItemsOnResize );
        } else {
            $( window ).off( 'resize', closeItemsOnResize );
        }
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

    function closeItemsOnResize() {
        const $activeToggleHolder = $( '.site-navigation-toggle-holder.elementor-active' );

        if ( $activeToggleHolder.length ) {
            $activeToggleHolder.removeClass( 'elementor-active' );
            $( window ).off( 'resize', closeItemsOnResize );
        }
    }
} )( jQuery );
