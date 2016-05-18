<?php @session_start(); ?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?php
$user_account = md5(trim(filter_input(INPUT_POST, 'user_account',FILTER_SANITIZE_ENCODED)));
$user_pwd = md5(trim(filter_input(INPUT_POST, 'user_pwd',FILTER_SANITIZE_ENCODED)));

include 'header.php';
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
include 'connection/connect_i.php';
if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
exit;}
$sql = $db->prepare("select m1.Name as id,e1.firstname as fname,e1.lastname as lname,e1.depid as dep,d1.main_dep as main_dep,m1.Status as Status from member m1 
           inner join emppersonal e1 on m1.Name=e1.empno
           inner join department d1 on e1.depid=d1.depId
           inner join posid p1 on e1.posid=p1.posId
           where   m1.Username= ? && m1.Password= ?") ;
$sql->bind_param("ss", $user_account,$user_pwd);
$sql->execute();
$sql->bind_result($id, $fname, $lname, $dep,$main_dep,$Status);
$sql->fetch();
if (empty($id)) {
    echo "<script>alert('ชื่อหรือรหัสผ่านผิด กรุณาตรวจสอบอีกครั้ง!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=./index.php'/>";
    exit();
} else {
    $date_login = date("Y-m-d");
    $time_login = date('H:i:s');
    $sql = mysql_query("update member  set date_login='$date_login' , time_login='$time_login' where   Username='$user_account' && Password='$user_pwd'");
    $_SESSION[user] = $id;
    $_SESSION[fname] = $fname;
    $_SESSION[lname] = $lname;
    $_SESSION[dep] = $dep;
    $_SESSION[main_dep] = $main_dep;
    $_SESSION[Status] = $Status;
    
    //echo "$_SESSION[user]-$_SESSION[fname]_$_SESSION[lname]-$_SESSION[dep]-$_SESSION[Status]";

    // require'myfunction/savelog.php';
    //	  echo "<input type='hidden' name='acc_id' value='$acc_username'> ";

   echo "<meta http-equiv='refresh' content='0;url=./' />";
}
 include 'footer.php';
?>
 