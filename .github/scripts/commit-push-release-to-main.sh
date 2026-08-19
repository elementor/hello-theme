#!/bin/bash
set -eo pipefail

if [[ -z "$PACKAGE_VERSION" ]]; then
	echo "::error::PACKAGE_VERSION env var is required"
	exit 1
fi

if [[ -z "$MAIN_LEASE_SHA" ]]; then
	echo "::error::MAIN_LEASE_SHA env var is required"
	exit 1
fi

bash "${GITHUB_WORKSPACE}/.github/scripts/set-git-user.sh"

git add package.json package-lock.json functions.php readme.txt style.css

git commit -m "Release ${PACKAGE_VERSION}"

git push --force-with-lease=refs/heads/main:${MAIN_LEASE_SHA} origin main
