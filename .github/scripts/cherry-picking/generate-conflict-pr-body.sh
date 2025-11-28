#!/bin/bash
set -eo pipefail

PR_NUMBER="$1"
ORIG_URL="$2"
TARGET="$3"
CONFLICT_BRANCH="$4"
TRIGGER_INFO="$5"

BODY="**Manual Resolution Required**

This cherry-pick of [#${PR_NUMBER}](${ORIG_URL}) to \`${TARGET}\` branch has conflicts that need manual resolution.

**Conflict Files:**
The conflicted files are included in this branch with conflict markers.

**Resolution Steps:**
1. Check out this branch: \`git checkout $CONFLICT_BRANCH\`
2. Resolve conflicts in the marked files
3. Stage resolved files: \`git add <resolved-files>\`
4. Amend the commit: \`git commit --amend\`
5. Push changes: \`git push --force-with-lease\`
6. Mark this PR as ready for review

**Original PR:** [#${PR_NUMBER}](${ORIG_URL})${TRIGGER_INFO}"

echo "$BODY"

