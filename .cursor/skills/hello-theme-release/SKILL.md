---
name: hello-theme-release
description: Cut a Hello Elementor patch release on a MAJOR.MINOR branch (version bump PR and WordPress.org Deploy). Use when releasing 3.5.x, bumping readme changelog, or running the Deploy workflow.
---

# Hello Elementor release

## When to use

- User asks to release Hello Theme, bump `readme.txt` / version, or deploy to WordPress.org.
- After fixes are merged and a GA zip is needed from a release line.

## Reference

- Main bump + `cp_3.5`: [#693](https://github.com/elementor/hello-theme/pull/693) → [#695](https://github.com/elementor/hello-theme/pull/695)
- Commit shape on release branch: `e86d30a7d64b2ab59373422a14933bba3621ee04`

Human-readable doc (files to touch, changelog, Deploy): `docs/release.md`.

## Workflow

### 1. Confirm what ships

```bash
git fetch origin main <release-branch>
git log origin/main --oneline -20
```

List merges since the last changelog header in `readme.txt`. Those belong in the new changelog bullets. Fix PRs must not bump version.

### 2. Version bump PR on `main` (default)

```bash
git checkout -b feat/<version>-changelog origin/main
```

Update the five files listed in [docs/release.md](../../docs/release.md#files-to-update) in one commit.

- Commit: `Internal: X.Y.Z changelog`
- PR **base `main`**, title `Internal: X.Y.Z changelog`
- Add label `cp_<release-line>` (for example `cp_3.5`) so `.github/workflows/cherry-pick-pr.yml` opens the release-branch PR on merge

Test plan: version `X.Y.Z` in all five files; changelog block `= X.Y.Z - DATE =`; release branch will get the cherry-pick PR automatically.

Do **not** merge or run Deploy unless the user asks.

### 3. Release branch

After the main bump merges with `cp_<line>`, review and merge the auto-opened cherry-pick PR to the release branch. Resolve conflicts only in version/changelog if needed.

**Exception:** bump PR opened directly on the release branch (rare; for example CP changelog to `main` only). See docs/release.md.

### 4. Deploy (permitted actor)

After merge to the release branch: Actions → **Deploy** on that branch, version = `package.json`. Steps and permissions: [docs/release.md](../../docs/release.md#deploy-to-wordpressorg). Never re-publish the same SVN version.

## Do not

- Edit version/changelog in individual fix or cherry-pick PRs when a dedicated bump PR is planned.
- Force-push release branches.
- Run Deploy from `main`.
