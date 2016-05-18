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
<script language="JavaScript" type="text/javascript"> 
var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
function KillMe()
{ 
setTimeout("self.close()",StayAlive * 1000); 
} 
</script>
</head>
    
<?php if (empty($_SESSION[user])) { ?>
    <body onLoad="KillMe();self.focus();window.opener.location.reload();">
<?php
    echo "<script>alert('กรุณา Login เข้าสู่ระบบครับ!!!')</script>";
    exit();
 }
include 'connection/connect_i.php';
if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
     exit;
}
$comm=$_REQUEST[comm];
?>
<form class="" role="form" action='prcpost.php' enctype="multipart/form-data" method='post'>
                          <div class="form-group">
                         <?php
                      $query2=mysqli_query($db,"select photo as photo from emppersonal 
                                        where empno='$_SESSION[user]'");
                         $photo_comm= mysqli_fetch_assoc($query2);
                         if ($photo_comm[photo] != '') {
                                    $photoc = $photo_comm[photo];
                                    $folderc = "photo/";
                                } else {
                                    $photoc = 'person.png';
                                    $folderc = "images/";
                                }
                         ?>
                          <table border="0" width="100%">
                              <tr>
                                  <td align="right" width="10%"><img src='<?= $folderc . $photoc ?>' width="50"></td>
                                  <td width="80%"><input type="text" class="form-control" name="recomm" placeholder="ตอบกลับความคิดเห็น"  aria-describedby="sizing-addon1" required="">
                                      <input type="hidden" name="method" value="recomment">
                                      <input type="hidden" name="comm_id" value="<?= $comm?>"></td>
                                  <td align="left" width="10%"><input class="btn btn-success" type="submit" name="submit" id="submit" value="ตกลง"></td>
                              </tr>
                          </table>
                                    </div>
                          </form>