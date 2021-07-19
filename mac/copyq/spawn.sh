if ps aux | grep "/Applications/CopyQ.app/Contents/MacOS/CopyQ" | grep -v grep
then
   echo "copyq already running"
else
   if ps aux | grep "Chrome" | grep -v grep
   then
      open /usr/local/bin/copyq
   else
      echo "Chrome is not running so assuming it is a shutdown"
   fi
fi
