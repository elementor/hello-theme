module.exports = {
	extends: [
		'plugin:react/recommended',
		'plugin:no-jquery/deprecated',
		'plugin:@wordpress/eslint-plugin/recommended-with-formatting',
		'plugin:prettier/recommended',
	],
	plugins: ['babel', 'react', 'no-jquery'],
	parser: '@babel/eslint-parser',
	globals: {
		wp: true,
		window: true,
		document: true,
		_: false,
		jQuery: false,
		JSON: false,
		elementorFrontend: true,
		require: true,
		elementor: true,
		DialogsManager: true,
		module: true,
		React: true,
		PropTypes: true,
		__: true,
	},
	parserOptions: {
		ecmaVersion: 2017,
		sourceType: 'module',
		ecmaFeatures: {
			jsx: true,
		},
	},
	rules: {
		'no-undef': 'off',
		'no-unused-vars': 'off',
		yoda: [
			'error',
			'always',
			{
				onlyEquality: true,
			},
		],
	},
};
