#!/bin/bash
set -euo pipefail

REPORT_FILE="${THEME_CHECK_REPORT:-theme-check-report.txt}"
COMMENT_FILE="${THEME_CHECK_COMMENT:-theme-check-comment.md}"
MAX_COMMENT_BYTES="${THEME_CHECK_MAX_COMMENT_BYTES:-58000}"

ZIP=$(find . -maxdepth 1 -name 'hello-elementor*.zip' -type f | head -1)
cp "$ZIP" tests/wp-env/config/hello-elementor-dist.zip

set +e
npx wp-env run cli bash hello-elementor-config/theme-check.sh > "$REPORT_FILE" 2>&1
EXIT_CODE=$?
set -e

if [[ -n "${GITHUB_OUTPUT:-}" ]]; then
	echo "exit_code=${EXIT_CODE}" >> "$GITHUB_OUTPUT"
fi

if [[ "${EXIT_CODE}" -eq 0 ]]; then
	STATUS_LABEL="passed"
else
	STATUS_LABEL="failed"
fi

{
	echo "<!-- hello-elementor-theme-check -->"
	echo "## WordPress Theme Check"
	echo
	echo "Status: **${STATUS_LABEL}** (exit code ${EXIT_CODE})"
	echo
	echo "Ran [Theme Check](https://github.com/WordPress/theme-check) against the packaged \`hello-elementor\` zip."
	echo
	echo '```text'
	if [[ "$(wc -c < "$REPORT_FILE")" -gt "${MAX_COMMENT_BYTES}" ]]; then
		head -c "${MAX_COMMENT_BYTES}" "$REPORT_FILE"
		echo
		echo "... output truncated to fit the GitHub comment size limit. Full report is attached as the theme-check-report artifact."
	else
		cat "$REPORT_FILE"
	fi
	echo '```'
} > "$COMMENT_FILE"

exit "${EXIT_CODE}"
