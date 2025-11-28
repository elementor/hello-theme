#!/bin/bash
set -eo pipefail

PR_NUMBER="$1"
ORIG_URL="$2"
TARGET="$3"
SOURCE_REPO="$4"
PR_USER_LOGIN="$5"
TRIGGER_INFO="$6"

BODY="Automatic cherry-pick of [#${PR_NUMBER}](${ORIG_URL}) to \`${TARGET}\` branch.

**Source:** ${SOURCE_REPO}
**Original Author:** @${PR_USER_LOGIN}${TRIGGER_INFO}"

echo "$BODY"

