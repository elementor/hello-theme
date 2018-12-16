/**
 * Elementor Hello Theme Makefile
 */
'use strict';

module.exports = function( grunt ) {

	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

	// Project configuration.
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		sass: {
			dist: {
				files: [ {
					expand: true,
					cwd: 'assets/scss',
					src: '*.scss',
					dest: './',
					ext: '.css'
				} ]
			}
		},

		postcss: {
			dev: {
				options: {
					//map: true,

					processors: [
						require( 'autoprefixer' )( {
							browsers: 'last 10 versions'
						} )
					]
				},
				files: [ {
					src: [
						'*.css',
						'!*.min.css'
					]
				} ]
			},
			minify: {
				options: {
					processors: [
						require( 'autoprefixer' )( {
							browsers: 'last 10 versions'
						} ),
						require( 'cssnano' )()
					]
				},
				files: [ {
					//expand: true,
					src: [
						'*.css',
						'!*.min.css'
					],
					ext: '.min.css'
				} ]
			}
		},

		watch: {
			styles: {
				files: [
					'assets/scss/**/*.scss'
				],
				tasks: [ 'styles' ]
			}
		}

	} );

	grunt.registerTask( 'styles', [
		'sass',
		'postcss'
	] );

	// Default task(s).
	grunt.registerTask( 'default', [
		'styles'
	] );
};
