#!/bin/bash
set -eo pipefail

HT_VERSION="${1:-main}"
HP_VERSION="${2:-latest-stable}"
EL_VERSION="${3:-main}"
DEPTH="${4:-2}"
RUN_TARGETED_TESTS="${5:-true}"

HT_VERSION_DISPLAY="$HT_VERSION"
HP_VERSION_DISPLAY="$HP_VERSION"
EL_VERSION_DISPLAY="$EL_VERSION"

get_latest_version() {
	local repo=$1
	local latest_version

	latest_version=$(curl -s "https://api.github.com/repos/${repo}/releases/latest" | jq -r '.tag_name // empty')
	latest_version=${latest_version#v}

	if [[ -z "$latest_version" || "$latest_version" == "null" ]]; then
		echo ""
	else
		echo "$latest_version"
	fi
}

get_wp_org_latest_version() {
	local plugin_slug=$1
	local latest_version

	latest_version=$(curl -s "https://api.wordpress.org/plugins/info/1.0/${plugin_slug}.json" | jq -r '.version // empty')

	if [[ -z "$latest_version" || "$latest_version" == "null" ]]; then
		echo ""
	else
		echo "$latest_version"
	fi
}

get_wp_org_theme_latest_version() {
	local theme_slug=$1
	local latest_version

	latest_version=$(curl -s "https://api.wordpress.org/themes/info/1.1/?action=theme_information&request%5Bslug%5D=${theme_slug}" | jq -r '.version // empty')

	if [[ -z "$latest_version" || "$latest_version" == "null" ]]; then
		echo ""
	else
		echo "$latest_version"
	fi
}

validate_version_availability() {
	local version=$1
	local plugin_name=$2

	if [[ "$version" == "main" ]]; then
		echo "$version"
		return 0
	fi

	if [[ "$plugin_name" == "Hello Plus" && "$version" == "latest-stable" ]]; then
		echo "$version"
		return 0
	fi

	if [[ $version =~ ^([0-9]+)\.([0-9]+) ]]; then
		echo "$version"
	else
		if [[ "$plugin_name" == "Hello Plus" ]]; then
			echo "latest-stable"
		else
			echo "main"
		fi
	fi
}

calculate_previous_versions() {
	local version=$1
	local depth=$2
	local strategy=${3:-"elementor"}

	if [[ "$version" == "main" || "$version" == "latest-stable" ]]; then
		echo ""
		return 0
	fi

	if [[ "$strategy" == "elementor" ]]; then
		if [[ $version =~ ^([0-9]+)\.([0-9]+)\.([0-9]+) ]]; then
			local major=${BASH_REMATCH[1]}
			local minor=${BASH_REMATCH[2]}
			local previous_versions=""

			for i in $(seq 1 "$depth"); do
				local prev_minor=$((minor - i))
				if [ $prev_minor -ge 0 ]; then
					local prev_version="${major}.${prev_minor}.7"
					if [ -z "$previous_versions" ]; then
						previous_versions="$prev_version"
					else
						previous_versions="$previous_versions,$prev_version"
					fi
				fi
			done
			echo "$previous_versions"
		else
			echo ""
		fi
	else
		if [[ $version =~ ^([0-9]+)\.([0-9]+)\.([0-9]+) ]]; then
			local major=${BASH_REMATCH[1]}
			local minor=${BASH_REMATCH[2]}
			local patch=${BASH_REMATCH[3]}
			local previous_versions=""
			local patches_added=0

			for i in $(seq 1 "$depth"); do
				if [ $patches_added -ge "$depth" ]; then
					break
				fi

				local prev_patch=$((patch - i))
				if [ $prev_patch -ge 0 ]; then
					local prev_version="${major}.${minor}.${prev_patch}"
					if [ -z "$previous_versions" ]; then
						previous_versions="$prev_version"
					else
						previous_versions="$previous_versions,$prev_version"
					fi
					patches_added=$((patches_added + 1))
				else
					local prev_minor=$((minor - 1))
					if [ $prev_minor -ge 0 ] && [ $patches_added -lt "$depth" ]; then
						local prev_version="${major}.${prev_minor}.9"
						if [ -z "$previous_versions" ]; then
							previous_versions="$prev_version"
						else
							previous_versions="$previous_versions,$prev_version"
						fi
						patches_added=$((patches_added + 1))
					fi
					break
				fi
			done

			echo "$previous_versions"
		else
			echo ""
		fi
	fi
}

write_github_output() {
	local key="$1"
	local value="$2"

	if [[ -n "${GITHUB_OUTPUT:-}" ]]; then
		echo "${key}=${value}" >>"$GITHUB_OUTPUT"
	fi
}

if [[ "$HT_VERSION" == "main" ]]; then
	HT_GA_LATEST=$(get_wp_org_theme_latest_version "hello-elementor")
	if [[ -n "$HT_GA_LATEST" ]]; then
		HT_VERSION_FOR_MATRIX="$HT_GA_LATEST"
	else
		HT_GA_LATEST=$(get_latest_version "elementor/hello-theme")
		if [[ -n "$HT_GA_LATEST" ]]; then
			HT_VERSION_FOR_MATRIX="$HT_GA_LATEST"
		else
			HT_VERSION_FOR_MATRIX="main"
		fi
	fi
else
	HT_VERSION_FOR_MATRIX="$HT_VERSION"
fi

if [[ "$HP_VERSION" == "latest-stable" ]]; then
	HP_LATEST=$(get_wp_org_latest_version "hello-plus")
	if [[ -n "$HP_LATEST" ]]; then
		HP_VERSION_FOR_MATRIX="$HP_LATEST"
	else
		HP_VERSION_FOR_MATRIX="latest-stable"
	fi
else
	HP_VERSION_FOR_MATRIX="$HP_VERSION"
fi

HT_VERSION=$(validate_version_availability "$HT_VERSION" "Hello Theme")
HP_VERSION=$(validate_version_availability "$HP_VERSION" "Hello Plus")
EL_VERSION=$(validate_version_availability "$EL_VERSION" "Elementor")

write_github_output "hello-theme-version" "$HT_VERSION"
write_github_output "hello-plus-version" "$HP_VERSION"
write_github_output "elementor-version" "$EL_VERSION"
write_github_output "hello-theme-version-for-display" "$HT_VERSION_DISPLAY"

TARGETED_TESTS="[]"

if [[ "$RUN_TARGETED_TESTS" == "true" ]]; then
	ELEMENTOR_PREVIOUS=$(calculate_previous_versions "$EL_VERSION" "$DEPTH" "elementor")
	HELLO_PLUS_PREVIOUS=$(calculate_previous_versions "$HP_VERSION" "$DEPTH" "theme")
	HELLO_THEME_PREVIOUS=$(calculate_previous_versions "$HT_VERSION_FOR_MATRIX" "$DEPTH" "theme")

	write_github_output "hello-theme-previous" "$HELLO_THEME_PREVIOUS"

	TARGETED_TESTS="["
	DELAY_COUNTER=0

	add_test_combination() {
		local combination=$1
		local name=$2
		local ht_ver=$3
		local el_ver=$4
		local hp_ver=$5
		local delay=$6

		if [[ "$TARGETED_TESTS" != "[" ]]; then
			TARGETED_TESTS="${TARGETED_TESTS},"
		fi

		if [[ -n "$hp_ver" ]]; then
			TARGETED_TESTS="${TARGETED_TESTS}{\"combination\":\"${combination}\",\"name\":\"${name}\",\"hello_theme_version\":\"${ht_ver}\",\"hello_plus_version\":\"${hp_ver}\",\"delay\":${delay}}"
		else
			TARGETED_TESTS="${TARGETED_TESTS}{\"combination\":\"${combination}\",\"name\":\"${name}\",\"hello_theme_version\":\"${ht_ver}\",\"elementor_version\":\"${el_ver}\",\"delay\":${delay}}"
		fi
	}

	add_test_combination "ht-main-el-main" "Hello Theme main + Elementor main" "main" "main" "" $((DELAY_COUNTER * 15))
	DELAY_COUNTER=$((DELAY_COUNTER + 1))

	if [[ -n "$ELEMENTOR_PREVIOUS" ]]; then
		IFS=',' read -ra EL_PREV_ARRAY <<<"$ELEMENTOR_PREVIOUS"
		for el_prev in "${EL_PREV_ARRAY[@]}"; do
			add_test_combination "ht-main-el-prev" "Hello Theme main + Elementor ${el_prev} (GA)" "main" "$el_prev" "" $((DELAY_COUNTER * 15))
			DELAY_COUNTER=$((DELAY_COUNTER + 1))
		done
	fi

	if [[ "$HT_VERSION_FOR_MATRIX" != "main" ]]; then
		add_test_combination "ht-ga-el-main" "Hello Theme ${HT_VERSION_FOR_MATRIX} (GA) + Elementor main" "$HT_VERSION_FOR_MATRIX" "main" "" $((DELAY_COUNTER * 15))
		DELAY_COUNTER=$((DELAY_COUNTER + 1))

		if [[ -n "$ELEMENTOR_PREVIOUS" ]]; then
			IFS=',' read -ra EL_PREV_ARRAY <<<"$ELEMENTOR_PREVIOUS"
			for el_prev in "${EL_PREV_ARRAY[@]}"; do
				add_test_combination "ht-ga-el-prev" "Hello Theme ${HT_VERSION_FOR_MATRIX} (GA) + Elementor ${el_prev} (GA)" "$HT_VERSION_FOR_MATRIX" "$el_prev" "" $((DELAY_COUNTER * 15))
				DELAY_COUNTER=$((DELAY_COUNTER + 1))
			done
		fi
	fi

	add_test_combination "ht-main-hp-latest" "Hello Theme main + Hello Plus ${HP_VERSION}" "main" "$EL_VERSION" "$HP_VERSION" $((DELAY_COUNTER * 15))
	DELAY_COUNTER=$((DELAY_COUNTER + 1))

	if [[ -n "$HELLO_PLUS_PREVIOUS" ]]; then
		IFS=',' read -ra HP_PREV_ARRAY <<<"$HELLO_PLUS_PREVIOUS"
		for hp_prev in "${HP_PREV_ARRAY[@]}"; do
			add_test_combination "ht-main-hp-prev" "Hello Theme main + Hello Plus ${hp_prev}" "main" "$EL_VERSION" "$hp_prev" $((DELAY_COUNTER * 15))
			DELAY_COUNTER=$((DELAY_COUNTER + 1))
		done
	fi

	if [[ "$HT_VERSION_FOR_MATRIX" != "main" ]]; then
		add_test_combination "ht-ga-hp-latest" "Hello Theme ${HT_VERSION_FOR_MATRIX} (GA) + Hello Plus ${HP_VERSION}" "$HT_VERSION_FOR_MATRIX" "$EL_VERSION" "$HP_VERSION" $((DELAY_COUNTER * 15))
		DELAY_COUNTER=$((DELAY_COUNTER + 1))

		if [[ -n "$HELLO_PLUS_PREVIOUS" ]]; then
			IFS=',' read -ra HP_PREV_ARRAY <<<"$HELLO_PLUS_PREVIOUS"
			for hp_prev in "${HP_PREV_ARRAY[@]}"; do
				add_test_combination "ht-ga-hp-prev" "Hello Theme ${HT_VERSION_FOR_MATRIX} (GA) + Hello Plus ${hp_prev}" "$HT_VERSION_FOR_MATRIX" "$EL_VERSION" "$hp_prev" $((DELAY_COUNTER * 15))
				DELAY_COUNTER=$((DELAY_COUNTER + 1))
			done
		fi
	fi

	TARGETED_TESTS="${TARGETED_TESTS}]"
fi

write_github_output "targeted-tests" "$TARGETED_TESTS"

echo "OUTPUT_START"
echo "hello-theme-version=${HT_VERSION}"
echo "hello-plus-version=${HP_VERSION}"
echo "elementor-version=${EL_VERSION}"
echo "hello-theme-version-for-display=${HT_VERSION_DISPLAY}"
echo "OUTPUT_END"
echo "JSON_START"
echo "$TARGETED_TESTS"
echo "JSON_END"
