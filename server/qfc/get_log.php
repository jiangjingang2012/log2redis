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
       echo "ȱ�ٱ�Ҫ����";
        
    }
    
}

else {
    
    echo "�޲������룡������" ;
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
           
           echo "��ʱû��".$end_time."���ʱ������־��������ѡ��";
           exit ;
          }
       }
       else
       {
           echo "��ʱû��".$start_time."���ʱ������־��������ѡ��";
           exit ;
        
       }
     
    $diff= $end_num - $start_num ; 
    if ($start_num == $end_num)
    {
        echo "���ʱ����ڣ�û��������־��";
    }
    else if ($diff > 1000 )
    {
        echo "��ѡ���ʱ����ڣ��д�����־�����С��ʼʱ��ͽ�����ʱ��";
    }
    else 
     {
    $arr1=have_array($start_num,$end_num);
   
    $str1=get_array($r->hmget($project_name."_log",$arr1));
    
     echo $str1 ;
      }
    }
    else {
        
        echo "������".$project_name."���̣���";
        
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