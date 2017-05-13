#!/usr/bin/env bash


#SCRIPTDIR=`dirname "$BASH_SOURCE"`
REALSOURCE=`realpath "$BASH_SOURCE"`
SCRIPTDIR=`dirname "$REALSOURCE"`

"$SCRIPTDIR/zcopy.php" "$@" | xclip