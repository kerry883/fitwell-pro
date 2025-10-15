# Trainer Dashboard E2E Tests

This directory contains comprehensive end-to-end tests for the FitWell Pro trainer dashboard system using Playwright.

## Test Structure

### Files
- `trainer-dashboard.spec.js` - Main trainer functionality tests
- `trainer-authentication.spec.js` - Authentication and access control tests

### Test Coverage

#### Authentication & Access Control
- ✅ Trainer login and role-based dashboard redirect
- ✅ Non-trainer user access prevention
- ✅ Route protection with middleware
- ✅ Session maintenance across navigation
- ✅ Logout functionality
- ✅ Direct URL access protection

#### Dashboard Functionality
- ✅ Dashboard statistics display
- ✅ Navigation menu structure
- ✅ Responsive design testing
- ✅ Data separation verification

#### Client Management
- ✅ Client list display and navigation
- ✅ Search and filtering functionality
- ✅ Client detail access

#### Program Management
- ✅ Program list display
- ✅ Program statistics and metrics
- ✅ Program filtering and search
- ✅ Program CRUD operations

#### Schedule Management
- ✅ Schedule overview display
- ✅ Today's sessions and weekly view
- ✅ Session detail access
- ✅ Availability management

#### Analytics Dashboard
- ✅ Performance metrics display
- ✅ Revenue and session tracking
- ✅ Goal progress visualization
- ✅ Quick insights display

#### Profile Management
- ✅ Profile information display
- ✅ Professional info and certifications
- ✅ Specializations management
- ✅ Profile editing functionality

## Running Tests

### Prerequisites
1. Ensure Laravel application is set up and running
2. Install Playwright: `npm install @playwright/test`
3. Install browsers: `npx playwright install`
4. Ensure test database is seeded with trainer user data

### Test Commands
```bash
# Run all E2E tests
npm run test:e2e

# Run tests in headed mode (visible browser)
npm run test:e2e:headed

# Run tests with UI mode
npm run test:e2e:ui

# Run only trainer dashboard tests
npm run test:e2e:trainer

# Run only authentication tests
npm run test:e2e:auth
```

### Test Data Requirements

The tests expect the following test users to exist in the database:

#### Trainer User
```
Email: trainer@example.com
Password: password
Role: trainer
Name: John Trainer
```

#### Regular User
```
Email: user@example.com  
Password: password
Role: user
```

### Configuration

The tests are configured in `playwright.config.js` with:
- Base URL: `http://localhost:8000`
- Multiple browser support (Chrome, Firefox, Safari, Edge)
- Mobile device testing (iPhone, Pixel)
- Automatic Laravel server startup
- HTML reporting
- Screenshot/video capture on failure

## Test Architecture

### Page Object Model
The tests follow Playwright best practices with:
- Selector-based element targeting
- Explicit wait strategies
- Cross-browser compatibility
- Mobile-responsive testing

### Assertions
- URL validation for proper routing
- Content visibility and text matching  
- Form interaction verification
- Navigation flow validation
- Role-based access control testing

## Maintenance

### Adding New Tests
1. Create test cases in appropriate spec files
2. Follow existing naming conventions
3. Use descriptive test names and comments
4. Include proper assertions and waits

### Updating Selectors
If UI elements change:
1. Update selectors in test files
2. Test across all browsers
3. Verify mobile compatibility
4. Update documentation if needed

## Troubleshooting

### Common Issues
1. **Browser not installed**: Run `npx playwright install`
2. **Server not running**: Ensure Laravel dev server is active
3. **Test data missing**: Verify test users exist in database
4. **Timeout errors**: Check for slow loading elements
5. **Selector failures**: Update selectors after UI changes

### Debug Mode
```bash
# Run specific test with debug
npx playwright test trainer-dashboard.spec.js --debug

# Run with verbose output
npx playwright test --reporter=line
```

This comprehensive E2E test suite ensures the trainer dashboard system works correctly across all major browsers and devices, providing confidence in the production deployment.