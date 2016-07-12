<?php @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="images/logo.png">
<!-- Bootstrap core CSS -->
<link href="option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="option/css/stylelist.css">
<?php if (empty($_SESSION[user])) {
    echo "<script>alert('กรุณา Login เข้าสู่ระบบครับ!!!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
<script language="JavaScript" type="text/javascript"> 
var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
function KillMe()
{ 
setTimeout("self.close()",StayAlive * 1000); 
} 
</script>
</head>
    <body onLoad="KillMe();self.focus();window.opener.location.reload();">
<?php include'option/jquery.php'; ?>
<?php
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='col-lg-12'>
    <div class='bs-example '>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success col-lg-12'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div></div>";
include 'connection/connect_i.php';
    $empno=$_SESSION[user];
    $Status=$_SESSION[Status];
    
if($_POST[method]=='post'){
    
    $post=$_POST['post'];
    $link=$_POST['link'];
    $date_pos=date("Y-m-d H:m:s");

function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "post/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}

$sql=$db->prepare('insert into topic_post set empno_post=? , post=? , post_date=? , photo_post=? , link=? , empno_status=?');
$sql->bind_param('isssss',$empno,$post,$date_pos, $image,$link,$Status);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='mainpost_page.php' >กลับ</a>";
}else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=mainpost_page.php'>";
}

}elseif($_POST[method]=='edit_post'){
    $topic_id=$_POST[topic_id];
    $post=$_POST[post];
    $link=$_POST['link'];
    $date_pos=date("Y-m-d H:m:s");

function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "post/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
if($image ==''){
$sql=$db->prepare('update topic_post set post=? , post_date=? , link=? where topic_id=?');
$sql->bind_param('sssi',$post,$date_pos,$link,$topic_id);
$sql->execute();    
}else{
$sql=$db->prepare('update topic_post set post=? , post_date=? , photo_post=?,link=? where topic_id=?');
$sql->bind_param('ssssi',$post,$date_pos, $image, $link,$topic_id);
$sql->execute();
}
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='mainpost_page.php' >กลับ</a>";
}else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=mainpost_page.php'>";
}

}elseif ($_POST[method]=='comment') {
     $topic_id=$_POST[topic_id];
     $comm=$_POST[comm];
     $date_comm=date("Y-m-d H:m:s");
     $check_comm='N';
     
     $sql=$db->prepare('insert into comment set topic_id=? , empno_comm=? , comm=? , comm_date=?, check_comm=?');
$sql->bind_param('iisss',$topic_id,$empno,$comm,$date_comm,$check_comm);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='comm_page.php' >กลับ</a>";
}else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=comm_page.php?post=$topic_id'>";
}
}elseif ($_POST[method]=='recomment') {
     $comm_id=$_POST[comm_id];
     $recomm=$_POST[recomm];
     $date_recomm=date("Y-m-d H:m:s");
     $check_recomm='N';
     
     $sql=$db->prepare('insert into re_comment set comm_id=? , empno_re=? , recomm=? , recomm_date=?, check_recomm=?');
$sql->bind_param('iisss',$comm_id,$empno,$recomm,$date_recomm,$check_recomm);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='recommenypage.php' >กลับ</a>";
}else { }
}elseif ($_POST[method]=='regularity') {
    $regu=$_POST[regu];
    $regu_date=date("Y-m-d H:m:s");
    function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "regu_file/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
$sql=$db->prepare('insert into regularity set topic_regu=? , regu_file=? , regu_date=? , empno_regu=?');
$sql->bind_param('sssi',$regu, $image,$regu_date,$empno);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='regularity.php' >กลับ</a>";
}else { 
    echo "<center><b>ดำเนินการเรียบร้อยครับ</b><center>";
 }
 
}elseif ($_POST['method']=='edit_regularity') {
    $regu=$_POST['regu'];
    $regu_id=$_POST['regu_id'];
    function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "regu_file/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
    }else {
    $image ='';
}
if($image ==''){
    $sql=$db->prepare('update regularity set topic_regu=? where regu_id=? ');
    $sql->bind_param('si',$regu, $regu_id);
}else{ 
    $sql=$db->prepare('update regularity set topic_regu=? , regu_file=?  where regu_id=? ');
    $sql->bind_param('ssi',$regu, $image, $regu_id);
}
    $sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='regularity.php' >กลับ</a>";
}else { 
    echo "<center><b>ดำเนินการเรียบร้อยครับ</b><center>";
 }
 
}
  include 'footeri.php';?>