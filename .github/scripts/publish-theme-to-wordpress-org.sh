#!/bin/bash
set -eo pipefail

if [[ -z "$SVN_USERNAME" ]]; then
	echo "Set the SVN_USERNAME secret"
	exit 1
fi

if [[ -z "$SVN_PASSWORD" ]]; then
	echo "Set the SVN_PASSWORD secret"
	exit 1
fi

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

echo "Checkout from SVN"
svn co --depth immediates "https://themes.svn.wordpress.org/hello-elementor" .

echo "Check if version folder already exists"
if svn list "https://themes.svn.wordpress.org/hello-elementor/${VERSION_DIR}" > /dev/null 2>&1; then
	echo "ERROR: Version folder $VERSION_DIR already exists in SVN!
   SVN URL: https://themes.svn.wordpress.org/hello-elementor/${VERSION_DIR}

   WordPress.org theme versions are immutable - you cannot update an existing version.
   If you need to make changes, create a new version (e.g., increment patch/minor/major)."
	exit 1
fi

mkdir -p "$VERSION_DIR"
cd "$VERSION_DIR"
cd ..
svn add "$VERSION_DIR"
cd "$VERSION_DIR"

echo "Copy files"
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

echo "Preparing files"
cd "$VERSION_DIR"

echo "svn add"
svn status | grep -v '^.[ \t]*\\..*' | { grep '^?' || true; } | awk '{print $2}' | xargs -r svn add || true

svn status

echo "Commit files to version folder $VERSION_DIR"
svn ci -m "Upload v${THEME_VERSION}" --no-auth-cache --non-interactive --username "$SVN_USERNAME" --password "$SVN_PASSWORD"

cd $SVN_PATH
svn update

echo "Remove the SVN folder from the workspace"
rm -rf $SVN_PATH

echo "Back to the workspace root"
cd $GITHUB_WORKSPACE

echo "Theme deployment complete: v${THEME_VERSION}"
