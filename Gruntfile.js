/**
 * Elementor Hello Theme Makefile
 */

module.exports = function( grunt ) {
	'use strict';

	const fs = require( 'fs' ),
		pkgInfo = grunt.file.readJSON( 'package.json' );

	require( 'load-grunt-tasks' )( grunt );

	// Project configuration
	grunt.initConfig( {
		pkg: pkgInfo,

		banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
			'<%= grunt.template.today("dd-mm-yyyy") %> */',

		checktextdomain: require( './.grunt-config/checktextdomain' ),
		sass: require( './.grunt-config/sass' ),
		postcss: require( './.grunt-config/postcss' ),
		watch: require( './.grunt-config/watch' ),
		wp_readme_to_markdown: require( './.grunt-config/wp_readme_to_markdown' ),
	} );

	// Default task(s).
	grunt.registerTask( 'default', [
		'i18n',
		'wp_readme_to_markdown',
		'styles',
	] );

	grunt.registerTask( 'i18n', [
		'checktextdomain',
	] );

	grunt.registerTask( 'styles', [
		'sass',
		'postcss'
	] );

	// Default task(s).
	grunt.registerTask( 'default', [
		'styles'
	] );
};
