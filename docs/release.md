# Hello Elementor release (WordPress.org)

Hello Theme ships from **release-line branches** named `MAJOR.MINOR` (for example `3.5`). `main` is day-to-day development; production WordPress.org releases are cut from the matching release branch.

## Before you bump

1. Merge fixes into `main` (and into the release branch via `cp_<line>` cherry-picks when needed).
2. Do **not** change version or `readme.txt` changelog in individual fix PRs; batch them in one version PR (see reference below).

## Version bump PR (patch release)

Reference: [#693](https://github.com/elementor/hello-theme/pull/693) on `main` → `cp_3.5` → [#695](https://github.com/elementor/hello-theme/pull/695) on `3.5` ([e86d30a](https://github.com/elementor/hello-theme/commit/e86d30a7d64b2ab59373422a14933bba3621ee04)).

**Default:** open the bump PR against **`main`**, then add label `cp_3.5` (or `cp_<release-line>`). After merge, the cherry-pick workflow opens the matching PR on the release branch.

**Exception:** a bump PR opened directly on the release line (for example backporting a changelog already merged on `3.5` to `main`).

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

Use categories `New`, `Tweak`, `Fix`, or `Internal`. Summarize every user-facing merge since the previous GA version.

### Branch and title

- **Default base:** `main`. Branch name pattern: `feat/<version>-changelog`.
- **Release-line base:** the `MAJOR.MINOR` branch when using the exception above.
- Commit/PR title pattern: `Internal: X.Y.Z changelog` (optional Jira ref).
- On a **main** bump PR, add `cp_<release-line>` (for example `cp_3.5`) before merge so cherry-pick automation opens the release-branch PR.

## Deploy to WordPress.org

After the version PR is merged into the **release branch**:

1. GitHub **Actions** → workflow **Deploy** → **Run workflow**.
2. Select the release branch (must match `^[0-9]+\.[0-9]+`, e.g. `3.5`).
3. Enter the **version** input exactly as in `package.json`.

The **Deploy** workflow (`.github/workflows/deploy.yml`) runs in order:

1. **validate** — actor allowed via repo variable `DEPLOYMENT_PERMITTED_USERS`; branch name pattern; workflow `version` input matches `package.json`.
2. **build** — reusable **Build** workflow produces the theme zip artifact.
3. **deploy** — download artifact; **Validate changelog** (`readme.txt` contains `= {version} -`); publish to [themes.svn.wordpress.org/hello-elementor](https://themes.svn.wordpress.org/hello-elementor/); Slack notify `#tmz-hello-delivery`.

WordPress.org theme versions are **immutable**. To ship further changes, increment patch (or minor/major) and run Deploy again.

## Agents

See `.cursor/skills/hello-theme-release/SKILL.md` for the step-by-step agent workflow.
