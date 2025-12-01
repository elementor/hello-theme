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
BUILD_DIR=""
if [ -d "$THEME_PATH/hello-elementor" ]; then
	BUILD_DIR="$THEME_PATH/hello-elementor"
elif [ -d "hello-elementor" ]; then
	BUILD_DIR="hello-elementor"
else
	ZIP_FILE=$(find "$THEME_PATH" -maxdepth 1 -name "hello-elementor*.zip" -type f | head -1)
	if [ -n "$ZIP_FILE" ]; then
		echo "Found zip file, extracting: $ZIP_FILE"
		unzip -q "$ZIP_FILE" -d "$THEME_PATH"
		if [ -d "$THEME_PATH/hello-elementor" ]; then
			BUILD_DIR="$THEME_PATH/hello-elementor"
		fi
	fi
fi

if [ -z "$BUILD_DIR" ] || [ ! -d "$BUILD_DIR" ]; then
	echo "ERROR: Build directory not found"
	echo "Current directory: $(pwd)"
	echo "THEME_PATH: $THEME_PATH"
	echo "Searched locations:"
	echo "  - $THEME_PATH/hello-elementor"
	echo "  - hello-elementor"
	echo ""
	echo "Available files and directories:"
	ls -la "$THEME_PATH" | head -30
	echo ""
	echo "Checking for zip files:"
	find "$THEME_PATH" -maxdepth 1 -name "hello-elementor*.zip" -type f || echo "No zip files found"
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
