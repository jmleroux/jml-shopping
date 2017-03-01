#!/bin/bash
myLocation="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )";

dataDirectory=$myLocation/../data;

dbName=shopping.sqlite3;

cd $dataDirectory;

echo `pwd`;

sqlite3 $dataDirectory/$dbName < setup-db.sql;
sqlite3 $dataDirectory/$dbName < fixtures-fr.sql;
