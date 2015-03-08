#!/usr/bin/perl -w

use Redis;

my $base=$ARGV[0];
my $counter=$base."_count";
my $counter_snap=$base."_snap";


my $r=Redis->new(server => '192.168.202.133:6379');

if(!$r->exists("$counter"))
{
$r->set("$counter"=>0);
}

while()
{
my  $curr_count= $r->get("$counter");
my  $curr_date=getTime(); 

if (!$r->hexists("$counter_snap",$curr_date))
{
$r->hmset(
           "$counter_snap",
           $curr_date => $curr_count,
);
}
sleep(60);
}



sub getTime
{
    my $time = shift || time();
    my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);

    $year += 1900;
    $mon ++;

    $min  = '0'.$min  if length($min)  < 2;
    $sec  = '0'.$sec  if length($sec)  < 2;
    $mon  = '0'.$mon  if length($mon)  < 2;
    $mday = '0'.$mday if length($mday) < 2;
    $hour = '0'.$hour if length($hour) < 2;
    
    my $weekday = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat')[$wday];

    return "$year$mon$mday$hour$min" ;
         
}
	
