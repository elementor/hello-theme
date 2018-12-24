/**
 * Grunt scss task config
 */
const sass = {
	dist: {
		files: [ {
			expand: true,
			cwd: 'assets/scss',
			src: '*.scss',
			dest: './',
			ext: '.css'
		} ]
	}
};

module.exports = sass;
