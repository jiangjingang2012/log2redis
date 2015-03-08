<?php 

header('Content-type: text/html;charset=utf-8'); 

$redis_server="192.168.202.133";


$project = $_GET["project"]; 
$num=$_GET["num"];

if($project == "pre_trade")
{
    header('Content-type: text/html;charset=gbk'); 
}
//conncet redis
$r= new Redis();
$r->connect($redis_server,6379);

$counter=$project."_count";

if($r->exists($counter) && $r->exists($project."_log"))
{
  $max_id=$r->get($counter);
  if( $num==0 )
    {
    $bengin_id=$max_id-2;
    $arr1=have_array($bengin_id,$max_id);
    $str1=get_array($r->hmget($project."_log",$arr1));
    $output=$output."\n".$str1;
    //$output=mb_convert_encoding( $output,"UTF-8","GBK");
    echo ($output."||||||".$max_id);
    }
  else if($num == $max_id)
  {
    
    echo  ("||||||".$max_id);
    
  }
  else {
    
       $arr1=have_array($num,$max_id);
       $str1=get_array($r->hmget($project."_log",$arr1));
       $output=$ouput."\n".$str1;
       //$output=mb_convert_encoding( $output,"UTF-8","GBK");
       echo ($output."||||||".$max_id);
  }
}
else 
{
    echo $project."_log" ;
    echo "不存在的项目，请确认之后重新选择！";
}



function have_array($beg,$end)
{
    $arr=array();
    
    while($beg<=$end)
    {
        $arr[]=$beg;
        $beg++;
        
    }
    return $arr;
}

function get_array($arr)
{
    foreach($arr as  $vaule)
    {
        $res=$res."\n".$vaule;
    }
    return $res ;
}  


?> 
