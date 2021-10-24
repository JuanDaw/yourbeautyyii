#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE yourbeauty_test;"
    psql -U postgres -c "CREATE USER yourbeauty PASSWORD 'yourbeauty' SUPERUSER;"
else
    [ "$1" = "test" ] || sudo -u postgres dropdb --if-exists yourbeauty
    sudo -u postgres dropdb --if-exists yourbeauty_test
    [ "$1" = "test" ] || sudo -u postgres dropuser --if-exists yourbeauty
    [ "$1" = "test" ] || sudo -u postgres psql -c "CREATE USER yourbeauty PASSWORD 'yourbeauty' SUPERUSER;"
    [ "$1" = "test" ] || sudo -u postgres createdb -O yourbeauty yourbeauty
    [ "$1" = "test" ] || sudo -u postgres psql -d yourbeauty -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O yourbeauty yourbeauty_test
    sudo -u postgres psql -d yourbeauty_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    [ "$1" = "test" ] && exit
    LINE="localhost:5432:*:yourbeauty:yourbeauty"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
