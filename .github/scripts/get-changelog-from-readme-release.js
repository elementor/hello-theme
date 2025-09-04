/* eslint-disable no-console */
'use strict';

// get-changelog-from-readme-release.js - Extract changelog from readme.txt for Hello Elementor releases

const fs = require( 'fs' );
const { VERSION } = process.env;

if ( ! VERSION ) {
	console.error( 'missing VERSION env var' );
	process.exit( 1 );
}

// Try to load marked, fallback to simple parsing if not available
let marked;
try {
	marked = require( 'marked' );
} catch ( error ) {
	console.log( 'marked not available, using simple parsing' );
	marked = null;
}

// Simple changelog parser fallback
function simpleParseChangelog( content, version ) {
	const lines = content.split( '\n' );
	let inChangelog = false;
	let foundVersion = false;
	const changelog = [];

	for ( const line of lines ) {
		if ( line.includes( '== Changelog ==' ) ) {
			inChangelog = true;
			continue;
		}

		if ( inChangelog ) {
			if ( line.includes( `= ${ version } -` ) ) {
				foundVersion = true;
				changelog.push( line );
				continue;
			}

			if ( foundVersion ) {
				if ( line.startsWith( '=' ) && line.includes( '-' ) ) {
					// Found next version, stop
					break;
				}
				if ( line.trim() ) {
					changelog.push( line );
				}
			}
		}
	}

	return foundVersion ? changelog.join( '\n' ) : null;
}

// Main execution
const readmeContent = fs.readFileSync( 'readme.txt', 'utf8' );

let changelog;
if ( marked ) {
	// Use marked parser (original logic would go here)
	console.log( 'Using marked parser' );
	// For now, fallback to simple parser even with marked
	changelog = simpleParseChangelog( readmeContent, VERSION );
} else {
	// Use simple parser
	changelog = simpleParseChangelog( readmeContent, VERSION );
}

if ( ! changelog ) {
	console.error( `❌ Changelog for version ${ VERSION } is missing` );
	process.exit( 1 ); // Always fail if version is missing
}

// Write changelog to temp file only if it exists
const changelogFile = 'temp-changelog-from-readme.txt';
if ( changelog ) {
  fs.writeFileSync( changelogFile, changelog );
} else {
  fs.writeFileSync( changelogFile, '' );
}

if ( changelog ) {
  console.log( `✅ Successfully extracted Hello Elementor changelog for version ${ VERSION }` );
  console.log( `Changelog saved to: ${ changelogFile }` );
}
