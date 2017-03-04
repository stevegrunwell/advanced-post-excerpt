module.exports = function(grunt) {

	grunt.initConfig({
		copy: {
			main: {
				src: [
					'languages/*',
					'advanced-post-excerpt.php',
					'CHANGELOG.md',
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
					exclude: ['dist/*', 'node_modules/*', 'plugin-repo-assets/*', 'tests/*', 'vendor/*'],
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