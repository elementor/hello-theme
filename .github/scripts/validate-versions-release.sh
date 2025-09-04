#!/bin/bash
set -eo pipefail

# validate-versions-release.sh - Validate version consistency across Hello Elementor theme files

echo "🔍 Validating Hello Elementor theme version consistency..."

# Get expected version from package.json
EXPECTED_VERSION=$(node -p "require('./package.json').version")
echo "Expected version: $EXPECTED_VERSION"

# Validate functions.php (Hello Theme uses HELLO_ELEMENTOR_VERSION)
FUNC_VERSION=$(grep -E "define\( 'HELLO_ELEMENTOR_VERSION'" functions.php | awk -F"'" '{print $4}')
if [ "$FUNC_VERSION" != "$EXPECTED_VERSION" ]; then
  echo "❌ Version mismatch: functions.php ($FUNC_VERSION) != package.json ($EXPECTED_VERSION)"
  exit 1
fi
echo "✅ functions.php HELLO_ELEMENTOR_VERSION: $FUNC_VERSION"

# Validate style.css
CSS_VERSION=$(grep -E "Version:" style.css | awk '{print $2}')
if [ "$CSS_VERSION" != "$EXPECTED_VERSION" ]; then
  echo "❌ Version mismatch: style.css ($CSS_VERSION) != package.json ($EXPECTED_VERSION)"
  exit 1
fi
echo "✅ style.css Version: $CSS_VERSION"

# Validate assets/scss/style.scss if it exists (Hello Theme specific)
if [ -f "assets/scss/style.scss" ]; then
  SCSS_VERSION=$(grep -E "Version:" assets/scss/style.scss | awk '{print $2}')
  if [ "$SCSS_VERSION" != "$EXPECTED_VERSION" ]; then
    echo "❌ Version mismatch: assets/scss/style.scss ($SCSS_VERSION) != package.json ($EXPECTED_VERSION)"
    exit 1
  fi
  echo "✅ assets/scss/style.scss Version: $SCSS_VERSION"
  
  # Also check Stable tag in SCSS file
  SCSS_STABLE_TAG=$(grep -E "Stable tag:" assets/scss/style.scss | awk '{print $3}')
  if [ "$SCSS_STABLE_TAG" != "$EXPECTED_VERSION" ]; then
    echo "❌ Version mismatch: assets/scss/style.scss Stable tag ($SCSS_STABLE_TAG) != package.json ($EXPECTED_VERSION)"
    exit 1
  fi
  echo "✅ assets/scss/style.scss Stable tag: $SCSS_STABLE_TAG"
else
  echo "ℹ️ No assets/scss/style.scss found, skipping SCSS validation"
fi

# Validate readme.txt stable tag
README_VERSION=$(grep -E "Stable tag:" readme.txt | awk '{print $3}')
if [ "$README_VERSION" != "$EXPECTED_VERSION" ]; then
  echo "❌ Version mismatch: readme.txt Stable tag ($README_VERSION) != package.json ($EXPECTED_VERSION)"
  exit 1
fi
echo "✅ readme.txt Stable tag: $README_VERSION"

# Validate readme.txt version field if it exists
if grep -q "^Version:" readme.txt; then
  README_VERSION_FIELD=$(grep -E "^Version:" readme.txt | awk '{print $2}')
  if [ "$README_VERSION_FIELD" != "$EXPECTED_VERSION" ]; then
    echo "❌ Version mismatch: readme.txt Version field ($README_VERSION_FIELD) != package.json ($EXPECTED_VERSION)"
    exit 1
  fi
  echo "✅ readme.txt Version field: $README_VERSION_FIELD"
else
  echo "ℹ️ No Version field found in readme.txt"
fi

echo ""
echo "🎉 All versions match: $EXPECTED_VERSION"
echo "✅ Hello Elementor theme version validation passed!"
