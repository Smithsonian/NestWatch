/**
 * Created by hpham on 5/9/17.
 */
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sassInlineSvg = require('gulp-sass-inline-svg'),
    svgmin = require('gulp-svgmin'),
    sourcemaps = require('gulp-sourcemaps'),
    sassGlob = require('gulp-sass-glob'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    concat = require("gulp-concat")
uglify = require("gulp-uglify");

var input = 'sass/*.scss',
    output = 'css',
    sassOptions = {
        errLogToConsole: true,
        outputStyle: 'expanded',
        // outputStyle: 'nested',
        sourceComments: 'map',
        sourceMap: 'sass',
        outputStyle: 'nested'
    };

gulp.task('sass', function () {
    var processors = [autoprefixer({browsers: ['last 2 version', 'ie > 8']})];
    return gulp
        .src(input)
        .pipe(sourcemaps.init())
        .pipe(sassGlob())
        .pipe(sass(sassOptions)
            .on('error', sass.logError))
        .pipe(postcss(processors))
        // .pipe(sourcemaps.write('maps', {
        //   includeContent: false,
        //   sourceRoot: 'sass'
        // }))
        .pipe(sourcemaps.write('maps'))
        // Write the resulting CSS in the output folder
        .pipe(gulp.dest(output));
});


gulp.task('sass:svg', function(){
    return gulp.src('images/svg/*.svg')
        .pipe(svgmin()) // Recommend using svg min to optimize svg files first
        .pipe(sassInlineSvg({
            destDir: 'sass/helpers'
        }));
});

gulp.task('js', function () {
    gulp.src('js/vendors/*.js')
        .pipe(concat('plugins.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js'));
});

gulp.task('js:modules', function () {
    gulp.src('mockup/source/js/vendors/*.js')
        .pipe(concat('modules.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('mockup/source/js'));
});

// gulp.task('js:menu', function () {
//   gulp.src('z-pattern-lab/source/js/superfish/*.js')
//     .pipe(concat('superfish.min.js'))
//     .pipe(uglify())
//     .pipe(gulp.dest('z-pattern-lab/source/js'));
// });

gulp.task('watch', function () {
    gulp.watch('images/svg/*.svg', ['sass:svg']);
    gulp.watch('sass/**/*.scss', ['sass']);
    gulp.watch('js/**/*.js', ['js']);
});
gulp.task('process', ['sass:svg','sass']);
gulp.task('compressJS', ['js','js:modules']);
gulp.task('default', ['sass:svg','sass']);