#!/usr/bin/perl
use strict;
use warnings;
use File::Tail;
use Redis;

my $base=$ARGV[0];
my $logfile=$ARGV[1];

print $logfile;

my $counter=$base.'_count';
my $redis_logname=$base.'_log';

my $r=Redis->new(server => '192.168.202.133:6379');

if(!$r->exists("$counter"))
{
$r->set("$counter"=>0);
}


my $file=File::Tail->new(name=>"$logfile", maxinterval=>2,interval=>2 );
my ($line);
while (defined($line=$file->read)) {
                          chomp($line);
                          my $count_nu=$r->incr("$counter");
			  print "$line";
                          $r->hmset(
                           "$redis_logname",
                           $count_nu => $line,
                           );
  }

