/**
 * Grunt postcss task config
 */
module.exports = {
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
};
