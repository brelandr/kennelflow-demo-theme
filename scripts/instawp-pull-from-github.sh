#!/usr/bin/env bash
#
# Pull KennelFlow demo stack from GitHub into an InstaWP (or any) WordPress install.
#
# Usage (on the server via SSH):
#   cd /path/to/public_html   # directory containing wp-config.php
#   bash instawp-pull-from-github.sh
#
# Or one-liner (always gets latest script from GitHub):
#   curl -fsSL https://raw.githubusercontent.com/brelandr/kennelflow-demo-theme/main/scripts/instawp-pull-from-github.sh | bash
#
# Optional env:
#   WP_ROOT=/path/to/public_html   WordPress root (default: current directory)
#   INCLUDE_PRO=1                  Also pull private Pro plugins (requires git auth on server)
#   GITHUB_ORG=brelandr            GitHub user/org (default: brelandr)
#
set -euo pipefail

GITHUB_ORG="${GITHUB_ORG:-brelandr}"
WP_ROOT="${WP_ROOT:-$(pwd)}"
INCLUDE_PRO="${INCLUDE_PRO:-0}"

if [[ ! -f "${WP_ROOT}/wp-config.php" ]]; then
	echo "Error: wp-config.php not found in WP_ROOT=${WP_ROOT}" >&2
	echo "cd to your WordPress root (public_html) or set WP_ROOT=/path/to/public_html" >&2
	exit 1
fi

THEMES_DIR="${WP_ROOT}/wp-content/themes"
PLUGINS_DIR="${WP_ROOT}/wp-content/plugins"

pull_repo() {
	local type="$1"   # theme | plugin
	local name="$2"   # folder name under themes/ or plugins/
	local repo="$3"   # GitHub repo slug (e.g. kennelflow-vet)

	local base target url
	if [[ "theme" == "${type}" ]]; then
		base="${THEMES_DIR}"
	else
		base="${PLUGINS_DIR}"
	fi
	target="${base}/${name}"
	url="https://github.com/${GITHUB_ORG}/${repo}.git"

	mkdir -p "${base}"

	if [[ -d "${target}/.git" ]]; then
		echo "==> Pull ${name}"
		git -C "${target}" pull --ff-only origin main
	elif [[ -d "${target}" ]]; then
		echo "==> Replace ${name} (not a git clone — backing up to ${target}.bak)"
		mv "${target}" "${target}.bak.$(date +%Y%m%d%H%M%S)"
		echo "==> Clone ${name}"
		git clone --depth 1 --branch main "${url}" "${target}"
	else
		echo "==> Clone ${name}"
		git clone --depth 1 --branch main "${url}" "${target}"
	fi
}

echo "WordPress root: ${WP_ROOT}"
echo ""

# Free stack (public repos).
pull_repo theme  kennelflow-demo-theme kennelflow-demo-theme
pull_repo plugin kennelflow-core       kennelflow-core
pull_repo plugin kennelflow-boarding   kennelflow-boarding
pull_repo plugin kennelflow-vet        kennelflow-vet
pull_repo plugin kennelflow-groom      kennelflow-groom
pull_repo plugin kennelflow-data       kennelflow-data

if [[ "1" == "${INCLUDE_PRO}" ]]; then
	echo ""
	echo "Pro plugins (private — git must be authenticated on this server):"
	pull_repo plugin kennelflow-boarding-pro kennelflow-boarding-pro
	pull_repo plugin kennelflow-vet-pro      kennelflow-vet-pro
	pull_repo plugin kennelflow-groom-pro      kennelflow-groom-pro
fi

echo ""
echo "Done. Next steps in WP Admin:"
echo "  1. Appearance → Themes — confirm KennelFlow Campus Demo is active"
echo "  2. Appearance → Demo Setup → Run Demo Setup (optional)"
echo "  3. Settings → Permalinks → Save"
echo "  4. KennelFlow → Sample Data → Generate (if you updated kennelflow-data)"
echo ""
echo "Verify in page source: theme.css?ver=1.0.2 and white Owner Portal button."

if command -v wp >/dev/null 2>&1; then
	echo ""
	echo "Flushing rewrite rules via WP-CLI..."
	wp rewrite flush --path="${WP_ROOT}" --hard 2>/dev/null || true
fi
