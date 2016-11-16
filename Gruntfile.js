module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        checktextdomain: {
            options:{
                report_missing: false,
                text_domain: 'plugin-name',
                keywords: [
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ]
            },
            files: {
                src:  [
                    '**/*.php', // Include all files
                    '!node_modules/**', // Exclude node_modules/
                    '!tests/**', // Exclude tests/
                    '!admin/assets/shared-ui/**', // Exclude WPMU DEV Shared UI
                    '!includes/external/**'
                ],
                expand: true
            }
        },

        copy: {
            main: {
                src:  [
                    '**',
                    '!npm-debug.log',
                    '!node_modules/**',
                    '!build/**',
                    '!bin/**',
                    '!.git/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!.gitignore',
                    '!.gitmodules',
                    '!sourceMap.map',
                    '!phpunit.xml.dist',
                    '!travis.yml',
                    '!tests/**',
                    '!**/Gruntfile.js',
                    '!**/package.json',
                    '!**/README.md',
                    '!lite-vs-pro.txt',
                    '!composer.json',
                    '!vendor/**',
                    '!tmp/**',
                    '!**/*~'
                ],
                dest: 'build/<%= pkg.name %>/'
            }
        },

        // Generate POT files.
        makepot: {
            options: {
                type: 'wp-plugin',
                domainPath: 'languages',
                potHeaders: {
                    'report-msgid-bugs-to': '',
                    'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
                }
            },
            dist: {
                options: {
                    potFilename: 'plugin-name.pot',
                    exclude: [
                        'tests/.*',
                        'node_modules/.*'
                    ]
                }
            }
        },

        clean: {
            main: ['build/*']
        },

        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: './build/<%= pkg.name %>-<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'build/<%= pkg.name %>/',
                src: ['**/*'],
                dest: '<%= pkg.name %>/'
            }
        },

        replace: {
            dist: {
                options: {
                    patterns: [
                        {
                            match: /\{\{plugin\-name\}\}/g,
                            replacement: '<%= pkg.textdomain %>'
                        },
                        {
                            match: /\{\{plugin\_name\}\}/g,
                            replacement: '<%= pkg.functions_prefix %>'
                        },
                        {
                            match: /\{\{Plugin\_Name\}\}/g,
                            replacement: '<%= pkg.classes_prefix %>'
                        },
                        {
                            match: /\{\{class\-plugin\}\}/g,
                            replacement: 'class-<%= pkg.files_prefix %>'
                        }
                    ]
                },
                files: [
                    {expand: true, src: [
                        './**/*.php',
                        '!node_modules/*'
                    ]}
                ]
            }
        }
    });


    grunt.registerTask('build', [
        'clean',
        'checktextdomain',
        'makepot',
        'copy',
        'compress'
    ]);
};