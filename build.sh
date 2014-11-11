#!/bin/sh

mkdir -p build
rm -fr build/*
cp index.php build
cp shariff.json build
cp -a vendor build
cp -a src build
