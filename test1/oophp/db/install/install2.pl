#!/usr/bin/perl -w

print "\nStarting installation.\n";

#
# Setup Sqlite
#
print "Create database:  ";

!system 'mysql --user=root --password=rootpass otest < create_tnm.sql 2> /dev/null' or die ('sql-err');

print "[OK]\n";

#
# 
# 
print "\nInstallation Complete.\n";
exit 0;

