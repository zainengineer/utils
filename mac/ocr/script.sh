script_path=$( cd "$(dirname "${BASH_SOURCE}")" ; pwd -P )
pushd "$script_path" > /dev/null
cp ~/Downloads/ocr.png ./img/ocr.png
convert img/ocr.png -resize 400% -type Grayscale img/input.tif
tesseract -l eng img/input.tif img/output
grep "@" img/output.txt
popd > /dev/null