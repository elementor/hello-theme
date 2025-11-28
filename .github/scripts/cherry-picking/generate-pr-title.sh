#!/bin/bash
set -eo pipefail

PR_TITLE="$1"
PR_NUMBER="$2"
TARGET="$3"

TYPE=$(echo "$PR_TITLE" | grep -oE '^[A-Za-z]+:' | head -1)
if [ -z "$TYPE" ]; then
  TYPE="Internal:"
fi

DESCRIPTION=$(echo "$PR_TITLE" | sed 's/^[A-Za-z]*: *//')
TITLE="${TYPE} Cherry-pick PR ${PR_NUMBER} to ${TARGET} ${DESCRIPTION}"

echo "$TITLE"

