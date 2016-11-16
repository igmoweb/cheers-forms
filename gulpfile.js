var gulp = require('gulp'),
    browserify = require('browserify'),
    babel = require('babelify'),
    source = require('vinyl-source-stream'),
    rename = require('gulp-rename'),
    watchify = require('watchify');

function executeBundle(bundle) {
    return bundle
        .bundle()
        .on("error", function (err) { console.log("Error : " + err.message); })
        .pipe(source('cforms.js'))
        .pipe(gulp.dest('./core/assets/js'));
}

gulp.task('default', function () {
    var options = {
        entries: ['./_src/cforms.js'],
        debug: true
    };
    var bundle = browserify(options);
    bundle.transform(babel.configure({presets: ["es2015"]}));
    return executeBundle( bundle );
});



gulp.task('watch', function () {
    var options = {
        entries: ['./_src/cforms.js'],
        debug: true
    };
    var bundle = browserify(options);
    bundle = watchify( bundle );
    bundle.transform(babel.configure({presets: ["es2015"]}));

    bundle
        .on('update', function( file ) {
            console.log("Updated file. Bundling...");
            console.log(file);
            executeBundle( bundle );
        })
        .on('log', function( msg ) {
            console.log( msg );
        });
    return executeBundle( bundle );
});