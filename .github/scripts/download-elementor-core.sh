#!/bin/bash
set -eo pipefail

ELEMENTOR_CORE_BRANCH="${ELEMENTOR_CORE_BRANCH:-$1}"
OUTPUT_DIR="${OUTPUT_DIR:-./tmp/elementor}"
REPO="elementor/elementor"

if [[ -z "$ELEMENTOR_CORE_BRANCH" ]]; then
	echo "ERROR: ELEMENTOR_CORE_BRANCH is required"
	exit 1
fi

if [[ "$ELEMENTOR_CORE_BRANCH" == "latest-stable" ]]; then
	echo "ERROR: latest-stable is not supported; use main or a GitHub release tag"
	exit 1
fi

write_effective_version() {
	if [[ -n "${GITHUB_OUTPUT:-}" ]]; then
		echo "effective-version=$1" >>"$GITHUB_OUTPUT"
	fi
}

resolve_release_tag() {
	if [[ "$ELEMENTOR_CORE_BRANCH" == "main" ]]; then
		local latest_tag
		latest_tag=$(curl -fsSL "https://api.github.com/repos/${REPO}/releases/latest" | jq -r '.tag_name // empty')
		latest_tag=${latest_tag#v}
		if [[ -z "$latest_tag" || "$latest_tag" == "null" ]]; then
			echo "ERROR: Could not resolve latest Elementor release"
			exit 1
		fi
		echo "$latest_tag"
		return 0
	fi

	echo "$ELEMENTOR_CORE_BRANCH"
}

install_release_zip() {
	local tag="$1"
	local release_json asset_url extract_dir zip_file

	release_json=$(curl -fsSL "https://api.github.com/repos/${REPO}/releases/tags/${tag}")
	asset_url=$(echo "$release_json" | jq -r '[.assets[] | select(.name | endswith(".zip"))][0].browser_download_url // empty')

	if [[ -z "$asset_url" || "$asset_url" == "null" ]]; then
		echo "ERROR: No zip asset found for Elementor release ${tag}"
		exit 1
	fi

	extract_dir="${OUTPUT_DIR}.extract"
	zip_file="./elementor-core-download.zip"

	rm -rf "$OUTPUT_DIR" "$extract_dir"
	mkdir -p "$extract_dir"

	curl -fsSL -o "$zip_file" "$asset_url"
	unzip -q "$zip_file" -d "$extract_dir"
	rm -f "$zip_file"

	if [[ -f "$extract_dir/elementor/elementor.php" ]]; then
		mv "$extract_dir/elementor" "$OUTPUT_DIR"
	elif [[ -f "$extract_dir/elementor.php" ]]; then
		mv "$extract_dir" "$OUTPUT_DIR"
	else
		echo "ERROR: elementor.php not found in release ${tag}"
		exit 1
	fi

	rm -rf "$extract_dir"

	if [[ ! -f "$OUTPUT_DIR/elementor.php" ]]; then
		echo "ERROR: Elementor install failed for ${tag}"
		exit 1
	fi

	write_effective_version "$tag"
	echo "Elementor ${tag} installed to ${OUTPUT_DIR}"
}

TAG=$(resolve_release_tag)
install_release_zip "$TAG"
