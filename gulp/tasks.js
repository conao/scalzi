var gulp = require('gulp');
var g = require('gulp-load-plugins')();
var notify = require('gulp-notify');
var conf = require('./config')

gulp.task('build', ['webpack', 'stylus', 'copy']);
gulp.task('default', ['webserver', 'build', 'watch']);

gulp.task('copy', function() {
    var config = conf.copy;
    
    gulp.src(config.src)
        .pipe(gulp.dest(config.dest));
})

gulp.task('stylus', function () {
    var config = conf.stylus;
    
    gulp.src(config.src)
        .pipe(g.plumber({
            errorHandler: notify.onError('<%= error.message %>')
        }))
        .pipe(g.stylus())               // 実際コンパイルしてるのはここ
        .pipe(g.concat(config.output))  // 1つのファイルに固める
        .pipe(g.autoprefixer(config.autoprefixer))  // vendor-prefixつける
        .pipe(g.if(config.minify, g.cleanCss()))    // 必要ならminifyする
        .pipe(gulp.dest(config.dest));            // 出力する
});

gulp.task('webpack', function() {
    var webpackStream = require('webpack-stream');
    var webpack = require('webpack');
    var config = conf.webpack;
    
    webpackStream(config.config, webpack)
        .pipe(gulp.dest(config.dest));
});

gulp.task('webserver', function() {
    var webserver = require('gulp-webserver');
    var config = conf.webserver;
    
  gulp.src(config.src)
    .pipe(webserver(config.config));
});

function bs() {
    var sync = require('browser-sync').create();
    var config = conf.sync

    gulp.task('sync-init', function() {
        sync.init(null, config);
    });

    gulp.task('sync-reload', function() {
        sync.reload();
    });

    gulp.task('sync', function() {
        gulp.watch('./**/*.php', ['sync-reload']);
    });
    
    gulp.task('sync-stylus', function () {
        var stylus_config = conf.stylus;
        
        gulp.src(config.src)
            .pipe(g.plumber({
                errorHandler: notify.onError('<%= error.message %>')
            }))
            .pipe(g.stylus())               // 実際コンパイルしてるのはここ
            .pipe(g.concat(stylus_config.output))  // 1つのファイルに固める
            .pipe(g.autoprefixer(stylus_config.autoprefixer))  // vendor-prefixつける
            .pipe(g.if(stylus_config.minify, g.cleanCss()))    // 必要ならminifyする
            .pipe(gulp.dest(stylus_config.dest))            // 出力する
            .pipe(sync.reload({stream:true}));
    });
}

bs();

gulp.task('watch', function () {
    var watch = require('gulp-watch');
    var config = conf.watch;
    
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
