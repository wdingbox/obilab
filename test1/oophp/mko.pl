#!/usr/bin/perl -w


use strict;
use warnings;


# Editable SourceDir
my $SrcPath = "/var/lib/mysql/";
my $DesPath = "/mnt/hgfs/lamp/wroot/odbak/var_lib_mysql";

my @projs = ("Hieroglyphics", "Jiaguwen");


#check dest dir
if (-d "$DesPath") {
   #system ("date");
}
else {
   !system("mkdir $DesPath") or die ("[ ERROR ] $DesPath : desPath not exit!");
}


foreach my $val (@projs) {
   my $srcpathDir = $SrcPath . $val;
   my $cmd_cp = "cp -rfuv $srcpathDir $DesPath";
   #print "$cmd_cp\n";
   #system $cmd_cp;
   my $ret = `$cmd_cp` ;
   if( length($ret)>0 ) {
      print "$cmd_cp \n";
      print "$ret \n";
   }
}
exit(0);















my $SrcPathDir = $SrcPath . $projs[0];
my $DesPathDir = $DesPath . $projs[0];
  
  my $test = `diff -r $SrcPathDir $DesPathDir` ;
  #chomp($test);
  print length($test) ."==$test\n";
  
  print "\n******\n"; 
  
  my @arr = split ("diff ", $test);
  print "\n0) " . $arr[0] . "<br/>"; 
  print "\n1) " . $arr[1] . "<br/>"; 
  print "\n2) " . $arr[2] . "<br/>"; 



exit(0);
