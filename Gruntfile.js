module.exports = function (grunt) {
	grunt.loadNpmTasks('grunt-php');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.initConfig({
		php: {
			watch: {
				options: {
					base: 'examples',
					port: 1024
				}
			}
		},
		watch: {
			scripts: {
				files: ['**/*.php'],
				options: {
					livereload: true
				}
			}
		}
	});

	grunt.registerTask('default', ['php:watch', 'watch']);
};