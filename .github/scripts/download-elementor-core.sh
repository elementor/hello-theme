#!/usr/bin/env bash
set -euo pipefail

ELEMENTOR_CORE_BRANCH="${1:?Elementor core branch or version required}"
TARGET_DIR="${2:-./tmp/elementor}"

log_cloud_devops_token_status() {
	echo "=== CLOUD_DEVOPS_TOKEN verification ==="
	if [ -z "${GITHUB_TOKEN:-}" ]; then
		echo "CLOUD_DEVOPS_TOKEN: NOT AVAILABLE (GITHUB_TOKEN env is empty or unset)"
		echo "install-source=none" >> "${GITHUB_OUTPUT}"
		return 1
	fi

	echo "CLOUD_DEVOPS_TOKEN: available (character length=${#GITHUB_TOKEN})"

	local repo_http_status
	repo_http_status=$(curl -sS -o /dev/null -w "%{http_code}" \
		-H "Authorization: Bearer ${GITHUB_TOKEN}" \
		-H "Accept: application/vnd.github+json" \
		"https://api.github.com/repos/elementor/elementor")

	echo "GitHub API repos/elementor/elementor: HTTP ${repo_http_status}"

	if [ "${repo_http_status}" != "200" ]; then
		echo "CLOUD_DEVOPS_TOKEN: cannot read elementor/elementor (expected HTTP 200)"
		return 1
	fi

	echo "CLOUD_DEVOPS_TOKEN: repository access OK"
	return 0
}

write_outputs() {
	local effective_version="$1"
	local install_source="$2"
	echo "effective-version=${effective_version}" >> "${GITHUB_OUTPUT}"
	echo "install-source=${install_source}" >> "${GITHUB_OUTPUT}"
}

download_from_wordpress_org() {
	local version_label="$1"
	local download_url="$2"

	echo "Downloading Elementor from WordPress.org: ${version_label}"
	curl --location -o ./elementor-core.zip "${download_url}"
	unzip -q ./elementor-core.zip
	rm -rf "${TARGET_DIR}"
	mkdir -p "$(dirname "${TARGET_DIR}")"
	mv ./elementor "${TARGET_DIR}"
	rm -f ./elementor-core.zip
	echo "Elementor ${version_label} downloaded from WordPress.org"
	write_outputs "${version_label}" "wordpress"
}

download_from_github_artifact() {
	local branch="$1"

	echo "Downloading Elementor from GitHub Actions artifact (branch: ${branch})"

	if ! log_cloud_devops_token_status; then
		echo "Missing or invalid CLOUD_DEVOPS_TOKEN; cannot download GitHub artifacts"
		exit 1
	fi

	local api_url runs_json run_id arts_json first_artifact artifact_name artifact_url

	api_url="https://api.github.com/repos/elementor/elementor/actions/workflows/build.yml/runs?branch=${branch}&status=success&event=push&per_page=1"
	runs_json=$(curl -sS -H "Authorization: Bearer ${GITHUB_TOKEN}" -H "Accept: application/vnd.github+json" "${api_url}")

	local runs_http_status
	runs_http_status=$(curl -sS -o /dev/null -w "%{http_code}" \
		-H "Authorization: Bearer ${GITHUB_TOKEN}" \
		-H "Accept: application/vnd.github+json" \
		"${api_url}")
	echo "GitHub API workflow runs for branch ${branch}: HTTP ${runs_http_status}"

	run_id=$(echo "${runs_json}" | node -e "let s='';process.stdin.on('data',d=>s+=d).on('end',()=>{const d=JSON.parse(s);const r=(d.workflow_runs||[])[0];if(!r){process.exit(2)}console.log(r.id)})") || {
		echo "No successful build found for branch ${branch}"
		exit 1
	}

	echo "Latest successful build run id: ${run_id}"

	arts_json=$(curl -sS -H "Authorization: Bearer ${GITHUB_TOKEN}" -H "Accept: application/vnd.github+json" \
		"https://api.github.com/repos/elementor/elementor/actions/runs/${run_id}/artifacts")

	first_artifact=$(echo "${arts_json}" | node -e "let s='';process.stdin.on('data',d=>s+=d).on('end',()=>{const d=JSON.parse(s);const a=(d.artifacts||[])[0];if(!a){process.exit(1)}console.log(a.name+'\t'+a.archive_download_url)})")

	if [ -z "${first_artifact}" ]; then
		echo "No artifacts found for run ${run_id}"
		exit 1
	fi

	artifact_name=$(echo "${first_artifact}" | cut -f1)
	artifact_url=$(echo "${first_artifact}" | cut -f2)
	echo "Downloading artifact: ${artifact_name}"

	mkdir -p ./elementor-artifact
	curl -sSL -H "Authorization: Bearer ${GITHUB_TOKEN}" -H "Accept: application/vnd.github+json" \
		-o "./elementor-artifact/${artifact_name}.zip" "${artifact_url}"

	rm -rf "${TARGET_DIR}"
	mkdir -p "${TARGET_DIR}"
	unzip -q "./elementor-artifact/${artifact_name}.zip" -d "${TARGET_DIR}"

	if [ -f "${TARGET_DIR}/elementor.php" ]; then
		echo "GitHub artifact extracted successfully to ${TARGET_DIR}"
		write_outputs "${branch}" "github"
		return 0
	fi

	echo "Invalid GitHub artifact: elementor.php not found in ${TARGET_DIR}"
	ls -la "${TARGET_DIR}/" | head -10 || true
	exit 1
}

rm -rf "${TARGET_DIR}" ./elementor ./elementor-core.zip ./elementor-artifact 2>/dev/null || true
mkdir -p "$(dirname "${TARGET_DIR}")"

echo "Elementor download requested: ${ELEMENTOR_CORE_BRANCH}"

if [[ "${ELEMENTOR_CORE_BRANCH}" == "latest-stable" ]]; then
	download_from_wordpress_org "latest-stable" "https://downloads.wordpress.org/plugin/elementor.latest-stable.zip"
elif [[ "${ELEMENTOR_CORE_BRANCH}" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
	download_url="https://downloads.wordpress.org/plugin/elementor.${ELEMENTOR_CORE_BRANCH}.zip"
	http_status=$(curl --silent --head --location --write-out "%{http_code}" --output /dev/null "${download_url}")

	if [[ "${http_status}" == "200" ]]; then
		download_from_wordpress_org "${ELEMENTOR_CORE_BRANCH}" "${download_url}"
	else
		echo "Elementor version ${ELEMENTOR_CORE_BRANCH} not found on WordPress.org (HTTP ${http_status})"
		exit 1
	fi
else
	download_from_github_artifact "${ELEMENTOR_CORE_BRANCH}"
fi

echo "Elementor install complete: branch=${ELEMENTOR_CORE_BRANCH}, target=${TARGET_DIR}"
