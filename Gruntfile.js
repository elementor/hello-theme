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
					expand: true,
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
		},

		checktextdomain: {
			options: {
				text_domain: 'hello-elementor',
				correct_domain: true,
				keywords: [
					// WordPress keywords
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src: [
					'**/*.php',
					'!docs/**',
					'!bin/**',
					'!node_modules/**',
					'!build/**',
					'!tests/**',
					'!.github/**',
					'!vendor/**',
					'!*~'
				],
				expand: true
			},
		},

		wp_readme_to_markdown: {
			readme: {
				files: {
					'README.md': 'readme.txt'
				}
			}
		}

	} );

	grunt.registerTask( 'i18n', [
		'checktextdomain',
	] );

	grunt.registerTask( 'wp_readme', [
		'wp_readme_to_markdown',
	] );

	grunt.registerTask( 'styles', [
		'sass',
		'postcss'
	] );

	// Default task(s).
	grunt.registerTask( 'default', [
		'i18n',
		'styles',
		'wp_readme',
	] );
};
