/**
 * Grunt webpack task config
 * @package Elementor
 */
const path = require( 'path' );

const CopyPlugin = require( 'copy-webpack-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );

const copyPluginConfig = new CopyPlugin( {
	patterns: [
		{
			from: '**/*',
			context: __dirname,
			to: path.resolve( __dirname, 'build' ),
			// Terser skip this file for minimization
			info: { minimized: true },
			globOptions: {
				ignore: [
					'**.zip',
					'**.css',
					'**/karma.conf.js',
					'**/assets/dev/**',
					'**/assets/scss/**',
					'**/assets/js/qunit-tests*',
					'**/bin/**',
					'**/build/**',
					'**/composer.json',
					'**/composer.lock',
					'**/Gruntfile.js',
					'**/node_modules/**',
					'**/npm-debug.log',
					'**/package-lock.json',
					'**/package.json',
					'**/phpcs.xml',
					'**/README.md',
					'**/webpack.config.js',
					'**/vendor/**',
				],
			},
		},
	],
} );

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
	module: moduleRules,
	entry: entry,
	mode: 'development',
	output: {
		path: path.resolve( __dirname, './build/assets/js' ),
		filename: '[name].js',
		devtoolModuleFilenameTemplate: './[resource]',
	},
};

const webpackProductionConfig = {
	target: 'web',
	context: __dirname,
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
				include: /\.min\.js$/,
			} ),
		],
	},
	mode: 'production',
	output: {
		path: path.resolve( __dirname, './build/assets/js' ),
		filename: '[name].js',
	},
	performance: { hints: false },
};

// Add minified entry points
Object.entries( webpackProductionConfig.entry ).forEach( ( [ wpEntry, value ] ) => {
	webpackProductionConfig.entry[ wpEntry + '.min' ] = value;

	delete webpackProductionConfig.entry[ wpEntry ];
} );

const localOutputPath = { ...webpackProductionConfig.output, path: path.resolve( __dirname, './assets/js' ) };

module.exports = ( env ) => {
	if ( env.developmentLocalWithWatch ) {
		return { ...webpackConfig, watch: true, devtool: 'source-map', output: localOutputPath };
	}

	if ( env.productionLocalWithWatch ) {
		return { ...webpackProductionConfig, watch: true, devtool: 'source-map', output: localOutputPath };
	}

	if ( env.productionLocal ) {
		return { ...webpackProductionConfig, devtool: 'source-map', output: localOutputPath };
	}

	if ( env.developmentLocal ) {
		return { ...webpackConfig, devtool: 'source-map', output: localOutputPath };
	}

	if ( env.production ) {
		return webpackProductionConfig;
	}

	if ( env.development ) {
		return { ...webpackConfig, plugins: [ copyPluginConfig ] };
	}

	throw new Error( 'missing or invalid --env= development/production/developmentWithWatch/productionWithWatch' );
};
