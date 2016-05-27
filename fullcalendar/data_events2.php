<?php @session_start(); ?>
<?php  
header("Content-type:application/json; charset=UTF-8");            
header("Cache-Control: no-store, no-cache, must-revalidate");           
header("Cache-Control: post-check=0, pre-check=0", false);      
include '../connection/connect_calendra.php'; // เรียกใช้งานไฟล์เชื่อมต่อกับฐานข้อมูล  
 // เชื่อมต่อกับฐานข้อมูล      
if($_GET['gData']){
    $main_dep=$_SESSION[main_dep];
    $event_array=array();  
    $i_event=0;  
    $q="SELECT tb.* FROM tbl_event tb 
         inner join emppersonal em on em.empno=tb.empno
         inner join department d on d.depId=em.depid
         WHERE date(event_start)>='".$_GET['start']."' AND date(event_end)<='".$_GET['end']."' 
         and d.main_dep='$main_dep' and tb.process='0' ORDER by event_id";    
    $qr=mysql_query($q) or die(mysql_error()); 
    
    $code_color=array("1"=>"#416cbb","2"=>"#d92727","3"=>"#1e6c06","4"=>"purple","5"=>"#00a6ba","6"=>"orange","7"=>"#4e5252");
    $sql_leave=  mysql_query("SELECT COUNT(idla) as count_leave FROM typevacation") or die(mysql_error($db));
    $car= mysql_fetch_array($sql_leave);
    while($rs=mysql_fetch_array($qr)){  
        for($i=1;$i<=$car['count_leave'];$i++){
        if ($rs['typela'] == "$i") {  
            $color = "$code_color[$i]";  
            }}
        $event_array[$i_event]['id']=$rs['event_id'];  
        $event_array[$i_event]['title']=$rs['event_title'];  
        $event_array[$i_event]['start']=$rs['event_start'];  
        $event_array[$i_event]['end']=$rs['event_end'];  
        $event_array[$i_event]['url']=$rs['event_url']; 
        $event_array[$i_event]['color']=$color;
        $event_array[$i_event]['allDay']=($rs['event_allDay']=="true")?true:false;  
        $i_event++;  
    }    
}  
$json= json_encode($event_array);    
if(isset($_GET['callback']) && $_GET['callback']!=""){    
echo $_GET['callback']."(".$json.");";        
}else{    
echo $json;    
}   
?>  
<?php  /* 
header("Content-type:application/json; charset=UTF-8");            
header("Cache-Control: no-store, no-cache, must-revalidate");           
header("Cache-Control: post-check=0, pre-check=0", false);      
include '../connection/connect_i.php'; // เรียกใช้งานไฟล์เชื่อมต่อกับฐานข้อมูล 
if($_GET['gData']){    
    $q="SELECT * FROM tbl_event WHERE date(event_start)>='".$_GET['start']."'  ";    
    $q.=" AND date(event_end)<='".$_GET['end']."' ORDER by event_id";    
    $result = $db->query($q);  
    while($rs=$result->fetch_object()){  
        if ($rs->typela == '1') {  
            $color = 'orange';  
        } else if ($rs->typela == '2') {  
            $color = 'violet';  
        } else if ($rs->typela == '3') {  
            $color = 'green';  
        }else if ($rs->typela == '4') {  
            $color = 'red';  
        } else if ($rs->typela == '5') {  
            $color = 'yellow';  
        }else if ($rs->typela == '7') {  
            $color = 'brown';  
        } 
        $json_data[]=array(    
            "id"=>$rs->event_id,  
            "title"=>$rs->event_title,  
            "start"=>$rs->event_start,  
            "end"=>$rs->event_end,  
            "url"=>$rs->event_url,
            "color" => $color,
            "allDay"=>($rs->event_allDay==true)?true:false   
              
        );  
    }    
}  
$json= json_encode($json_data);    
if(isset($_GET['callback']) && $_GET['callback']!=""){    
echo $_GET['callback']."(".$json.");";        
}else{    
echo $json;    
}    */ 
?>    
