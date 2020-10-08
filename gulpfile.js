// Skapar konstanter för alla paket/verktyg
const { src, dest, watch, series, parallel } = require("gulp");
const jsConcat = require("gulp-concat"); // Läser in concat
const jsUglify = require("gulp-uglify-es").default; // Läser in för minifiering av js 
const cssConcat = require('gulp-concat-css');
const cssUglify = require("gulp-clean-css");
const imageOptimize = require('gulp-imagemin'); // Minifiera bilder
const browserSync = require('browser-sync').create(); // Live-reload
const sass = require('gulp-sass');
sass.compiler = require('node-sass');
const babel = require('gulp-babel');

// Sökvägarna (html, css och js)
const files = {
    htmlPath: "src/**/*.html",
    imagePath: "src/images/*",
    cssPath: "src/**/*.css",
    jsPath: "src/**/*.js",
    sassPath: "src/sass/**/*.scss"
}

// Kopiera HTML-filer (task)
function htmlTask() {
    return src(files.htmlPath)
        .pipe(dest('pub')) //Flytta till pub
}


// Sammanslå och minifiera JS-filer
function jsTask() {
    return src(files.jsPath)
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(jsConcat('main.js')) // Lagrad i minnet
        .pipe(jsUglify()) // Minifiera
        .pipe(dest('pub/js')); // Filen blir skriven 
};

/*
// CSS-task 
function cssTask() {
    return src(files.cssPath)
        .pipe(cssConcat('styles.css'))
        .pipe(cssUglify()) // Minifiera
        .pipe(dest('pub/css'));
}*/

function sassTask() {
    return src(files.sassPath)
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(dest("pub/css"), dest("src/css"))
}

// Image-task 
function imageTask() {
    return src(files.imagePath)
        .pipe(imageOptimize())
        .pipe(dest('pub/images'));
}


// Browser-sync
function updateBrowser() {
    browserSync.init({
        server: {
            baseDir: './pub/'
        }
    });

    // Watcher
    watch([files.htmlPath, files.jsPath, files.cssPath, files.imagePath, files.sassPath],
        parallel(htmlTask, jsTask, imageTask, sassTask));

    watch(['pub/js', 'pub/css', 'pub', 'pub/img', 'pub/sass']).on('change', browserSync.reload)
}


// Serie för att allt ska kopieras från start, default task
exports.default = series(
    parallel(htmlTask, jsTask, imageTask, sassTask), //Kör dem parallelt 
    updateBrowser, updateBrowser
);