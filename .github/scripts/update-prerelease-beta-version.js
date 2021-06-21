'use strict';

const semverInc = require( 'semver/functions/inc' );
const packageJson = require( '../../package.json' );
const fs = require( 'fs' );

const bumpVersion = (relativeVersion, lastVersionTagName, bumpsFromCurrentVersion = 1) => {
	const lastVersion = packageJson[lastVersionTagName] || '';
	let expectedVersion = relativeVersion;
	(new Array( bumpsFromCurrentVersion ).fill( 1 )).forEach(() => {
		expectedVersion = semverInc( expectedVersion, 'minor' );
	});
	let currentLastVersionNumber = 0;

if (lastVersion) {
	const splitVersion = lastVersion.split( `-beta` );
	if (splitVersion[0] === expectedVersion) {
		const currentLastVersion = splitVersion[splitVersion.length - 1];
		currentLastVersionNumber = Number( currentLastVersion );
		if (Number.isNaN( currentLastVersionNumber )) {
			console.error( `invalid beta version: ${currentLastVersion}` );
			process.exit( 1 );
			return;
		}
	}
}

	const newVersion = `${expectedVersion}-beta${currentLastVersionNumber + 1}`;
	packageJson[lastVersionTagName] = newVersion;
	fs.writeFileSync( './package.json', JSON.stringify( packageJson, null, 4 ) );
	console.log( newVersion );
}

const relativeVersion = packageJson.version;
bumpVersion( relativeVersion, 'last_beta_version' );
