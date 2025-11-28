#!/bin/bash
set -eo pipefail

PR_NUMBER="$1"
TARGET="$2"
ORIGINAL_BRANCH="$3"

CLEAN_BRANCH=$(echo "$ORIGINAL_BRANCH" | sed 's|^[^/]*/||g')
SANITIZED_BRANCH=$(echo "$CLEAN_BRANCH" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9]/-/g' | sed 's/--*/-/g' | sed 's/^-\|-$//g')
SANITIZED_BRANCH=${SANITIZED_BRANCH:0:35}
TIMESTAMP=$(date +%s)
BRANCH="${SANITIZED_BRANCH}-cherry-pick-pr${PR_NUMBER}-${TIMESTAMP}"

echo "$BRANCH"

