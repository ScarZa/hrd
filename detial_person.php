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

    <?php
    if(!empty($_REQUEST[id])){
    $empno = $_REQUEST[id];
    }else{ 
if ($_SESSION[Status]=='USER' or $_SESSION[Status]=='SUSER'  or $_SESSION[Status]=='USUSER') {
    $empno = $_SESSION[user];
    } }      
    $detial = mysql_query("SELECT *,e7.statusname as emp_status,e6.statusname as wstatus from emppersonal e1
INNER JOIN pcode p1 on e1.pcode=p1.pcode
INNER JOIN district d1 on e1.tambol=d1.DISTRICT_ID
INNER JOIN amphur a1 on e1.empure=a1.AMPHUR_ID
INNER JOIN province p2 on e1.provice=p2.PROVINCE_ID
LEFT OUTER JOIN educate e5 on e1.empno=e5.empno
INNER JOIN emstatus e6 on e1.`status`=e6.statusid
INNER JOIN empstatus e7 on e1.emp_status=e7.`status`
where e1.empno='$empno' order by e5.educate desc");
    
    $tophis=mysql_query("SELECT wh.his_id, wh.empcode, wh.dateBegin, po.posname, d1.depName, et.StucName, etp.TypeName, ed.eduname, d2.dep_name 
FROM work_history wh 
INNER JOIN posid po on po.posId=wh.posid
INNER JOIN department d1 on d1.depId=wh.depid
INNER JOIN department_group d2 on d1.main_dep=d2.main_dep
INNER JOIN empstuc et on et.Emstuc=wh.empstuc
INNER JOIN emptype etp on etp.EmpType=wh.emptype
INNER JOIN education ed on ed.education=wh.education
WHERE wh.empno='$empno' ORDER BY wh.his_id DESC");

    $topedu = mysql_query("SELECT eduname topadu from education ed1
INNER JOIN educate ed2 on ed1.education=ed2.educate
INNER JOIN emppersonal em on ed2.empno=em.empno
WHERE em.empno='$empno' order by ed2.educate desc");

    $Detial = mysql_fetch_assoc($detial);
    $Tophis = mysql_fetch_assoc($tophis);
    $Topedu = mysql_fetch_assoc($topedu);

    include_once ('option/funcDateThai.php');
    ?>
    <!--<div class="row">
              <div class="col-lg-12">
                <h1><font color='blue'>  รายละเอียดข้อมูลบุคลากร </font></h1> 
                <ol class="breadcrumb alert-success">
                  <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
                  <li class="active"><a href="pre_person.php"><i class="fa fa-edit"></i> ข้อมูลพื้นฐาน</a></li>
                  <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลบุคลากร</li>
                </ol>
              </div>
          </div>-->
    <body>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">ข้อมูลบุคลากร</h3>
                    </div>
                    <div class="panel-body">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลทั่วไป</h3>
                            </div>
                            <div class="panel-body">
                                <?
                                if ($Detial[photo] != '') {
                                    $pic = $Detial[photo];
                                    $fol = "photo/";
                                } else {
                                    $pic = 'person.png';
                                    $fol = "images/";
                                }
                                ?>
                                <div class="text-right">
                                    <right></right>
                                </div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="92%">รหัสพนักงาน :
<?= $Detial[pid]; ?></td>
                                        <td width="8%" rowspan="5" align="right" valign="top"><img  src="<?= $fol . $pic; ?>" width="true" height="100" /></td>
                                    </tr>
                                    <tr>
                                        <td>ชื่อ นามสกุล :
                                            <?= $Detial[pname]; ?> <?= $Detial[firstname]; ?>&nbsp; <?= $Detial[lastname]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>วัน เดือน ปีเกิด :
<?= DateThai1($Detial[birthdate]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>หมายเลขบัตรประชาชน :&nbsp;<?= $Detial[idcard]; ?> &nbsp;&nbsp; สถานะภาพ :
<?= $Detial[emp_status]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>ที่อยู่ :
                                            <?= $Detial[address]; ?>
                                            <?= $Detial[baan]; ?>
                                            ต.
                                            <?= $Detial[DISTRICT_NAME]; ?>
                                            อ.
                                            <?= $Detial[AMPHUR_NAME]; ?>
                                            จ.
                                            <?= $Detial[PROVINCE_NAME]; ?>
                                            รหัสไปรษณีย์
<?= $Detial[zipcode]; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">โทรศัพท์บ้าน :
                                            <?= $Detial[telephone]; ?>
                                            &nbsp;&nbsp; โทรศัพท์มือถือ :
                                            <?= $Detial[mobile]; ?>
                                            &nbsp;&nbsp; E-mail :
<?= $Detial[email]; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลการปฏิบัติงาน</h3>
                            </div>
                            <div class="panel-body">
                                เลขที่คำสั่ง : <?= $Tophis[empcode]; ?><br>
                                วันที่เริ่มงาน : <?= DateThai1($Tophis[dateBegin]); ?>&nbsp;&nbsp;ตำแหน่ง : <?= $Tophis[posname]; ?><br>
                                ฝ่ายงาน : <?= $Tophis[dep_name]; ?>&nbsp;&nbsp; กลุ่มงาน : <?= $Tophis[depName]; ?>&nbsp;&nbsp; สายงาน : <?= $Tophis[StucName]; ?>
                                <br>ประเภทพนักงาน : <?= $Tophis[TypeName]; ?>&nbsp;&nbsp; 
                                วุฒิที่บรรจุ : <?= $Tophis[eduname]; ?>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลการศึกษา</h3>
                            </div>
                            <div class="panel-body">
                                วุฒิการศึกษาสูงสุด : <?= $Topedu[topadu]; ?>&nbsp;&nbsp; สาขา/วิชาเอก :  <?= $Detial[major]; ?><br>
                                สถาบันการศึกษาที่จบ : <?= $Detial[institute]; ?>&nbsp;&nbsp; วันที่จบการศึกษา :  <?= DateThai1($Detial[enddate]); ?>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลอื่นๆ</h3>
                            </div>
                            <div class="panel-body">
                                สถานะการทำงาน : <?= $Detial[wstatus]; ?><br>
                                เหตุผลการย้าย/สถานที่ย้าย/มาช่วยราชการ/ไปช่วยราชการ :<br>
<?= $Detial[empnote]; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<? include 'footer.php'; ?>