#! /usr/bin/env python


import os

print "hello test.pt\n\
   sdd gg"
   
#print sys.argv[0] 
a,b = 0,1
while b< 10:
  pass #
  
  print b
  pass #a, b = b, a+b
  a, b = b, a+b
  x = int(raw_input("hi:"))
  pass
  
  if x<0:  
      print "neg=", x   
      x=0
  elif x == 0:
     print "xero"
  else :
      print "more",x

      
def fun(n):
   return lambda x:   x+n
f = fun(10)        
print "lamda=", f(2)

os.listdir(".")

dirname = "."


os.listdir(dirname)

print [f for f in os.listdir(dirname) if os.path.isfile(os.path.join(dirname, f))]        [3]

print [f for f in os.listdir(dirname) if os.path.isdir(os.path.join(dirname, f))]            [4]
