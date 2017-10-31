#!/bin/bash
source functions.sh

install_db
install_data
cd $MOODLEDIR

if $MOOSHCMD data-stats | grep "dataroot:" ; then
  exit 0
else
  exit 1
fi
