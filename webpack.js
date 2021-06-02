/**
 * Grunt webpack task config
 * @package Elementor
 */
const path = require( 'path' );

const TerserPlugin = require( 'terser-webpack-plugin' );

const moduleRules = {
	rules: [
		{
			test: /\.js$/,
			exclude: /node_modules/,
			use: [
				{
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-env' ],
						plugins: [
							[ '@babel/plugin-proposal-class-properties' ],
							[ '@babel/plugin-transform-runtime' ],
							[ '@babel/plugin-transform-modules-commonjs' ],
							[ '@babel/plugin-proposal-optional-chaining' ],
						],
					},
				},
			],
		},
	],
};

const entry = {
	'hello-editor': path.resolve( __dirname, './assets/dev/js/editor/hello-editor.js' ),
	'hello-frontend': path.resolve( __dirname, './assets/dev/js/frontend/hello-frontend.js' ),
};

const webpackConfig = {
	target: 'web',
	context: __dirname,
	devtool: 'source-map',
	module: moduleRules,
	entry: entry,
	mode: 'development',
	output: {
		path: path.resolve( __dirname, './assets/js' ),
		filename: '[name].js',
		devtoolModuleFilenameTemplate: './[resource]',
	},
	watch: true,
};

const webpackProductionConfig = {
	target: 'web',
	context: __dirname,
	devtool: 'source-map',
	module: moduleRules,
	entry: {
		...entry,
	},
	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin( {
				terserOptions: {
					keep_fnames: true,
				},
				include: /\.min\.js$/
			} ),
		],
	},
	mode: 'production',
	output: {
		path: path.resolve( __dirname, './assets/js' ),
		filename: '[name].js',
	},
	performance: { hints: false },
};

// Add minified entry points
Object.entries( webpackProductionConfig.entry ).forEach( ( [ entry, value ] ) => {
	webpackProductionConfig.entry[ entry + '.min' ] = value;

	delete webpackProductionConfig.entry[ entry ];
} );


const gruntWebpackConfig = {
	development: webpackConfig,
	production: webpackProductionConfig
};

module.exports = gruntWebpackConfig;
