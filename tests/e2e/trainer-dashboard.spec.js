import { test, expect } from '@playwright/test';

/**
 * Comprehensive E2E Tests for Trainer Dashboard System
 * Tests all major trainer functionalities including authentication, navigation,
 * client management, programs, schedule, analytics, and profile management.
 */

// Test fixtures and helpers
const trainerCredentials = {
    email: 'trainer@example.com',
    password: 'password'
};

test.describe('Trainer Dashboard E2E Tests', () => {

    test.beforeEach(async({ page }) => {
        // Navigate to login page
        await page.goto('/login');

        // Login as trainer
        await page.fill('input[name="email"]', trainerCredentials.email);
        await page.fill('input[name="password"]', trainerCredentials.password);
        await page.click('button[type="submit"]');

        // Wait for redirect to trainer dashboard
        await page.waitForURL('**/trainer/dashboard');
    });

    test('should redirect trainer to trainer dashboard after login', async({ page }) => {
        // Verify we're on the trainer dashboard
        await expect(page).toHaveURL(/.*trainer\/dashboard/);
        await expect(page.locator('h4')).toContainText('Trainer Dashboard');

        // Verify trainer name is displayed
        await expect(page.locator('h6')).toContainText('John Trainer');
        await expect(page.locator('text=Personal Trainer')).toBeVisible();
    });

    test('should display dashboard statistics correctly', async({ page }) => {
        // Verify dashboard stats cards are visible and have correct structure
        await expect(page.locator('text=Total Clients')).toBeVisible();
        await expect(page.locator('text=Active Programs')).toBeVisible();
        await expect(page.locator('text=Sessions Today')).toBeVisible();
        await expect(page.locator('text=Monthly Revenue')).toBeVisible();

        // Verify numeric values are displayed
        await expect(page.locator('h4:has-text("12")')).toBeVisible(); // Total Clients
        await expect(page.locator('h4:has-text("3")')).toBeVisible(); // Active Programs
        await expect(page.locator('h4:has-text("4")')).toBeVisible(); // Sessions Today
    });

    test('should navigate to clients section and display client list', async({ page }) => {
        // Navigate to clients
        await page.click('text=My Clients');
        await expect(page).toHaveURL(/.*trainer\/clients/);

        // Verify clients page header
        await expect(page.locator('h4')).toContainText('My Clients');
        await expect(page.locator('text=Manage your client relationships')).toBeVisible();

        // Verify client search and filters
        await expect(page.locator('input[placeholder="Search clients..."]')).toBeVisible();
        await expect(page.locator('select')).toHaveCount(3); // Status, Program, Sort filters

        // Verify client cards are displayed
        await expect(page.locator('text=Sarah Johnson')).toBeVisible();
        await expect(page.locator('text=Mike Chen')).toBeVisible();
        await expect(page.locator('text=Emma Wilson')).toBeVisible();

        // Test client search functionality
        await page.fill('input[placeholder="Search clients..."]', 'Sarah');
        // Note: In a real app, this would filter results
    });

    test('should navigate to programs section and display program management', async({ page }) => {
        // Navigate to programs
        await page.click('text=Programs');
        await expect(page).toHaveURL(/.*trainer\/programs/);

        // Verify programs page header
        await expect(page.locator('h4')).toContainText('Training Programs');
        await expect(page.locator('text=Create and manage your training programs')).toBeVisible();

        // Verify program statistics
        await expect(page.locator('text=Total Programs')).toBeVisible();
        await expect(page.locator('text=Enrolled Clients')).toBeVisible();
        await expect(page.locator('text=Completion Rate')).toBeVisible();
        await expect(page.locator('text=Average Rating')).toBeVisible();

        // Verify program cards
        await expect(page.locator('text=Beginner Strength Building')).toBeVisible();
        await expect(page.locator('text=HIIT Fat Burn')).toBeVisible();
        await expect(page.locator('text=Advanced Powerlifting')).toBeVisible();

        // Verify program filters and search
        await expect(page.locator('input[placeholder="Search programs..."]')).toBeVisible();
        await expect(page.locator('text=All Types')).toBeVisible();
        await expect(page.locator('text=All Levels')).toBeVisible();
    });

    test('should navigate to schedule section and display schedule management', async({ page }) => {
        // Navigate to schedule
        await page.click('text=Schedule');
        await expect(page).toHaveURL(/.*trainer\/schedule/);

        // Verify schedule page header
        await expect(page.locator('h4')).toContainText('Schedule Management');
        await expect(page.locator('text=Manage your training sessions and availability')).toBeVisible();

        // Verify schedule statistics
        await expect(page.locator('text=Today\'s Sessions')).toBeVisible();
        await expect(page.locator('text=This Week')).toBeVisible();
        await expect(page.locator('text=Completed This Month')).toBeVisible();
        await expect(page.locator('text=Monthly Revenue')).toBeVisible();

        // Verify today's schedule
        await expect(page.locator('text=Today\'s Schedule')).toBeVisible();
        await expect(page.locator('text=Sarah Johnson')).toBeVisible();
        await expect(page.locator('text=Mike Chen')).toBeVisible();

        // Verify weekly availability
        await expect(page.locator('text=Weekly Availability')).toBeVisible();
        await expect(page.locator('text=Monday')).toBeVisible();
        await expect(page.locator('text=Tuesday')).toBeVisible();
    });

    test('should navigate to analytics section and display performance metrics', async({ page }) => {
        // Navigate to analytics
        await page.click('text=Analytics');
        await expect(page).toHaveURL(/.*trainer\/analytics/);

        // Verify analytics page header
        await expect(page.locator('h1')).toContainText('Performance Analytics');
        await expect(page.locator('text=Track your performance and business metrics')).toBeVisible();

        // Verify analytics metrics
        await expect(page.locator('text=Total Revenue')).toBeVisible();
        await expect(page.locator('text=Total Sessions')).toBeVisible();
        await expect(page.locator('text=Active Clients')).toBeVisible();
        await expect(page.locator('text=Avg Session Rate')).toBeVisible();

        // Verify charts sections
        await expect(page.locator('text=Revenue Overview')).toBeVisible();
        await expect(page.locator('text=Sessions by Type')).toBeVisible();

        // Verify goals progress section
        await expect(page.locator('text=Monthly Goals Progress')).toBeVisible();
        await expect(page.locator('text=Revenue Goal')).toBeVisible();
        await expect(page.locator('text=Sessions Goal')).toBeVisible();
        await expect(page.locator('text=New Clients Goal')).toBeVisible();

        // Verify quick insights
        await expect(page.locator('text=Quick Insights')).toBeVisible();
        await expect(page.locator('text=Peak Hours')).toBeVisible();
        await expect(page.locator('text=Client Retention')).toBeVisible();
    });

    test('should navigate to profile section and display trainer profile', async({ page }) => {
        // Navigate to profile
        await page.click('text=Profile');
        await expect(page).toHaveURL(/.*trainer\/profile/);

        // Verify profile page header
        await expect(page.locator('h4')).toContainText('My Profile');
        await expect(page.locator('text=Manage your professional profile and settings')).toBeVisible();

        // Verify profile information
        await expect(page.locator('h3')).toContainText('John Trainer');
        await expect(page.locator('text=trainer@example.com')).toBeVisible();

        // Verify professional info section
        await expect(page.locator('text=Professional Info')).toBeVisible();
        await expect(page.locator('text=Years of Experience')).toBeVisible();
        await expect(page.locator('text=8 years')).toBeVisible();

        // Verify certifications section
        await expect(page.locator('text=Certifications')).toBeVisible();
        await expect(page.locator('text=NASM-CPT')).toBeVisible();
        await expect(page.locator('text=ACE-CPT')).toBeVisible();

        // Verify specializations
        await expect(page.locator('text=Specializations')).toBeVisible();
        await expect(page.locator('text=Strength Training')).toBeVisible();
        await expect(page.locator('text=Weight Loss')).toBeVisible();

        // Verify tabs functionality
        await expect(page.locator('text=Overview')).toBeVisible();
        await expect(page.locator('text=Business Info')).toBeVisible();
        await expect(page.locator('text=Availability')).toBeVisible();
    });

    test('should test program view and edit functionality', async({ page }) => {
        // Navigate to programs
        await page.click('text=Programs');

        // Click on first program's "View Program" button
        await page.click('text=View Program >> nth=0');
        await expect(page).toHaveURL(/.*trainer\/programs\/1/);

        // Go back and test edit
        await page.goBack();

        // Click on edit button for first program
        await page.click('a[href*="/programs/1/edit"] >> nth=0');
        await expect(page).toHaveURL(/.*trainer\/programs\/1\/edit/);
    });

    test('should test schedule session details functionality', async({ page }) => {
        // Navigate to schedule
        await page.click('text=Schedule');

        // Click on a session to view details
        const sessionButtons = page.locator('button:has-text("")').first();
        await sessionButtons.click();
        // This would open a modal or navigate to session details in a real app
    });

    test('should test profile edit functionality', async({ page }) => {
        // Navigate to profile
        await page.click('text=Profile');

        // Click edit profile button
        await page.click('text=Edit Profile');
        await expect(page).toHaveURL(/.*trainer\/profile\/edit/);

        // Verify edit form is displayed
        // In a real test, we would verify form fields and test form submission
    });

    test('should verify navigation between all trainer sections', async({ page }) => {
        // Test navigation through all main sections
        const sections = [
            { link: 'My Clients', url: 'clients' },
            { link: 'Programs', url: 'programs' },
            { link: 'Schedule', url: 'schedule' },
            { link: 'Analytics', url: 'analytics' },
            { link: 'Profile', url: 'profile' }
        ];

        for (const section of sections) {
            await page.click(`text=${section.link}`);
            await expect(page).toHaveURL(new RegExp(`.*trainer/${section.url}`));
        }

        // Return to dashboard
        await page.click('text=Dashboard');
        await expect(page).toHaveURL(/.*trainer\/dashboard/);
    });

    test('should verify trainer middleware protection', async({ page }) => {
        // This test would verify that trainer routes are protected
        // by accessing them directly without proper authentication

        // Logout first
        await page.click('button:has-text("Logout")');

        // Try to access trainer routes directly
        await page.goto('/trainer/dashboard');
        // Should redirect to login
        await expect(page).toHaveURL(/.*login/);

        await page.goto('/trainer/clients');
        await expect(page).toHaveURL(/.*login/);

        await page.goto('/trainer/programs');
        await expect(page).toHaveURL(/.*login/);
    });

    test('should test responsive design elements', async({ page }) => {
        // Test mobile viewport
        await page.setViewportSize({ width: 375, height: 667 });

        // Navigate to dashboard and verify it's still functional
        await page.goto('/trainer/dashboard');
        await expect(page.locator('h6')).toContainText('John Trainer');

        // Test navigation on mobile
        // This would test mobile-specific UI elements like hamburger menus

        // Reset to desktop
        await page.setViewportSize({ width: 1280, height: 720 });
    });

    test('should verify trainer-specific data separation', async({ page }) => {
        // This test ensures trainer data is properly separated from client data
        // Verify we don't see regular client dashboard elements
        await expect(page.locator('text=My Workouts')).not.toBeVisible();
        await expect(page.locator('text=My Nutrition')).not.toBeVisible();

        // Verify we see trainer-specific elements
        await expect(page.locator('text=My Clients')).toBeVisible();
        await expect(page.locator('text=Training Programs')).toBeVisible();
        await expect(page.locator('text=Performance Analytics')).toBeVisible();
    });
});

/**
 * Additional test suite for form interactions and CRUD operations
 */
test.describe('Trainer Dashboard Forms and CRUD Operations', () => {

    test.beforeEach(async({ page }) => {
        await page.goto('/login');
        await page.fill('input[name="email"]', trainerCredentials.email);
        await page.fill('input[name="password"]', trainerCredentials.password);
        await page.click('button[type="submit"]');
        await page.waitForURL('**/trainer/dashboard');
    });

    test('should test client search and filtering', async({ page }) => {
        await page.click('text=My Clients');

        // Test search functionality
        const searchInput = page.locator('input[placeholder="Search clients..."]');
        await searchInput.fill('Sarah');

        // Test filter dropdowns
        const statusFilter = page.locator('select').first();
        await statusFilter.selectOption('Active');

        // Test sorting
        const sortFilter = page.locator('select').last();
        await sortFilter.selectOption('Name');
    });

    test('should test program filtering and search', async({ page }) => {
        await page.click('text=Programs');

        // Test program search
        const searchInput = page.locator('input[placeholder="Search programs..."]');
        await searchInput.fill('Strength');

        // Test type filter
        const typeFilter = page.locator('select').first();
        await typeFilter.selectOption('Strength Training');

        // Test level filter
        const levelFilter = page.locator('select').nth(1);
        await levelFilter.selectOption('Beginner');
    });

    test('should test analytics time period selection', async({ page }) => {
        await page.click('text=Analytics');

        // Test time period button (if it's interactive)
        const timePeriodButton = page.locator('button:has-text("Last 30 Days")');
        await expect(timePeriodButton).toBeVisible();
    });
});