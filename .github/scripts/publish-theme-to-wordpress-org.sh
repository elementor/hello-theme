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

THEME_PATH="$GITHUB_WORKSPACE"
SVN_PATH="$GITHUB_WORKSPACE/svn"
SVN_URL="https://themes.svn.wordpress.org/${THEME_SLUG}"
VERSION_DIR="${THEME_VERSION}"

cd $THEME_PATH
pwd
mkdir -p $SVN_PATH
cd $SVN_PATH

echo "Checkout from SVN"
svn co --depth immediates "$SVN_URL" .

echo "Check if version folder already exists"
if svn list "$SVN_URL/$VERSION_DIR" > /dev/null 2>&1; then
	echo "❌ ERROR: Version folder $VERSION_DIR already exists in SVN!"
	echo "   SVN URL: $SVN_URL/$VERSION_DIR"
	echo ""
	echo "   WordPress.org theme versions are immutable - you cannot update an existing version."
	echo "   If you need to make changes, create a new version (e.g., increment patch/minor/major)."
	exit 1
fi

echo "Version folder $VERSION_DIR does not exist - will create it"
mkdir -p "$VERSION_DIR"
cd "$VERSION_DIR"
cd ..
svn add "$VERSION_DIR"
cd "$VERSION_DIR"

echo "Copy files"
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
