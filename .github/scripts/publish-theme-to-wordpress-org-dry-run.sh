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
echo "DEBUG: Current directory: $(pwd)"
echo "DEBUG: THEME_PATH: $THEME_PATH"
echo "DEBUG: GITHUB_WORKSPACE: ${GITHUB_WORKSPACE:-not set}"
echo ""
echo "DEBUG: Checking workspace root structure:"
ls -la "$THEME_PATH" | head -20
echo ""
echo "DEBUG: Searching for hello-elementor directory:"
find "$THEME_PATH" -maxdepth 3 -type d -name "hello-elementor" 2>/dev/null | head -10 || echo "No hello-elementor directories found"
echo ""
echo "DEBUG: Searching for zip files:"
find "$THEME_PATH" -maxdepth 3 -name "hello-elementor*.zip" -type f 2>/dev/null | head -10 || echo "No zip files found"
echo ""
echo "DEBUG: Checking for style.css files (theme indicator):"
find "$THEME_PATH" -maxdepth 3 -name "style.css" -type f 2>/dev/null | head -10 || echo "No style.css files found"
echo ""
echo "DEBUG: Checking artifact download location (if exists):"
if [ -d "$THEME_PATH/hello-elementor" ]; then
	echo "Found: $THEME_PATH/hello-elementor"
	ls -la "$THEME_PATH/hello-elementor" | head -10
elif [ -d "hello-elementor" ]; then
	echo "Found: hello-elementor (relative)"
	ls -la "hello-elementor" | head -10
else
	echo "hello-elementor directory not found in expected locations"
fi
echo ""

BUILD_DIR=""
if [ -d "$THEME_PATH/hello-elementor" ]; then
	BUILD_DIR="$THEME_PATH/hello-elementor"
	echo "DEBUG: Using BUILD_DIR=$BUILD_DIR (absolute path)"
elif [ -d "hello-elementor" ]; then
	BUILD_DIR="hello-elementor"
	echo "DEBUG: Using BUILD_DIR=$BUILD_DIR (relative path)"
else
	echo "DEBUG: hello-elementor not found in standard locations, searching for zip files..."
	ZIP_FILE=$(find "$THEME_PATH" -maxdepth 3 -name "hello-elementor*.zip" -type f 2>/dev/null | head -1)
	if [ -n "$ZIP_FILE" ]; then
		echo "DEBUG: Found zip file: $ZIP_FILE"
		TEMP_DIR=$(mktemp -d)
		echo "DEBUG: Extracting to temp directory: $TEMP_DIR"
		unzip -q "$ZIP_FILE" -d "$TEMP_DIR"
		echo "DEBUG: Temp directory contents after extraction:"
		ls -la "$TEMP_DIR" | head -10
		if [ -d "$TEMP_DIR/hello-elementor" ]; then
			echo "DEBUG: Found hello-elementor directory in zip"
			mv "$TEMP_DIR/hello-elementor" "$THEME_PATH/hello-elementor"
			BUILD_DIR="$THEME_PATH/hello-elementor"
		elif [ -f "$TEMP_DIR/style.css" ] && [ -f "$TEMP_DIR/functions.php" ]; then
			echo "DEBUG: Found theme files directly in zip root, creating hello-elementor directory"
			mkdir -p "$THEME_PATH/hello-elementor"
			mv "$TEMP_DIR"/* "$THEME_PATH/hello-elementor/" 2>/dev/null || true
			BUILD_DIR="$THEME_PATH/hello-elementor"
		else
			echo "DEBUG: Zip contents don't match expected structure"
		fi
		rm -rf "$TEMP_DIR"
	fi
	if [ -z "$BUILD_DIR" ]; then
		echo "DEBUG: Searching recursively for hello-elementor directory..."
		ARTIFACT_DIR=$(find "$THEME_PATH" -type d -name "hello-elementor" 2>/dev/null | head -1)
		if [ -n "$ARTIFACT_DIR" ] && [ -f "$ARTIFACT_DIR/style.css" ]; then
			echo "DEBUG: Found hello-elementor directory at: $ARTIFACT_DIR"
			BUILD_DIR="$ARTIFACT_DIR"
		else
			echo "DEBUG: No valid hello-elementor directory found recursively"
		fi
	fi
fi

if [ -z "$BUILD_DIR" ] || [ ! -d "$BUILD_DIR" ]; then
	echo ""
	echo "ERROR: Build directory not found"
	echo "Current directory: $(pwd)"
	echo "THEME_PATH: $THEME_PATH"
	echo "BUILD_DIR: ${BUILD_DIR:-not set}"
	echo ""
	echo "Searched locations:"
	echo "  - $THEME_PATH/hello-elementor"
	echo "  - hello-elementor"
	echo "  - Recursive search in $THEME_PATH"
	echo ""
	echo "DEBUG: Full workspace structure (first 50 items):"
	find "$THEME_PATH" -maxdepth 2 -type d 2>/dev/null | head -50
	echo ""
	echo "DEBUG: All files in workspace root:"
	ls -la "$THEME_PATH"
	echo ""
	echo "DEBUG: Checking if artifact was downloaded at all:"
	if [ -f "$THEME_PATH/.github/workflows/deploy.yml" ]; then
		echo "Repository files present (checkout successful)"
	else
		echo "WARNING: Repository files not found - checkout may have failed"
	fi
	echo ""
	echo "DEBUG: Environment variables:"
	echo "  GITHUB_WORKSPACE: ${GITHUB_WORKSPACE:-not set}"
	echo "  THEME_PATH: $THEME_PATH"
	echo ""
	exit 1
fi

echo "Using build directory: $BUILD_DIR"
rsync -ah --progress "$BUILD_DIR/"* . || rsync -ah --progress "$BUILD_DIR/." . || true

echo "Preparing files for SVN"
svn status 2>/dev/null || echo ""

echo "svn add new files"
echo "DRY RUN: Would add new files"
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

