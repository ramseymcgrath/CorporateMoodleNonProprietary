#!/bin/bash -e

. /opt/bitnami/base/functions
. /opt/bitnami/base/helpers

if [[ "$1" == "nami" && "$2" == "start" ]] || [[ "$1" == "/run.sh" ]]; then
  nami_initialize apache php moodle
  info "Starting moodle... "
fi

exec tini -- "$@"
