'use strict';
module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    jshint: {
      options: {
        "browser": true,
        "curly": true,
        "eqeqeq": true,
        "eqnull": true,
        "immed": true,
        "jquery": true,
        "latedef": true,
        "node": true,
        "strict": false,
        "trailing": true,
        "undef": true
      },
      all: [
        'Gruntfile.js',
        'assets/js/*.js',
        '!assets/js/scripts.min.js'
      ]
    },
    uglify: {
      dist: {
        files: {
          'assets/js/scripts.min.js': [
            'assets/js/bootstrap/transition.js',
            'assets/js/bootstrap/alert.js',
            'assets/js/bootstrap/button.js',
            'assets/js/bootstrap/carousel.js',
            'assets/js/bootstrap/collapse.js',
            'assets/js/bootstrap/dropdown.js',
            'assets/js/bootstrap/modal.js',
            'assets/js/bootstrap/tooltip.js',
            'assets/js/bootstrap/popover.js',
            'assets/js/bootstrap/scrollspy.js',
            'assets/js/bootstrap/tab.js',
            'assets/js/bootstrap/affix.js',
            'assets/js/plugins/*.js',
            'assets/js/_*.js'
          ]
        }
      }
    },
    recess: {
        options: {
          strictPropertyOrder: false
        },
        dist: {
            src: ['../../uploads/wp-less-cache/cftp-theme.css']
        }
    },
    watch: {
      options: {
        spawn: false // added for speed, may cause strangeness 
      },
      js: {
        files: [
          '<%= jshint.all %>'
        ],
        tasks: ['uglify']
      },
      livereload: {
        options: {
          livereload: true
        },
        files: [
          'assets/less/*.less',
          'assets/less/**/*.less',
          'assets/js/scripts.min.js',
          'pages/**/*.php',
          'parts/**/*.php',
          '*.php'
        ]
      }
    },
    clean: {
      dist: [
        'assets/js/scripts.min.js'
      ]
    },
    imagemin: {
      png: {
        options: {
          optimizationLevel: 7
        },
        files: [
          {
            expand: true,
            cwd: 'assets/images/',
            src: ['**/*.png'],
            dest: 'assets/images/',
            ext: '.png'
          }
        ]
      },
      jpg: {
        options: {
          progressive: true
        },
        files: [
          {
            expand: true,
            cwd: 'assets/images/',
            src: ['**/*.jpg'],
            dest: 'assets/images/',
            ext: '.jpg'
          }
        ]
      }
    }
  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-recess');

  // Register tasks
  grunt.registerTask('default', [
    'jshint',
    'clean',
    'uglify',
    'imagemin'
  ]);

  grunt.registerTask('dev', [
    'watch'
  ]);

  grunt.registerTask('css', [
    'recess'
  ]);
};