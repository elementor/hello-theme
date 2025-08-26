/**
 * Utility functions for the daily Hello Theme test matrix workflow
 */

const {
	getStatusEmoji,
	getStatusText,
	validateWorkflowData,
	pollWorkflows,
	generateStatusSummary,
	setJobStatus,
	generateResultLink,
} = require( './workflow-reporting.js' );

/**
 * Generates a daily trigger workflow report
 * @param {Object} github       - GitHub API client
 * @param {Object} context      - GitHub Actions context
 * @param {Object} core         - GitHub Actions core utilities
 * @param {Array}  workflowData - Array of workflow run data
 * @param {Object} timing       - Timing configuration object
 */
async function generateDailyTriggerReport( github, context, core, workflowData, timing ) {
	// eslint-disable-next-line no-console
	console.log( `Generating report for ${ workflowData.length } daily compatibility tests` );

	const validation = validateWorkflowData( workflowData );

	if ( ! validation.hasValidRuns ) {
		// eslint-disable-next-line no-console
		console.warn( 'No valid workflow run IDs found, generating preliminary report' );
		return;
	}

	// Poll workflows until completion
	const results = await pollWorkflows( github, context, validation.validRuns, timing, {
		logPrefix: 'daily workflows',
	} );

	// Generate and write report
	const summary = generateDailyMarkdownReport( results );
	await core.summary.addRaw( summary ).write();
	// eslint-disable-next-line no-console
	console.log( 'Generated daily trigger workflow report' );

	setJobStatus( core, results, 'Some daily workflows failed or encountered errors' );
}

/**
 * Generates a markdown report for daily trigger testing
 * @param {Array} results - Array of workflow results
 * @return {string} - Markdown formatted report
 */
function generateDailyMarkdownReport( results ) {
	const summary = generateStatusSummary( results );

	// Sort results by type and name for consistent display
	const sortedResults = sortDailyResults( results );

	let report = `# 🧪 Hello Theme Daily Test Matrix Results\n\n`;

	// Overall summary
	report += `## 📊 Summary\n\n`;
	report += `| Status | Count |\n`;
	report += `|--------|-------|\n`;
	report += `| ✅ Success | ${ summary.success } |\n`;
	report += `| ❌ Failed | ${ summary.failed } |\n`;
	report += `| ❌ Error | ${ summary.error } |\n`;
	if ( summary.running > 0 ) {
		report += `| 🔄 Running | ${ summary.running } |\n`;
	}
	if ( summary.cancelled > 0 ) {
		report += `| 🚫 Cancelled | ${ summary.cancelled } |\n`;
	}
	if ( summary.skipped > 0 ) {
		report += `| ⏭️ Skipped | ${ summary.skipped } |\n`;
	}
	report += `| **Total** | **${ summary.total }** |\n\n`;

	// Detailed results
	report += `## 📋 Detailed Results\n\n`;

	// Group by matrix type
	const coreTests = sortedResults.filter( ( r ) => r.combination && r.combination.includes( 'el' ) );
	const plusTests = sortedResults.filter( ( r ) => r.combination && r.combination.includes( 'hp' ) );

	if ( coreTests.length > 0 ) {
		report += `### ⚡ Hello Theme × Elementor Tests\n\n`;
		report += generateTestTable( coreTests );
		report += `\n`;
	}

	if ( plusTests.length > 0 ) {
		report += `### 🔌 Hello Theme × Hello Plus Tests\n\n`;
		report += generateTestTable( plusTests );
		report += `\n`;
	}

	// Footer
	report += `## 🎯 Matrix Strategy\n\n`;
	report += `- **Core Matrix**: Hello Theme × Elementor (main, latest, previous minors)\n`;
	report += `- **Plus Matrix**: Hello Theme × Hello Plus (latest, previous patch - WordPress.org only)\n`;
	report += `- **Versions**: Tests both main development and GA release combinations\n\n`;

	report += `*Generated at ${ new Date().toISOString() }*`;

	return report;
}

/**
 * Generates a test results table
 * @param {Array} tests - Array of test results
 * @return {string} - Markdown table
 */
function generateTestTable( tests ) {
	let table = `| Status | Test Name | Duration | Link |\n`;
	table += `|--------|-----------|----------|------|\n`;

	tests.forEach( ( test ) => {
		const emoji = getStatusEmoji( test.status, test.conclusion );
		const statusText = getStatusText( test.status, test.conclusion );
		const duration = test.duration ? `${ test.duration }m` : '-';
		const link = generateResultLink( test );

		table += `| ${ emoji } ${ statusText } | ${ test.name || test.combination } | ${ duration } | ${ link } |\n`;
	} );

	return table;
}

/**
 * Sorts daily test results for consistent display order
 * @param {Array} results - Array of workflow results
 * @return {Array} - Sorted array of results
 */
function sortDailyResults( results ) {
	return results.sort( ( a, b ) => {
		// First sort by matrix type (core vs plus)
		const aIsCore = a.combination && a.combination.includes( 'el' );
		const bIsCore = b.combination && b.combination.includes( 'el' );

		if ( aIsCore && ! bIsCore ) {
			return -1;
		}
		if ( ! aIsCore && bIsCore ) {
			return 1;
		}

		// Then sort by Hello Theme version (main first, then GA)
		const aIsMain = 'main' === a.hello_theme_version;
		const bIsMain = 'main' === b.hello_theme_version;

		if ( aIsMain && ! bIsMain ) {
			return -1;
		}
		if ( ! aIsMain && bIsMain ) {
			return 1;
		}

		// Finally sort by dependency version (main first, then latest, then previous)
		const aVersion = a.elementor_version || a.hello_plus_version || '';
		const bVersion = b.elementor_version || b.hello_plus_version || '';

		if ( 'main' === aVersion && bVersion !== 'main' ) {
			return -1;
		}
		if ( aVersion !== 'main' && 'main' === bVersion ) {
			return 1;
		}

		// Alphabetical fallback
		return ( a.name || a.combination || '' ).localeCompare( b.name || b.combination || '' );
	} );
}

module.exports = {
	generateDailyTriggerReport,
	generateDailyMarkdownReport,
	sortDailyResults,
};
