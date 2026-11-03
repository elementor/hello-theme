# Hello Elementor release (WordPress.org)

Hello Theme ships from **release-line branches** named `MAJOR.MINOR` (for example `3.5`). `main` is day-to-day development; production WordPress.org releases are cut from the matching release branch.

## Before you bump

1. Merge all fixes into the release branch (cherry-pick PRs, or automatic picks via `cp_<branch>` labels on merges to `main`).
2. Do **not** change version or `readme.txt` changelog in individual fix PRs; batch them in one version PR (see reference below).

## Version bump PR (patch release)

Reference implementation: [e86d30a](https://github.com/elementor/hello-theme/commit/e86d30a7d64b2ab59373422a14933bba3621ee04) / [#695](https://github.com/elementor/hello-theme/pull/695) (3.5.1 on `3.5`), originally [#693](https://github.com/elementor/hello-theme/pull/693) on `main`.

### Files to update

| File | What to change |
|------|----------------|
| `functions.php` | `HELLO_ELEMENTOR_VERSION` |
| `style.css` | `Version`, `Stable tag`; align `Tested up to` with `readme.txt` when needed |
| `readme.txt` | `Stable tag`, `Version`, new `== Changelog ==` block |
| `package.json` | `"version"` |
| `package-lock.json` | Root `"version"` and `packages[""].version` (both must match) |

### Changelog block

Add at the top of `== Changelog ==` in `readme.txt`:

```text
= X.Y.Z - YYYY-MM-DD =
* Fix: …
* Tweak: …
```

Use categories `New`, `Tweak`, `Fix`, or `Internal`. Summarize every user-facing merge on the release branch since the previous GA version.

### Branch and title

- Base branch: the release line (for example `3.5`).
- Commit/PR title pattern: `Internal: X.Y.Z changelog` (optional Jira ref).
- Label `cp_3.5` on the **main** version PR if you also want the cherry-pick workflow to open the release-branch PR automatically; otherwise open the release-branch bump PR directly on `3.5`.

## Deploy to WordPress.org

After the version PR is merged into the release branch:

1. GitHub **Actions** → workflow **Deploy** → **Run workflow**.
2. Select the release branch (must match `^[0-9]+\.[0-9]+`, e.g. `3.5`).
3. Enter the **version** input exactly as in `package.json`.

The workflow validates the actor against `DEPLOYMENT_PERMITTED`, checks that `readme.txt` contains `= {version} -`, builds the theme zip, publishes to [themes.svn.wordpress.org/hello-elementor](https://themes.svn.wordpress.org/hello-elementor/), and notifies `#tmz-hello-delivery`.

WordPress.org theme versions are **immutable**. To ship further changes, increment patch (or minor/major) and run Deploy again.

## Agents

See `.cursor/skills/hello-theme-release/SKILL.md` for the step-by-step agent workflow.
