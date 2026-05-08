# hello-theme Playwright happy-path refactor plan

Source plan: `hello-theme-playwright-happy-path-refactor_12452bce`  
Scope: `themes/hello-theme/.github/workflows`

## Current implementation status (latest feedback incorporated)

- [x] Create `playwright-with-specific-elementor-version-candidate.yml` as rollout candidate.
- [x] Keep legacy workflow file unchanged.
- [x] Add `test_source` input to candidate workflow (`workflow_dispatch` / `workflow_call`), default `candidate`.
- [x] Prefix workflow artifact names with `core-${{ inputs.test_source || 'candidate' }}-...` for parity and distinguishability.
- [x] Add execution mode visibility line in candidate workflow summary.
- [x] Duplicate daily matrix rows so each core entry runs twice:
  - once via `playwright-with-specific-elementor-version.yml` with `test_source: legacy`
  - once via `playwright-with-specific-elementor-version-candidate.yml` with `test_source: candidate`
- [x] Keep + workflows unchanged.
- [x] Thread `test_source` through matrix metadata and artifact naming for comparable reports.
- [x] Run full matrix for both workflow paths (no canary/filtering).

## Plan file updates completed

The following plan items were updated as completed in the working plan:

- `duplicate-workflow` → completed
- `run-parallel-matrix` → completed
- `no-canary-run-all` → completed

## Remaining work (not yet implemented)

- `extract-input-resolver` remains pending.
- `extract-elementor-download` remains pending.
- `dedupe-test-setup` remains pending.
- `unify-test-run` remains pending.
- `validate-and-guard` remains pending.
- `extract-runtime bootstrap action` remains pending.

## Files already changed during rollout wiring

- `themes/hello-theme/.github/workflows/playwright-with-specific-elementor-version-candidate.yml`
- `themes/hello-theme/.github/workflows/daily-test-matrix.yml`

## Next recommended step

Proceed to steps 1–3 from the original plan (resolver scripts + test-run unification) while retaining the current legacy/candidate matrix structure in place.

