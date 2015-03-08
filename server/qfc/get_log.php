<?php

    $redis_server="192.168.202.133";
    $r= new Redis();
   # global $r ;
    $r->connect($redis_server,6379);


if(_GET)
{
    if(!empty($_GET["project"]) && !empty($_GET["start_time"]) && !empty($_GET["end_time"]))
    {
       # $project_name=$_GET["project"];        
        get_redis($r,$_GET["project"],$_GET["start_time"],$_GET["end_time"]);
        
    }
    else
     {
       echo "缺少必要参数";
        
    }
    
}

else {
    
    echo "无参数输入！！！！" ;
}


function get_redis($r,$project_name,$start_time,$end_time)
{

    
    $counter_snap=$project_name."_snap";
    if ($r->exists($counter_snap))
    {
       if($r->hexists($counter_snap,$start_time))
       {
         $start_num=$r->hget($counter_snap,$start_time);
         if($r->hexists($counter_snap,$end_time))
          {
           $end_num=$r->hget($counter_snap,$end_time);
          }
          else
          {
           
           echo "暂时没有".$end_time."这个时间点的日志，请重新选择";
           exit ;
          }
       }
       else
       {
           echo "暂时没有".$start_time."这个时间点的日志，请重新选择";
           exit ;
        
       }
     
    $diff= $end_num - $start_num ; 
    if ($start_num == $end_num)
    {
        echo "这个时间段内，没有生成日志！";
    }
    else if ($diff > 1000 )
    {
        echo "所选择的时间段内，有大量日志，请减小开始时间和结束的时间差！";
    }
    else 
     {
    $arr1=have_array($start_num,$end_num);
   
    $str1=get_array($r->hmget($project_name."_log",$arr1));
    
     echo $str1 ;
      }
    }
    else {
        
        echo "不存在".$project_name."工程！！";
        
    }
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