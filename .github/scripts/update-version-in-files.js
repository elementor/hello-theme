'use strict';

const replaceInFile = require( 'replace-in-file' );

const { VERSION } = process.env;

const replaceInFileWithLog = async ( options ) => {
	const results = await replaceInFile( options );
	console.log( 'Replacement results:', results, 'options: ', options );
};

const run = async () => {
	try {
		await replaceInFileWithLog( {
			files: './assets/scss/style.scss',
			from: /Version:.*$/m,
			to: `Version: ${ VERSION }`,
		} );

		await replaceInFileWithLog( {
			files: './assets/scss/style.scss',
			from: /Stable tag:.*$/m,
			to: `Stable tag: ${ VERSION }`,
		} );

		await replaceInFileWithLog( {
			files: './functions.php',
			from: /HELLO_ELEMENTOR_VERSION', '(.*?)'/m,
			to: `HELLO_ELEMENTOR_VERSION', '${ VERSION }'`,
		} );

		await replaceInFileWithLog( {
			files: './readme.txt',
			from: /Version:.*$/m,
			to: `Version: ${ VERSION }`,
		} );

		await replaceInFileWithLog( {
			files: './readme.txt',
			from: /Stable tag:.*$/m,
			to: `Stable tag: ${ VERSION }`,
		} );
	} catch ( err ) {
		// eslint-disable-next-line no-console
		console.error( 'Error occurred:', err );
		process.exit( 1 );
	}
};

run();
