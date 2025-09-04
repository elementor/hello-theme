# Product Requirements Document (PRD)
# Cloning Release Preparation Workflow from Hello Commerce to Hello Theme

## Executive Summary

This document outlines the requirements for cloning the `release-preparation.yml` workflow from `hello-commerce` to `hello-theme`. The workflow automates version bumping, building, GitHub release creation, and notification processes for theme releases. This implementation follows the same systematic approach used for Hello Biz, with specific adaptations for Hello Theme's unique requirements.

## Current State Analysis

### What Already Exists in Hello Theme
- ✅ `.github/config/release.json` - Pre-configured for hello-elementor
- ✅ `.github/workflows/build-theme/action.yml` - Custom build action (NEEDS COMPARISON)
- ✅ Legacy release workflows: publish-release.yml, publish-patch.yml, publish-beta.yml  
- ✅ Existing version management scripts: update-version-in-files.js
- ✅ Build workflow with npm/composer integration
- ✅ Package.json with proper scripts (different from hello-commerce)

### What Needs to Be Created/Adapted

#### Required GitHub Actions (8 total)
1. **`.github/actions/install-dependencies/action.yml`** - Dependency installation
2. **`.github/actions/bump-theme-version/action.yml`** - Version bumping in multiple files  
3. **`.github/actions/get-changelog-from-readme/action.yml`** - Changelog extraction
4. **`.github/actions/create-pr-with-bumped-theme-version/action.yml`** - PR creation
5. **`.github/actions/update-main-branch-version/action.yml`** - Main branch version sync
6. **`.github/actions/theme-slack-notification/action.yml`** - Slack notifications
7. **Replace existing build-theme action** with hello-commerce version (AFTER COMPARISON)
8. **`.github/actions/create-theme-release/action.yml`** - GitHub release creation

#### Required Scripts (2 critical)
1. **`.github/scripts/validate-versions.sh`** - Version consistency validation
2. **`.github/scripts/generate-upload-instructions.sh`** - Upload instruction generation

## Detailed Requirements

### 1. Repository-Specific Changes Required

#### A. Theme Name References
- **From:** `hello-commerce` → **To:** `hello-elementor` (note: not hello-theme!)
- **From:** `Hello Commerce` → **To:** `Hello Elementor`  
- **From:** `HELLO_COMMERCE_ELEMENTOR_VERSION` → **To:** `HELLO_ELEMENTOR_VERSION`

#### B. Repository URLs
- **From:** `elementor/hello-commerce` → **To:** `elementor/hello-theme`
- **From:** `https://github.com/elementor/hello-commerce` → **To:** `https://github.com/elementor/hello-theme`

#### C. Package Configuration
- **From:** Package name `hello-commerce` → **To:** `hello-elementor`
- **From:** Theme slug `hello-commerce` → **To:** `hello-elementor`
- **From:** WordPress.org URL `wordpress.org/themes/hello-commerce/` → **To:** `wordpress.org/themes/hello-elementor/`

#### D. File Naming Patterns
- **From:** `hello-commerce-{version}.zip` → **To:** `hello-elementor-{version}.zip`
- **From:** `/tmp/hello-commerce-builds/` → **To:** `/tmp/hello-elementor-builds/`

### 2. Critical Compatibility Analysis

#### A. Build Process Differences
**Hello Theme Build Commands:**
```json
{
  "zip": "npm run clean:build && npm run build:prod && rsync -av --exclude-from=.buildignore . $npm_package_name && zip -r $npm_package_name.$npm_package_version.zip $npm_package_name/*",
  "build:prod": "composer install --no-dev && wp-scripts build --env=production",
  "clean:build": "rm -rf assets && rm -rf $npm_package_name"
}
```

**Hello Commerce Build Commands:**
```json
{
  "package:zip": "npm run package && zip -r $npm_package_name.$npm_package_version.zip ./$npm_package_name/*",
  "build": "composer install --no-dev && npx wp-scripts build --env=production",
  "clean": "rm -rf assets && rm -rf $npm_package_name"
}
```

**⚠️ CRITICAL ADAPTATION REQUIRED:**
- Hello Theme uses `zip` script vs Hello Commerce `package:zip`
- Hello Theme uses `wp-scripts` directly vs Hello Commerce `npx wp-scripts`
- Hello Theme has more complex build process with sass dependencies

#### B. Version Constant Differences
**Hello Theme:**
```php
define( 'HELLO_ELEMENTOR_VERSION', '3.4.4' );
```

**Hello Commerce:**
```php
define( 'HELLO_COMMERCE_ELEMENTOR_VERSION', '1.0.1' );
```

#### C. Existing Version Management Scripts
Hello Theme already has `.github/scripts/update-version-in-files.js` which updates:
- `./assets/scss/style.scss` 
- `./functions.php`
- `./readme.txt`

**⚠️ INTEGRATION DECISION NEEDED:**
- Keep existing JS-based version management OR replace with hello-commerce bash approach
- Current JS script targets `assets/scss/style.scss` instead of `style.css`

### 3. GitHub Actions Adaptation Requirements

#### Action 1: install-dependencies
```yaml
# Current hello-commerce implementation covers:
- PHP 7.4 setup with shivammathur/setup-php
- Composer OAuth with DEVOPS_TOKEN
- Node.js 18 setup with npm registry configuration  
- NPM authentication with CLOUD_DEVOPS_TOKEN

# Hello Theme adaptation needed: 
# - Verify compatibility with Hello Theme's more complex dependencies (sass, webpack)
# - May need enhanced npm retry logic (Hello Theme build-theme action has sophisticated retry logic)
```

#### Action 2: bump-theme-version  
```yaml
# Files to update with new version:
- package.json (version field)
- functions.php (HELLO_ELEMENTOR_VERSION constant) # CHANGED
- style.css (Version: header)
- readme.txt (Stable tag: field)

# CRITICAL: Hello Theme has assets/scss/style.scss that may also need updating
# Integration decision: Use existing update-version-in-files.js OR adapt hello-commerce bash approach
```

#### Action 3: get-changelog-from-readme
```yaml
# Functionality:
- Extract changelog section for specific version from readme.txt
- Create temporary changelog file
- Validate changelog exists and is not empty
- Set environment variable with changelog file path

# Hello Theme adaptation: No changes needed - can copy directly
```

#### Action 4: build-theme
```yaml
# REQUIRES DETAILED COMPARISON AND POTENTIAL REPLACEMENT:

# Hello Theme current build-theme features:
- Sophisticated npm retry logic with multiple fallbacks
- Advanced error handling
- Package naming: hello-elementor-${VERSION}.zip
- Uses "npm run build:prod" by default

# Hello Commerce build-theme features:
- Simpler npm installation
- Uses "npm run build" by default
- Package naming: hello-commerce-${VERSION}.zip

# RECOMMENDATION: Keep Hello Theme's build-theme action but update:
- Change package naming from hello-elementor to match repository context
- Verify script compatibility with hello-commerce workflow
```

#### Action 5: create-pr-with-bumped-theme-version
```yaml
# Functionality:
- Create PR with version-bumped files
- Auto-configure git user as github-actions[bot]
- Use peter-evans/create-pull-request action
- Include specific files: package.json, functions.php, style.css, readme.txt

# Hello Theme adaptation: No changes needed - can copy directly
```

#### Action 6: update-main-branch-version
```yaml
# Functionality:
- Compare new version with main branch version
- Only update if new version > main version
- Auto-detect default branch (main vs master)
- Handle version comparison logic

# Hello Theme adaptation: No changes needed - can copy directly
```

#### Action 7: theme-slack-notification
```yaml
# Customization needed for hello-theme:
- Update header text: "🚀 Hello Elementor v{version} Released!" # Note: Hello Elementor, not Hello Theme
- Update description: "*Hello Elementor theme* has been successfully released"
- Update manual upload instructions for hello-elementor context
- Keep same Slack formatting and structure
```

### 4. Script Adaptation Requirements

#### Script 1: validate-versions.sh
```bash
# Current hello-commerce version checks:
FUNC_VERSION=$(grep -E "define\( 'HELLO_COMMERCE_ELEMENTOR_VERSION'" functions.php)

# Hello Theme adaptation needed:
FUNC_VERSION=$(grep -E "define\( 'HELLO_ELEMENTOR_VERSION'" functions.php)

# All other logic remains the same:
- Check package.json version
- Check style.css Version header  
- Check readme.txt Stable tag
- Ensure all versions match
```

#### Script 2: generate-upload-instructions.sh
```bash
# Customizations needed for hello-theme:
echo "📋 **Hello Elementor v${PACKAGE_VERSION} - Manual Upload Instructions**"
echo "   - Theme: Hello Elementor"
echo "   - Go to GitHub Releases page"  
echo "   - Navigate to Hello Elementor theme page"
echo "   - GitHub Release: https://github.com/elementor/hello-theme/releases/tag/v${PACKAGE_VERSION}"
echo "   - WordPress.org: https://wordpress.org/themes/hello-elementor/"

# All other instruction logic remains the same
```

### 5. Configuration Updates Required

#### Update .github/config/release.json
```json
{
  "repository": {
    "name": "hello-elementor",  // ✅ Already correct
    "owner": "elementor",       // ✅ Already correct
    "main_branch": "main",      // ✅ Already correct
    "release_branches": ["3.4"] // ✅ Already correct
  },
  "security": {
    "allowed_repositories": ["elementor/hello-theme"], // ✅ Already correct
  },
  "release": {
    "wordpress_org": {
      "theme_slug": "hello-elementor"  // ✅ Already correct
    }
  }
}
```

#### Secrets Verification Required
```yaml
# Verify these secrets exist in hello-theme repository:
- DEVOPS_TOKEN              # ❓ Needs verification
- CLOUD_DEVOPS_TOKEN        # ❓ Needs verification
- SLACK_BOT_TOKEN           # ❓ Needs verification
- CLOUD_SLACK_BOT_TOKEN     # ❓ Needs verification
- GITHUB_TOKEN              # ✅ Automatically provided
```

### 6. Legacy Workflow Migration

#### Current Hello Theme Workflows to Consider
- **publish-release.yml** - Should this be replaced or kept alongside?
- **publish-patch.yml** - Should this be replaced or kept alongside?  
- **publish-beta.yml** - Should this be replaced or kept alongside?

**RECOMMENDATION:**
- Keep legacy workflows for backward compatibility
- Add new release-preparation.yml as the primary release workflow
- Document which workflow should be used going forward

### 7. Version Management Integration Decision

#### Option A: Keep Existing JS-based Version Management
**Pros:**
- Maintains consistency with existing Hello Theme approach
- No disruption to current processes
- JS script already handles assets/scss/style.scss

**Cons:**
- Different from Hello Commerce/Hello Biz approach
- Requires adapting bump-theme-version action significantly

#### Option B: Adopt Hello Commerce Bash Approach
**Pros:**
- Consistent with Hello Commerce/Hello Biz
- Minimal adaptation of bump-theme-version action
- Proven workflow in production

**Cons:**
- May not handle assets/scss/style.scss (Hello Theme specific)
- Disrupts existing Hello Theme version management

**RECOMMENDATION:** Option A - Keep existing JS approach but integrate it into the GitHub Actions workflow

### 8. Testing Strategy

#### Pre-deployment Testing
1. **Build compatibility test**: Verify hello-theme builds correctly with cloned workflow
2. **Version management test**: Ensure all files are updated consistently
3. **Legacy workflow coexistence**: Test that new workflow doesn't conflict with existing ones
4. **Dependency test**: Verify all npm/composer dependencies install correctly

#### Post-deployment Testing  
1. **End-to-end test**: Complete release process on test branch
2. **Build artifact validation**: Verify hello-elementor-{version}.zip is created correctly
3. **Version synchronization**: Ensure all version fields are updated properly
4. **Legacy workflow test**: Ensure existing workflows still function

### 9. Risk Analysis

#### High Risk Items
- **Build process differences**: Hello Theme has more complex build with sass/webpack
- **Version management integration**: Two different approaches (JS vs Bash)
- **Legacy workflow conflicts**: New workflow might interfere with existing ones
- **Package naming confusion**: hello-elementor vs hello-theme naming

#### Mitigation Strategies
- Thorough build compatibility testing with dry_run mode
- Careful integration of existing version management scripts
- Clear documentation of workflow migration path
- Comprehensive testing of all build artifacts

### 10. Questions for Clarification

#### Critical Questions:
1. **Build Action Strategy**: Should we replace the existing build-theme action with hello-commerce version, or adapt hello-commerce workflow to use hello-theme's more sophisticated build action?

2. **Version Management Approach**: Should we keep Hello Theme's existing `update-version-in-files.js` approach or adopt Hello Commerce's bash-based approach?

3. **Legacy Workflows**: Should the existing publish-*.yml workflows be deprecated, kept alongside, or replaced entirely?

4. **Package Naming**: The repository is `hello-theme` but the theme name is `hello-elementor` - confirm that build artifacts should be named `hello-elementor-{version}.zip`?

5. **SCSS Handling**: Hello Theme has `assets/scss/style.scss` that needs version updates - how should this be integrated?

6. **Release Branch Strategy**: Hello Theme uses branch "3.4" - should this be updated to match Hello Commerce pattern?

#### Build Process Questions:
7. **Build Script**: Should we use Hello Theme's `zip` script or adapt to Hello Commerce's `package:zip` pattern?

8. **Dependency Complexity**: Hello Theme has more complex dependencies (sass, webpack) - any specific adaptations needed?

#### Workflow Integration Questions:
9. **Slack Notifications**: Theme display name should be "Hello Elementor" not "Hello Theme" - confirm?

10. **WordPress.org Integration**: Should Hello Theme adopt Hello Commerce's auto-deploy feature or keep manual upload?

### 11. Implementation Checklist

#### GitHub Actions Creation
- [ ] Copy and adapt install-dependencies from hello-commerce
- [ ] Copy and adapt bump-theme-version from hello-commerce (integrate with existing JS version management)
- [ ] Copy and adapt get-changelog-from-readme from hello-commerce
- [ ] Copy and adapt create-pr-with-bumped-theme-version from hello-commerce
- [ ] Copy and adapt update-main-branch-version from hello-commerce
- [ ] Copy and adapt theme-slack-notification from hello-commerce (customize for hello-elementor)
- [ ] **DECISION REQUIRED:** Replace or adapt build-theme with hello-commerce version
- [ ] Copy create-theme-release from hello-commerce

#### Scripts Creation
- [ ] Copy and adapt validate-versions.sh (update HELLO_COMMERCE → HELLO_ELEMENTOR)
- [ ] Copy and adapt generate-upload-instructions.sh (customize for hello-elementor)

#### Workflow Setup
- [ ] Copy release-preparation.yml and customize all references
- [ ] **DECISION REQUIRED:** Deprecate or maintain existing publish-*.yml workflows
- [ ] Test with dry_run: true
- [ ] Verify all secrets are available
- [ ] Test complete end-to-end flow

#### Version Management Integration
- [ ] **DECISION REQUIRED:** Choose version management approach (JS vs Bash)
- [ ] Ensure assets/scss/style.scss is handled properly
- [ ] Test version consistency across all files

#### Compatibility Testing
- [ ] Test build process compatibility
- [ ] Verify all dependencies install correctly
- [ ] Test build artifact creation (hello-elementor-{version}.zip)
- [ ] Validate version synchronization

#### Documentation
- [ ] Update team documentation with new process
- [ ] Create migration guide from legacy workflows
- [ ] Document manual fallback procedures

## Conclusion

This PRD provides a comprehensive roadmap for cloning the hello-commerce release-preparation workflow to hello-theme. The primary complexity lies in the integration of different version management approaches and build processes. Critical decisions are needed around build action replacement and version management integration.

**Estimated Implementation Time**: 6-8 hours (more complex than Hello Biz due to build process differences)
**Primary Risk**: Version management integration and build process compatibility  
**Key Dependencies**: Build action strategy decision, version management approach decision

---

*This PRD serves as the authoritative guide for implementing the release preparation workflow in hello-theme. All implementation should follow this specification after critical decisions are resolved.*
