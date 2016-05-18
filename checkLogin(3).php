<?php @session_start(); ?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?php
$user_account = trim($_POST['user_account']);
$user_pwd = md5(trim($_POST['user_pwd']));
//include 'connection/connect.php';
// using PDO
$dbh = new PDO('mysql:host=localhost;dbname=hrd;charset=utf8','root','password');

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

/*$sql = "select m1.Name as id,e1.firstname as fname,e1.lastname as lname,e1.depid as dep,m1.Status as Status from member m1 
           inner join emppersonal e1 on m1.Name=e1.empno
           inner join department d1 on e1.depid=d1.depId
           inner join posid p1 on e1.posid=p1.posId
           where   m1.Username='$user_account' && m1.Password='$user_pwd'";*/
//mysql_query("SET NAMES 'utf8'", $con);
//$result = mysql_query($sql);
//$num_row = mysql_num_rows($result);
//$result = mysql_fetch_assoc($result);

$sql = "select m1.Name as id,e1.firstname as fname,e1.lastname as lname,e1.depid as dep,m1.Status as Status from member m1 
           inner join emppersonal e1 on m1.Name=e1.empno
           inner join department d1 on e1.depid=d1.depId
           inner join posid p1 on e1.posid=p1.posId
           where m1.Username = :user_account AND m1.Password = :user_pwd";
$sth = $dbh->prepare($sql);
$sth->execute(array(':user_account' => $user_account, ':user_pwd' => $user_pwd));

if ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
    $date_login = date("Y-m-d");
    $time_login = date('H:i:s');
    //$sql = mysql_query("update member  set date_login='$date_login' , time_login='$time_login' where   Username='$user_account' && Password='$user_pwd'");
    $sth = $dbh->prepare("UPDATE member SET date_login=:date_login , time_login=:time_login WHERE Username=:user_account");
    $sth->execute(array(':user_account' => $user_account, ':date_login' => $date_login, ':time_login' => $time_login));
    $_SESSION[user] = $result[id];
    $_SESSION[fname] = $result[fname];
    $_SESSION[lname] = $result[lname];
    $_SESSION[dep] = $result[dep];
    $_SESSION[main_dep] = $result[main_dep];
    $_SESSION[Status] = $result[Status];

    // require'myfunction/savelog.php';
    //	  echo "<input type='hidden' name='acc_id' value='$acc_username'> ";

    echo "<meta http-equiv='refresh' content='0;url=./' />";
}else{
	echo "<script>alert('ชื่อหรือรหัสผ่านผิด กรุณาตรวจสอบอีกครั้ง!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=./index.php'/>";
    exit();
}
?>
 
