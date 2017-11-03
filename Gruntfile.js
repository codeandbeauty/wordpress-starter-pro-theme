/* global require */

/**
 * When grunt command does not execute try these steps:
 *
 * - delete folder 'node_modules' and run command in console:
 *   $ npm install
 *
 * - Run test-command in console, to find syntax errors in script:
 *   $ grunt hello
 */

module.exports = function(grunt) {
 	// Show elapsed time at the end.
 	require( 'time-grunt' )(grunt);

 	// Load all grunt tasks.
 	require( 'load-grunt-tasks' )(grunt);

 	var buildtime, conf, pkg;

 	buildtime = new Date().toISOString();

 	conf = {
 	    js_folder: 'assets/js/',
 	    js_files: [
 	        'Gruntfile.js',
 	    ],
 	    sass_folder: 'assets/sass/',
 	    css_folder: 'assets/css/',
 	    css_files: {
 	        'assets/css/style.css': 'assets/sass/style.scss'
 	    },
 	    translation: {
 	        dir: 'language/',
 	        ignore_files: [
                '(^.php)',	  // Ignore non-php files.
 				'unit-test/', // Upgrade tests
 				'node_modules/',
 				'.sass-cache' // In case .sass-cache get's generated
 	        ],
 	        textdomain: 'cad'
 	    }
 	};
 	pkg = grunt.file.readJSON('package.json');

 	grunt.initConfig({
 	    pkg: pkg,
 	    conf: conf,
        // JS: Validate JS files (1).
		jsvalidate: {
			all: conf.js_files
		},

		// JS: Validate JS files (2).
		jshint: {
			all: conf.js_files,
			options: {
				curly:   true,
				browser: true,
				eqeqeq:  true,
				immed:   true,
				latedef: true,
				newcap:  true,
				noarg:   true,
				sub:     true,
				undef:   true,
				boss:    true,
				eqnull:  true,
				unused:  true,
				quotmark: 'single',
				predef: [
					'jQuery',
					'Backbone',
					'_'
				],
				globals: {
					exports: true,
					module:  false
				}
			}
		},

        // JS: Compile/minify js files.
		uglify: {
			all: {
				files: [{
					expand: true,
					src: ['*.js', '!*.min.js', '!Gruntfile.js', '!Gulpfile.js'],
					ext: '.min.js',
					extDot: 'last'
				}],
				options: {
					banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
						' * <%= pkg.homepage %>\n' +
						' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
						' * Licensed GPLv2+' +
						' */\n',
					mangle: {
						except: ['jQuery']
					}
				}
			}
		},

        // CSS: Compile .scss into .css files.
		sass:   {
			all: {
				options: {
					'sourcemap=none': true, // 'sourcemap': 'none' does not work...
					unixNewlines: true,
					style: 'expanded'
				},
				files: conf.css_files
			}
		},

        // CSS: Add browser-specific CSS prefixes to css files.
		autoprefixer: {
			options: {
				browsers: ['last 2 version', 'ie 8', 'ie 9'],
				diff: false
			},
			single_file: {
				files: [{
					expand: true,
					src: ['*.css', '!*.min.css'],
					cwd: conf.css_folder,
					dest: conf.css_folder,
					ext: '.css',
					extDot: 'last'
				}]
			}
		},

		// CSS: Minify css files (create a .min.css file).
		cssmin: {
			options: {
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
					' * <%= pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' * Licensed GPLv2+' +
					' */\n'
			},
			minify: {
				expand: true,
				src: ['*.css', '!*.min.css'],
				cwd: conf.css_folder,
				dest: conf.css_folder,
				ext: '.min.css',
				extDot: 'last'
			}
		},

        // POT: Create the .pot translation index.
		makepot: {
			target: {
				options: {
					cwd: '',
					domainPath: conf.translation.dir,
					exclude: conf.translation.ignore_files,
					mainFile: pkg.name,
					potFilename: conf.translation.textdomain + '.pot',
					potHeaders: {
						'poedit': true, // Includes common Poedit headers.
						'language-team': pkg.author_info.name + ' <' + pkg.author_info.email + '>',
						'report-msgid-bugs-to': pkg.author_info.report_bugs_to,
						'last-translator': pkg.author_info.name + ' <' + pkg.author_info.email + '>',
						'x-generator': 'grunt-wp-i18n',
						'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
					},
					type: 'wp-theme' // wp-plugin or wp-theme
				}
			}
		},

		// Create a generated compressed file for production
		compress: {
		    release: {
		        options: {
		            mode: 'zip',
		            archive: '../' + pkg.name + '-' + pkg.version + '.zip'
		        },
		        expand: true,
		        dest: pkg.name,
		        src: [
		            '*',
		            '**',
		            '!Gruntfile.js',
		            '!Gulpfile.js',
		            '!package.json',
		            '!.gitignore',
		            '!.git/*',
		            '!.git/**',
		            '!.git',
		            '!node_modules/',
		            '!node_modules/*',
		            '!node_modules/**',
		            '!assets/sass/',
		            '!assets/sass/*',
		            '!assets/sass/**',
		            '!.sass-cache/',
		            '!.idea/', // PHPStorm config
		            '!.idea/*', // PHPStorm config
		            '!.idea/**' // PHPStorm config
		        ]
		    }
		},

        // PHP: Validate file syntax.
		phplint: {
			src: conf.php_files,
			options: {
				swapPath: '/tmp'  // Make sure this folder exists; its for caching to speed up the task.
			}
		},

		// PHP: Code Sniffer to validate WP Coding Standards.
		phpcs: {
			sniff: {
				src: conf.php_files,
				options: {
					bin: '../../../../../phpcs/scripts/phpcs',
					standard: 'WordPress-Core',
					verbose: true
				}
			}
		},

		phpcbf: {
			options: {
				noPatch: true,
				bin: '../../../../../phpcs/scripts/phpcs',
				standard: 'WordPress-Core'
			},
			main: conf.php_files
		},

		// PHP: Unit tests.
		phpunit: {
			classes: {
				dir: ''
			},
			options: {
				bootstrap: 'unit-test/bootstrap.php',
				testsuite: 'default',
				configuration: 'unit-test/phpunit.xml',
				colors: true,
				staticBackup: false,
				noGlobalsBackup: false
			}
		}
 	});

    // Validate and compile js files
 	grunt.registerTask( 'js', ['jsvalidate', 'jshint', 'uglify'] );

 	// Validate and compile sass files
 	grunt.registerTask( 'css', ['sass', 'autoprefixer', 'cssmin'] );

 	// Generate translation
 	grunt.registerTask( 'makepot', ['makepot'] );

 	// Generate a compress production copy
 	// Ensure that validation runs first before generating the release
 	// Ensure that the language gets regenerated
 	grunt.registerTask( 'generate-zip', ['js', 'css', 'makepot', 'compress'] );
};