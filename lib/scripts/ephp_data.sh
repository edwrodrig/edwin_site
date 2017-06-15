#!/bin/sh

BASEDIR=$(dirname $0)/..

REPO=http://edwin@repos.edwin.cl/ephp_data
DIR=ephp_data

cd $BASEDIR
rm $DIR -rf
mkdir $DIR
cd $DIR
fossil clone $REPO r.fossil
fossil open --nested r.fossil

fossil close; rm -rf r.fossil test

