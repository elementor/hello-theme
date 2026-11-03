---
name: hello-theme-release
description: Cut a Hello Elementor patch release on a MAJOR.MINOR branch (version bump PR and WordPress.org Deploy). Use when releasing 3.5.x, bumping readme changelog, or running the Deploy workflow.
---

# Hello Elementor release

## When to use

- User asks to release Hello Theme, bump `readme.txt` / version on `3.5` (or another release line), or deploy to WordPress.org.
- After cherry-picks are merged into a release branch and a GA zip is needed.

## Reference

Follow the same file set and diff shape as:

- Commit: `e86d30a7d64b2ab59373422a14933bba3621ee04`
- Release branch PR: [#695](https://github.com/elementor/hello-theme/pull/695)
- Main PR (optional `cp_<line>`): [#693](https://github.com/elementor/hello-theme/pull/693)

Human-readable doc: `docs/release.md` in the repo root.

## Workflow

### 1. Confirm release branch state

```bash
git fetch origin main <release-branch>
git log origin/<release-branch> --oneline -20
```

List merges since the last changelog version header in `origin/<release-branch>:readme.txt`. Those commits belong in the new changelog bullets.

Ensure individual fix PRs did not bump version (happy path: only the dedicated changelog PR touches version files).

### 2. Version bump PR on the release branch

```bash
git checkout -b feat/<version>-changelog-45bb origin/<release-branch>
```

Update in one commit:

- `functions.php` — `HELLO_ELEMENTOR_VERSION`
- `style.css` — `Version`, `Stable tag`; sync `Tested up to` with `readme.txt` if needed
- `readme.txt` — `Stable tag`, `Version`, new top changelog section `= X.Y.Z - YYYY-MM-DD =`
- `package.json` and `package-lock.json` (both version fields in lockfile)

Commit message: `Internal: X.Y.Z changelog` with body listing included PRs.

Open PR **base `<release-branch>`**, not `main`. Title example: `Internal: 3.5.2 changelog`.

Test plan checklist:

- Version is `X.Y.Z` in all five files above
- Changelog block exists for the release date
- Deploy workflow will find `= X.Y.Z -` in `readme.txt`

Do **not** merge or run Deploy unless the user asks.

### 3. Optional main-line bump

For a release on `main` first, merge version PR there, add label `cp_3.5` (or target branch name) so `.github/workflows/cherry-pick-pr.yml` opens the release-branch PR; resolve conflicts only in version/changelog if needed.

### 4. Deploy (human / permitted actor)

After merge to release branch: Actions → **Deploy** → branch = release line, version = `package.json` version. Never re-publish the same version to SVN.

## Do not

- Edit version/changelog in cherry-pick fix PRs when the release process owns the bump.
- Force-push release branches.
- Run Deploy from `main`.
