var gulp = require('gulp');
var g = require('gulp-load-plugins')();

gulp.task('build', ['webpack', 'stylus', 'copy']);
gulp.task('default', ['webserver', 'build', 'watch']);

gulp.task('copy', function() {
    var config = require('../config').copy;
    
    gulp.src(config.src)
        .pipe(gulp.dest(config.dest));
})

gulp.task('stylus', function () {
    var config = require('../config').stylus;
    
    gulp.src(config.src)
        .pipe(g.plumber())              // エラー出ても止まらないようにする
        .pipe(g.stylus())               // 実際コンパイルしてるのはここ
        .pipe(g.concat(config.output))  // 1つのファイルに固める
        .pipe(g.autoprefixer(config.autoprefixer))  // vendor-prefixつける
        .pipe(g.if(config.minify, g.cleanCss()))    // 必要ならminifyする
        .pipe(gulp.dest(config.dest));            // 出力する
});

gulp.task('webpack', function() {
    var webpackStream = require('webpack-stream');
    var webpack = require('webpack');
    var config = require('../config').webpack;
    
    webpackStream(config.config, webpack)
        .pipe(gulp.dest(config.dest));
});

gulp.task('webserver', function() {
    var webserver = require('gulp-webserver');
    var config = require('../config').webserver;
    
  gulp.src(config.src)
    .pipe(webserver(config.config));
});

function bs() {
    var sync = require('browser-sync').create();
    var config = require('../config').sync

    gulp.task('sync-init', function() {
        sync.init(null, config);
    });

    gulp.task('sync-reload', function() {
        sync.reload();
    });

    gulp.task('sync', function() {
        gulp.watch('./**/*.php', ['sync-reload']);
    });
}

bs();

gulp.task('watch', function () {
    var config = require('../config').watch;
    
    // js
    watch(config.js, function () {
        gulp.start(['webpack']);
    });

    // styl
    watch(config.stylus, function () {
        gulp.start(['stylus']);
    });

    // www
    watch(config.www, function () {
        gulp.start(['copy']);
    });
});
