var gulp = require('gulp');
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
