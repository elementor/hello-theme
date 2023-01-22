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
        this.elements.$menuToggle.on( 'click', () => this.handleMenuToggle() );
        this.elements.$menuToggle.on( 'keyup', (event) => {
            const ENTER_KEY = 13;
            if ( ENTER_KEY === event.keyCode ) {
                this.handleMenuToggle()
            }
        });
        this.elements.$dropdownMenu.on( 'click', '.menu-item-has-children > a', this.handleMenuChildren );
    }

    closeMenuItems() {
        this.elements.$menuToggleHolder.removeClass( 'elementor-active' );
        this.elements.$window.off( 'resize', () => this.closeMenuItems() );
    }

    handleMenuToggle() {
        const isDropdownVisible = ! this.elements.$menuToggleHolder.hasClass( 'elementor-active' );

        this.elements.$menuToggle.attr( 'aria-expanded', isDropdownVisible );
        this.elements.$dropdownMenu.attr( 'aria-hidden', ! isDropdownVisible );
        this.elements.$menuToggleHolder.toggleClass( 'elementor-active', isDropdownVisible );

        // Always close all sub active items.
        this.elements.$dropdownMenu.find( '.elementor-active' ).removeClass( 'elementor-active' );

        if ( isDropdownVisible ) {
            this.elements.$window.on( 'resize', () => this.closeMenuItems() );
        } else {
            this.elements.$window.off( 'resize', () => this.closeMenuItems() );
        }
    }

    handleMenuChildren( event ) {
        const $anchor = jQuery( event.currentTarget ),
            $parentLi = $anchor.parent( 'li' ),
            isSubmenuVisible = $parentLi.hasClass( 'elementor-active' );

        if ( ! isSubmenuVisible ) {
            $parentLi.addClass( 'elementor-active' );
        } else {
            $parentLi.removeClass( 'elementor-active' );
        }
    }
}

jQuery( () => {
 new elementorHelloThemeHandler();
} );
