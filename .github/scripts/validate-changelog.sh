#!/bin/bash
set -eo pipefail

if [[ -z "$VERSION" ]]; then
	echo "Set the VERSION env var"
	exit 1
fi

if [[ ! -f "readme.txt" ]]; then
	echo "readme.txt file does not exist"
	exit 1
fi

if ! grep -q "= ${VERSION} -" readme.txt; then
	echo "readme.txt file does not contain changelog entry for version: ${VERSION}"
	echo "Expected format: = ${VERSION} - DATE"
	exit 1
fi

