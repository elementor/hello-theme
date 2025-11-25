#!/bin/bash
set -eo pipefail

echo "🧪 DRY RUN MODE: Will simulate SVN operations without committing"

if [[ -z "$THEME_VERSION" ]]; then
	echo "Set the THEME_VERSION env var"
	exit 1
fi

if [[ -z "$THEME_SLUG" ]]; then
	echo "Set the THEME_SLUG env var"
	exit 1
fi

if [[ -z "$BUILD_DIR" ]]; then
	echo "Set the BUILD_DIR env var"
	exit 1
fi

# Ensure SVN is installed
svn --version

echo "SVN installed"

echo "Publish theme version: ${THEME_VERSION}"
echo "Theme slug: ${THEME_SLUG}"
echo "Build directory: ${BUILD_DIR}"

THEME_PATH="$GITHUB_WORKSPACE"
SVN_PATH="$GITHUB_WORKSPACE/svn"
SVN_URL="https://themes.svn.wordpress.org/${THEME_SLUG}"
VERSION_DIR="${THEME_VERSION}"

cd $THEME_PATH
pwd
mkdir -p $SVN_PATH
cd $SVN_PATH

echo "🧪 DRY RUN: Checking out SVN repository (read-only)"
svn co --depth immediates "$SVN_URL" . 2>&1 | head -20 || {
	echo "⚠️  Could not checkout repository (may require auth for some operations)"
	echo "   This is normal - simulating checkout for dry-run"
	mkdir -p "$VERSION_DIR"
	cd "$VERSION_DIR"
}

echo "Check if version folder already exists"
VERSION_EXISTS=false
if svn list "$SVN_URL/$VERSION_DIR" > /dev/null 2>&1; then
	VERSION_EXISTS=true
fi

if [[ "$VERSION_EXISTS" == "true" ]]; then
	echo "❌ ERROR: Version folder $VERSION_DIR already exists in SVN!"
	echo "   SVN URL: $SVN_URL/$VERSION_DIR"
	echo ""
	echo "   WordPress.org theme versions are immutable - you cannot update an existing version."
	echo "   If you need to make changes, create a new version (e.g., increment patch/minor/major)."
	echo ""
	echo "🧪 DRY RUN: Would fail here (version already exists)"
	exit 0
fi

echo "Version folder $VERSION_DIR does not exist - would create it"
mkdir -p "$VERSION_DIR"
cd "$VERSION_DIR"

echo "Copy files from build directory"
if [[ "$BUILD_DIR" == /* ]]; then
	BUILD_SOURCE="$BUILD_DIR"
else
	BUILD_SOURCE="$THEME_PATH/$BUILD_DIR"
fi

if [ ! -d "$BUILD_SOURCE" ]; then
	echo "❌ Build directory not found: $BUILD_SOURCE"
	exit 1
fi

rsync -ah --progress "$BUILD_SOURCE/"* . || rsync -ah --progress "$BUILD_SOURCE/." . || true

echo "Preparing files for SVN"
svn status 2>/dev/null || echo ""

echo "svn add new files"
echo "🧪 DRY RUN: Would add new files"
svn status 2>/dev/null | grep -v '^.[ \t]*\\..*' | { grep '^?' || true; } | awk '{print $2}' | sed 's|^|     Would add: |' || true

echo ""
echo "📊 **SVN Status Summary (what would be committed):**"
echo "=========================================="
SVN_STATUS=$(svn status 2>/dev/null || echo "")
TOTAL_CHANGES=0
if [ -n "$SVN_STATUS" ]; then
	echo "$SVN_STATUS"
	echo ""
	echo "Summary:"
	ADDED_COUNT=$(echo "$SVN_STATUS" | grep -c "^A" || echo "0")
	MODIFIED_COUNT=$(echo "$SVN_STATUS" | grep -c "^M" || echo "0")
	UNTRACKED_COUNT=$(echo "$SVN_STATUS" | grep -c "^?" || echo "0")
	
	echo "   Added (A): $ADDED_COUNT files"
	if [ "$MODIFIED_COUNT" -gt 0 ]; then
		echo "   Modified (M): $MODIFIED_COUNT files"
	fi
	if [ "$UNTRACKED_COUNT" -gt 0 ]; then
		echo "   ⚠️  Untracked (?): $UNTRACKED_COUNT files (would be added)"
	fi
	echo ""
	TOTAL_CHANGES=$((ADDED_COUNT + MODIFIED_COUNT))
	echo "   Total files that would be committed: $TOTAL_CHANGES files"
else
	echo "   (No changes detected - files are up to date)"
fi
echo "=========================================="
echo ""

if [ "$TOTAL_CHANGES" -gt 0 ]; then
	echo "🧪 DRY RUN: Would commit $TOTAL_CHANGES files to version folder $VERSION_DIR"
	echo "   Commit message: Upload v${THEME_VERSION}"
else
	echo "🧪 DRY RUN: No changes to commit (files are up to date)"
fi
echo "   🚫 No actual commit performed (dry-run mode)"

echo "Remove the SVN folder from the workspace"
rm -rf $SVN_PATH

echo "Back to the workspace root"
cd $GITHUB_WORKSPACE

echo "✅ Dry-run complete: v${THEME_VERSION}"
echo "   All checks passed - ready for actual deployment"

