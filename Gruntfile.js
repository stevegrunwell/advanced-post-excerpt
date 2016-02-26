module.exports = function(grunt) {

	grunt.initConfig({
		copy: {
			main: {
				src: [
					'languages/*',
					'advanced-post-excerpt.php',
					'LICENSE.md',
					'readme.txt'
				],
				dest: 'dist/'
			},
		},
		makepot: {
			target: {
				options: {
					domainPath: 'languages/',
					mainFile: 'advanced-post-excerpt.php',
					type: 'wp-plugin',
					updateTimestamp: false,
					updatePoFiles: true
				}
			}
	}
	});

	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-wp-i18n');

	grunt.registerTask('i18n', ['makepot']);
	grunt.registerTask('build', ['makepot', 'copy']);
};