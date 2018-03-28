var gulp = require("gulp")
var webserver = require('gulp-webserver');
var config = require('../config').webserver;

gulp.task('webserver', function() {
  gulp.src(config.src)
    .pipe(webserver(config.config));
});
