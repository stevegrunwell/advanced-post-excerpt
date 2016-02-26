module.exports = function(grunt) {

  grunt.initConfig({
    copy: {
      main: {
        src: [
          'advanced-post-excerpt.php',
          'LICENSE.md',
          'readme.txt'
        ],
        dest: 'dist/'
      },
    }
  });

  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('build', ['copy']);
};