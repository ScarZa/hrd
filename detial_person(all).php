<?php @session_start(); ?>
<?php include 'connection/connect.php';?>
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
 
<!-- InstanceBeginEditable name="head" -->
    </head>
    <body>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php include 'option/function_date.php';
$empno = $_GET[id];
if ($_POST['id'] != '') {
    $empno = $_POST['id'];
} elseif ($_SESSION[Status] == 'USER') {
    $empno = $_SESSION[user];
}
$name_detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            where e1.empno='$empno'");
if ($_POST['method'] == 'check_detial_leave' and !empty($_POST['check_date01'])) {
    $date01 = $_POST['check_date01'];
    $date02 = $_POST['check_date02'];

    $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' and w1.begindate between '$date01' and '$date02' and w1.enddate between '$date01' and '$date02'
                            AND statusla='Y' order by w1.begindate desc");
    $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and (begin_date between '$date01' and '$date02') order by begin_date desc");
    $detial_tin = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and (bdate between '$date01' and '$date02') and (edate between '$date01' and '$date02') order by p.bdate desc");

} elseif(!empty($_POST['year'])){
        $y = $_POST['year'] - 543;
        $Y = $y - 1;
        $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' AND statusla='Y'  and w1.begindate BETWEEN '$Y-10-01' and '$y-09-30' order by w1.begindate desc");
        $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and (begin_date between '$Y-10-01' and '$y-09-30') order by begin_date desc");
    $detial_tin = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and (bdate between '$Y-10-01' and '$y-09-30') and (edate between '$Y-10-01' and '$y-09-30') order by p.bdate desc");

    }else{
        if($date >= $bdate and $date <= $edate){
    $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' AND statusla='Y'  and w1.begindate BETWEEN '$y-10-01' and '$Yy-09-30' order by w1.begindate desc");
    $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and (begin_date between '$y-10-01' and '$Yy-09-30') order by begin_date desc");
    $detial_tin = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and (bdate between '$y-10-01' and '$Yy-09-30') and (edate between '$y-10-01' and '$Yy-09-30') order by p.bdate desc");

    }else{
    $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' AND statusla='Y'  and w1.begindate BETWEEN '$Y-10-01' and '$y-09-30' order by w1.begindate desc");
    $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and (begin_date between '$Y-10-01' and '$y-09-30') order by begin_date desc");
    $detial_tin = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and (bdate between '$Y-10-01' and '$y-09-30') and (edate between '$Y-10-01' and '$y-09-30') order by p.bdate desc");

}}
$NameDetial = mysql_fetch_assoc($name_detial);

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดข้อมูลต่างๆของบุคลากร </font></h1> 
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลบุคลากร</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12">
                <div class="row alert alert-info alert-dismissable"  align="right">
                    <form method="post" action="detial_person(all).php" class="navbar-form navbar-right">
                            <div class="col-xs-3"> เลือกช่วงเวลา : </div>
                            <div class="col-xs-4 form-group">
                                <input type="date"   name='check_date01' class="form-control"> 
                            </div>
                            <div class="col-xs-4 form-group">
                                <input type="date"   name='check_date02' class="form-control">
                            </div>
                            <input type="hidden" name="method" value="check_detial_leave">
                            <input type="hidden" name="id" value="<?= $empno ?>">
                            <div class="col-xs-1">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                            </div>
                        </form>
                </div></div>
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                    <div class="col-xs-4 col-md-4 col-lg-4"></div>
                        <div class="col-xs-6 col-md-6 col-lg-6 form-group"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2558; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <input type="hidden" name="id" value="<?= $empno ?>">
                    <div class="col-xs-2 col-md-2 col-lg-2"><button type="submit" class="btn btn-success">ตกลง</button></div>
                    </form>
                <table  id="datatable" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial[fullname]; ?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial[posi]; ?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial[dep]; ?>
                            <br />
<br>
                            </font></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลการลา</h3>
                                </div>
                                <div class="panel-body">
                                    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                        <?php if(!empty($_POST['year'])){ ?>
                                        <tr>
                                            <td colspan="9" align="center"> ปีงบประมาณ <?= $_POST['year']?></td>
                                        </tr>
                                        <?php }?>
                                                <?php if ($_POST['method'] == 'check_detial_leave' and !empty($_POST['check_date01'])) { ?>
                                            <tr>
                                                <td colspan="9" align="center">ตั้งแต่วันที่
    <?= DateThai1($date01); ?>
                                                    ถึง
    <?= DateThai1($date02); ?></td>
                                            </tr>
<?php } ?>
                                        <tr align="center" bgcolor="#898888">
                                            <td align="center" width="10%"><b>ลำดับ</b></td>
                                            <td align="center" width="20%"><b>เลขที่ใบลา</b></td>
                                            <td align="center" width="20%"><b>ประเภทการลา</b></td>
                                            <td align="center" width="20%"><b>ตั้งแต่</b></td>
                                            <td align="center" width="20%"><b>ถึง</b></td>
                                            <td align="center" width="10%"><b>จำนวนวัน</b></td>
                                        </tr>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysql_fetch_assoc($detial)) {
                                                        ?>
                                            <tr>
                                                <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                <td align="center"><?= $result[leave_no]?></td>
                                                <td align="center"><?= $result[nameLa]; ?></td>
                                                <td align="center"><?= DateThai1($result[begindate]); ?></td>
                                                <td align="center"><?= DateThai1($result[enddate]); ?></td>
                                                <td align="center"><?= $result[amount]; ?></td>
                                            </tr>
    <?php $i++;
}
?>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลการไปราชการ</h3>
                                </div>
                                <div class="panel-body">
                                   <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                        <tr align="center" bgcolor="#898888">
                                            <td width="5%" align="center"><b>ลำดับ</b></td>
                                            <td width="55%" align="center"><b>โครงการ</b></td>
                                            <td width="20%" align="center"><b>เข้าร่วมตั้งแต่</b></td>
                                            <td width="20%" align="center"><b>วันเดินทาง</b></td>
                                        </tr>
<?php
$i = 1;
while ($result2 = mysql_fetch_assoc($detiatl)) {
    ?>
                                            <tr>
                                                <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                <td><?= $result2[projectName]; ?></td>
                                                <td align="center"><?= DateThai1($result2[Beginedate]); ?><br> ถึง <br><?= DateThai1($result2[endDate]); ?></td>
                                                <td align="center"><?= DateThai1($result2[stdate]); ?><br> ถึง <br><?= DateThai1($result2[etdate]); ?></td>
                                            </tr>
                                                <?php $i++;
                                            }
                                            ?>
                                     </table> 
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลการอบรมภายใน</h3>
                                </div>
                                <div class="panel-body">
                                    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                    <tr align="center" bgcolor="#898888">
                                        <td align="center" width="5%"><b>ลำดับ</b></td>
                                        <td width="60%" align="center" bgcolor="#898888"><b>ชื่อโครงการ</b></td>
                                        <td align="center" width="15%"><b>ตั้งแต่</b></td>
                                        <td align="center" width="15%"><b>ถึง</b></td>
                                        <td align="center" width="5%"><b>ชั่วโมง</b></td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    while ($result = mysql_fetch_assoc($detial_tin)) {
                                        ?>
                                        <tr>
                                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                            <td><?= $result[in2]; ?></td>
                                            <td align="center"><?= DateThai1($result[bdate]); ?></td>
                                            <td align="center"><?= DateThai1($result[edate]); ?></td>
                                            <td align="center"><?= $result[amount]; ?></td>
                                        </tr>

    <?php $i++;
}
?>
                                </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
</div>
 <?php
   if($con){
   mysql_close($con);
   }?>

    </div><!-- /#wrapper -->
    <script src="option/js/ajax.js"></script> 
    <!-- Bootstrap core JavaScript -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
 	<script type="text/javascript" src="DatePicker/js/jquery-1.4.4.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- Page Specific Plugins -->
    <script src="js/raphael-min.js"></script>
    <script src="js/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>
  </body>
</html>
