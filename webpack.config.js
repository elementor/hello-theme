/**
 * Grunt webpack task config
 *
 * @package
 */
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const CopyPlugin = require( 'copy-webpack-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );

const entry = {
	'hello-editor': path.resolve( __dirname, './assets/dev/js/editor/hello-editor.js' ),
	'hello-frontend': path.resolve( __dirname, './assets/dev/js/frontend/hello-frontend.js' ),
	'hello-admin': path.resolve( __dirname, './assets/dev/js/admin/hello-admin.js' ),
};

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
					// ignore minified php files
					...Object.keys( entry ).map( ( key ) => `**/assets/js/${ key }.min.asset.php` ),
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
		...defaultConfig.module.rules,
		{
			test: /\.js$/,
			exclude: /node_modules/,
			use: [
				{
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-env', '@babel/preset-react' ],
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

const commonConfig = {
	...defaultConfig,
	target: 'web',
	context: __dirname,
	module: moduleRules,
	entry,
	output: {
		...defaultConfig.output,
		path: path.resolve( __dirname, './assets/js' ),
		filename: '[name].js',
	},
};

const webpackConfig = {
	...commonConfig,
	mode: 'development',
	output: {
		...commonConfig.output,
		devtoolModuleFilenameTemplate: './[resource]',
	},
	entry: {
		...entry,
	},
	devtool: 'source-map',
};

const webpackProductionConfig = {
	...commonConfig,
	mode: 'production',
	optimization: {
		...defaultConfig.optimization || {},
		minimize: false,
		minimizer: [
			new TerserPlugin( {
				terserOptions: {
					keep_fnames: true,
				},
				include: /\.min\.js$/,
			} ),
		],
	},
	performance: { hints: false },
};

// Add minified entry points
Object.entries( webpackProductionConfig.entry ).forEach( ( [ wpEntry, value ] ) => {
	webpackProductionConfig.entry[ wpEntry + '.min' ] = value;
} );

// Override copyPluginConfig
// we first remove the one supplied by @wordpress/scripts
webpackProductionConfig.plugins = webpackProductionConfig.plugins.filter( ( plugin ) => {
	return plugin.constructor.name !== 'CopyPlugin';
} );
// then we add our own
webpackProductionConfig.plugins = [ copyPluginConfig, ...defaultConfig.plugins ];

module.exports = ( env ) => {
	if ( env.developmentLocal ) {
		return { ...webpackConfig, watch: true };
	}

	if ( env.production ) {
		return webpackProductionConfig;
	}

	if ( env.development ) {
		return webpackConfig;
	}

	throw new Error( 'missing or invalid --env= development/production/developmentWithWatch/productionWithWatch' );
};
