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

 	var buildtime, conf, pkg, banner, theme_dir, theme_slug, theme_domain, theme_config;

 	buildtime = new Date().toISOString();

 	conf = {
 	    js_folder: 'assets/js/',
 	    js_files: [
 	        'Gruntfile.js',
 	        // Include js files that require validation here ...
 	    ],
 	    js_files_concat: {
 	        // Include files that will be merge into 1
 	        // Example: `admin.js: [ assets/src/jsone.js, ...list of file ]`,
 	        'admin.js': ['assets/src/admin/test1.js']
 	    },
 	    sass_folder: 'assets/sass/',
 	    css_folder: 'assets/css/',
 	    css_files: {
 	        'assets/css/normalize.css': 'assets/sass/normalize.scss',
 	        'assets/css/style.css': 'assets/sass/style.scss'
 	    },
 	    php_files: [
 	        '*.php',
 	        'inc/*.php',
 	        'inc/**/*.php',
 	        'templates/*.php',
 	        'templates/**/*.php',
 	        'tests/*.php',
 	        'tests/php/*.php',
 	        'tests/php/**/*.php'
 	    ],
 	    translation: {
 	        dir: 'language/',
 	        ignore_files: [
                '(^.php)',	  // Ignore non-php files.
 				'tests/', // Upgrade tests
 				'node_modules/',
 				'.sass-cache' // In case .sass-cache get's generated
 	        ],
 	        textdomain: 'TEXTDOMAIN'
 	    }
 	};
 	pkg = grunt.file.readJSON('package.json');
 	banner = '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
	    ' * <%= pkg.homepage %>\n' +
		' * Copyright (c) <%= grunt.template.today("yyyy") %>;\n' +
		' * Licensed GPLv2+' +
		' */\n';

    theme_config = {
	    expand: true,
		src: [
		    '*',
		    '**',
		    '!node_modules/*',
		    '!node_modules/**',
		    '!node_modules/',
		    '!logs/*',
		    '!logs/',
		    '!.sass-cache/*',
		    '!.sass-cache/**',
		    '!.sass-cache/'
		],
		dest: '',
		noEmpty: true,
		options: {
		    process: function(content, src_path) {
                var file_ext;

                file_ext = src_path.lastIndexOf('.') + 1;
                file_ext = src_path.substring(file_ext);

                if ( 'php' !== file_ext ||
                    'html' !== file_ext ||
                    'htm' !== file_ext ||
                    'scss' !== file_ext ||
                    'css' !== file_ext ||
                    'js' !== file_ext ||
                    'json' !== file_ext ||
                    'txt' !== file_ext ||
                    'pot' !== file_ext
                    ) {
                    return content;
                }

                content = content.replace( /codeandbeauty/g, theme_slug );
                content = content.replace( /TEXTDOMAIN/g, theme_domain );

                return content;
		    }
		}
	};

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

        // Concatenate js files
		concat: {
		    options: {
		        stripBanners: true
		    },
		    scripts: {
		        files: conf.js_files_concat
		    }
		},

        // JS: Compile/minify js files.
		uglify: {
			all: {
				files: [{
					expand: true,
					src: ['assets/js/*.js', '!assets/js/*.min.js'],
					ext: '.min.js',
					extDot: 'last'
				}],
				options: {
					banner: banner,
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
				banner: banner
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
						'language-team': pkg.author + ' <' + pkg.author_email + '>',
						'report-msgid-bugs-to': pkg.author_uri,
						'last-translator': pkg.author + ' <' + pkg.author_email + '>',
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
		            '!assets/js/src/*',
		            '!assets/js/src/**',
		            '!assets/js/src',
		            '!.sass-cache/',
		            '!.idea/', // PHPStorm config
		            '!.idea/*', // PHPStorm config
		            '!.idea/**', // PHPStorm config
		            '!tests/',
		            '!tests/*',
		            '!tests/**',
		            '!README.md'
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
					bin: '../../../../../../phpcs/bin/phpcs',
					standard: 'WordPress-Core',
					verbose: true
				}
			}
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
		},

		copy: {
		    all: theme_config
		}
 	});

    // Validate and compile js files
 	grunt.registerTask( 'js', ['jsvalidate', 'jshint', 'concat', 'uglify'] );

 	// Validate and compile sass files
 	grunt.registerTask( 'css', ['sass', 'autoprefixer', 'cssmin'] );

    // Validate php files
    grunt.registerTask( 'php', ['phplint', 'phpcs'] );

 	// Generate translation
 	grunt.registerTask( 'makepot', ['makepot'] );

 	// Generate a compress copy for production
 	grunt.registerTask( 'generate-zip', ['js', 'css', 'compress'] );

    grunt.registerTask( 'create-theme', 'Generating new theme...', function() {
 	    var folder, slug, domain;

 	    folder = grunt.option('folder');
 	    slug = grunt.option('slug');
 	    domain = grunt.option('domain');

 	    // Ensure that the name and slug doesn't contain spaces
 	    slug = slug.replace( / /g, '' );

 	    theme_config.dest = '../' + folder;
 	    theme_dir = folder;
 	    theme_slug = slug;
 	    theme_domain = domain;

 	    grunt.task.run( ['copy:all'] );
 	});
};