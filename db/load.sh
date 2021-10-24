#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U yourbeauty -d yourbeauty < $BASE_DIR/yourbeauty.sql
    if [ -f "$BASE_DIR/yourbeauty_test.sql" ]; then
        psql -h localhost -U yourbeauty -d yourbeauty < $BASE_DIR/yourbeauty_test.sql
    fi
    echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U yourbeauty -d yourbeauty
fi
psql -h localhost -U yourbeauty -d yourbeauty_test < $BASE_DIR/yourbeauty.sql
echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U yourbeauty -d yourbeauty_test
