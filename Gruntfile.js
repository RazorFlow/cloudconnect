module.exports = function (grunt) {
    grunt.initConfig({
        copyto: {
            phprf: {
                files: [
                    {cwd: '../phprf/src/', src:['**'], dest: 'rfphp/'}
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-copy-to');
}