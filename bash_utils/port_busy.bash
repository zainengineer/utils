#!/usr/bin/env bash

#to find processes use netstat -ntlp | grep "50443"
#to kill use
#fuser -k 50443/tcp
portResponse=$(netstat -lnt | awk '$6 == "LISTEN" && $4 ~ ".50443"')
if [ -z "$portResponse" ]
then
  echo "Port available for nodejs, starting port processor"
  nohup nodejs nodejs/express/server.js  0<&- &>/dev/null &
else
  echo "Nodejs server already running"
fi
