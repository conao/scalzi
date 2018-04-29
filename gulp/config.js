var path = require('path');

var dest = './build';
var src = './src';
var relativeSrcPath = path.relative('.', src);


module.exports = {
    dest: dest,

    copy: {
        src:[
            src + '/www/index.html'
        ],
        dest: dest
    },


    stylus: {
        src: [  // もし外部のcssフレームワーク使うなら配列の先頭で読み込むと良い
            src + '/stylus/**/!(_)*'  // ファイル名の先頭がアンスコはビルド対象外にする
        ],
        dest: dest + '/css/',
        output: 'monaco.css',  // 出力ファイル名
        autoprefixer: {
            browsers: ['last 2 versions']
        },
        minify: false
    },

    webpack: {
        dest: dest + '/js',
        config: {
            mode: 'development',
            //mode: 'production',
            entry: src + '/js/main.js',
            output: {
                filename: 'bundle.js'
            },
            resolve: {
                extensions: ['.js']
            }
        }
    },    

    webserver: {
        src: dest,
        config: {
            host: 'localhost',
            port: 3000,
            livereload: true
        }
    },

    sync: {
        server: {
            proxy: 'localhost:8888'
        }
    },
    
    js: {
        src: src + '/js/**',
        dest: dest + '/js',
        uglify: false
    },

    watch: {
        js: relativeSrcPath + '/js/**',
        stylus: relativeSrcPath + '/stylus/**',
        www: relativeSrcPath + '/www/index.html'
    }
}
