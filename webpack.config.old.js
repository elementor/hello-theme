/**
 * Grunt webpack task config
 *
 * @package
 */
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const TerserPlugin = require( 'terser-webpack-plugin' );

const entry = {
	'hello-editor': path.resolve( __dirname, './assets/dev/js/editor/hello-editor.js' ),
	'hello-frontend': path.resolve( __dirname, './assets/dev/js/frontend/hello-frontend.js' ),
	'hello-home-app': path.resolve( __dirname, './modules/admin-home/assets/js//hello-elementor-admin.js' ),
	'hello-elementor-menu': path.resolve( __dirname, './modules/admin-home/assets/js//hello-elementor-menu.js' ),
	'hello-elementor-settings': path.resolve( __dirname, './modules/admin-home/assets/js//hello-elementor-settings.js' ),
	'hello-elementor-topbar': path.resolve( __dirname, './modules/admin-home/assets/js/hello-elementor-topbar.js' ),
	'hello-conversion-banner': path.resolve( __dirname, './modules/admin-home/assets/js//hello-elementor-conversion-banner.js' ),
};

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
							[ '@babel/plugin-syntax-dynamic-import' ],
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

const webpackConfigOld = {
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
	performance: { hints: false },
};

// Add minified entry points
Object.entries( webpackProductionConfig.entry ).forEach( ( [ wpEntry, value ] ) => {
	webpackProductionConfig.entry[ wpEntry + '.min' ] = value;
} );

webpackProductionConfig.plugins = defaultConfig.plugins;

module.exports = ( env ) => {
	if ( env.developmentLocal ) {
		return { ...webpackConfigOld, watch: true };
	}

	if ( env.production ) {
		return webpackProductionConfig;
	}

	if ( env.development ) {
		return webpackConfigOld;
	}

	throw new Error( 'missing or invalid --env= development/production/developmentWithWatch/productionWithWatch' );
};
