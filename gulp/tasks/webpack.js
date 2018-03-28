var gulp = require('gulp');
var webpackStream = require('webpack-stream');
var webpack = require('webpack');
var config = require('../config').webpack;

gulp.task('webpack', function() {
    webpackStream(config.config, webpack)
        .pipe(gulp.dest(config.dest));
});
