import { parallelTest as test } from '../parallelTest.ts';
import { expect } from '@playwright/test';
import WpAdminPage from '../pages/wp-admin-page.ts';

test.describe( 'Admin Menu', () => {
  test( 'Hello Elementor menu exists in sidebar with correct name', async ( { page, apiRequests }, testInfo ) => {
    // Arrange
    const wpAdmin = new WpAdminPage( page, testInfo, apiRequests );

    // Navigate to dashboard
    await wpAdmin.gotoDashboard();

    // Get the Hello Elementor menu element
    const helloElementorMenu = page.locator( '#toplevel_page_hello-elementor' );

    // Verify the menu exists
    await expect( helloElementorMenu ).toBeVisible();

    // Verify the menu has the correct title "Hello Elementor"
    const menuTitle = helloElementorMenu.locator( '.wp-menu-name' );
    await expect( menuTitle ).toHaveText( 'Hello' );
  } );
} );
