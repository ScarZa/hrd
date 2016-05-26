<?php @session_start(); ?>
<?php

if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php include'option/jquery.php'; ?>
<?php include'header.php'; ?>
<?php
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";	

$adminId=$_SESSION[user];
$empno=$_REQUEST[empno];
$depno=$_REQUEST[depno];
$emptype=$_REQUEST[emptype];

if($_POST[method]=='leave'){
    if($_SESSION[Status]=='ADMIN'){
$date_reg_conv = $_POST[date_reg];
$date_reg='';
insert_date($date_reg_conv,$date_reg);
    }else{
$date_reg=date('Y-m-d');        
    }
$typel = $_POST[typel];
$date_s_conv = $_POST[date_s];
$date_s='';
insert_date($date_s_conv,$date_s);
$date_e_conv = $_POST[date_e];
$date_e='';
insert_date($date_e_conv,$date_e);
$amount = $_POST[amount];
$reason_l = $_POST[reason_l];
$add_conn = $_POST[add_conn];
$tell = $_POST[tell];
$cert = $_POST[cert];
$note = $_POST[note];
$statusla='Y';
$regis='W';

include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    $beg_date="$y-10-01";
    $en_date="$Yy-09-30";
}else{
    $beg_date="$Y-10-01";
    $en_date="$y-09-30";
}

$check_leave_date=  mysql_query("select begindate from work where enpid='$empno' and begindate='$date_s' and statusla='Y'");
$num_row = mysql_num_rows($check_leave_date);
if (empty($num_row)) {
$sql_leave=  mysql_query("select workid from work where enpid='$empno' and  typela='$typel' and statusla='Y' and begindate between '$beg_date' and '$en_date' ORDER BY workid desc");
$befor_leave=  mysql_fetch_assoc($sql_leave);

$befor_workid=$befor_leave['workid'];
for($i = 0; $i < count($_POST["typela"]); $i++){
    if (trim($_POST["typela"][$i]) != "") {
        $typela[$i]=$_POST["typela"][$i];
        $last_amount[$i]=$_POST["leave_type"][$i];
    }
    
}

$insert_print=  mysql_query("insert into print_leave set empno='$empno', befor_workid='$befor_workid',last_type1='$typela[0]',last_amount1='$last_amount[0]',
        last_type2='$typela[1]',last_amount2='$last_amount[1]',last_type3='$typela[2]',last_amount3='$last_amount[2]',last_type4='$typela[3]',last_amount4='$last_amount[3]',
        last_type5='$typela[4]',last_amount5='$last_amount[4]',last_type6='$typela[5]',last_amount6='$last_amount[5]',last_type7='$typela[6]',last_amount7='$last_amount[6]'");
if ($insert_print == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{

function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "myfile/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
$regis_leave=  mysql_query("select count from count where count_name='regis_leave'");
$Regis_Leave=  mysql_fetch_assoc($regis_leave);
$Ln=$Regis_Leave['count']+1;
$Y=date('y')+43;
$leave_no="$Y/$Ln";
    $update_count=  mysql_query("update count set count='$Ln' where count_name='regis_leave'");
    $insert_leave=  mysql_query("insert into work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                typela='$typel', amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note', pics='$image', idAdmin='$adminId', statusla='$statusla',depId='$depno',regis_leave='$regis' ");
    $event=  mysql_query("select CONCAT(firstname,' ',lastname) as fullname from emppersonal where empno='$empno'");
    $Event=mysql_fetch_assoc($event);
    $workid=mysql_query("select workid from work where enpid='$empno' ORDER BY workid DESC");
    $Workid=mysql_fetch_assoc($workid);
    
    $date_end=date('Y-m-d', strtotime("$date_e+1 days "));
    $insert_event=mysql_query("insert into tbl_event set event_title='$Event[fullname]',event_start='$date_s',event_end='$date_end',event_allDay='true',
            empno='$empno',workid='$Workid[workid]',typela='$typel',process='0'");
    
    if($typel=='1'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L1]-$amount;
        $L_day2=  mysql_query("update leave_day set L1='$leave' where empno='$empno'");
      }  elseif($typel=='2'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L2]-$amount;
        $L_day2=  mysql_query("update leave_day set L2='$leave' where empno='$empno'");
      }elseif($typel=='3'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L3]-$amount;
        $L_day2=  mysql_query("update leave_day set L3='$leave' where empno='$empno'");
      }elseif($typel=='4'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L4]-$amount;
        $L_day2=  mysql_query("update leave_day set L4='$leave' where empno='$empno'");
      }elseif($typel=='5'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L5]-$amount;
        $L_day2=  mysql_query("update leave_day set L5='$leave' where empno='$empno'");
      }elseif($typel=='6'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L6]-$amount;
        $L_day2=  mysql_query("update leave_day set L6='$leave' where empno='$empno'");
      }elseif($typel=='7'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L7]-$amount;
        $L_day2=  mysql_query("update leave_day set L7='$leave' where empno='$empno'");
      } 
          
          if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{
    $selec_work= mysql_query("select workid from work  where enpid='$empno' and reg_date='$date_reg' and typela='$typel' ORDER BY workid desc");
    $workId=  mysql_fetch_assoc($selec_work);
    $select_print_id=  mysql_query("select print_id from print_leave  where empno='$empno' order by print_id desc");
    $Print_id=  mysql_fetch_assoc($select_print_id);
    $update_work=mysql_query("update print_leave set workid='$workId[workid]' where print_id='$Print_id[print_id]' and befor_workid='$befor_workid' and empno='$empno'");
    if ($update_work == false) {
        echo "<p>";
        echo "update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
    
}}}}else{
    echo "<script>alert('มีการบันทึกการลาในวันที่เลือกแล้ว กรุณาตรวจสอบอีกครั้ง!!!    * หากต้องการลาต้องยกเลิกใบเดิมใบเดิม')</script>";
    echo "<meta http-equiv='refresh' content='0;url=./pre_leave.php'/>";
    exit();
}}elseif ($_POST[method]=='time_leave'){
//$leave_no=$_POST[leave_no]; 
        if($_SESSION[Status]=='ADMIN'){
$date_reg_conv = $_POST[date_reg];
$date_reg='';
insert_date($date_reg_conv,$date_reg);
    }else{
$date_reg=date('Y-m-d');        
    }
$date_l_conv = $_POST[date_l];
$date_l='';
insert_date($date_l_conv,$date_l);
$time_s = $_POST[time_s];
$time_e = $_POST[time_e];
$amount = $_POST[amount];
$reason_l = $_POST[reason_l];
$stat_tl='N';
$regis='W';

$countla=$_POST["countla"];
$sumt=$_POST["sumt"];
$insert_print=  mysql_query("insert into print_tleave set empno='$empno',last_tleave='$countla',last_tamount='$sumt'");
if ($insert_print == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_leave.php' >กลับ</a>";
    }else{

function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "time_l/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
$regis_tleave=  mysql_query("select count from count where count_name='regis_tleave'");
$Regis_TLeave=  mysql_fetch_assoc($regis_tleave);
$Ln=$Regis_TLeave['count']+1;
$Y=date('y')+43;
$leave_no="$Y/$Ln";
    $update_count=  mysql_query("update count set count='$Ln' where count_name='regis_tleave'");
    $insert_leave=  mysql_query("insert into timela set empno='$empno', vstdate='$date_reg', idno='$leave_no',
                                   comment='$reason_l',datela='$date_l',starttime='$time_s',endtime='$time_e',
                                       total='$amount',status='$stat_tl',depId='$depno',pics_t='$image',idAdmin='$adminId',regis_time='$regis' ");
    if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_leave.php' >กลับ</a>";
    }else{
    $selec_timela= mysql_query("select id from timela where empno='$empno' and vstdate='$date_reg' ORDER BY id desc");
    $timeid=  mysql_fetch_assoc($selec_timela);
    $update_time=mysql_query("update print_tleave set tleave_id='$timeid[id]' where last_tleave='$countla' and empno='$empno'");
    if ($update_time == false) {
        echo "<p>";
        echo "update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_leave.php' >กลับ</a>";
    }else{
    
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
    }}}}elseif ($_POST[method]=='transfer') {
    $leave_no=$_POST[leave_no];
    $date_reg = $_POST[date_reg];
    $typel = $_POST[typel];
    $amount = $_POST[amount];
    $note = $_POST[note];
    $date_s = $_POST[date_reg];
    $date_e = $_POST[date_reg];
    $reason_l = '';
    $add_conn = '';
    $tell = '';
    $cert = '';
    $image ='';
    $regis='Y';
    $insert_leave=  mysql_query("insert into work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                typela='$typel', amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note', pics='$image', idAdmin='$adminId', statusla='Y',depId='$depno',regis_leave='$regis'");
    
     if($typel=='1'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L1]-$amount;
        $L_day2=  mysql_query("update leave_day set L1='$leave' where empno='$empno'");
      }  elseif($typel=='2'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L2]-$amount;
        $L_day2=  mysql_query("update leave_day set L2='$leave' where empno='$empno'");
      }elseif($typel=='3'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L3]-$amount;
        $L_day2=  mysql_query("update leave_day set L3='$leave' where empno='$empno'");
      }elseif($typel=='4'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L4]-$amount;
        $L_day2=  mysql_query("update leave_day set L4='$leave' where empno='$empno'");
      }elseif($typel=='5'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L5]-$amount;
        $L_day2=  mysql_query("update leave_day set L5='$leave' where empno='$empno'");
      }elseif($typel=='6'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L6]-$amount;
        $L_day2=  mysql_query("update leave_day set L6='$leave' where empno='$empno'");
      }elseif($typel=='7'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L7]-$amount;
        $L_day2=  mysql_query("update leave_day set L7='$leave' where empno='$empno'");
      } 
    
    if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=detial_leave.php?id=$empno'>";

}elseif($_POST[method]=='edit_leave'){
    $Lno=$_POST[Lno];
    $leave_no=$_POST[leave_no];
    $date_reg_conv = $_POST[date_reg];
$date_reg=date('Y-m-d');
$date_s_conv = $_POST[date_s];
$date_s='';
insert_date($date_s_conv,$date_s);
$date_e_conv = $_POST[date_e];
$date_e='';
insert_date($date_e_conv,$date_e);
    $typel = $_POST[typel];
    $amount = $_POST[amount];
    $reason_l = $_POST[reason_l];
    $add_conn = $_POST[add_conn];
    $tell = $_POST[tell];
    $cert = $_POST[cert];
    $note = $_POST[note];
    
    function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "myfile/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
    if($image !=''){
    $update_leave=  mysql_query("update work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note',idAdmin='$adminId',pics='$image'
                                where enpid='$empno' and workid='$Lno'");
    }else{
        $update_leave=  mysql_query("update work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note',idAdmin='$adminId'
                                where enpid='$empno' and workid='$Lno'");
    }
    
    $date_end=date('Y-m-d', strtotime("$date_e+1 days "));
        $update_event=mysql_query("update tbl_event set event_start='$date_s',event_end='$date_end' where empno='$empno' and workid='$Lno'");
        
        include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    $beg_date="$y-10-01";
    $en_date="$Yy-09-30";
}else{
    $beg_date="$Y-10-01";
    $en_date="$y-09-30";
}
    /*   $sql_leave=  mysql_query("select workid from work where enpid='$empno' and  typela='$typel' and statusla='Y' and begindate between '$beg_date' and '$en_date' ORDER BY workid desc");
$befor_leave=  mysql_fetch_assoc($sql_leave);
$befor_workid=$befor_leave['workid']; 
$update_print=  mysql_query("update print_leave set befor_workid='$befor_workid' where empno='$empno' and workid='$Lno'");*/

    if ($update_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
}elseif ($_POST[method]=='edit_Tleave'){
$Lno=$_POST[Lno];    
$leave_no=$_POST[leave_no];    
$date_reg_conv = $_POST[date_reg];
$date_reg='';
insert_date($date_reg_conv,$date_reg);
$date_l_conv = $_POST[date_l];
$date_l='';
insert_date($date_l_conv,$date_l);
$time_s = $_POST[time_s];
$time_e = $_POST[time_e];
$amount = $_POST[amount];
$reason_l = $_POST[reason_l];

function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "time_l/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
if($image !=''){
$update_leave=  mysql_query("update timela set idno='$leave_no', vstdate='$date_reg', 
                                   comment='$reason_l',datela='$date_l',starttime='$time_s',endtime='$time_e',
                                       total='$amount',pics_t='$image'
                            where empno='$empno' and id='$Lno'");
}else{
    $update_leave=  mysql_query("update timela set idno='$leave_no', vstdate='$date_reg', 
                                   comment='$reason_l',datela='$date_l',starttime='$time_s',endtime='$time_e',
                                       total='$amount'
                            where empno='$empno' and id='$Lno'");
}
    if ($update_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
    } 
}elseif ($_POST[method]=='cancle_leave'){
    $typel=$_POST[typela];
    $amount=$_POST[amount];
    $Lno=$_POST[Lno];
    $comment=$_POST[reason];
    $status='N';
    date_default_timezone_set('Asia/Bangkok');
    $candate=  date('Y-m-d H:i:s');

    function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "cancle/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}  
    $update_work=  mysql_query("update work set statusla='$status' where enpid='$empno' and workid='$Lno'");
    $in_cancle=  mysql_query("insert into cancle set workid='$Lno', cancledate='$candate', cancle_comment='$comment',
            admin_cancle='$adminId', pics_cancle='$image'");
           
    $delete_event=mysql_query("delete from tbl_event where empno='$empno' and workid='$Lno'");
    $delete_print_leave=mysql_query("delete from print_leave where empno='$empno' and workid='$Lno'");
    
    if($typel=='1'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L1]+$amount;
        $L_day2=  mysql_query("update leave_day set L1='$leave' where empno='$empno'");
      }  elseif($typel=='2'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L2]+$amount;
        $L_day2=  mysql_query("update leave_day set L2='$leave' where empno='$empno'");
      }elseif($typel=='3'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L3]+$amount;
        $L_day2=  mysql_query("update leave_day set L3='$leave' where empno='$empno'");
      }elseif($typel=='4'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L4]+$amount;
        $L_day2=  mysql_query("update leave_day set L4='$leave' where empno='$empno'");
      }elseif($typel=='5'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L5]+$amount;
        $L_day2=  mysql_query("update leave_day set L5='$leave' where empno='$empno'");
      }elseif($typel=='6'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L6]+$amount;
        $L_day2=  mysql_query("update leave_day set L6='$leave' where empno='$empno'");
      }elseif($typel=='7'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L7]+$amount;
        $L_day2=  mysql_query("update leave_day set L7='$leave' where empno='$empno'");
      }
    if ($in_cancle == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }?>
<center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='detial_leave.php?id=<?=$empno?>'; window.close();">ปิดหน้าต่าง</a></center> 
    
<?php }  elseif($_POST[method]=='add_leave'){
    $L1=$_POST[L1];
    $L2=$_POST[L2];
    $L3=$_POST[L3];
    $L4=$_POST[L4];
    $L5=$_POST[L5];
    $L6=$_POST[L6];
    $L7=$_POST[L7];
    
    $sql=  mysql_query("SELECT empno FROM leave_day WHERE empno='$empno'");
         $num_row=  mysql_num_rows($sql);
         if($num_row >= 1){
             echo "<div class='alert alert-dismissable alert-danger'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>***เพิ่มคนนี้ไปแล้วจ้า***</center></a> 
</div>";

    echo "<meta http-equiv='refresh' content='2;URL=pre_leave.php'>";
         }else{
    $insert_leave=  mysql_query("insert into leave_day set empno='$empno',emptype='$emptype', L1='$L1',L2='$L2',L3='$L3',L4='$L4',L5='$L5',L6='$L6',L7='$L7' ");
    if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_leave.php' >กลับ</a>";
         }
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
}}elseif($_POST[method]=='edit_add_leave'){
    $L1=$_POST[L1];
    $L2=$_POST[L2];
    $L3=$_POST[L3];
    $L4=$_POST[L4];
    $L5=$_POST[L5];
    $L6=$_POST[L6];
    $L7=$_POST[L7];
    $update_add_leave=  mysql_query("update leave_day set  L1='$L1',L2='$L2',L3='$L3',L4='$L4',L5='$L5',L6='$L6',L7='$L7'
            where empno='$empno' ");
    if ($update_add_leave == false) {
        echo "<p>";
        echo "update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_leave.php' >กลับ</a>";
         }
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
}elseif ($_POST[method]=='regis_leave') {
    $workid=$_POST[workid];
    $regis='A';
    $leave_no=$_POST[leave_no];
    $regis_date=date('Y-m-d');
    $update_regis=  mysql_query("update work set  leave_no='$leave_no',regis_leave='$regis',receiver='$adminId',regis_date='$regis_date'
            where enpid='$empno' and workid='$workid' ");
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }else{ ?>
    <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='receive_leave.php'; window.close();">ปิดหน้าต่าง</a></center> 
 <?php        }
}elseif ($_POST[method]=='check_leave') {
    $workid=$_POST[workid];
    $regis=$_POST[confirm];
    $typel=$_POST['typela'];
    $update_regis=  mysql_query("update work set regis_leave='$regis',confirmer='$adminId'
            where enpid='$empno' and workid='$workid' ");
    if($regis=='N'){
    $delete_event=mysql_query("delete from tbl_event where empno='$empno' and workid='$workid'");
    $amount_leave=  mysql_query("select amount from work where enpid='$empno' and workid='$workid'");
    $sql_amount=  mysql_fetch_assoc($amount_leave);
    $amount=$sql_amount['amount'];
    
    if($typel=='1'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L1]+$amount;
        $L_day2=  mysql_query("update leave_day set L1='$leave' where empno='$empno'");
      }  elseif($typel=='2'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L2]+$amount;
        $L_day2=  mysql_query("update leave_day set L2='$leave' where empno='$empno'");
      }elseif($typel=='3'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L3]+$amount;
        $L_day2=  mysql_query("update leave_day set L3='$leave' where empno='$empno'");
      }elseif($typel=='4'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L4]+$amount;
        $L_day2=  mysql_query("update leave_day set L4='$leave' where empno='$empno'");
      }elseif($typel=='5'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L5]+$amount;
        $L_day2=  mysql_query("update leave_day set L5='$leave' where empno='$empno'");
      }elseif($typel=='6'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L6]+$amount;
        $L_day2=  mysql_query("update leave_day set L6='$leave' where empno='$empno'");
      }elseif($typel=='7'){
        $L_day=  mysql_query("select * from leave_day where empno='$empno'");
        $L_Day=  mysql_fetch_assoc($L_day);
        $leave=$L_Day[L7]+$amount;
        $L_day2=  mysql_query("update leave_day set L7='$leave' where empno='$empno'");
    }}
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }else{ ?>
    <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='receive_leave.php'; window.close();">ปิดหน้าต่าง</a></center> 
 <?php        }
}elseif ($_POST[method]=='regis_tleave') {
    $workid=$_POST[workid];
    $regis='A';
    $leave_no=$_POST[leave_no];
    $regis_date=date('Y-m-d');
    $update_regis=  mysql_query("update timela set  idno='$leave_no',regis_time='$regis',receivert='$adminId', regis_date='$regis_date' 
            where empno='$empno' and id='$workid' ");
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }else{ ?>
    <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='receive_leave.php'; window.close();">ปิดหน้าต่าง</a></center> 
 <?php        }
}elseif ($_POST[method]=='check_tleave') {
    $workid=$_POST[workid];
    $regis=$_POST[confirm];
    $update_regis=  mysql_query("update timela set regis_time='$regis',comfirmert='$adminId'
            where empno='$empno' and id='$workid' ");
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }else{ ?>
    <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='receive_leave.php'; window.close();">ปิดหน้าต่าง</a></center> 
 <?php        }
}
?>