'use strict';

const replaceInFile = require( 'replace-in-file' );
const pkg = require( '../package.json' );

const version = pkg.version;

const replaceInFileWithLog = async( options ) => {
	const results = await replaceInFile( options );
	console.log( 'Replacement results:', results, "options: ", options );
}

const run = async() => {
	try {
		await replaceInFileWithLog( {
			files: './assets/scss/style.scss',
			from: /Version:.*$/m,
			to: `Version: ${version}`,
		} );

		await replaceInFileWithLog( {
			files: './assets/scss/style.scss',
			from: /Stable tag:.*$/m,
			to: `Stable tag: ${version}`,
		} );

		await replaceInFileWithLog( {
			files: './functions.php',
			from: /HELLO_ELEMENTOR_VERSION', '(.*?)'/m,
			to: `HELLO_ELEMENTOR_VERSION', '${version}'`,
		} );

	} catch (err) {
		console.error( 'Error occurred:', err );
		process.exit( 1 );
	}
}

run();
