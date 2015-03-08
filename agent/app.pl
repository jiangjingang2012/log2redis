#!/usr/bin/perl

use strict;
use warnings;
use Config::IniFiles;

my $base_dir=$ENV{'PWD'};

#my $cfg= Config::IniFiles->new(-file=>"$base_dir/config.ini");

my  $redis_server=$cfg->val('redis','server');
my  $redis_port  =$cfg->val('redis','port');

my @sects=$cfg->Sections;
my $logs ;

foreach my $sect (@sects){
chomp($sect);
if ($sect eq 'redis') 
{
 next;
}

my $base_str=$sect ;
$logs = $cfg->val($sect, "logname"); 
system("$base_dir/count_snap.pl $base_str &") ;

my @array_log=split(/,/,$logs); 
for  my $logfile (@array_log)
{
   if ( -e $logfile )
    {
	print "$logfile exists \n"; 
	system("$base_dir/get_log.pl $base_str $logfile &") ;
	 }
	 else 
	 {
    print "$logfile not exist \n"; 
	 }
}
 }

