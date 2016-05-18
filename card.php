<?php @session_start(); ?>
<?php include 'connection/connect.php';?>
<?php if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
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
<script src="option/js/excellentexport.js"></script>
</head>
<body>

<?php $empno=$_REQUEST[id];
include 'connection/connect_i.php';
$sql = $db->prepare("SELECT CONCAT(e1.firstname,' ',e1.lastname) as fullname,p1.posname as posion,e1.photo as photo FROM emppersonal e1
INNER JOIN posid p1 on e1.posid=p1.posId
WHERE e1.empno= ?");
$sql->bind_param("i",$empno);
$sql->execute();
$sql->bind_result($name,$posion,$photo);
$sql->fetch();
$db->close();
if ($photo != '') {
                                    $photo = $photo;
                                    $folder = "photo/";
                                } else {
                                    $photo = 'person.png';
                                    $folder = "images/";
                                }
include 'connection/connect_i.php';
if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
     exit;
}
$query=mysqli_query($db,"select * from hospital");
$hospital=  mysqli_fetch_assoc($query);
if ($hospital[logo] != '') {
                                    $pic = $hospital[logo];
                                    $fol = "logo/";
                                } else {
                                    $pic = 'agency.ico';
                                    $fol = "images/";
                                }
?>
<style type="text/css">
    body{
  -webkit-print-color-adjust:exact;
}
p.small {line-height: 90%}
p.big {line-height: 200%}
table {
  border-collapse: separate;
  border-spacing: 0px;
}
</style>
    <?php
require_once('option/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<table border="1" name="card" background="images/card.png" color="blue">
    <tr bg="images/card.png">
        <td align="center" width="190" height="295" >
            <img src='<?= $fol . $pic; ?>' width="35"><br>
            <font size="2" color="blue"><p><b><?= $hospital[name]?><br>
                    กรมสุขภาพจิต กระทรวงสาธารณสุข</b></p></font>
            <img src='<?= $folder . $photo; ?>' height="120"><br>
            <p class="small"><b><font size="3"><?= $name?><br>
                <?= $posion?></font></b></p>
            <p><img src='images/logogrom.png' width="25"> <img src='images/URS.png' width="45">&nbsp;</p>
        </td>
    </tr>
</table>
<?php
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('th', 'A4', '10', 'THSaraban');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output("card/card$empno$Code.pdf");
echo "<meta http-equiv='refresh' content='0;url=card/card$empno$Code.pdf' />";
$db->close();
?>
<?php include 'footer.php';?>