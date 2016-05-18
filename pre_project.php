<?php @session_start(); ?>
<?php include 'connection/connect.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
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
<?
if ($_REQUEST['del_id'] != "") { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    $del_id = $_REQUEST['del_id'];
    $del_pro = $_REQUEST['del_pro'];
    $sql_del = "delete from plan where type_id = '$del_id' and pjid='$del_pro'";
    mysql_query($sql_del) or die(mysql_error());
//echo "ลบข้อมูล ID $del_id เรียบร้อยแล้ว";
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดโครงการ </font></h1>
        <?if($_SESSION[Status]=='ADMIN'){?>
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li><a href="pre_trainin.php"><i class="fa fa-home"></i> บันทึกการฝึกอบรมภายในหน่วยงาน</a></li>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดโครงการ</li>
        </ol>
        <?}?>
    </div>
</div>
<?
include_once ('option/funcDateThai.php');
$project_id = $_REQUEST[id];
$sql_pro = mysql_query("SELECT t.*, CONCAT(e.firstname,' ',e.lastname) as fullname,p.PROVINCE_NAME FROM trainingin t
INNER JOIN emppersonal e ON t.adminadd=e.empno
inner join province p on t.in6=p.PROVINCE_ID
 WHERE idpi='$project_id'");
$Project_detial = mysql_fetch_assoc($sql_pro);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบันทึกการฝึกอบรมภายในหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><b>เลขที่โครงการ : &nbsp; </b><?= $Project_detial[in1] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ชื่อโครงการ : &nbsp; </b><?= $Project_detial[in2] ?></td>
                                </tr>
                                <tr>
                                    <td><b>หน่วยงานที่จัดโครงการ : &nbsp; </b><?= $Project_detial[in3] ?></td>
                                </tr>
                                <tr>
                                    <td><b>วัตถุประสงค์ที่จัดโครงการ : &nbsp; </b><?= $Project_detial[in4] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ตั้งแตวันที่ : &nbsp; </b><?= DateThai1($Project_detial[dateBegin]) ?>&nbsp; <b> ถึง &nbsp;</b><?= DateThai1($Project_detial[dateEnd]) ?>
                                    <b> &nbsp; จำนวน : &nbsp; </b><?= $Project_detial[in8] ?><b>&nbsp; วัน</b><b> &nbsp; จำนวนชั่วโมง : &nbsp; </b><?= $Project_detial[in9] ?><b>&nbsp; ชั่วโมง</b>
                                    <b> &nbsp; ณ. &nbsp; </b><?= $Project_detial[in5] ?><b> &nbsp; จ. </b> &nbsp; <?= $Project_detial[PROVINCE_NAME] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ผู้รับผิดชอบโครงการ : &nbsp; </b><?= $Project_detial[fullname] ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <?
                                $sql_pro_name = mysql_query("SELECT p.*, CONCAT(e.firstname,' ',e.lastname) as fullname FROM plan p
INNER JOIN emppersonal e ON p.type_id=e.empno
 WHERE p.pjid='$project_id'");
                            ?>
                            <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                 
                                <tr>
                                    <td colspan="4" align="center"><b>ผู้เข้าร่วมโครงการ</b></td>
                                </tr>
                                 <tr><th>ลำดับ</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>วันที่เข้าร่วม</th>
                                    <th>จำนวนชั่วโมง</th>
                                    <?if($_SESSION[Status]=='ADMIN'){?>
                                    <th>ลบ</th>
                                    <?}?>
                                </tr>
                                <?
                    $i = 1;
                    while ($Project_Name = mysql_fetch_assoc($sql_pro_name)) {
                        ?>
                                <tr><td align="center"><?=$i?></td>
                                    <td><?=$Project_Name[fullname]?></td>
                                    <td align="center"><?=DateThai1($Project_Name[bdate])?> ถึง <?=DateThai1($Project_Name[edate])?></td>
                                    <td align="center"><?=$Project_Name[amount]?></td>
                                    <?if($_SESSION[Status]=='ADMIN'){?>
                                    <td align="center"><a href='pre_project.php?del_id=<?=$Project_Name[type_id];?>&del_pro=<?=$Project_Name[pjid];?>&id=<?=$Project_Name[pjid];?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' width='25'></a></td>
                                    <?}?>
                                </tr>
                                <? $i++;
                }
                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<? include 'footer.php'; ?>
