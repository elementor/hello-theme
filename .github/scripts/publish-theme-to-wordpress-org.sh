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
rsync -ah --progress "$THEME_PATH/hello-elementor/"* . || rsync -ah --progress "$THEME_PATH/hello-elementor/." . || true

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
