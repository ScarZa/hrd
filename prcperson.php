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

    $empid = $_POST[empid];
    $cid = $_POST[cidid];
    $pname = $_POST[pname];
    $fname = $_POST[fname];
    $lname = $_POST[lname];
    $sex = $_POST[sex];
    $take_date_conv = $_POST[bday];
    $bday='';
    insert_date(&$take_date_conv,&$bday);
    $address = $_POST[address];
    $hname = $_POST[hname];
    $Province = $_POST[province];
    $Amphur = $_POST[amphur];
    $district = $_POST[district];
    $postcode = $_POST[postcode];
    $status = $_POST[status];
    $htell = $_POST[htell];
    $mtell = $_POST[mtell];
    $email = $_POST[email];
    $order = $_POST[order];
    $posid=$_POST[position];
    $dep = $_POST[dep];
    $line = $_POST[line];
    $pertype = $_POST[pertype];
    $educat = $_POST[educat];
    $swday_conv = $_POST[swday];
    $swday ='';
    insert_date($swday_conv,$swday);
    $teducat = $_POST[teducat];
    $major = $_POST[major];
    $inst = $_POST[inst];
    $grad_conv = $_POST[Graduation];
    $grad='';
    insert_date($grad_conv,$grad);
    $statusw = $_POST[statusw];
    $reason = $_POST[reason];
    $movedate = $_POST[movedate];
    if ($_POST[method] == 'add_person') {
        function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "photo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}

    $add = mysql_query("insert into emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday', status='$statusw', empnote='$reason', dateEnd='$movedate', photo='$image' ");
    
    $select=  mysql_query("select empno from emppersonal order by empno desc");
    $select_empno=  mysql_fetch_assoc($select);
    
    $add_his= mysql_query("insert into work_history set empno='$select_empno[empno]', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday'");
    if ($add == false or $add_his==false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_person.php' >กลับ</a>";
    } else {
        $select_ed = mysql_query("select empno from emppersonal where pid='$empid'");
        $educ = mysql_fetch_assoc($select_ed);
        $empno = $educ[empno];

        $add_educate = mysql_query("insert into educate set empno='$empno', educate='$teducat',
                                                                            major='$major', institute='$inst', enddate='$grad', check_ed='1'");
        if ($add_educate == false) {
            echo "<p>";
            echo "Insert not complete" . mysql_error();
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='add_person.php' >กลับ</a>";
        } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_person.php'>";
        }
    }
}else if ($_POST[method] == 'edit') {
    $empno=$_REQUEST[edit_id];
    function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);}
if (trim($_FILES["image"]["name"] == "")) {
    $edit = mysql_query("update emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', status='$statusw', empnote='$reason', dateEnd='$movedate'
                             where empno='$empno'");
    
}else{
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "photo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    
} else{
    $image ='';
}
$edit = mysql_query("update emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', status='$statusw', empnote='$reason', dateEnd='$movedate', photo='$image'
                             where empno='$empno'");

}
    if ($edit == false) {
        echo "<p>";
        echo "Update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_person.php' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_person.php'>";
        }
    }

?>