#! /usr/bin/env python
import os
import sys
import time

print "hello test.pt\n\
   sdd gg"
  

#os.listdir(".")

proj = "oophp"
dirsrc = "/mnt/hgfs/lamp/wroot/" +  proj



count = 0
while 1:
   ret1 = os.popen("cp -rfvux %s %s" % (dirsrc, ".") ).read()
   ret2 = '' #os.popen("cp -rfvux %s %s" % (dirsrc,"/mnt/hgfs/htdocs/wroot/oophp") ).read()
   if(ret1 != '' ) : 
      print ret1 , ret2, "\a"
      count = 0
   else :
      sys.stdout.write( "%d-" % count )
      sys.stdout.flush()
      #print count 
   count=count+1
   time.sleep(3)
   
