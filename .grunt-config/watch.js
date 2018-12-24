/**
 * Grunt watch task config
 */
const watch = {
	styles: {
		files: [
			'assets/scss/**/*.scss'
		],
		tasks: [ 'styles' ]
	}
};

module.exports = watch;
