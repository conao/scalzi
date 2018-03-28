var gulp = require('gulp');
var g = require('gulp-load-plugins')();
var config = require('../config').stylus;

gulp.task('stylus', function () {
    gulp.src(config.src)
        .pipe(g.plumber())              // エラー出ても止まらないようにする
        .pipe(g.stylus())               // 実際コンパイルしてるのはここ
        .pipe(g.concat(config.output))  // 1つのファイルに固める
        .pipe(g.autoprefixer(config.autoprefixer))  // vendor-prefixつける
        .pipe(g.if(config.minify, g.cleanCss()))    // 必要ならminifyする
        .pipe(gulp.dest(config.dest));            // 出力する
});

