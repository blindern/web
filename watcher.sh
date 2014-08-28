#!/bin/bash

# Run SASS-watcher
#
# Compiles CSS-files from SCSS-files
#
# to install: gem install sass
sass --scss --sourcemap --style compressed --force --update layout/scss:layout
sass --scss --sourcemap --style compressed --watch layout/scss:layout
