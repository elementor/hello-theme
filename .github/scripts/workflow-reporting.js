/**
 * Base utility functions for workflow reporting
 * Shared functionality between different workflow report types
 * Adapted for Hello Theme compatibility testing
 */

/**
 * Gets default configuration for workflow polling
 * @return {Object} - Default configuration object with timing settings
 */
function getDefaultPollingConfig() {
	return {
		maxWaitTime: 50 * 60 * 1000, // 50 minutes
		initialWait: 15 * 60 * 1000, // 15 minutes
		pollInterval: 3 * 60 * 1000, // 3 minutes
	};
}

/**
 * Gets timing configuration for daily trigger workflows
 * @return {Object} - Configuration object with timing settings including trigger delays
 */
function getDailyTriggerTimingConfig() {
	return {
		...getDefaultPollingConfig(),
		triggerDelays: {
			'ht-main-el-main': 0, // No delay for first trigger
			'ht-main-el-latest': 15, // 15 seconds delay
			'ht-main-el-prev': 30, // 30 seconds delay
			'ht-ga-el-main': 45, // 45 seconds delay
			'ht-main-hp-latest': 60, // 60 seconds delay
			'ht-main-hp-prev': 75, // 75 seconds delay
			'ht-ga-hp-latest': 90, // 90 seconds delay
			'ht-ga-hp-prev': 105, // 105 seconds delay
		},
	};
}

/**
 * Generates status emoji based on workflow status and conclusion
 * @param {string}  status                 - Workflow status
 * @param {string}  conclusion             - Workflow conclusion
 * @param {Object}  options                - Additional options for status handling
 * @param {boolean} options.supportMissing - Whether to support 'missing' status
 * @return {string} - Emoji representing the status
 */
function getStatusEmoji( status, conclusion, options = {} ) {
	const { supportMissing = false } = options;

	if ( supportMissing && ( 'missing' === status || 'missing' === conclusion ) ) {
		return '⚠️';
	}

	if ( 'error' === status || 'error' === conclusion ) {
		return '❌';
	}

	if ( status !== 'completed' ) {
		return '🔄';
	}

	switch ( conclusion ) {
		case 'success':
			return '✅';
		case 'failure':
			return '❌';
		case 'cancelled':
			return '🚫';
		case 'skipped':
			return '⏭️';
		default:
			return '❓';
	}
}

/**
 * Generates status text based on workflow status and conclusion
 * @param {string}  status                 - Workflow status
 * @param {string}  conclusion             - Workflow conclusion
 * @param {Object}  options                - Additional options for status handling
 * @param {boolean} options.supportMissing - Whether to support 'missing' status
 * @return {string} - Human readable status text
 */
function getStatusText( status, conclusion, options = {} ) {
	const { supportMissing = false } = options;

	if ( supportMissing && ( 'missing' === status || 'missing' === conclusion ) ) {
		return 'Missing';
	}

	if ( 'error' === status || 'error' === conclusion ) {
		return 'Error';
	}

	if ( status !== 'completed' ) {
		return 'Running';
	}

	switch ( conclusion ) {
		case 'success':
			return 'Success';
		case 'failure':
			return 'Failed';
		case 'cancelled':
			return 'Cancelled';
		case 'skipped':
			return 'Skipped';
		default:
			return 'Unknown';
	}
}

/**
 * Validates and filters workflow data
 * @param {Array} workflowData - Array of workflow run data
 * @return {Object} - Validation results object
 */
function validateWorkflowData( workflowData ) {
	const validRuns = workflowData.filter( ( run ) => run && run.id && ! isNaN( run.id ) );
	const uniqueIds = [ ...new Set( validRuns.map( ( run ) => run.id ) ) ];

	return {
		total: workflowData.length,
		valid: validRuns.length,
		invalid: workflowData.length - validRuns.length,
		validRuns,
		hasValidRuns: validRuns.length > 0,
		hasDuplicates: uniqueIds.length !== validRuns.length,
	};
}

/**
 * Core workflow polling logic
 * @param {Object}   github                      - GitHub API client
 * @param {Object}   context                     - GitHub Actions context
 * @param {Array}    workflowData                - Array of workflow run data
 * @param {Object}   timing                      - Timing configuration object
 * @param {Object}   options                     - Additional options for polling behavior
 * @param {Function} options.preprocessWorkflows - Function to preprocess workflows before polling
 * @param {Function} options.createResult        - Function to create result object from workflow run
 * @param {string}   options.logPrefix           - Prefix for log messages
 * @return {Array} - Array of results with status information
 */
async function pollWorkflows( github, context, workflowData, timing, options = {} ) {
	const {
		preprocessWorkflows = ( workflows ) => ( { actualWorkflows: workflows, additionalResults: [] } ),
		createResult = ( workflow, workflowRun ) => ( {
			...workflow,
			status: workflowRun.status,
			conclusion: workflowRun.conclusion,
			duration: workflowRun.updated_at
				? Math.round( ( new Date( workflowRun.updated_at ) - new Date( workflowRun.created_at ) ) / 1000 / 60 ) : 0,
			created_at: workflowRun.created_at,
			updated_at: workflowRun.updated_at,
		} ),
		logPrefix = 'workflows',
	} = options;

	const { maxWaitTime, initialWait, pollInterval } = timing;
	const startTime = Date.now();

	// Initial wait
	// eslint-disable-next-line no-console
	console.log( `Waiting ${ initialWait / 1000 / 60 } minutes before starting to poll workflow statuses...` );
	await new Promise( ( resolve ) => setTimeout( resolve, initialWait ) );
	// eslint-disable-next-line no-console
	console.log( `Starting to poll ${ logPrefix } statuses...` );

	let allCompleted = false;
	const results = [];

	// Preprocess workflows (e.g., separate missing entries)
	const { actualWorkflows, additionalResults } = preprocessWorkflows( workflowData );

	// Add any additional results (e.g., missing entries)
	results.push( ...additionalResults );

	// eslint-disable-next-line no-console
	console.log( `Polling ${ actualWorkflows.length } actual workflows, ${ additionalResults.length } additional entries` );

	while ( ! allCompleted && ( Date.now() - startTime ) < maxWaitTime ) {
		allCompleted = true;

		for ( const workflow of actualWorkflows ) {
			try {
				const response = await github.rest.actions.getWorkflowRun( {
					owner: context.repo.owner,
					repo: context.repo.repo,
					run_id: workflow.id,
				} );

				const workflowRun = response.data;
				const status = workflowRun.status;

				if ( status !== 'completed' ) {
					allCompleted = false;
				}

				// Update or add result
				const existingIndex = results.findIndex( ( r ) => r.id === workflow.id );
				const result = createResult( workflow, workflowRun );

				if ( existingIndex >= 0 ) {
					results[ existingIndex ] = result;
				} else {
					results.push( result );
				}
			} catch ( error ) {
				// eslint-disable-next-line no-console
				console.log( `Error checking run ${ workflow.id }: ${ error.message }` );
				if ( ! results.find( ( r ) => r.id === workflow.id ) ) {
					results.push( {
						...workflow,
						status: 'error',
						conclusion: 'error',
						duration: 0,
						error: error.message,
					} );
				}
			}
		}

		if ( ! allCompleted ) {
			const elapsedMinutes = Math.round( ( Date.now() - startTime ) / 1000 / 60 );
			const completedCount = results.filter( ( r ) => 'completed' === r.status ).length;
			// eslint-disable-next-line no-console
			console.log( `Polling... ${ completedCount }/${ actualWorkflows.length } ${ logPrefix } completed (${ elapsedMinutes } minutes elapsed)` );
			await new Promise( ( resolve ) => setTimeout( resolve, pollInterval ) );
		}
	}

	return results;
}

/**
 * Generates common status summary statistics
 * @param {Array}   results                - Array of workflow results
 * @param {Object}  options                - Options for summary generation
 * @param {boolean} options.includeMissing - Whether to include missing count
 * @return {Object} - Object containing status counts
 */
function generateStatusSummary( results, options = {} ) {
	const { includeMissing = false } = options;

	const summary = {
		total: results.length,
		success: results.filter( ( r ) => 'success' === r.conclusion ).length,
		failed: results.filter( ( r ) => 'failure' === r.conclusion ).length,
		error: results.filter( ( r ) => 'error' === r.status ).length,
		cancelled: results.filter( ( r ) => 'cancelled' === r.conclusion ).length,
		skipped: results.filter( ( r ) => 'skipped' === r.conclusion ).length,
		running: results.filter( ( r ) => r.status !== 'completed' && r.status !== 'error' ).length,
	};

	if ( includeMissing ) {
		summary.missing = results.filter( ( r ) => 'missing' === r.status ).length;
	}

	return summary;
}

/**
 * Sets job status based on results
 * @param {Object} core           - GitHub Actions core utilities
 * @param {Array}  results        - Array of workflow results
 * @param {string} contextMessage - Context message for the failure
 */
function setJobStatus( core, results, contextMessage = 'Some workflows failed or encountered errors' ) {
	const errors = results.filter( ( r ) => 'error' === r.status ).length;
	const failed = results.filter( ( r ) => 'failure' === r.conclusion ).length;

	if ( errors > 0 || failed > 0 ) {
		core.setFailed( `${ contextMessage }. Failed: ${ failed }, Errors: ${ errors }` );
	}
}

/**
 * Generates a standard link for workflow result
 * @param {Object}  result                 - Test result object
 * @param {Object}  options                - Options for link generation
 * @param {boolean} options.supportMissing - Whether to support missing status
 * @return {string} - Link or status text
 */
function generateResultLink( result, options = {} ) {
	const { supportMissing = false } = options;

	if ( supportMissing && ( 'missing' === result.status || 'missing' === result.conclusion ) ) {
		return 'Missing';
	}

	if ( result.url ) {
		return `[View Run](${ result.url })`;
	}
	return 'No Link';
}

module.exports = {
	getDefaultPollingConfig,
	getDailyTriggerTimingConfig,
	getStatusEmoji,
	getStatusText,
	validateWorkflowData,
	pollWorkflows,
	generateStatusSummary,
	setJobStatus,
	generateResultLink,
};
