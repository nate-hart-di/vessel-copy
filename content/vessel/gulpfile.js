var gulp = require('gulp'),
  plumber = require('gulp-plumber'),
  rename = require('gulp-rename'),
  autoprefixer = require('gulp-autoprefixer'),
  concat = require('gulp-concat'),
  uglify = require('gulp-uglify'),
  cache = require('gulp-cache'),
  sass = require('gulp-sass'),
  notify = require('gulp-notify'),
  minifyCSS = require('gulp-minify-css'),
  jsValidate = require('gulp-jsvalidate'),
  changed = require('gulp-changed'),
  newer = require('gulp-newer'),
  browserSync = require('browser-sync').create();


//File system and path modules required to read folders
var fs = require('fs');
var path = require('path');

var fjSlugs = fs.readdirSync(path.join(__dirname, '../dealers'))
  .filter(item => item !== '.DS_Store')

getJsFolders = (slugs) => {
  var jsFolders = []
  slugs.forEach((slug) => {
    jsFolders.push(`../dealers/${slug}/js`)
  });
  jsFolders.push('../shared/');
  return jsFolders;
}

getCssFolders = (slugs) => {
  var cssFolders = []
  slugs.forEach((slug) => {
    cssFolders.push('../dealers/' + slug + '/css')
  })

  return cssFolders;
}


/*
BEGIN JS
*/
gulp.task('compile-js', gulp.series(
  function(done) {
    var onError = function(err) {
      var filename = err.fileName.match(/(wp-content.*)/g),
        fileType = /[^.]+$/.exec(filename);

      notify.onError({
        title: "Gulp",
        subtitle: fileType[0].toUpperCase() + " error",
        message: filename + " - <%= error.message %>",
        sound: false
      })(err);
      this.emit('end');
    };



    getJsFolders(fjSlugs).forEach(function(folder, i) {
      var __stream = gulp.src([folder + '/*.js', '!' + folder + '/*.min.js'])
        .pipe(plumber({
          errorHandler: onError
        }))
        .pipe(jsValidate())
        .pipe(uglify())
        .pipe(rename({
          suffix: '.min'
        }))
        .pipe(changed(folder + '/min'))
        .pipe(gulp.dest(folder + '/min'))
        .pipe(notify({
          message: `${fjSlugs[i]} JavaScript compiled`,
          onLast: true
        }))

      return __stream
    });

    done()
  }));


buildJsWatchers = () => {
  var folders = getJsFolders(fjSlugs)
  folders.forEach((folder) => {
    return gulp.watch(`${folder}/*.js`, gulp.series('compile-js'))
  })
}

buildCssWatchers = () => {
  var cssFolders = getCssFolders(fjSlugs)

  cssFolders.forEach((folder) => {
    return gulp.watch(folder + '/*.scss', gulp.series('compile-css'))
  })
}
/* ================== */

//Koral's Sandbox dev site
gulp.task('sandboxStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/koralssandbox/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Sandbox CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/koralssandbox/css'))
  }))


// fletcherchryslerdodgejeepram
gulp.task('fletcherchryslerdodgejeepramStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherchryslerdodgejeepram/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'FJ CDJR CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherchryslerdodgejeepram/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesbigislandhondahilo

gulp.task('fletcherjonesbigislandhondahiloStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesbigislandhondahilo/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'FJ Big Island Honda Hilo CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesbigislandhondahilo/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesimports
gulp.task('fletcherjonesimportsStyles', gulp.series(
  function() {
    return gulp.src('../dealers/fletcherjonesimports/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'FJ Imports CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesimports/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmbnewport
gulp.task('fletcherjonesmbnewportStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesmbnewport/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'MB Newport CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmbnewport/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmercedesbenzchicago
gulp.task('fletcherjonesmercedesbenzchicagoStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesmercedesbenzchicago/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'MB Chicago CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmercedesbenzchicago/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmercedesbenzhonolulumaui
gulp.task('fletcherjonesmercedesbenzhonolulumauiStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesmercedesbenzhonolulumaui/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'MB Honolulu/Maui CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmercedesbenzhonolulumaui/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmercedesbenzofhenderson
gulp.task('fletcherjonesmercedesbenzofhendersonStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesmercedesbenzofhenderson/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'MB Henderson CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmercedesbenzofhenderson/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmercedesbenzofmaui
gulp.task('fletcherjonesmercedesbenzofmauiStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesmercedesbenzofmaui/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'MB of Maui CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmercedesbenzofmaui/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmercedesbenzontario
gulp.task('fletcherjonesmercedesbenzontarioStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesmercedesbenzontario/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'MB Ontario CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmercedesbenzontario/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmercedesbenztemecula
gulp.task('fletcherjonesmercedesbenztemeculaStyles', gulp.series(
  function() {
    return gulp.src('../dealers/fletcherjonesmercedesbenztemecula/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'MB Temecula CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmercedesbenztemecula/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesmotorcarsoffremont
gulp.task('fletcherjonesmotorcarsoffremontStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesmotorcarsoffremont/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Fremont CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesmotorcarsoffremont/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesporscheofhawaii
gulp.task('fletcherjonesporscheofhawaiiStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesporscheofhawaii/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Porsche Hawaii CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesporscheofhawaii/css'))
      .pipe(browserSync.stream())
  }))

gulp.task('porscheoffremontStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/porscheoffremont/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Porsche Hawaii CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/porscheoffremont/css'))
      .pipe(browserSync.stream())
  }))

// porscheoffremont-legacymigration062018 (LEGACY MIGRATION - TEMPORARY)
gulp.task('porscheoffremont-legacymigration062018Styles', gulp.series(
  function(done) {
    return gulp.src('../dealers/porscheoffremont-legacymigration062018/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Fremont CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/porscheoffremont-legacymigration062018/css'))
      .pipe(browserSync.stream())
  }))

gulp.task('fletcherjonesautomotivegroupStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonesautomotivegroup/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Automotive group site CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesautomotivegroup/css'))
      .pipe(browserSync.stream())
  }))


gulp.task('fletcherjonessocalregionalStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonessocalregional/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'SoCal portal CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonessocalregional/css'))
      .pipe(browserSync.stream())
  }))

gulp.task('fletcherjoneslasvegaspreownedStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjoneslasvegaspreowned/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Las Vegas PreOwned portal CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjoneslasvegaspreowned/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonesnevada
gulp.task('fletcherjonesnevadaStyles', gulp.series(
  function() {
    return gulp.src('../dealers/fletcherjonesnevada/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'FJ Nevada portal CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonesnevada/css'))
      .pipe(browserSync.stream())
  }))

// porschelongbeach
gulp.task('porschelongbeachStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/porschelongbeach/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Porsche Long Beach CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/porschelongbeach/css'))
      .pipe(browserSync.stream())
  }))

// fletcherjonestoyotaofcarson
gulp.task('fletcherjonestoyotaofcarsonStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/fletcherjonestoyotaofcarson/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Fletcher Jones Toyota of Carson CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/fletcherjonestoyotaofcarson/css'))
      .pipe(browserSync.stream())
  }))

  // porschewalnutcreek
gulp.task('porschewalnutcreekStyles', gulp.series(
  function(done) {
    return gulp.src('../dealers/porschewalnutcreek/css/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Porsche Walnut Creek CSS compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../dealers/porschewalnutcreek/css'))
      .pipe(browserSync.stream())
  }))

gulp.task('sharedStyles', gulp.series(
  function(done) {
    return gulp.src('../shared/styles/**/*.scss')
      // .pipe(autoprefixer('last 2 versions'))
      .pipe(plumber({
        errorHandler: function(error) {
          console.log(error.message)
          this.emit('end')
        }
      }))
      .pipe(sass({
        outputStyle: 'compressed'
      }).on('error', sass.logError))
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(notify({
        message: 'Shared stylesheet compiled',
        onLast: true
      }))
      .pipe(gulp.dest('../shared/styles'))
  }))


gulp.task('browser-sync', gulp.series(
  function(done) {
    var browserSyncOptions = {
      proxy: '127.0.0.1:9081',
      notify: false,
      port: 3000
    };
    browserSync.init(browserSyncOptions);

    done()
  }))

gulp.task('reloadBrowserSync', gulp.series(
  function(done) {
    browserSync.reload()

    done()
  }))


gulp.task('watch', gulp.series(
  function(done) {
    buildJsWatchers()
    gulp.watch(["../shared/styles/**/*.scss","../shared/styles/**/*.scss"], gulp.series('sharedStyles'))
    gulp.watch(["../dealers/koralssandbox/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('sandboxStyles'))
    gulp.watch(["../dealers/fletcherchryslerdodgejeepram/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherchryslerdodgejeepramStyles'))
    gulp.watch(["../dealers/fletcherjonesbigislandhondahilo/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesbigislandhondahiloStyles'))
    gulp.watch(["../dealers/fletcherjonesimports/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesimportsStyles'))
    gulp.watch(["../dealers/fletcherjonesmbnewport/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesmbnewportStyles'))
    gulp.watch(["../dealers/fletcherjonesmercedesbenzchicago/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesmercedesbenzchicagoStyles'))
    gulp.watch(["../dealers/fletcherjonesmercedesbenzhonolulumaui/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesmercedesbenzhonolulumauiStyles'))
    gulp.watch(["../dealers/fletcherjonesmercedesbenzofhenderson/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesmercedesbenzofhendersonStyles'))
    gulp.watch(["../dealers/fletcherjonesmercedesbenzofmaui/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesmercedesbenzofmauiStyles'))
    gulp.watch(["../dealers/fletcherjonesmercedesbenzontario/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesmercedesbenzontarioStyles'))
    gulp.watch(["../dealers/fletcherjonesmotorcarsoffremont/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesmotorcarsoffremontStyles'))
    gulp.watch(["../dealers/fletcherjonesporscheofhawaii/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesporscheofhawaiiStyles'))
    gulp.watch(["../dealers/porscheoffremont/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('porscheoffremontStyles'))
    gulp.watch(["../dealers/fletcherjonesautomotivegroup/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesautomotivegroupStyles'))
    gulp.watch(["../dealers/fletcherjonessocalregional/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonessocalregionalStyles'))
    gulp.watch(["../dealers/porscheoffremont-legacymigration062018/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('porscheoffremont-legacymigration062018Styles'))
    gulp.watch(["../dealers/fletcherjoneslasvegaspreowned/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjoneslasvegaspreownedStyles'))
    gulp.watch(["../dealers/fletcherjonesnevada/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonesnevadaStyles'))
    gulp.watch(["../dealers/porschelongbeach/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('porschelongbeachStyles'))
    gulp.watch(["../dealers/fletcherjonestoyotaofcarson/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('fletcherjonestoyotaofcarsonStyles'))
    gulp.watch(["../dealers/porschewalnutcreek/css/**/*.scss","../shared/styles/**/*.scss"], gulp.series('porschewalnutcreekStyles'))
    gulp.watch("../shared/shared-scripts.js", gulp.series('compile-js'))

    done()
}))

gulp.task('default', gulp.parallel('browser-sync', 'watch'));
