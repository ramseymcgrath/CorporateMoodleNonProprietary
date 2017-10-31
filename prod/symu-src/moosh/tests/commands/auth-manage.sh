
#!/bin/bash
source functions.sh

install_db
install_data
cd $MOODLEDIR

if $MOOSHCMD auth-manage enable db | grep "Auth modules enabled"; then
  exit 0
else
  exit 1
fi