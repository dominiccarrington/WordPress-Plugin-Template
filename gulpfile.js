const gulp = require('gulp');
const scss = require('gulp-sass');
const cleanCss = require('gulp-clean-css');
const minify = require('gulp-minify');
const autoprefixer = require('gulp-autoprefixer');

gulp.task("styles", function () {
  return gulp.src("assets/scss/**/*.scss")
    .pipe(scss({}))
    .pipe(autoprefixer({}))
    .pipe(cleanCss({}))
    .pipe(gulp.dest("assets/css"));
});

gulp.task("scripts", function () {
  return gulp.src(["./assets/js/**/*.js", "!./assets/js/**/*.min.js"])
    .pipe(minify({
      ext: {
        min: ".min.js"
      },
      ignoreFiles: ['.min.js']
    }))
    .pipe(gulp.dest("assets/js"));
});

gulp.task("default", gulp.parallel("styles", "scripts"));

gulp.task("watch", function () {
  gulp.watch(
    "assets/scss/**/*.scss", {
      ignoreInitial: false,
      usePolling: true
    },
    gulp.task("styles")
  );
});
