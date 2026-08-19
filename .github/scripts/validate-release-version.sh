#!/bin/bash
set -eo pipefail

if [[ -z "$INPUT_VERSION" ]]; then
	echo "::error::INPUT_VERSION env var is required"
	exit 1
fi

if [[ ! "$INPUT_VERSION" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
	echo "::error::Version must be stable SemVer (X.Y.Z). Got: $INPUT_VERSION"
	exit 1
fi

CURRENT_VERSION=$(node -p "require('./package.json').version")

version_to_number() {
	local version="$1"
	local major minor patch
	IFS='.' read -r major minor patch <<< "$version"
	echo $((major * 1000000 + minor * 1000 + patch))
}

INPUT_NUM=$(version_to_number "$INPUT_VERSION")
CURRENT_NUM=$(version_to_number "$CURRENT_VERSION")

if [ "$INPUT_NUM" -le "$CURRENT_NUM" ]; then
	echo "::error::Input version ($INPUT_VERSION) must be greater than current version ($CURRENT_VERSION)"
	exit 1
fi

if git rev-parse "refs/tags/v${INPUT_VERSION}" >/dev/null 2>&1; then
	echo "::error::Tag v${INPUT_VERSION} already exists"
	exit 1
fi

echo "Release version ${INPUT_VERSION} is valid (current: ${CURRENT_VERSION})"
