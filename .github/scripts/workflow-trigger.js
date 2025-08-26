/**
 * Utility functions for GitHub Actions workflow management
 * Adapted for Hello Theme compatibility testing
 */

/**
 * Triggers a workflow and waits for it to appear in the runs list
 * @param {Object} github                      - GitHub API client
 * @param {Object} context                     - GitHub Actions context
 * @param {Object} core                        - GitHub Actions core utilities
 * @param {Object} config                      - Configuration object
 * @param {string} config.combination          - Combination identifier
 * @param {string} config.name                 - Human-readable name
 * @param {string} config.workflowId           - Workflow ID to trigger
 * @param {string} config.ref                  - Git ref to use
 * @param {Object} config.inputs               - Workflow inputs
 * @param {number} [config.maxAttempts=12]     - Maximum polling attempts
 * @param {number} [config.pollInterval=10000] - Polling interval in milliseconds
 * @param {number} [config.bufferTime=5000]    - Buffer time for run detection
 * @return {Object} - Object containing runId and runUrl
 */
async function triggerWorkflowAndWait( github, context, core, config ) {
	const {
		combination,
		name,
		workflowId,
		ref,
		inputs,
		maxAttempts = 12,
		pollInterval = 10000,
		bufferTime = 5000,
	} = config;

	const triggerTime = Date.now();
	const uniqueId = `${ combination }-${ triggerTime }`;

	// eslint-disable-next-line no-console
	console.log( `=== Triggering: ${ name } (${ uniqueId }) ===` );
	// eslint-disable-next-line no-console
	console.log( `Workflow: ${ workflowId }` );
	// eslint-disable-next-line no-console
	console.log( `Ref: ${ ref }` );
	// eslint-disable-next-line no-console
	console.log( `Inputs:`, JSON.stringify( inputs, null, 2 ) );

	// Trigger the workflow
	try {
		await github.rest.actions.createWorkflowDispatch( {
			owner: context.repo.owner,
			repo: context.repo.repo,
			workflow_id: workflowId,
			ref,
			inputs,
		} );

		// eslint-disable-next-line no-console
		console.log( '✅ Workflow dispatch sent successfully' );
	} catch ( error ) {
		// eslint-disable-next-line no-console
		console.error( '❌ Failed to trigger workflow:', error.message );
		throw new Error( `Failed to trigger workflow ${ workflowId }: ${ error.message }` );
	}

	// eslint-disable-next-line no-console
	console.log( '⏳ Waiting for workflow run to appear...' );

	// Wait and find the specific run with better detection
	let newRun = null;
	let attempts = 0;

	while ( ! newRun && attempts < maxAttempts ) {
		await new Promise( ( resolve ) => setTimeout( resolve, pollInterval ) );
		attempts++;

		try {
			const runs = await github.rest.actions.listWorkflowRuns( {
				owner: context.repo.owner,
				repo: context.repo.repo,
				workflow_id: workflowId,
				per_page: 50, // Increased to catch more runs
			} );

			// More specific run detection
			const candidateRuns = runs.data.workflow_runs.filter( ( run ) =>
				'workflow_dispatch' === run.event &&
				new Date( run.created_at ).getTime() >= triggerTime - bufferTime &&
				new Date( run.created_at ).getTime() <= triggerTime + ( pollInterval * attempts ) + bufferTime,
			);

			// Sort by creation time (newest first) and take the most recent
			candidateRuns.sort( ( a, b ) => new Date( b.created_at ) - new Date( a.created_at ) );

			if ( candidateRuns.length > 0 ) {
				newRun = candidateRuns[ 0 ];
				// eslint-disable-next-line no-console
				console.log( `✅ Found ${ candidateRuns.length } candidate runs, selected newest: ${ newRun.id }` );
				// eslint-disable-next-line no-console
				console.log( `   Created: ${ newRun.created_at }` );
				// eslint-disable-next-line no-console
				console.log( `   Status: ${ newRun.status }` );
			}

			// eslint-disable-next-line no-console
			console.log( `Attempt ${ attempts }/${ maxAttempts }: ${ newRun ? 'Found' : 'Not found' } new run for ${ combination }` );
		} catch ( error ) {
			// eslint-disable-next-line no-console
			console.error( `Error on attempt ${ attempts }:`, error.message );
		}
	}

	if ( ! newRun ) {
		throw new Error( `Could not find the triggered workflow run for ${ combination } after ${ maxAttempts * pollInterval / 1000 } seconds` );
	}

	const runUrl = `https://github.com/${ context.repo.owner }/${ context.repo.repo }/actions/runs/${ newRun.id }`;

	// eslint-disable-next-line no-console
	console.log( `✅ Successfully captured run ID for ${ combination }: ${ newRun.id }` );
	// eslint-disable-next-line no-console
	console.log( `📋 Run URL: ${ runUrl }` );

	return {
		runId: newRun.id,
		runUrl,
		status: newRun.status,
		createdAt: newRun.created_at,
	};
}

/**
 * Applies delay based on timing configuration
 * @param {string} combination - Combination identifier (e.g., 'baseline', 'ht-3.4', 'hp-1.3')
 * @param {Object} timing      - Timing configuration object with triggerDelays
 */
async function applyTriggerDelay( combination, timing ) {
	if ( ! timing.triggerDelays || ! timing.triggerDelays[ combination ] ) {
		return; // No delay configured
	}

	const delaySeconds = timing.triggerDelays[ combination ];
	if ( delaySeconds > 0 ) {
		// eslint-disable-next-line no-console
		console.log( `⏱️  Applying ${ delaySeconds }s delay to prevent race condition...` );
		await new Promise( ( resolve ) => setTimeout( resolve, delaySeconds * 1000 ) );
	}
}

/**
 * Waits for a specific workflow run to complete
 * @param {Object} github  - GitHub API client
 * @param {Object} context - GitHub Actions context
 * @param {string} runId   - The workflow run ID to wait for
 * @param {Object} options - Options for polling
 * @return {Object} - Final run status and details
 */
async function waitForWorkflowCompletion( github, context, runId, options = {} ) {
	const {
		maxAttempts = 60,
		pollInterval = 30000,
		logProgress = true,
	} = options;

	// eslint-disable-next-line no-console
	console.log( `⏳ Waiting for workflow run ${ runId } to complete...` );

	for ( let attempt = 1; attempt <= maxAttempts; attempt++ ) {
		try {
			const response = await github.rest.actions.getWorkflowRun( {
				owner: context.repo.owner,
				repo: context.repo.repo,
				run_id: runId,
			} );

			const run = response.data;

			if ( 'completed' === run.status ) {
				// eslint-disable-next-line no-console
				console.log( `✅ Run ${ runId } completed with conclusion: ${ run.conclusion }` );
				return {
					runId,
					status: run.status,
					conclusion: run.conclusion,
					url: run.html_url,
					createdAt: run.created_at,
					updatedAt: run.updated_at,
					duration: calculateDuration( run.created_at, run.updated_at ),
				};
			}

			if ( logProgress && ( 0 === attempt % 10 || attempt <= 5 ) ) {
				// eslint-disable-next-line no-console
				console.log( `⏳ Run ${ runId } is ${ run.status } (attempt ${ attempt }/${ maxAttempts })` );
			}

			await new Promise( ( resolve ) => setTimeout( resolve, pollInterval ) );
		} catch ( error ) {
			// eslint-disable-next-line no-console
			console.error( `Error checking run ${ runId } status (attempt ${ attempt }):`, error.message );
			if ( attempt === maxAttempts ) {
				throw error;
			}
		}
	}

	throw new Error( `Workflow run ${ runId } did not complete within ${ maxAttempts * pollInterval / 1000 } seconds` );
}

/**
 * Calculates duration between two timestamps
 * @param {string} startTime - ISO timestamp
 * @param {string} endTime   - ISO timestamp
 * @return {string} - Human-readable duration
 */
function calculateDuration( startTime, endTime ) {
	const start = new Date( startTime );
	const end = new Date( endTime );
	const durationMs = end - start;
	const durationMin = Math.round( durationMs / 60000 );
	return `${ durationMin }m`;
}

/**
 * Validates workflow inputs before triggering
 * @param {Object} inputs - Workflow inputs to validate
 * @return {boolean} - True if valid
 */
function validateWorkflowInputs( inputs ) {
	const required = [ 'hello_theme_version', 'hello_plus_version', 'elementor_version' ];

	for ( const field of required ) {
		if ( ! inputs[ field ] || '' === inputs[ field ].trim() ) {
			throw new Error( `Required input ${ field } is missing or empty` );
		}
	}

	// Validate version format (basic check)
	const versionRegex = /^(main|latest-stable|\d+\.\d+(\.\d+)?)$/;
	for ( const field of required ) {
		if ( ! versionRegex.test( inputs[ field ] ) ) {
			throw new Error( `Invalid version format for ${ field }: ${ inputs[ field ] }` );
		}
	}

	return true;
}

module.exports = {
	triggerWorkflowAndWait,
	applyTriggerDelay,
	waitForWorkflowCompletion,
	calculateDuration,
	validateWorkflowInputs,
};
