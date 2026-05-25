#!/bin/bash
set -eo pipefail

VERSION_REF_SCRIPT_USAGE="Usage: resolve-version-ref.sh <command> <version> [--fetch]

Commands:
  resolve                 Print the matching git ref (v, V, or bare version)
  exists                  Exit 0 when a matching ref exists, 1 otherwise
  checkout                Check out the matching ref
  extract-playwright-tests
                          Extract tests/playwright/ from the matching ref and write workflow outputs"

version_ref_candidates() {
	local version="$1"
	printf '%s\n' "v${version}" "V${version}" "${version}"
}

maybe_fetch_tags() {
	if [[ "${1:-}" == "--fetch" ]]; then
		git fetch --all --tags --force
	fi
}

find_version_ref() {
	local version="$1"
	local candidate

	while IFS= read -r candidate; do
		if git rev-parse --verify "$candidate" >/dev/null 2>&1; then
			echo "$candidate"
			return 0
		fi
	done < <(version_ref_candidates "$version")

	return 1
}

write_github_output() {
	local key="$1"
	local value="$2"

	if [[ -n "${GITHUB_OUTPUT:-}" ]]; then
		echo "${key}=${value}" >>"$GITHUB_OUTPUT"
	else
		echo "${key}=${value}"
	fi
}

cmd_resolve() {
	local version="$1"
	shift

	maybe_fetch_tags "$@"

	find_version_ref "$version"
}

cmd_exists() {
	cmd_resolve "$@" >/dev/null
}

report_version_not_found() {
	local version="$1"

	echo "ERROR: Version ${version} not found"
	git tag --sort=-version:refname | head -20 || true
}

cmd_checkout() {
	local version="$1"
	shift
	local ref

	if [[ "$version" == "main" ]]; then
		echo "ERROR: Cannot checkout main with resolve-version-ref.sh"
		return 1
	fi

	maybe_fetch_tags "$@"

	if ! ref="$(find_version_ref "$version")"; then
		report_version_not_found "$version"
		return 1
	fi

	if ! git checkout "$ref" 2>/dev/null; then
		echo "ERROR: Failed to checkout ${ref}"
		return 1
	fi

	echo "Checked out ${ref}"
}

cmd_extract_playwright_tests() {
	local version="$1"
	shift
	local candidate
	local tests_available="false"
	local test_version="$version"
	local test_source_type="version-specific"

	maybe_fetch_tags "$@"

	if [[ "$version" == "main" ]]; then
		echo "Using main branch tests (already available)"
		write_github_output "test-version" "main"
		write_github_output "test-source-type" "main-branch"
		write_github_output "tests-available" "true"
		return 0
	fi

	echo "Extracting tests from version: ${version}"

	while IFS= read -r candidate; do
		echo "Checking for tag: ${candidate}"

		if ! git rev-parse --verify "$candidate" >/dev/null 2>&1; then
			echo "Tag ${candidate} not found"
			continue
		fi

		echo "Found tag: ${candidate}"

		if ! git ls-tree -r "$candidate" | grep -q "tests/playwright/"; then
			echo "No playwright tests found in ${candidate}"
			continue
		fi

		echo "Playwright tests found in ${candidate}"
		echo "Extracting tests directory from ${candidate}..."
		rm -rf ./tests/playwright/
		git archive "$candidate" tests/playwright/ | tar -x

		if [[ -d "./tests/playwright/" ]]; then
			echo "Successfully extracted tests from ${candidate}"
			tests_available="true"
			test_version="$version"
			test_source_type="extracted-from-${candidate}"
			break
		fi

		echo "Failed to extract tests from ${candidate}"
	done < <(version_ref_candidates "$version")

	if [[ "$tests_available" != "true" ]]; then
		echo "No compatible tests found for version ${version}"
		echo "Will skip testing for this version (tests don't exist yet)"
		test_version="none"
		test_source_type="not-available"
	fi

	write_github_output "test-version" "$test_version"
	write_github_output "test-source-type" "$test_source_type"
	write_github_output "tests-available" "$tests_available"
}

main() {
	local command="${1:-}"

	if [[ -z "$command" ]]; then
		echo "$VERSION_REF_SCRIPT_USAGE"
		exit 1
	fi

	shift

	case "$command" in
	resolve)
		cmd_resolve "$@"
		;;
	exists)
		cmd_exists "$@"
		;;
	checkout)
		cmd_checkout "$@"
		;;
	extract-playwright-tests)
		cmd_extract_playwright_tests "$@"
		;;
	*)
		echo "$VERSION_REF_SCRIPT_USAGE"
		exit 1
		;;
	esac
}

main "$@"
