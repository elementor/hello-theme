# Critical Questions for Hello Commerce → Hello Theme Workflow Clone

## Overview
Before proceeding with the workflow cloning, these critical questions must be answered to ensure successful implementation. Each question impacts the implementation approach and requires stakeholder input.

---

## 1. Build Process Strategy Questions

### Q1: Build Action Replacement Strategy
**Context:** Hello Theme has a more sophisticated build-theme action with retry logic and error handling, while Hello Commerce has a simpler approach.

**Question:** Should we:
- **Option A:** Replace Hello Theme's build-theme action with Hello Commerce version?
- **Option B:** Keep Hello Theme's build-theme action and adapt Hello Commerce workflow to use it?
- **Option C:** Merge the best features from both actions?

**Current State:**
- Hello Theme: 72-line sophisticated build action with retry logic
- Hello Commerce: 68-line simpler build action  

**Impact:** Medium - affects build reliability and error handling

**Recommendation:** Option B - Keep Hello Theme's superior build action

HVV: For all duplicate files or folder names, add the suffix '-release', e.g. 'build-theme-release'. Use the workflows and actions from Hello Commerce if possible. Logic: I would like to clone existing files as much possible, so that we can't break the workflows with new implementations.

---

### Q2: Build Script Naming Strategy
**Context:** Different script names between repositories

**Hello Theme:** `npm run zip` (creates hello-elementor-{version}.zip)  
**Hello Commerce:** `npm run package:zip` (creates hello-commerce-{version}.zip)

**Question:** Should we:
- **Option A:** Update Hello Theme package.json to use `package:zip` script name?
- **Option B:** Adapt workflow to use Hello Theme's `zip` script?
- **Option C:** Create alias script for backward compatibility?

**Impact:** Low - cosmetic change but affects script consistency

**Recommendation:** Option B - Use Hello Theme's existing script names

HVV: Use option A. Add the option to use 'package:zip'. Don't remove any existing options.

---

## 2. Version Management Integration Questions

### Q3: Version Management Approach
**Context:** Two different approaches for version management

**Hello Theme Current:** JavaScript-based `update-version-in-files.js`
- Updates: `assets/scss/style.scss`, `functions.php`, `readme.txt`
- Uses replace-in-file package
- Already integrated into existing workflows

**Hello Commerce:** Bash-based approach in GitHub Actions
- Updates: `package.json`, `functions.php`, `style.css`, `readme.txt`
- Uses sed commands
- Integrated into release-preparation workflow

**Question:** Should we:
- **Option A:** Replace Hello Theme's JS approach with Hello Commerce bash approach?
- **Option B:** Keep Hello Theme's JS approach and adapt GitHub Actions to call it?
- **Option C:** Hybrid approach - use bash for some files, JS for SCSS-specific files?

**Impact:** High - affects version synchronization reliability

**Recommendation:** Option B - Keep Hello Theme's existing approach for continuity

HVV: Option A. But don't delete any existing functionality.

---

### Q4: SCSS File Version Management
**Context:** Hello Theme has `assets/scss/style.scss` that needs version management

**Question:** How should version updates be handled for SCSS files?
- **Option A:** Add SCSS handling to Hello Commerce's bash approach
- **Option B:** Keep Hello Theme's JS approach which already handles SCSS
- **Option C:** Manual SCSS version management (not recommended)

**Current Hello Theme JS script updates:**
```javascript
files: './assets/scss/style.scss',
from: /Version:.*$/m,
to: `Version: ${ VERSION }`,
```

**Impact:** High - SCSS files must have correct versions for WordPress.org compliance

**Recommendation:** Option B - Leverage existing JS script capability

HVV: Use option A.

---

## 3. Repository and Theme Naming Questions

### Q5: Theme Display Name Confirmation
**Context:** Repository name vs theme display name confusion

**Repository:** `elementor/hello-theme`  
**Theme Name:** "Hello Elementor"  
**Package Name:** `hello-elementor`  
**Build Artifact:** `hello-elementor-{version}.zip`

**Question:** Confirm the correct naming for all workflow messages:
- Slack notifications should say "Hello Elementor" (not "Hello Theme")?
- Build artifacts should be named `hello-elementor-{version}.zip`?
- WordPress.org references should use `hello-elementor`?

**Impact:** Medium - affects user communication and artifact naming

**Recommendation:** Use "Hello Elementor" for all user-facing messages

HVV: Compary with the 'Publish Release Version' workflow.
'hello-elementor' seems correct.
WordPress url: https://en-za.wordpress.org/themes/hello-elementor/
Github url: https://github.com/elementor/hello-theme

---

### Q6: Repository Reference Strategy
**Context:** GitHub repository references throughout workflow

**Question:** Should workflow references point to:
- **Option A:** `elementor/hello-theme` (actual repository)
- **Option B:** Update any hardcoded references to be dynamic
- **Option C:** Mix of repository and theme names where contextually appropriate

**Examples:**
- GitHub release URLs: `github.com/elementor/hello-theme/releases`
- Action references: `.github/actions/build-theme` (repository context)
- Theme references: WordPress.org URLs use `hello-elementor`

**Impact:** Low - mainly affects URLs and references

**Recommendation:** Option A - Use actual repository name for all GitHub references

HVV: Option A.

---

## 4. Legacy Workflow Migration Questions

### Q7: Legacy Workflow Coexistence Strategy
**Context:** Hello Theme has existing release workflows

**Existing Workflows:**
- `publish-release.yml` - Full release process
- `publish-patch.yml` - Patch releases  
- `publish-beta.yml` - Beta releases

**Question:** What should happen to these workflows when release-preparation.yml is added?
- **Option A:** Keep all workflows active (coexistence)
- **Option B:** Deprecate legacy workflows with migration timeline
- **Option C:** Immediately replace/disable legacy workflows
- **Option D:** Keep beta workflow, replace others

**Impact:** High - affects team workflow and potential conflicts

**Recommendation:** Option A initially, then Option B with documented migration plan

HVV: Option A.

---

### Q8: Workflow Migration Timeline
**Context:** Team needs clear guidance on workflow transition

**Question:** What should be the migration strategy?
- **Option A:** Immediate switch to new workflow for all releases
- **Option B:** Parallel operation for 1-2 release cycles, then deprecate old workflows
- **Option C:** Feature branch testing first, then gradual rollout
- **Option D:** Team choice per release type

**Impact:** High - affects team adoption and risk management

**Recommendation:** Option C - Feature branch testing, then Option B parallel operation

HVV: Option D: Keep both options in parellel. We don't want a single change to the existing functionality.

---

## 5. Secret and Configuration Questions

### Q9: GitHub Secrets Verification
**Context:** New workflow requires specific secrets

**Required Secrets:**
- `DEVOPS_TOKEN` - For composer authentication
- `CLOUD_DEVOPS_TOKEN` - For NPM registry access  
- `SLACK_BOT_TOKEN` - For release notifications
- `CLOUD_SLACK_BOT_TOKEN` - For build notifications

**Question:** Which of these secrets are already available in hello-theme repository?

**Current Hello Theme Workflows Use:**
- `MAINTAIN_TOKEN` (for publish-*.yml workflows)
- Other secrets TBD

**Action Required:** Verify secret availability and configure missing ones

HVV: GITHUB_TOKEN, CLOUD_DEVOPS_TOKEN. Ignore the slack issues for now.

---

### Q10: Slack Notification Configuration
**Context:** Release notifications need proper channel configuration

**Question:** What are the correct Slack settings for Hello Theme releases?
- **Channel:** Which Slack channel should receive notifications?
- **Format:** Should notifications distinguish Hello Elementor from other Elementor themes?
- **Frequency:** All releases, or only major/minor releases?

**Current Default:** `#release` (from config)

**Impact:** Medium - affects team communication

HVV: Leave as is for now.

---

## 6. WordPress.org Integration Questions

### Q11: WordPress.org Release Process
**Context:** Different WordPress.org integration approaches

**Hello Commerce:** Auto-deploy to WordPress.org (in config)  
**Hello Theme:** Manual upload process (in config)

**Question:** Should Hello Theme adopt auto-deploy or keep manual process?
- **Option A:** Keep manual upload (current Hello Theme approach)
- **Option B:** Adopt auto-deploy (Hello Commerce approach)
- **Option C:** Configurable per release type

**Impact:** Medium - affects release automation level

**Recommendation:** Option A - Keep manual for safety, consider Option B later

HVV: Follow Hello Commerce for now.

---

## 7. Technical Integration Questions

### Q12: Release Branch Strategy
**Context:** Different branching approaches

**Hello Commerce:** Release branches `["1.0"]`  
**Hello Theme:** Release branches `["3.4"]`

**Question:** Should Hello Theme:
- **Option A:** Keep current "3.4" branch approach
- **Option B:** Adopt Hello Commerce pattern
- **Option C:** Update to next major version pattern (e.g., "3.5")

**Impact:** Low - affects branch validation in workflow

**Recommendation:** Option A - Keep existing approach

HVV: Option A.

---

### Q13: Testing and Validation Strategy
**Context:** Ensuring workflow compatibility

**Question:** What testing approach should we use?
- **Option A:** Create test branch and run full dry_run workflow
- **Option B:** Test individual actions separately, then full workflow
- **Option C:** Test on fork repository first
- **Option D:** All of the above

**Required Tests:**
- Build process compatibility
- Version management accuracy  
- Secret availability
- Legacy workflow coexistence

**Impact:** High - affects implementation success

**Recommendation:** Option D - Comprehensive testing approach

HVV: I will test manually.

---

## 8. Documentation and Training Questions

### Q14: Team Training Requirements
**Context:** New workflow requires team education

**Question:** What documentation/training is needed?
- **Option A:** Written documentation only
- **Option B:** Team walkthrough session
- **Option C:** Both documentation and training session
- **Option D:** Gradual rollout with mentoring

**Documentation Needs:**
- Migration guide from legacy workflows
- New workflow usage instructions
- Troubleshooting guide
- Rollback procedures

**Impact:** Medium - affects adoption success

**Recommendation:** Option C - Both written docs and training

HVV: None.

---

## 9. Priority and Timeline Questions

### Q15: Implementation Priority
**Context:** Resource allocation and timeline planning

**Question:** What is the priority and timeline for this implementation?
- **High Priority:** Implement immediately (1-2 weeks)
- **Medium Priority:** Implement in next sprint (3-4 weeks)  
- **Low Priority:** Implement when convenient (1-2 months)

**Factors to Consider:**
- Current Hello Theme release schedule
- Team availability
- Upcoming releases that could benefit from new workflow

HVV: Today

---

### Q16: Rollback Strategy
**Context:** Risk mitigation planning

**Question:** What should be the rollback plan if issues arise?
- **Option A:** Revert to legacy workflows immediately
- **Option B:** Fix issues in new workflow
- **Option C:** Hybrid approach - use working parts, fallback for broken parts

**Impact:** High - affects risk management

**Recommendation:** Option A with documented quick rollback procedures

HVV: We won't update any existing worfklows. There is no risk.

---

## Decision Matrix Summary

| Question | Impact | Urgency | Recommended Option |
|----------|--------|---------|-------------------|
| Q1: Build Action Strategy | Medium | High | Keep Hello Theme's build action |
| Q2: Script Names | Low | Medium | Use Hello Theme's scripts |
| Q3: Version Management | High | High | Keep Hello Theme's JS approach |
| Q4: SCSS Handling | High | High | Use existing JS script |
| Q5: Theme Names | Medium | High | Use "Hello Elementor" |
| Q6: Repository References | Low | Medium | Use actual repository names |
| Q7: Legacy Workflows | High | Medium | Coexistence then migration |
| Q8: Migration Timeline | High | High | Feature testing → Parallel |
| Q9: Secrets | High | High | Verify availability |
| Q10: Slack Config | Medium | Medium | Confirm channel/format |
| Q11: WordPress.org | Medium | Low | Keep manual process |
| Q12: Branch Strategy | Low | Low | Keep "3.4" approach |
| Q13: Testing Strategy | High | High | Comprehensive testing |
| Q14: Training | Medium | Medium | Docs + training session |
| Q15: Priority | High | High | TBD by stakeholders |
| Q16: Rollback Plan | High | High | Quick revert procedures |

---

## Next Steps

1. **Answer high-impact questions** (Q3, Q4, Q7, Q8, Q9, Q13, Q16)
2. **Verify technical requirements** (secrets, build compatibility)
3. **Create implementation timeline** based on priorities
4. **Begin Phase 1 implementation** with answered questions
5. **Schedule team training** once workflow is ready

**All questions marked as "High Impact" must be answered before implementation begins.**
