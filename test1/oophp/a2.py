#! /usr/bin/env python
import os
import sys
import time

print "hello test.pt\n\
   sdd gg"
  

os.listdir(".")

dirname = "/mnt/hgfs/lamp"


os.listdir(dirname)

print [f for f in os.listdir(dirname) if os.path.isfile(os.path.join(dirname, f))]       

print [f for f in os.listdir(dirname) if os.path.isdir(os.path.join(dirname, f))]        


count = 0
for f in os.listdir(dirname) :
   #print os.path.join(dirname,f)
   ret = os.popen("cp -rfvu %s %s" % ("/mnt/hgfs/lamp/wroot/oophp",".") ).read()
   
    
   print ret
   count=count+1
   sys.stdout.write( "b" )
   sys.stdout.write(" a ")
   time.sleep(3)
   
