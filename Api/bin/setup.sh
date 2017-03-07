#!/bin/bash
myLocation="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )";

dataDirectory=$myLocation/../data;
varDirectory=$myLocation/../var;

dbName=shopping.sqlite3;

cd $dataDirectory;

echo `pwd`;

sqlite3 $varDirectory/$dbName < setup-db.sql;
sqlite3 $varDirectory/$dbName < fixtures-fr.sql;
