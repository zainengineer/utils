#!/usr/bin/env bash

script_path=$( cd "$(dirname "${BASH_SOURCE}")" ; pwd -P )
script_path=$(dirname $(dirname "$script_path"));
pushd "$script_path" > /dev/null
cp ~/Downloads/ocr.jpeg ./img/ocr.jpeg
convert img/ocr.jpeg -resize 400% -type Grayscale img/input.tif
tesseract -l eng img/input.tif img/output
cat img/output.txt
popd > /dev/null