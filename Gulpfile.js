var gulp = require( 'gulp' ),
	sourcemaps = require( 'gulp-sourcemaps' ),
	header = require( 'gulp-header' ),
	date = new Date(),
	datestring = date.toDateString(),
	fs = require( 'fs' ),
	pkg = JSON.parse(fs.readFileSync('./package.json'))
	banner_args = {
		title: pkg.title,
		version: pkg.version,
		datestring: datestring,
		pkg: pkg
	},
	banner = '/**! <%=title%> -v <%=version%>\n' +
	' * Copyright (c) <%=datestring%>\n' +
	' * Author <%=pkg.author%> <<%=pkg.author_email%>>\n' +
	' * License GPvL2 or higher\n' +
	'!**/\n',
	php_files = [
		'*.php',
		'**.php',
		'!node_modules/**'
	],
	js_files = {
	    'assets/js/build.js': [
	        'assets/js/src/front/*.js'
	    ],
	    'assets/js/admin.js': [
	        'assets/js/src/common/*.js',
	        'assets/js/src/admin/*.js'
	    ]
	};


gulp.task( 'phpunit', function() {
	var phpunit = require( 'gulp-phpunit' ),
		path = '.\\..\\..\\..\\..\\vendor\\bin\\phpunit',
		options = {
			//bootstrap: './tests/bootstrap.php',
			testSuite: 'default',
			configurationFile: './tests/phpunit.xml',
			colors: true,
			staticBackup: false,
			noGlobalsBackup: false
		};

	gulp.src( './tests/phpunit.xml' ).pipe(phpunit(path));
});

gulp.task( 'phplint', function() {
	var phplint = require( 'gulp-phplint' );

	gulp.src( php_files ).pipe(phplint());
});

gulp.task( 'phpcs', function() {
	var phpcs = require( 'gulp-phpcs' ),
		options = {
			// Change this to your actual phpcs location
			bin: '../../../../phpcs/bin/phpcs',
			standard: 'WordPress-Core'
		};

	gulp.src( php_files ).pipe( phpcs( options ) ).pipe(phpcs.reporter('log'));
});

gulp.task( 'jsvalidate', function() {
	var jsvalidate = require( 'gulp-jsvalidate' );

	gulp.src(js_files).pipe(jsvalidate());
});

gulp.task( 'jshint', function() {
	var jshint = require( 'gulp-jshint' ),
		options = {
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
			predef: [ 'jQuery', 'Backbone', '_' ],
			globals: {
				exports: true,
				module:  false
			}
		};

	gulp.src( js_files ).pipe(jshint(options)).pipe(jshint.reporter('default'));
});

gulp.task( 'js', function() {
	// Concat common js
	var concat = require( 'gulp-concat' ),
		replace = require( 'gulp-replace' ),
		rename = require( 'gulp-rename' ),
		uglify = require( 'gulp-uglify' );

	// Concatinate and minify Js
	for ( var i in js_files ) {
	    gulp.src( js_files[i] )
	        .pipe(concat(i))
	        .pipe(gulp.dest( 'assets/js/' ))
	        .on( 'finish', function() {
	            gulp.src( i )
	                .pipe(sourcemaps.init())
                    .pipe(uglify({preserveComments:'license'}))
                    .pipe(header(banner, banner_args))
                    .pipe(rename(function(path) {
                        path.basename = path.basename + '.min';
                    }))
                    .pipe(sourcemaps.write('maps'))
                    .pipe(gulp.dest('assets/js/'));
	        });
	}
});

gulp.task( 'css', function() {
	var autoprefixer = require('gulp-autoprefixer'),
		sass = require( 'gulp-sass' ),
		rename = require( 'gulp-rename' ),
		css = ['*.scss', '!mixin.scss' ];

		gulp.src(css, {cwd: 'assets/sass/'})
			.pipe(sass({outputStyle: 'expanded'}))
			.pipe(autoprefixer('last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
			.pipe(gulp.dest( 'assets/css/' ))
			.on( 'finish', function() {
			    gulp.src( ['assets/css/*.css', '!assets/css/*.min.css'] )
			        .pipe(sourcemaps.init())
			        .pipe(sass({outputStyle: 'compressed'}))
			        .pipe(rename(function(path){
			            path.basename = path.basename + '.min';
			        }))
			        .pipe(header(banner, banner_args))
			        .pipe(autoprefixer('last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
                    .pipe(sourcemaps.write('maps'))
                    .pipe(gulp.dest( 'assets/css/'));
			});
});

gulp.task( 'watch', ['css', 'js'], function() {
	gulp.watch( ['assets/js/*.js', 'assets/js/**/*.js', '!assets/js/*.min.js'], ['js'] );
	gulp.watch( ['assets/sass/*.scss', 'assets/sass/**/*.scss', 'assets/sass/**/**/*.scss'], ['css'] );
});

gulp.task( 'makepot', function() {
	var wpPot = require( 'gulp-wp-pot' );

	gulp.src( php_files )
		.pipe(wpPot({package: pkg.title + ' ' + pkg.version}))
		.pipe(gulp.dest('languages/' + pkg.name + '-en_US.pot'));
});

gulp.task( 'generate-zip', function() {
	var zip = require( 'gulp-zip' ),
		notify = require('gulp-notify'),
		zipfile = pkg.name + '-' + pkg.version + '.zip',
		files = [
			'*',
			'**',
			'!docs/*',
			'!docs/**',
			'!docs',
			'!node_modules/*',
			'!node_modules/**',
			'!node_modules',
			'!.git/*',
			'!.git/**',
			'!.git',
			'!.gitignore',
			'!Gulpfile.js',
			'!Gruntfile.js',
			'!package.json',
			'!assets/sass/*',
			'!assets/sass/**',
			'!assets/sass',
			'!assets/js/common/*',
			'!assets/js/common',
			'!assets/**/maps/*',
			'!assets/**/maps',
			'!temp/*',
			'!temp/**',
			'!temp',
			'!tests/*',
			'!tests/**',
			'!tests',
			'!README.md'
		];

	gulp.src( files, {base: '../'})
		.pipe(zip(zipfile))
		.pipe(gulp.dest('../'))
		.pipe(notify({message: zipfile + ' file successfully generated!', onLast:true}));
});
