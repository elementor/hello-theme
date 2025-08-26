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
if ( fs.existsSync( './tmp/hello-theme' ) ) {
	wpEnv.themes = [ './tmp/hello-theme' ];
	// eslint-disable-next-line no-console
	console.log( '✅ Using built Hello Theme from ./tmp/hello-theme' );
} else {
	// eslint-disable-next-line no-console
	console.error( 'Built Hello Theme not found at ./tmp/hello-theme' );
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
	console.log( '🔍 =============================================' );
	// eslint-disable-next-line no-console
	console.log( '🔍 BUILD-WP-ENV.JS ELEMENTOR DEBUG' );
	// eslint-disable-next-line no-console
	console.log( '🔍 =============================================' );
	// eslint-disable-next-line no-console
	console.log( `🎯 ELEMENTOR_VERSION: "${ ELEMENTOR_VERSION }"` );

	if ( 'latest-stable' === ELEMENTOR_VERSION ) {
		// Use WordPress.org directly for latest-stable (most reliable)
		wpEnv.plugins.push( 'https://downloads.wordpress.org/plugin/elementor.latest-stable.zip' );
		// eslint-disable-next-line no-console
		console.log( '✅ Using WordPress.org Elementor latest-stable (direct)' );
	} else if ( ELEMENTOR_VERSION.match( /^v?[0-9]+\.[0-9]+\.[0-9]+$/ ) ) {
		// Use WordPress.org directly for semantic versions (e.g., 3.30.4, v3.30.4)
		const cleanVersion = ELEMENTOR_VERSION.replace( /^v/, '' );
		wpEnv.plugins.push( `https://downloads.wordpress.org/plugin/elementor.${ cleanVersion }.zip` );
		// eslint-disable-next-line no-console
		console.log( `✅ Using WordPress.org Elementor ${ cleanVersion } (direct)` );
	} else if ( fs.existsSync( './tmp/elementor' ) ) {
		// GitHub branches (main, feature-branch) - expect built artifacts from workflow
		// eslint-disable-next-line no-console
		console.log( `🔍 Using GitHub built artifacts for Elementor ${ ELEMENTOR_VERSION }` );
		// Debug: Verify Elementor directory structure
		// eslint-disable-next-line no-console
		console.log( '🔍 DEBUG: Elementor directory found, verifying structure...' );
		try {
			const elementorContents = fs.readdirSync( './tmp/elementor' );
			// eslint-disable-next-line no-console
			console.log( `📁 Elementor directory contents (${ elementorContents.length } items):`, elementorContents.slice( 0, 10 ) );

			// Check for main plugin file
			if ( fs.existsSync( './tmp/elementor/elementor.php' ) ) {
				// eslint-disable-next-line no-console
				console.log( '✅ Main plugin file found: elementor.php' );

				// Read plugin header for verification
				try {
					const pluginContent = fs.readFileSync( './tmp/elementor/elementor.php', 'utf8' );
					const headerMatch = pluginContent.match( /Plugin Name:\s*(.+)/i );
					const versionMatch = pluginContent.match( /Version:\s*(.+)/i );
					if ( headerMatch ) {
						// eslint-disable-next-line no-console
						console.log( `📄 Plugin Name: ${ headerMatch[ 1 ].trim() }` );
					}
					if ( versionMatch ) {
						// eslint-disable-next-line no-console
						console.log( `🏷️  Plugin Version: ${ versionMatch[ 1 ].trim() }` );
					}
				} catch ( error ) {
					// eslint-disable-next-line no-console
					console.log( '⚠️  Could not read plugin header:', error.message );
				}
			} else {
				// eslint-disable-next-line no-console
				console.log( '❌ Main plugin file missing: elementor.php' );
				const phpFiles = elementorContents.filter( ( file ) => file.endsWith( '.php' ) );
				// eslint-disable-next-line no-console
				console.log( `🔍 Available PHP files (${ phpFiles.length }):`, phpFiles.slice( 0, 5 ) );
			}

			// Check for essential directories
			const essentialDirs = [ 'includes', 'assets' ];
			essentialDirs.forEach( ( dir ) => {
				if ( fs.existsSync( `./tmp/elementor/${ dir }` ) ) {
					// eslint-disable-next-line no-console
					console.log( `✅ Essential directory found: ${ dir }` );
				} else {
					// eslint-disable-next-line no-console
					console.log( `⚠️  Essential directory missing: ${ dir }` );
				}
			} );
		} catch ( error ) {
			// eslint-disable-next-line no-console
			console.error( '❌ Error reading Elementor directory:', error.message );
		}

		// Check if local Elementor installation is valid
		const isValidElementor = fs.existsSync( './tmp/elementor/elementor.php' ) &&
			fs.existsSync( './tmp/elementor/includes' ) &&
			fs.existsSync( './tmp/elementor/assets' );

		if ( isValidElementor ) {
			// Use the GitHub built artifacts for branches
			wpEnv.plugins.push( './tmp/elementor' );
			// eslint-disable-next-line no-console
			console.log( `✅ Using GitHub built artifacts for Elementor ${ ELEMENTOR_VERSION }` );
		} else {
			// GitHub artifacts should be valid - if not, something went wrong in workflow
			// eslint-disable-next-line no-console
			console.error( `❌ Invalid GitHub artifacts for Elementor ${ ELEMENTOR_VERSION }` );
			// eslint-disable-next-line no-console
			console.error( 'Expected workflow to provide valid built artifacts in ./tmp/elementor' );
			process.exit( 1 );
		}
	} else {
		// eslint-disable-next-line no-console
		console.error( `❌ Elementor directory not found at ./tmp/elementor for branch/commit: ${ ELEMENTOR_VERSION }` );
		// eslint-disable-next-line no-console
		console.error( 'Note: Semantic versions (e.g., 3.30.4) and latest-stable are downloaded directly from WordPress.org' );
		process.exit( 1 );
	}

	// eslint-disable-next-line no-console
	console.log( '🔍 =============================================' );
	// eslint-disable-next-line no-console
	console.log( '🔍 END BUILD-WP-ENV.JS ELEMENTOR DEBUG' );
	// eslint-disable-next-line no-console
	console.log( '🔍 =============================================' );
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
console.log( '✅ wp-env.json updated successfully' );
