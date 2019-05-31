#!/usr/bin/perl -w

$databasename = "otest";
$mysql_db="mysql --user=root --password=rootpass  ". $databasename;
$mysql_db="mysql --user=root ". $databasename;   #in case not secured.
print "To Create database:  ". $mysql_db . ":\n\n";

use Cwd;
my $directory = cwd;
$directory = $directory . "/sql";
opendir (DIR, $directory) or die $!;
while (my $file = readdir(DIR)) {
        if ( ($file eq "." ) || ($file eq "..") ) {
         next; 
         }
        print "- $file\n";
        $cmdstr = $mysql_db.' < sql/'.$file;
        print( $cmdstr ."\n");
        !system ( $cmdstr ) or die ('sql-err');

    }
closedir(DIR);


exit(0);



print "\nStarting installation.\n";

#
# Setup Sqlite
#


$mysql_db="mysql --user=root --password=rootpass otest ";
print "Create database:  ". $mysql_db . "\n";

!system $mysql_db.' < sql/irregular_verbs.sql 2> /dev/null' or die ('sql-err irregular_verbs.sql');
#!system 'mysql --user=root --password=rootpass otest < sql/irregular_verbs.sql 2> /dev/null' or die ('sql-err irregular_verbs.sql');


print "[OK]\n";

#
# 
# 
print "\nInstallation Complete.\n";
exit 0;

