class elementorHelloThemeHandler {
    constructor() {
        this.initSettings();
        this.initElements();
        this.bindEvents();
    }

    initSettings() {
        this.settings = {
            selectors: {
                menuToggle: '.site-header .site-navigation-toggle',
                menuToggleHolder: '.site-header .site-navigation-toggle-holder',
                dropdownMenu: '.site-header .site-navigation-dropdown',
            },
        };
    }

    initElements() {
        this.elements = {
            window,
            menuToggle: document.querySelector( this.settings.selectors.menuToggle ),
            menuToggleHolder: document.querySelector( this.settings.selectors.menuToggleHolder ),
            dropdownMenu: document.querySelector( this.settings.selectors.dropdownMenu ),
        };
    }

    bindEvents() {
        this.elements.menuToggle.addEventListener( 'click', this.handleMenuToggle.bind( this ), false );
        this.elements.menuToggle.addEventListener( 'keyup', ( event ) => {
            const ENTER_KEY = 13;
            const SPACE_KEY = 32;

            if ( ENTER_KEY === event.keyCode || SPACE_KEY === event.keyCode ) {
                event.currentTarget.click();
            }
        } );
        this.elements.dropdownMenu.addEventListener( 'click', ( event ) => {
            if ( event.target.closest( '.menu-item-has-children > a' ) ) {
                this.handleMenuChildren.bind( this );
            }
        } );
    }

    closeMenuItems() {
        this.elements.menuToggleHolder.classList.remove( 'elementor-active' );
        this.elements.window.removeEventListener( 'resize', this.closeMenuItems.bind( this ) );
    }

    handleMenuToggle() {
        const isDropdownVisible = ! this.elements.menuToggleHolder.classList.contains( 'elementor-active' );

        this.elements.menuToggle.setAttribute( 'aria-expanded', isDropdownVisible );
        this.elements.dropdownMenu.setAttribute( 'aria-hidden', ! isDropdownVisible );
        this.elements.menuToggleHolder.classList.toggle( 'elementor-active', isDropdownVisible );

        // Always close all sub active items.
        this.elements.dropdownMenu.querySelectorAll( ':scope .elementor-active' ).forEach( ( item ) => item.classList.remove( 'elementor-active' ) );

        if ( isDropdownVisible ) {
            this.elements.window.addEventListener( 'resize', this.closeMenuItems.bind( this ) );
        } else {
            this.elements.window.removeEventListener( 'resize', this.closeMenuItems.bind( this ) );
        }
    }

    handleMenuChildren( event ) {
        const anchor = event.currentTarget;
        const parentLi = anchor.parent( 'li' );
        const isSubmenuVisible = parentLi.classList.contains( 'elementor-active' );

        if ( ! isSubmenuVisible ) {
            parentLi.classList.add( 'elementor-active' );
        } else {
            parentLi.classList.remove( 'elementor-active' );
        }
    }
}

document.addEventListener( 'DOMContentLoaded', () => {
    new elementorHelloThemeHandler();
} );
