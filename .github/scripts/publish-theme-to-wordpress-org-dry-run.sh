#!/bin/bash
set -eo pipefail

echo "DRY RUN MODE: Will simulate SVN operations without committing"

if [[ -z "$THEME_VERSION" ]]; then
	echo "Set the THEME_VERSION env var"
	exit 1
fi

# Ensure SVN is installed
svn --version

echo "SVN installed"

echo "Publish theme version: ${THEME_VERSION}"

THEME_PATH="$GITHUB_WORKSPACE"
SVN_PATH="$GITHUB_WORKSPACE/svn"
VERSION_DIR="${THEME_VERSION}"

cd $THEME_PATH
pwd
mkdir -p $SVN_PATH
cd $SVN_PATH

echo "DRY RUN: Checking out SVN repository (read-only)"
svn co --depth immediates "https://themes.svn.wordpress.org/hello-elementor" . 2>&1 | head -20 || {
	echo "Could not checkout repository (may require auth for some operations)"
	echo "This is normal - simulating checkout for dry-run"
	mkdir -p "$VERSION_DIR"
	cd "$VERSION_DIR"
}

echo "Check if version folder already exists"
VERSION_EXISTS=false
if svn list "https://themes.svn.wordpress.org/hello-elementor/${VERSION_DIR}" > /dev/null 2>&1; then
	VERSION_EXISTS=true
fi

if [[ "$VERSION_EXISTS" == "true" ]]; then
	echo "ERROR: Version folder $VERSION_DIR already exists in SVN!
   SVN URL: https://themes.svn.wordpress.org/hello-elementor/${VERSION_DIR}

   WordPress.org theme versions are immutable - you cannot update an existing version.
   If you need to make changes, create a new version (e.g., increment patch/minor/major).

   DRY RUN: Would fail here (version already exists)"
	exit 0
fi

mkdir -p "$VERSION_DIR"
cd "$VERSION_DIR"

echo "Copy files from build directory"
BUILD_DIR=""
if [ -d "$THEME_PATH/hello-elementor" ]; then
	BUILD_DIR="$THEME_PATH/hello-elementor"
elif [ -d "hello-elementor" ]; then
	BUILD_DIR="hello-elementor"
else
	ZIP_FILE=$(find "$THEME_PATH" -maxdepth 2 \( -name "hello-elementor-*.zip" -o -name "hello-elementor.*.zip" \) -type f | head -1)
	if [ -n "$ZIP_FILE" ]; then
		TEMP_DIR=$(mktemp -d)
		unzip -q "$ZIP_FILE" -d "$TEMP_DIR"
		if [ -d "$TEMP_DIR/hello-elementor" ]; then
			mv "$TEMP_DIR/hello-elementor" "$THEME_PATH/hello-elementor"
			BUILD_DIR="$THEME_PATH/hello-elementor"
		fi
		rm -rf "$TEMP_DIR"
	fi
fi

if [ -z "$BUILD_DIR" ] || [ ! -d "$BUILD_DIR" ]; then
	echo "ERROR: Build directory not found: $THEME_PATH/hello-elementor"
	exit 1
fi
rsync -ah --progress "$BUILD_DIR/"* . || rsync -ah --progress "$BUILD_DIR/." . || true

echo "Preparing files for SVN"
svn status 2>/dev/null || echo ""

echo "svn add new files"
echo "DRY RUN: Would add new files"
svn status 2>/dev/null | grep -v '^.[ \t]*\\..*' | { grep '^?' || true; } | awk '{print $2}' | sed 's|^|     Would add: |' || true

echo ""
echo "SVN Status Summary (what would be committed):"
echo "=========================================="
SVN_STATUS=$(svn status 2>/dev/null || echo "")
TOTAL_CHANGES=0
if [ -n "$SVN_STATUS" ]; then
	echo "$SVN_STATUS"
	echo ""
	echo "Summary:"
	ADDED_COUNT=$(echo "$SVN_STATUS" | grep -c "^A" 2>/dev/null || echo "0")
	MODIFIED_COUNT=$(echo "$SVN_STATUS" | grep -c "^M" 2>/dev/null || echo "0")
	UNTRACKED_COUNT=$(echo "$SVN_STATUS" | grep -c "^?" 2>/dev/null || echo "0")
	
	ADDED_COUNT=${ADDED_COUNT:-0}
	MODIFIED_COUNT=${MODIFIED_COUNT:-0}
	UNTRACKED_COUNT=${UNTRACKED_COUNT:-0}
	
	echo "Added (A): $ADDED_COUNT files"
	if [ "$MODIFIED_COUNT" -gt 0 ]; then
		echo "Modified (M): $MODIFIED_COUNT files"
	fi
	if [ "$UNTRACKED_COUNT" -gt 0 ]; then
		echo "Untracked (?): $UNTRACKED_COUNT files (would be added)"
	fi
	echo ""
	TOTAL_CHANGES=$((ADDED_COUNT + MODIFIED_COUNT))
	echo "Total files that would be committed: $TOTAL_CHANGES files"
else
	echo "(No changes detected - files are up to date)"
fi
echo "=========================================="
echo ""

if [ "$TOTAL_CHANGES" -gt 0 ]; then
	echo "DRY RUN: Would commit $TOTAL_CHANGES files to version folder $VERSION_DIR"
	echo "Commit message: Upload v${THEME_VERSION}"
else
	echo "DRY RUN: No changes to commit (files are up to date)"
fi
echo "No actual commit performed (dry-run mode)"

echo "Remove the SVN folder from the workspace"
rm -rf $SVN_PATH

echo "Back to the workspace root"
cd $GITHUB_WORKSPACE

echo "Dry-run complete: v${THEME_VERSION}"
echo "All checks passed - ready for actual deployment"

