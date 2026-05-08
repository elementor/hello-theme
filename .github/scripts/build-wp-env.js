'use strict';

const fs = require( 'fs' );

const wpEnv = require( '../../.wp-env.json' );
const {
	PHP_VERSION,
	WP_CORE_VERSION,
	HELLO_THEME_VERSION,
	HELLO_PLUS_VERSION,
	ELEMENTOR_VERSION,
} = process.env;

if ( ! PHP_VERSION ) {
	// eslint-disable-next-line no-console
	console.error( 'missing env var PHP_VERSION' );
	process.exit( 1 );
}

if ( ! WP_CORE_VERSION ) {
	// eslint-disable-next-line no-console
	console.error( 'missing env var WP_CORE_VERSION' );
	process.exit( 1 );
}

// Set WordPress core version
let wpCore = null;
if ( WP_CORE_VERSION !== 'latest' ) {
	wpCore = `WordPress/WordPress#${ WP_CORE_VERSION }`;
}

// Set PHP version
wpEnv.phpVersion = PHP_VERSION;
wpEnv.core = wpCore;

// Configure themes - Require built Hello Theme to avoid false positives
if ( fs.existsSync( './tmp/hello-elementor' ) ) {
	wpEnv.themes = [ './tmp/hello-elementor' ];
	// eslint-disable-next-line no-console
	console.log( 'Using built Hello Theme from ./tmp/hello-elementor' );
} else {
	// eslint-disable-next-line no-console
	console.error( 'Built Hello Theme not found at ./tmp/hello-elementor' );
	// eslint-disable-next-line no-console
	console.error( 'This prevents false positives from using unbuild source theme' );
	// eslint-disable-next-line no-console
	console.error( 'Current directory contents:' );
	// eslint-disable-next-line no-console
	console.error( fs.readdirSync( '.' ) );
	if ( fs.existsSync( './tmp' ) ) {
		// eslint-disable-next-line no-console
		console.error( './tmp contents:' );
		// eslint-disable-next-line no-console
		console.error( fs.readdirSync( './tmp' ) );
	}
	process.exit( 1 );
}

// Add Hello Plus if available (for Plus matrix tests)
if ( HELLO_PLUS_VERSION && fs.existsSync( './tmp/hello-plus' ) ) {
	wpEnv.themes.push( './tmp/hello-plus' );
}

// Configure plugins
wpEnv.plugins = [];

// Add Elementor plugin
if ( ELEMENTOR_VERSION ) {
	// eslint-disable-next-line no-console
	console.log( `ELEMENTOR_VERSION: "${ ELEMENTOR_VERSION }"` );

	const isValidLocalElementor = fs.existsSync( './tmp/elementor/elementor.php' ) &&
		fs.existsSync( './tmp/elementor/includes' ) &&
		fs.existsSync( './tmp/elementor/assets' );

	if ( isValidLocalElementor ) {
		// Prefer the artifact downloaded during the build job. This pins the exact
		// Elementor binary across both jobs and prevents version drift when
		// 'latest-stable' is updated between the build and test steps.
		wpEnv.plugins.push( './tmp/elementor' );
		// eslint-disable-next-line no-console
		console.log( 'Using local Elementor artifact from ./tmp/elementor (pinned from build job)' );
	} else if ( ELEMENTOR_VERSION === 'latest-stable' ) {
		wpEnv.plugins.push( 'https://downloads.wordpress.org/plugin/elementor.latest-stable.zip' );
		// eslint-disable-next-line no-console
		console.log( 'Using Elementor latest-stable from WordPress.org' );
	} else if ( ELEMENTOR_VERSION.match( /^v?[0-9]+\.[0-9]+\.[0-9]+$/ ) ) {
		const cleanVersion = ELEMENTOR_VERSION.replace( /^v/, '' );
		wpEnv.plugins.push( `https://downloads.wordpress.org/plugin/elementor.${ cleanVersion }.zip` );
		// eslint-disable-next-line no-console
		console.log( `Using WordPress.org Elementor ${ cleanVersion } (direct)` );
	} else {
		if ( fs.existsSync( './tmp/elementor' ) ) {
			// eslint-disable-next-line no-console
			console.error( `Elementor artifact at ./tmp/elementor is incomplete for ${ ELEMENTOR_VERSION } (missing elementor.php, includes, or assets)` );
		} else {
			// eslint-disable-next-line no-console
			console.error( `Elementor directory not found at ./tmp/elementor for ${ ELEMENTOR_VERSION }` );
		}
		wpEnv.plugins.push( 'https://downloads.wordpress.org/plugin/elementor.latest-stable.zip' );
		// eslint-disable-next-line no-console
		console.log( `Falling back to Elementor latest-stable from WordPress.org for ${ ELEMENTOR_VERSION }` );
	}
}

// Test configuration
wpEnv.config = {
	...wpEnv.config,
	ELEMENTOR_SHOW_HIDDEN_EXPERIMENTS: true,
	SCRIPT_DEBUG: false,
	WP_DEBUG: true,
	WP_DEBUG_LOG: true,
	WP_DEBUG_DISPLAY: false,
};

// Add version info for debugging
if ( HELLO_THEME_VERSION ) {
	wpEnv.config.HELLO_THEME_VERSION = HELLO_THEME_VERSION;
}
if ( HELLO_PLUS_VERSION ) {
	wpEnv.config.HELLO_PLUS_VERSION = HELLO_PLUS_VERSION;
}

// eslint-disable-next-line no-console
console.log( 'Building wp-env configuration:' );
// eslint-disable-next-line no-console
console.log( `- PHP Version: ${ PHP_VERSION }` );
// eslint-disable-next-line no-console
console.log( `- WP Core: ${ wpCore || 'latest' }` );
// eslint-disable-next-line no-console
console.log( `- Hello Theme: ${ HELLO_THEME_VERSION || 'current' }` );
// eslint-disable-next-line no-console
console.log( `- Hello Plus: ${ HELLO_PLUS_VERSION || 'not included' }` );
// eslint-disable-next-line no-console
console.log( `- Elementor: ${ ELEMENTOR_VERSION || 'latest-stable' }` );
// eslint-disable-next-line no-console
console.log( `- Themes: ${ wpEnv.themes.join( ', ' ) }` );
// eslint-disable-next-line no-console
console.log( `- Plugins: ${ wpEnv.plugins.join( ', ' ) }` );

fs.writeFileSync( '.wp-env.json', JSON.stringify( wpEnv, null, 4 ) );
// eslint-disable-next-line no-console
console.log( 'wp-env.json updated successfully' );
