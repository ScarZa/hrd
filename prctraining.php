<?php @session_start(); ?>
<?php if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
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
    $admin=$_SESSION[user];
if($_SESSION[Status]=='ADMIN'){
    $take_date_conv = $_POST['reg_date'];
    $reg_date='';
    insert_date(&$take_date_conv,&$reg_date);
    $check='0';
}else{
    $reg_date = date('Y-m-d');
    $check='1';
}
    $project_no = $_POST[project_no];
    $project_name = $_POST[project_name];
    $project_dep = $_POST[project_dep];
    $project_obj = $_POST[project_obj];
    $project_place = $_POST[project_place];
    $province = $_POST[province];
    $take_date_conv = $_POST['Pdates'];
    $Pdates='';
    insert_date(&$take_date_conv,&$Pdates);
    $take_date_conv = $_POST['Pdatee'];
    $Pdatee='';
    insert_date(&$take_date_conv,&$Pdatee);
    $take_date_conv = $_POST['stdate'];
    $stdate='';
    insert_date(&$take_date_conv,&$stdate);
    $take_date_conv = $_POST['etdate'];
    $etdate='';
    insert_date(&$take_date_conv,&$etdate);
    $Hoscar=$_POST[Hos_car];
    $amountd = $_POST[amountd];
    $amounth = $_POST[amounth];
    $format = $_POST[format];
    $persen = $_POST[persen];
    $barrier = $_POST[barrier];
    $further = $_POST[further];
    $comment = $_POST[comment];
    $cost = $_POST[cost];
    $meals = $_POST[meals];
    $expert=$_POST[expert];
    $travel = $_POST[travel];
    $material = $_POST[material];
    $source = $_POST[source];
    $type_know = $_POST[type_know];
    $respon = $_POST[respon];
    $note = $_POST[note];

    if ($_POST[method] == 'add_trainin') {


    $add = mysql_query("insert into trainingin set reg_date='$reg_date', in1='$project_no', in2='$project_name', in3='$project_dep',
                in4='$project_obj', in5='$project_place', in6='$province', dateBegin='$Pdates', dateEnd='$Pdatee', in8='$amountd',
                   in9='$amounth', in10='$format', in11='$persen', in12='$barrier', in13='$further',
                      in14='$comment', mp='$cost', m1='$meals', m2='$expert', m3='$travel', m4='$material', in15='$source',
                         in16='$type_know', adminadd='$respon', in18='$note' ");
    $insert_id=mysql_insert_id();
    $date_end=date('Y-m-d', strtotime("$Pdatee+1 days "));
            $insert_event=mysql_query("insert into tbl_event set event_title='$project_no',event_start='$Pdates',event_end='$date_end',event_allDay='true',
            empno='$respon',workid='$insert_id',typela='$format',process='6', event_url='../pre_project.php?id=$insert_id&method=back'");
    if ($add and $insert_event == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_person.php' >กลับ</a>";
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_trainin.php'>";
        }
    }else if ($_POST[method] == 'edit') {
    
        $idpi=$_REQUEST[edit_id];
$edit = mysql_query("update trainingin set reg_date='$reg_date', in1='$project_no', in2='$project_name', in3='$project_dep',
                in4='$project_obj', in5='$project_place', in6='$province', dateBegin='$Pdates', dateEnd='$Pdatee', in8='$amountd',
                   in9='$amounth', in10='$format', in11='$persen', in12='$barrier', in13='$further',
                      in14='$comment', mp='$cost', m1='$meals', m2='$expert', m3='$travel', m4='$material', in15='$source',
                         in16='$type_know', adminadd='$respon', in18='$note'
                             where idpi='$idpi'");
$date_end=date('Y-m-d', strtotime("$Pdatee+1 days "));
$update_event=mysql_query("update tbl_event set event_title='$project_no',event_start='$Pdates',event_end='$date_end',
            empno='$respon',typela='$format'
        where workid='$idpi'");


    if ($edit == false) {
        echo "<p>";
        echo "Update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_person.php' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_trainin.php'>";
        }
    
        
    }elseif ($_POST[method] == 'add_pro_trainin'){ 
        $project_id=$_POST[id];
        if($_POST[check_ps] == '') {
    echo "<div class='alert alert-dismissable alert-danger'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>***ยังไม่ได้เลือกรายการที่จะโอน***</center></a> 
</div>";

    echo "<meta http-equiv='refresh' content='2;URL=add_trainin.php?id=$project_id' />";
}
$check_ps=$_POST[check_ps];
foreach ($check_ps as $key => $value) {
         $empno_id[$value] = $_POST[empno][$value];
        $amount[$value]=$_POST[amount][$value];
        $dates[$value]=$_POST[dates][$value];
        $datee[$value]=$_POST[datee][$value];
       
        $empno_ID=$empno_id[$value];
        $Amount=$amount[$value];
        $dateS=$dates[$value];
        $dateE=$datee[$value];
        
         $sql=  mysql_query("SELECT type_id,pjid FROM plan WHERE type_id='$empno_ID' and pjid='$project_id'");
         $num_row=  mysql_num_rows($sql);
         if($num_row >= 1){
             echo "<div class='alert alert-dismissable alert-danger'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>***เพิ่มคนนี้ไปแล้วจ้า***</center></a> 
</div>";

    echo "<meta http-equiv='refresh' content='2;URL=add_trainin.php?id=$project_id' />";
         }else{
        
        $add = mysql_query("insert into plan set type_id='$empno_ID', amount='$Amount', pjid='$project_id', bdate='$dateS',
                edate='$dateE' ");
    if ($add == false) {
        echo "<p>";
        echo "Insert not complete " . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_trainin.php?id=$project_id' >กลับ</a>";
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_trainin.php?id=$project_id'>";
        }
         }
        }
        
    }elseif ($_POST[method] == 'add_pro_trainout'){ 
        $project_id=$_POST[id];
        if($_POST[check_ps] == '') {
    echo "<div class='alert alert-dismissable alert-danger'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>***ยังไม่ได้เลือกรายการที่จะโอน***</center></a> 
</div>";

    echo "<meta http-equiv='refresh' content='2;URL=add_trainout.php?id=$project_id' />";
}
$check_ps=$_POST[check_ps];
foreach ($check_ps as $key => $value) {
        $empno_id[$value] = $_POST[empno][$value];
        $amount[$value]=$_POST[amount][$value];
        $dates[$value]=$_POST[dates][$value];
        $datee[$value]=$_POST[datee][$value];
        $pro_type[$value]=$_POST[pro_type][$value];
       
        $empno_ID=$empno_id[$value];
        $Amount=$amount[$value];
        $dateS=$dates[$value];
        $dateE=$datee[$value];
        $Ptype=$pro_type[$value];
        
         $sql=  mysql_query("SELECT empno,idpo FROM plan_out WHERE empno='$empno_ID' and idpo='$project_id'");
         $num_row=  mysql_num_rows($sql);
         if($num_row >= 1){
             echo "<div class='alert alert-dismissable alert-danger'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>***เพิ่มคนนี้ไปแล้วจ้า***</center></a> 
</div>";

    echo "<meta http-equiv='refresh' content='2;URL=add_trainout.php?id=$project_id' />";
         }else{
        
        $add = mysql_query("insert into plan_out set empno='$empno_ID', amount='$Amount', idpo='$project_id', begin_date='$dateS', end_date='$dateE',
                status_out='N' ");
        
        $event=  mysql_query("select CONCAT(firstname,' ',lastname) as fullname from emppersonal where empno='$empno_ID'");
        $Event=mysql_fetch_assoc($event);
        $date_end=date('Y-m-d', strtotime("$dateE+1 days "));
        $insert_event=mysql_query("insert into tbl_event set event_title='$Event[fullname]',event_start='$dateS',event_end='$date_end',event_allDay='true',
            empno='$empno_ID',workid='$project_id',typela='$Ptype',process='1', event_url='../pre_project_out.php?id=$project_id&method=back'");
    
    if ($add and $insert_event == false) {
        echo "<p>";
        echo "Insert not complete " . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_trainout.php?id=$project_id' >กลับ</a>";
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_trainout.php?id=$project_id'>";
        }
         }
        }
        
    }elseif ($_POST[method] == 'add_trainout') {


    $add = mysql_query("insert into training_out set datein='$reg_date', memberbook='$project_no', projectName='$project_name', anProject='$project_dep',
                stantee='$project_place', provenID='$province', Beginedate='$Pdates', endDate='$Pdatee', stdate='$stdate', etdate='$etdate', Hos_car='$Hoscar', amount='$amountd',
                   dt='$format', m1='$cost', m2='$meals', m3='$expert', m4='$travel', m5='$material', budget='$source',
                         material='$type_know', nameAdmin='$admin',hboss='W', empno='$admin',chek='$check'");
    $insert_id=mysql_insert_id();
    if ($add == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_project_out.php' >กลับ</a>";
    } else {
        if($Hoscar=='Y' and $format=='8'){?>
          <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_trainout.php?id=<?=$insert_id?>&popup=true&project_place=<?= $project_place?>&province=<?=$province?>
                &stdate=<?=$stdate?>&etdate=<?=$etdate?>&amount=<?=$amountd?>'>  
       <?php }else{
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_trainout.php?id=$insert_id'>";
    }}
    }else if ($_POST[method] == 'edit_trainout') {
    
        $idpi=$_REQUEST[edit_id];
$edit = mysql_query("update training_out set datein='$reg_date', memberbook='$project_no', projectName='$project_name', anProject='$project_dep',
                stantee='$project_place', provenID='$province', Beginedate='$Pdates', endDate='$Pdatee', stdate='$stdate', etdate='$etdate', Hos_car='$Hoscar', amount='$amountd',
                   dt='$format', m1='$cost', m2='$meals', m3='$expert', m4='$travel', m5='$material', budget='$source',
                         material='$type_know', nameAdmin='$admin', empno='$admin'
                             where tuid='$idpi'");
$edit_po=  mysql_query("update plan_out set begin_date='$Pdates' where idpo='$idpi'");

    if ($edit == false or $edit_po == false) {
        echo "<p>";
        echo "Update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_project_out.php' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_trainout.php'>";
        }
    
        
    }elseif ($_POST[method] == 'add_planout') {
        $empno=$_POST[empno];
        $idpo=$_POST[idpo];
        $pj_obj=$_POST[project_obj];
        $abode=$_POST[cost];
        $reg=$_POST[meals];
        $allow=$_POST[expert];
        $travel=$_POST[travel];
        $other=$_POST[material];
        $abstract=$_POST['abstract'];
        $comment=$_POST[comment];
        $book=$_POST[book];
        $paper=$_POST[paper];
        $cd=$_POST[cd];
        $reg_date=  date('Y-m-d');
        $begin_date=$_POST[begin_date];
        $amount=$_POST[amount];
        $join_amount=$_POST['join_amount'];
        $complacency=$_POST['complacency'];

        function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "OPI/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}

    $add = mysql_query("update plan_out set pj_obj='$pj_obj', abode=' $abode',
                   reg='$reg', allow='$allow', travel='$travel', other='$other', abstract='$abstract',
                      comment='$comment', book='$book', paper='$paper', cd='$cd', OPI='$image', reg_date='$reg_date',
                            status_out='Y', join_amount='$join_amount', complacency='$complacency' 
                                where empno='$empno' and idpo='$idpo'");
    if ($add == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='person_trainout.php?id=$empno&pro_id=$idpo' >กลับ</a>";
    } 
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_trainout.php'>";
         
         
    }elseif ($_POST[method] == 'edit_planout') {
        $empno=$_POST[empno];
        $idpo=$_POST[idpo];
        $pj_obj=$_POST[project_obj];
        $abode=$_POST[cost];
        $reg=$_POST[meals];
        $allow=$_POST[expert];
        $travel=$_POST[travel];
        $other=$_POST[material];
        $abstract=$_POST['abstract'];
        $comment=$_POST[comment];
        $book=$_POST[book];
        $paper=$_POST[paper];
        $cd=$_POST[cd];
        $join_amount=$_POST['join_amount'];
        $complacency=$_POST['complacency'];
        function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "OPI/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
if($image==''){
    $add = mysql_query("update plan_out set pj_obj='$pj_obj', abode=' $abode',reg='$reg',
                   allow='$allow', travel='$travel', other='$other', abstract='$abstract',
                      comment='$comment', book='$book', paper='$paper', cd='$cd' , join_amount='$join_amount', complacency='$complacency' 
                        where empno='$empno' and idpo='$idpo'");
}else{
    $add = mysql_query("update plan_out set pj_obj='$pj_obj', abode=' $abode',reg='$reg',
                   allow='$allow', travel='$travel', other='$other', abstract='$abstract',
                      comment='$comment', book='$book', paper='$paper', cd='$cd', OPI='$image' , join_amount='$join_amount', complacency='$complacency'  
                        where empno='$empno' and idpo='$idpo'");

}
    if ($add == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='person_trainout.php?id=$empno&pro_id=$idpo' >กลับ</a>";
    } 
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_person_trainout.php?id=$idpo'>";
         }
         elseif ($_POST['method'] == 'edit_date_out') {
             $id_plan=$_POST['id_plan'];
             $begin_date=$_POST['begin_date'];
             $end_date=$_POST['end_date'];
             $amount=$_POST['amount'];
             $empno=$_POST['empno'];
             $idpo=$_POST['idpo'];
             
             $update_out=  mysql_query("update plan_out set begin_date='$begin_date',end_date='$end_date',amount='$amount'
                 where id_plan=$id_plan");
             if ($update_out == false) {
        echo "<p>";
        echo "Update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_project_out.php?method=edit&empno=$empno&id=$idpo' >กลับ</a>";
    } 
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_project_out.php?id=$idpo'>";
         }
         elseif ($_POST['method'] == 'edit_date_in') {
             $pid=$_POST['pid'];
             $bdate=$_POST['bdate'];
             $edate=$_POST['edate'];
             $amount=$_POST['amount'];
             $empno=$_POST['empno'];
             $pjid=$_POST['pjid'];
             
             $update_in=  mysql_query("update plan set bdate='$bdate',edate='$edate',amount='$amount'
                 where pid=$pid");
             if ($update_in == false) {
        echo "<p>";
        echo "Update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_project.php?method=edit&empno=$empno&id=$pjid' >กลับ</a>";
    }else{ 
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_project.php?id=$pjid'>";
    }
         }elseif ($_POST['method']=='approve_trainout') {
             $project_id=$_POST['pro_id'];
             $hboss=$_POST['hboss'];
             $approve_out=mysql_query("update training_out set hboss='$hboss',approver='$_SESSION[user]' where tuid='$project_id'");
             if ($approve_out == false) {
        echo "<p>";
        echo "Approve not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_project_out.php?id=$project_id' >กลับ</a>";
    }else{ ?>
       <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='pre_trainout.php'; window.close();">ปิดหน้าต่าง</a></center> 
    <?php }
        }
         
?>