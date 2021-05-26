class elementorHelloThemeHandler {
    constructor() {
        this.initSettings();
        this.initElements();
        this.bindEvents();
    }

    initSettings() {
        this.settings = {
            selectors: {
                header: 'header.site-header',
                footer: 'footer.site-footer',
                menuToggle: '.site-header .site-navigation-toggle',
                menuToggleHolder: '.site-header .site-navigation-toggle-holder',
                dropdownMenu: '.site-header .site-navigation-dropdown',
            },
        };
    }

    initElements() {
        this.elements = {
            $window: jQuery( window ),
            $document: jQuery( document ),
            $header: jQuery( this.settings.selectors.header ),
            $footer: jQuery( this.settings.selectors.footer ),
            $menuToggle: jQuery( this.settings.selectors.menuToggle ),
            $menuToggleHolder: jQuery( this.settings.selectors.menuToggleHolder ),
            $dropdownMenu: jQuery( this.settings.selectors.dropdownMenu ),
        };
    }

    bindEvents() {
        const self = this;

        self.elements.$menuToggle.on( 'click', ( event ) => {
            const isDropdownVisible = ! this.elements.$menuToggleHolder.hasClass( 'elementor-active' );

            this.elements.$menuToggle.attr( 'aria-expanded', isDropdownVisible );
            this.elements.$dropdownMenu.attr( 'aria-hidden', ! isDropdownVisible );
            this.elements.$menuToggleHolder.toggleClass( 'elementor-active', isDropdownVisible );

            // Always close all sub active items.
            this.elements.$dropdownMenu.find( '.elementor-active' ).removeClass( 'elementor-active' );

            if ( isDropdownVisible ) {
                self.elements.$window.on( 'resize', closeItemsOnResize );
            } else {
                self.elements.$window.off( 'resize', closeItemsOnResize );
            }
        } );

        function closeItemsOnResize() {
            self.elements.$menuToggleHolder.removeClass( 'elementor-active' );
            self.elements.$window.off( 'resize', closeItemsOnResize );
        }

        self.elements.$dropdownMenu.on( 'click', '.menu-item-has-children > a', ( event ) => {
            const $anchor = jQuery( event.currentTarget ),
                $parentLi = $anchor.parent( 'li' ),
                isSubmenuVisible = $parentLi.hasClass( 'elementor-active' );

            if ( ! isSubmenuVisible ) {
                $parentLi.addClass( 'elementor-active' );
            } else {
                $parentLi.removeClass( 'elementor-active' );
            }
        } );
    }
}

jQuery( () => {
    new elementorHelloThemeHandler();
} );

