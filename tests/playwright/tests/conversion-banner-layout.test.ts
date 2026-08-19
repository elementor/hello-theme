import { parallelTest as test } from '../parallelTest.ts';
import { expect } from '@playwright/test';
import WpAdminPage from '../pages/wp-admin-page.ts';
import { timeouts } from '../config/timeouts.ts';

test.describe('Conversion banner flows [ED-25235]', () => {
	test('Pages list does not mount banner when Elementor suppresses welcome config', async ({
		page,
		apiRequests,
	}, testInfo) => {
		const wpAdmin = new WpAdminPage(page, testInfo, apiRequests);

		await wpAdmin.login();

		await page.goto('/wp-admin/edit.php?post_type=page', {
			waitUntil: 'networkidle',
			timeout: timeouts.longAction,
		});

		await page.waitForSelector('.wrap h1.wp-heading-inline', {
			timeout: timeouts.longAction,
		});

		await page.waitForTimeout(timeouts.longAction / 5);

		await expect(page.locator('#ehe-admin-cb')).toHaveCount(0);

		const headingBox = await page
			.locator('.wrap h1.wp-heading-inline')
			.boundingBox();
		const actionBox = await page
			.locator('.wrap .page-title-action')
			.first()
			.boundingBox();

		expect(headingBox).not.toBeNull();
		expect(actionBox).not.toBeNull();

		if (headingBox && actionBox) {
			expect(actionBox.y).toBeLessThan(headingBox.y + headingBox.height + 8);
		}
	});

	test('Hello settings page still loads without conversion banner regressions', async ({
		page,
		apiRequests,
	}, testInfo) => {
		const wpAdmin = new WpAdminPage(page, testInfo, apiRequests);

		await wpAdmin.login();

		await page.goto('/wp-admin/admin.php?page=hello-elementor-settings', {
			waitUntil: 'networkidle',
			timeout: timeouts.longAction,
		});

		await expect(page.locator('#ehe-admin-settings')).toBeVisible({
			timeout: timeouts.longAction,
		});

		const bannerCount = await page.locator('#ehe-admin-cb').count();

		if (bannerCount > 0) {
			const action = page.locator('.wrap .page-title-action').first();
			const banner = page.locator('#ehe-admin-cb');

			if ((await action.count()) > 0) {
				const isAfterAction = await page.evaluate(() => {
					const actionNode = document.querySelector('.wrap .page-title-action');
					const bannerNode = document.getElementById('ehe-admin-cb');

					return Boolean(
						actionNode &&
							bannerNode &&
							actionNode.nextElementSibling === bannerNode,
					);
				});

				expect(isAfterAction).toBe(true);
			}
		}
	});

	test('Plugins page keeps native title row when banner is absent', async ({
		page,
		apiRequests,
	}, testInfo) => {
		const wpAdmin = new WpAdminPage(page, testInfo, apiRequests);

		await wpAdmin.login();

		await page.goto('/wp-admin/plugins.php', {
			waitUntil: 'networkidle',
			timeout: timeouts.longAction,
		});

		await page.waitForSelector('.wrap h1', {
			timeout: timeouts.longAction,
		});

		await page.waitForTimeout(timeouts.longAction / 5);

		const banner = page.locator('#ehe-admin-cb');
		const bannerCount = await banner.count();

		if (bannerCount > 0) {
			const heading = page.locator('.wrap h1').first();
			const action = page.locator('.wrap .page-title-action').first();

			if ((await action.count()) > 0) {
				const isAfterAction = await page.evaluate(() => {
					const actionNode = document.querySelector('.wrap .page-title-action');
					const bannerNode = document.getElementById('ehe-admin-cb');

					return Boolean(
						actionNode &&
							bannerNode &&
							actionNode.nextElementSibling === bannerNode,
					);
				});

				expect(isAfterAction).toBe(true);
			}

			await expect(heading).toBeVisible();
		}
	});
});
