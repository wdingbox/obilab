#!/usr/bin/perl -w
use strict;
use warnings;

$a=5;
while($a>0) {
   my $ret = `perl mko.pl` ;
   print $ret . "\r\n";
   my $tm = `date`;
   print $tm . "\r\n";
   sleep(1);
   
}



exit(0);
