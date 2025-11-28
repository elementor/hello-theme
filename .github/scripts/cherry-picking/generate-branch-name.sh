#!/bin/bash
set -eo pipefail

PR_NUMBER="$1"
TARGET="$2"

TARGET_SAFE=$(echo "$TARGET" | sed 's/\./_/g')
BRANCH="cherry-pick-pr${PR_NUMBER}_to_${TARGET_SAFE}"

echo "$BRANCH"

