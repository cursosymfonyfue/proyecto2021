#!/bin/bash

KILL=0;
START=1;

read_command_line_input() {
  for i in "$1"
  do
  case $i in
      -k=*|--kill=*)
      KILL="${i#*=}"
      shift # past argument=value
      ;;
      -s=*|--start=*)
      START="${i#*=}"
      shift # past argument=value
      ;;
  esac
  done
}

stop_selenium() {
  if [ $KILL -eq 1 ]; then

      pid=`ps aux | grep -v grep | grep selenium-server | awk '{print $2}'`
      if [ "$pid" != '' ]; then
          echo "Killing Selenium $pid"
          sudo kill -9 $pid
      fi

      pid=`ps aux | grep -v grep | grep Xvfb | awk '{print $2}'`
      if [ "$pid" != '' ]; then
          echo "Killing Xvfb $pid"
          sudo kill -9 $pid
       fi

      pid=`ps aux | grep -v grep | grep chromedriver-74 | awk '{print $2}'`
      if [ "$pid" != '' ]; then
          echo "Killing chromedriver-74 $pid"
          sudo kill -9 $pid
       fi

      sudo pkill -f chrome
  fi
}

start_selenium() {
  if [ $START -eq 1 ]; then

      ps cax | grep -v grep | grep Xvfb > /dev/null
      if [ $? -ne 1 ]; then
          echo "Xvfb Process is running."
      else
          echo "Starting Xvfb Process ..."
          if [ -f /usr/bin/Xvfb ]; then
            sudo Xvfb :10 -ac &
          fi
      fi

      export DISPLAY=:10

      ps cax | grep -v grep | grep selenium-server > /dev/null
      if [ $? -ne 1 ]; then
          echo "Selenium Process is running."
      else
          scriptdir=`dirname "$BASH_SOURCE"`
          jarFolder="$PWD/"$scriptdir"/../bin/"
          echo "Starting Selenium Process ... ($jarFolder)"
          LANG=en-US java -Dwebdriver.chrome.driver=/var/www/html/drivers/chromedriver -Dwebdriver.chrome.whitelistedIps="127.0.0.1" -jar /var/www/html/bin/selenium-server-standalone.jar &
    fi
  fi
}


read_command_line_input "$@"
start_selenium
stop_selenium
