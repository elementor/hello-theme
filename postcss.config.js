module.exports = {
	plugins: [
		require( 'postcss-custom-media' ),
		require( '@wordpress/postcss-plugins-preset' ),
		...( 'production' === process.env.NODE_ENV ? [ require( 'cssnano' )( { preset: 'default' } ) ] : [] ),
	],
};
