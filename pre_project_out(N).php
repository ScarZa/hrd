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
<?php
include_once ('option/funcDateThai.php');
$project_id = $_REQUEST[id];
$sql_pro = mysql_query("SELECT t.*, CONCAT(e.firstname,' ',e.lastname) as fullname,p.PROVINCE_NAME 
FROM training_out t
INNER JOIN emppersonal e ON t.nameAdmin=e.empno
inner join province p on t.provenID=p.PROVINCE_ID
 WHERE tuid='$project_id'");
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
                                    <td><b>เลขที่โครงการ : &nbsp; </b><?= $Project_detial[memberbook] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ชื่อโครงการ : &nbsp; </b><?= $Project_detial[projectName] ?></td>
                                </tr>
                                <tr>
                                    <td><b>หน่วยงานที่จัดโครงการ : &nbsp; </b><?= $Project_detial[anProject] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ตั้งแตวันที่ : &nbsp; </b><?= DateThai1($Project_detial[Beginedate]) ?>&nbsp; <b> ถึง &nbsp;</b><?= DateThai1($Project_detial[endDate]) ?>
                                    <b> &nbsp; จำนวน : &nbsp; </b><?= $Project_detial[amount] ?><b>&nbsp; วัน</b>
                                    <b> &nbsp; ณ. &nbsp; </b><?= $Project_detial[stantee] ?><b> &nbsp; จ. </b> &nbsp; <?= $Project_detial[PROVINCE_NAME] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ค่าที่พัก : &nbsp; </b><?= $Project_detial[m1] ?><b>&nbsp;บาท&nbsp; </b><b>ค่าลงทะเบียน : &nbsp; </b><?= $Project_detial[m2] ?><b>&nbsp;บาท&nbsp; </b>
                                    <b>ค่าเบี้ยเลี้ยง : &nbsp; </b><?= $Project_detial[m3] ?><b>&nbsp;บาท&nbsp; </b><b>ค่าพาหนะเดินทาง : &nbsp; </b><?= $Project_detial[m4] ?><b>&nbsp;บาท&nbsp; </b>
                                    <b>ค่าใช้จ่ายอื่นๆ : &nbsp; </b><?= $Project_detial[m5] ?><b>&nbsp;บาท&nbsp; </b></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <?php
                                $sql_pro_name = mysql_query("SELECT CONCAT(em.firstname,' ',em.lastname) as fullname,d1.depName,d2.dep_name, po.status_out FROM plan_out po
INNER JOIN training_out tro on po.idpo=tro.tuid
INNER JOIN emppersonal em on em.empno=po.empno
INNER JOIN department d1 on d1.depId=em.depid
INNER JOIN department_group d2 on d1.main_dep=d2.main_dep
WHERE po.status_out='N' AND idpo='$project_id'");
                            ?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 
                                <tr>
                                    <td colspan="4" align="center"><b>ผู้เข้าร่วมโครงการ</b></td>
                                </tr>
                                 <tr><th>ลำดับ</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ฝ่าย</th>
                                    <th>ศูนย์/กลุ่มงาน</th>
                                    <th>สถานะ</th>
                                </tr>
                                <?php
                    $i = 1;
                    while ($Project_Name = mysql_fetch_assoc($sql_pro_name)) {
                        ?>
                                <tr><td align="center"><?=$i?></td>
                                    <td><?=$Project_Name[fullname]?></td>
                                    <td align="center"><?=$Project_Name[dep_name]?></td>
                                    <td align="center"><?=$Project_Name[depName]?></td>
                                    <td align="center">
                                    <?php if($Project_Name['status_out']=='N'){ ?>
                                        <a href="" title="ยังไม่ได้สรุป"><i class="fa fa-spinner fa-spin"></i></a>
                                    <?php } elseif ($Project_Name['status_out']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="สรุปแล้ว">
                                    <?php }?></td>
                                </tr>
                                <?php $i++;
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
<?php include 'footer.php'; ?>
