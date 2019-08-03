#!/usr/bin/env bash


#SCRIPTDIR=`dirname "$BASH_SOURCE"`
REALSOURCE=`realpath "$BASH_SOURCE"`
SCRIPTDIR=`dirname "$REALSOURCE"`

"$SCRIPTDIR/zphpenv.php" "$@" | bash
#php  -dxdebug.remote_enable=1 -dxdebug.remote_autostart=1 /var/www/vhost/gits/utils/phpenv/zphpenv.php restart
#below not working
#php  -dxdebug.remote_enable=1 -dxdebug.remote_autostart=1 " $SCRIPTDIR/zphpenv.php "
