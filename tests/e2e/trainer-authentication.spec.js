import { test, expect } from '@playwright/test';

/**
 * E2E Tests for Trainer Authentication and Role-Based Access Control
 * Tests the trainer authentication flow and verifies proper role separation.
 */

test.describe('Trainer Authentication and Access Control', () => {

    test('should redirect trainer users to trainer dashboard on login', async({ page }) => {
        // Navigate to login page
        await page.goto('/login');

        // Verify login form elements
        await expect(page.locator('input[name="email"]')).toBeVisible();
        await expect(page.locator('input[name="password"]')).toBeVisible();
        await expect(page.locator('button[type="submit"]')).toBeVisible();

        // Login with trainer credentials
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');

        // Should redirect to trainer dashboard
        await page.waitForURL('**/trainer/dashboard');
        await expect(page).toHaveURL(/.*trainer\/dashboard/);

        // Verify trainer dashboard elements are visible
        await expect(page.locator('h4')).toContainText('Trainer Dashboard');
        await expect(page.locator('text=John Trainer')).toBeVisible();
        await expect(page.locator('text=Personal Trainer')).toBeVisible();
    });

    test('should prevent non-trainer users from accessing trainer routes', async({ page }) => {
        // Login with regular user credentials
        await page.goto('/login');
        await page.fill('input[name="email"]', 'user@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');

        // Wait for dashboard redirect
        await page.waitForURL('**/dashboard');

        // Try to access trainer dashboard directly
        await page.goto('/trainer/dashboard');

        // Should be redirected away from trainer routes (403, 404, or redirect to regular dashboard)
        await page.waitForTimeout(1000); // Wait for any redirects
        await expect(page).not.toHaveURL(/.*trainer\/dashboard/);
    });

    test('should protect all trainer routes with authentication', async({ page }) => {
        const trainerRoutes = [
            '/trainer/dashboard',
            '/trainer/clients',
            '/trainer/programs',
            '/trainer/schedule',
            '/trainer/analytics',
            '/trainer/profile'
        ];

        for (const route of trainerRoutes) {
            await page.goto(route);
            // Should redirect to login page
            await expect(page).toHaveURL(/.*login/);
        }
    });

    test('should maintain trainer session and navigation', async({ page }) => {
        // Login as trainer
        await page.goto('/login');
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');

        // Navigate to different trainer sections and verify session is maintained
        const trainerSections = [
            { name: 'My Clients', url: 'clients', heading: 'My Clients' },
            { name: 'Programs', url: 'programs', heading: 'Training Programs' },
            { name: 'Schedule', url: 'schedule', heading: 'Schedule Management' },
            { name: 'Analytics', url: 'analytics', heading: 'Performance Analytics' },
            { name: 'Profile', url: 'profile', heading: 'My Profile' }
        ];

        for (const section of trainerSections) {
            await page.click(`text=${section.name}`);
            await expect(page).toHaveURL(new RegExp(`.*trainer/${section.url}`));

            // Verify trainer identity is maintained
            await expect(page.locator('text=John Trainer')).toBeVisible();
        }
    });

    test('should handle trainer logout correctly', async({ page }) => {
        // Login as trainer
        await page.goto('/login');
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');

        // Logout
        await page.click('button:has-text("Logout")');

        // Should redirect to home or login page
        await page.waitForURL('**/');

        // Verify we can't access trainer routes after logout
        await page.goto('/trainer/dashboard');
        await expect(page).toHaveURL(/.*login/);
    });

    test('should verify trainer navigation menu structure', async({ page }) => {
        // Login as trainer
        await page.goto('/login');
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');

        // Verify all expected trainer navigation links are present
        const expectedLinks = [
            'Dashboard',
            'My Clients',
            'Programs',
            'Schedule',
            'Analytics',
            'Profile',
            'Settings'
        ];

        for (const link of expectedLinks) {
            await expect(page.locator(`text=${link}`)).toBeVisible();
        }

        // Verify logout button is present
        await expect(page.locator('button:has-text("Logout")')).toBeVisible();
    });

    test('should verify trainer profile dropdown functionality', async({ page }) => {
        // Login as trainer
        await page.goto('/login');
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');

        // Check if there's a trainer profile dropdown in the header
        const profileDropdown = page.locator('button:has-text("John")');
        if (await profileDropdown.isVisible()) {
            await profileDropdown.click();
            // Verify dropdown options if they exist
        }
    });

    test('should handle direct URL access to trainer routes', async({ page }) => {
        // Login as trainer first
        await page.goto('/login');
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');

        // Test direct navigation to specific trainer routes
        const trainerRoutes = [
            { url: '/trainer/clients', expectedContent: 'My Clients' },
            { url: '/trainer/programs', expectedContent: 'Training Programs' },
            { url: '/trainer/schedule', expectedContent: 'Schedule Management' },
            { url: '/trainer/analytics', expectedContent: 'Performance Analytics' },
            { url: '/trainer/profile', expectedContent: 'My Profile' }
        ];

        for (const route of trainerRoutes) {
            await page.goto(route.url);
            await expect(page).toHaveURL(new RegExp(`.*${route.url}`));
            await expect(page.locator('text=' + route.expectedContent)).toBeVisible();
        }
    });

    test('should verify role-based dashboard redirect from /dashboard', async({ page }) => {
        // Login as trainer
        await page.goto('/login');
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');

        // Navigate to generic dashboard route
        await page.goto('/dashboard');

        // Should redirect to trainer dashboard
        await expect(page).toHaveURL(/.*trainer\/dashboard/);
        await expect(page.locator('h4')).toContainText('Trainer Dashboard');
    });

    test('should verify trainer middleware enforcement on sub-routes', async({ page }) => {
        // Test program sub-routes
        const protectedRoutes = [
            '/trainer/programs/create',
            '/trainer/programs/1',
            '/trainer/programs/1/edit',
            '/trainer/schedule/create',
            '/trainer/schedule/1',
            '/trainer/clients/1',
            '/trainer/profile/edit'
        ];

        // Without authentication, should redirect to login
        for (const route of protectedRoutes) {
            await page.goto(route);
            await expect(page).toHaveURL(/.*login/);
        }

        // Login as trainer and verify access
        await page.goto('/login');
        await page.fill('input[name="email"]', 'trainer@example.com');
        await page.fill('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');

        // Now test accessible routes (some might be 404 if entities don't exist, but should not redirect to login)
        for (const route of protectedRoutes) {
            await page.goto(route);
            // Should not redirect to login page
            await expect(page).not.toHaveURL(/.*login/);
        }
    });
});