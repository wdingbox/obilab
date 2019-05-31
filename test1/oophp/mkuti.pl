#!/usr/bin/perl -w


# Editable SourceDir
my $SrcDir = "/mnt/hgfs/lamp/wroot/oophp/";
my $proj="uti";


#use DBI;
#use Switch;



my $src = $SrcDir.$proj;

chomp(my $tgt = `pwd`);

my $parm=" -rfvu ";



print "\nsrc=".$src ;
print "\ntgt=".$tgt;

print "\nForce overwrite? [Yes(y)/No(Enter)]";
chomp($answer = <STDIN>);
if ("y" eq $answer ){
    $parm = " -rfv ";
}
print "cp $parm $src $tgt";

print "\n";
#
# copy source codes.
# 
chdir "./".$proj;
system "cp ".$parm. $src. " ".$tgt;




exit(0);





#
# make Makefile
# 
print "\n\nmake Makefile [q(quit), nvr(default),all]\n";
chomp ($answer = <STDIN> );
if ("q" eq $answer ){
  exit(0);
}
if ("" eq $answer ){
  $answer="nvr";
}
system "make " . $answer;

exit 0;

