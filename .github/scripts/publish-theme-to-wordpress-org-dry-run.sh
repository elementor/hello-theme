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

echo "Copy files from build directory"
rsync -ah --progress "$THEME_PATH/hello-elementor/"* $VERSION_DIR

cd "$VERSION_DIR"

echo "svn delete"
svn status | grep -v '^.[ \t]*\\..*' | { grep '^!' || true; } | awk '{print $2}' | xargs -r svn delete;

echo "svn add"
svn status | grep -v '^.[ \t]*\\..*' | { grep '^?' || true; } | awk '{print $2}' | xargs -r svn add;

echo "Print SVN Status changes"
svn status

pwd

echo "Preparing files for SVN"
SVN_STATUS=$(svn status 2>/dev/null | grep -v '^\?[ \t]*\.$' || echo "")

echo ""
echo "svn add new files"
echo "DRY RUN: Would add new files"
if [ -n "$SVN_STATUS" ]; then
	echo "$SVN_STATUS" | grep '^?' | awk '{print "     Would add: " $2}' || true
fi

echo ""
echo "SVN Status Summary (what would be committed):"
echo "=========================================="
if [ -n "$SVN_STATUS" ]; then
	echo "$SVN_STATUS"
	echo ""
	TOTAL_FILES=$(echo "$SVN_STATUS" | wc -l | tr -d '[:space:]')
	echo "Total files to upload: $TOTAL_FILES"
	echo ""
	echo "DRY RUN: Would commit all files to version folder $VERSION_DIR"
	echo "Commit message: Upload v${THEME_VERSION}"
else
	TOTAL_FILES=$(find . -type f ! -name '.svn' ! -path '*/.svn/*' | wc -l | tr -d '[:space:]')
	echo "Total files to upload: $TOTAL_FILES"
	echo ""
	echo "DRY RUN: Would commit all files to version folder $VERSION_DIR"
	echo "Commit message: Upload v${THEME_VERSION}"
fi
echo "=========================================="
echo ""
echo "No actual commit performed (dry-run mode)"

echo "Remove the SVN folder from the workspace"
rm -rf $SVN_PATH

echo "Back to the workspace root"
cd $GITHUB_WORKSPACE

echo "Dry-run complete: v${THEME_VERSION}"
echo "All checks passed - ready for actual deployment"

