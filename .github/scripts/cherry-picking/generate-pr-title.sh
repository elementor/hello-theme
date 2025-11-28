#!/bin/bash
set -eo pipefail

PR_TITLE="$1"
PR_NUMBER="$2"
TARGET="$3"

PR_TICKETS=$(echo "$PR_TITLE" | grep -o '\[[A-Z]\{2,\}-[0-9]\+\]' | tr '\n' ' ' | sed 's/[[:space:]]*$//')

if [ -n "$PR_TICKETS" ]; then
  TITLE_WITHOUT_TICKETS=$(echo "$PR_TITLE" | sed 's/\[[A-Z]\{2,\}-[0-9]\+\]//g' | sed 's/[[:space:]]*$//')
  CHERRY_PICK_TITLE="$TITLE_WITHOUT_TICKETS (CP #${PR_NUMBER}→${TARGET}) ${PR_TICKETS}"
else
  CHERRY_PICK_TITLE="$PR_TITLE (CP #${PR_NUMBER}→${TARGET})"
fi

echo "$CHERRY_PICK_TITLE"

