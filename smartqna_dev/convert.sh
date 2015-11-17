#!/bin/bash

# convert ISO-8859 to UTF-8




if [ -z "$1" ]; then

	echo "Usage : $0 [input file]"

	echo "        $0 [input file] [output-file]"

	echo "        input-file  : Must ISO-8859 file type"

	echo "        output-file : default input file name"

	exit

fi




outfile=$2




filetype=$(file $1 | grep ISO-8859)

if [ -z "$filetype" ]; then

	echo "$1 is not ISO-8859 type"

	exit

fi




if [ -z "$2" ]; then

	outfile=$1

fi




echo "================================"

echo "input file  : $1"

echo "output file : $1"

echo "================================"

echo ""




dos2unix $1




iconv -f EUC-KR -t UTF-8 $1 -o $outfile




echo "done..."

