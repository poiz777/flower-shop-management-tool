const path                  = require('path');
const gulp                  = require('gulp');
const sass                  = require('gulp-sass');
const autoprefixer          = require('gulp-autoprefixer');
const { series, parallel }  = require('gulp');


const publicPath            = path.resolve(__dirname, "..");
const processSass       = (done) => {
    const  procedure   = gulp.src('./sass/**/*.scss')
    .pipe(sass({outputStyle: 'compressed'})
    .on('error', sass.logError))
    .pipe(gulp.dest(`${publicPath}/css`));
    done();
    return procedure;
};

const processCss        = (done) => {
    const procedure = gulp.src(`${publicPath}/css/**/*.css`)
    .pipe(autoprefixer({
        // browsers: ['last 2 versions'],
        cascade: false
    }))
    .pipe(gulp.dest(`${publicPath}/css`));
    done();
    return procedure;
};

const observeSass       = (done) => {
    gulp.watch('./sass/**/*.scss', gulp.series(processSass, processCss) );
    done();
};


exports.default = series(
    processSass,
    processCss,
    observeSass,
);

exports.observe = series(
    observeSass,
);

exports.build = series(
    processSass,
    processCss,
);
