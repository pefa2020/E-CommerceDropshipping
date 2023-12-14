#!/bin/bash

file1=`egrep -o "(amway|hivebrands)" <<< $1`
file2=`egrep -o "(hivebrands|amway)" <<< $2`
# Downloading tagsoup in the current directory
curl -o tagsoup-1.2.1.jar https://repo1.maven.org/maven2/org/ccil/cowan/tagsoup/tagsoup/1.2.1/tagsoup-1.2.1.jar
# asserting that file1 and file2 are different...

$index

while true
do
    # About to read file1
    while read -r line; do
	    #echo "--------------------------------------------------------------------------------------------------------"
	    # Know  $line stands for URL
	    
	    #curl -o ${file1}.html $line
	    wget -O ${file1}.html $line
	    java -jar tagsoup-1.2.1.jar --output-encoding=utf-8 --files ${file1}.html
	    #echo "ABOUT TO ENTER PYTHON"
	    # when using parser, use nwefile.xhtml not newfile.html
	    #echo "About to execute python for index $index"
	    python3 parser.py ${file1}.xhtml
	    rm ${file1}.html
	    rm ${file1}.xhtml
	    #echo "--------------------------------------------------------------------------------------------------------"
    done < "${file1}.txt"
     
    # About to read file2
    while read -r line; do
	    #echo "--------------------------------------------------------------------------------------------------------"
	    # Know $Line stands for URL
	    #echo $line
        #curl -o ${file2}.html $line
        wget -O ${file2}.html $line
        java -jar tagsoup-1.2.1.jar --output-encoding=utf-8 --files ${file2}.html
        #echo "ABOUT TO ENTER PYTHON"
        # when using parser, use nwefile.xhtml not newfile.html
        python3 parser.py ${file2}.xhtml
        rm ${file2}.html
        rm ${file2}.xhtml
	    #echo "--------------------------------------------------------------------------------------------------------"
    done < "${file2}.txt"
    sleepTime=$(( 6*60*60)) 
   sleep $sleepTime
done
