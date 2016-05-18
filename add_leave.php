<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?
if ($_REQUEST[work_id] != '') {
    $work_id = $_REQUEST[work_id];
    echo $work_id;
    $sql_delw = "delete from work where workid ='$work_id'";
    mysql_query($sql_delw) or die(mysql_error());
} elseif ($_REQUEST[time_id] != '') {
    $time_id = $_REQUEST[time_id];
    $sql_delt = "delete from timela where id='$time_id'";
    mysql_query($sql_delt) or die(mysql_error());
}
?>
<?
$empno = $_REQUEST[id];
if ($_SESSION[emp] != '') {
    $empno = $_SESSION[emp];
} elseif ($_SESSION[status] == 'USER') {
    $empno = $_SESSION[user];
}
$name_detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno, e2.TypeName as typename,e2.EmpType as emptype
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            inner join emptype e2 on e2.EmpType=e1.emptype
                            where e1.empno='$empno'");
$NameDetial = mysql_fetch_assoc($name_detial);

$sql_leave=  mysql_query("SELECT empno FROM leave_day WHERE empno='$empno'");
         $num_row1=  mysql_num_rows($sql_leave);
         if($num_row1 >= 1){
             $Sql_leave=  mysql_query("SELECT * FROM leave_day WHERE empno='$empno'");
             $Sql_Leave=  mysql_fetch_assoc($Sql_leave);
         }

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดข้อมูลการลาของบุคลากร </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
<? if ($_SESSION[status] != 'USER') {
    if ($_REQUEST[method] == 'check_page') {
        $depno = $_REQUEST[depno];
        ?> 

                    <li class="active"><a href="Lperson_report.php?depname=<?= $depno ?>"><i class="fa fa-edit"></i> สถิติการลาของของของบุคลากรหน่วยงาน</a></li>
                <? } elseif ($_REQUEST[method] == 'check_page2') { ?>
                    <li class="active"><a href="statistics_leave.php"><i class="fa fa-edit"></i> สถิติการลา</a></li>
    <? } else { ?>
                    <li class="active"><a href="pre_leave.php"><i class="fa fa-edit"></i> ข้อมูลการลา</a></li>
    <? }
} ?>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลการลา</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลบุคลากร</h3>
            </div>
            <div class="panel-body">
                <form class="navbar-form navbar-left" role="form" action='prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">

<font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial[fullname]; ?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial[posi]; ?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial[dep]; ?>
                            <br />
                            ประเภทพนักงาน :
<?= $NameDetial[typename]; ?>
                            <br /><br />
                            </font>                            <div class="form-group"> 
                            <label>ลาป่วย &nbsp;</label>
                            <input size="1" value='<?=$Sql_Leave[L1]?>' type="text" class="form-control" name="L1" id="L1" placeholder="ลาป่วย" onkeydown="return nextbox(event, 'L2')" required>
                            </div>
                                                        <div class="form-group"> 
                            <label>ลากิจ &nbsp;</label>
                            <input size="1" value='<?=$Sql_Leave[L2]?>' type="text" class="form-control" name="L2" id="L2" placeholder="ลากิจ" onkeydown="return nextbox(event, 'L3')" required>
                            </div>
                            <div class="form-group"> 
                            <label>ลาพักผ่อน &nbsp;</label>
                            <input size="1" value='<?=$Sql_Leave[L3]?>' type="text" class="form-control" name="L3" id="L3" placeholder="ลาพักผ่อน" onkeydown="return nextbox(event, 'L4')" required>
                            </div>
                            <div class="form-group"> 
                            <label>ลาคลอด &nbsp;</label>
                            <input size="1" value='<?=$Sql_Leave[L4]?>' type="text" class="form-control" name="L4" id="L4" placeholder="ลาคลอด" onkeydown="return nextbox(event, 'L5')">
                            </div>
                            <div class="form-group"> 
                            <label>ลาบวช &nbsp;</label>
                            <input size="1" value='<?=$Sql_Leave[L5]?>' type="text" class="form-control" name="L5" id="L5" placeholder="ลาบวช" onkeydown="return nextbox(event, 'L6')">
                            </div>
                            <div class="form-group"> 
                            <label>ลาศึกษาต่อ &nbsp;</label>
                            <input size="1" value='<?=$Sql_Leave[L6]?>' type="text" class="form-control" name="L6" id="L6" placeholder="ลาศึกษาต่อ" onkeydown="return nextbox(event, 'L7')">
                            </div>
                            <div class="form-group">
                            <label>ลาเลี้ยงดูบุตร &nbsp;</label>
                            <input size="1" value='<?=$Sql_Leave[L7]?>' type="text" class="form-control" name="L7" id="L7" placeholder="ลาเลี้ยงดูบุตร" onkeydown="return nextbox(event, 'Submit')">
                            </div>
                            <br><br>
                            <?
                            $sql=  mysql_query("SELECT empno FROM leave_day WHERE empno='$empno'");
         $num_row=  mysql_num_rows($sql);
         if($num_row >= 1){?>
                            <input type="hidden" name="method" id="method" value="edit_add_leave">
                             <input type="hidden" name="empno" id="method" value="<?=$empno?>">
                             <input type="hidden" name="emptype" id="method" value="<?= $NameDetial[emptype]; ?>">
                             <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="บันทึก">
        <? }else{?>
                             <input type="hidden" name="method" id="method" value="add_leave">
                             <input type="hidden" name="empno" id="method" value="<?=$empno?>">
                             <input type="hidden" name="emptype" id="method" value="<?= $NameDetial[emptype]; ?>">
                             <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
         <?}?>
                </form>
        </div>
    </div>
</div>
</div>
<? include 'footer.php'; ?>