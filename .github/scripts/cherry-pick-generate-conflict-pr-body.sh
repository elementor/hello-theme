#!/bin/bash
set -eo pipefail

PR_NUMBER="$1"
ORIG_URL="$2"
TARGET="$3"
CONFLICT_BRANCH="$4"
TRIGGER_INFO="$5"

BODY="**Manual Resolution Required**

This cherry-pick of [#${PR_NUMBER}](${ORIG_URL}) to \`${TARGET}\` branch has conflicts that need manual resolution.

**Resolution Steps:**
1. Resolve conflicts in the marked files
2. Stage resolved files: \`git add <resolved-files>\`
3. Amend the commit: \`git commit --amend\`
4. Push changes: \`git push --force-with-lease\`

**Original PR:** [#${PR_NUMBER}](${ORIG_URL})${TRIGGER_INFO}"

echo "$BODY"

