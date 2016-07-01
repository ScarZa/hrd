<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php
if (!empty($_REQUEST['his'])) { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    $his=$_REQUEST['his'];
    $sqle_del = "delete from work_history where his_id='$his'";
    mysql_query($sqle_del) or die(mysql_error());
//echo "ลบข้อมูล ID $del_id เรียบร้อยแล้ว";
}?>
<?php
$empno = $_REQUEST[id];
if ($_SESSION[emp] != '') {
    $empno = $_SESSION[emp];
} elseif ($_SESSION[Status] == 'USER' or $_SESSION[Status]=='SUSER'  or $_SESSION[Status]=='USUSER') {
    $empno = $_SESSION[user];
}
$name_detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            where e1.empno='$empno'");


    $detial = mysql_query("SELECT wh.his_id, wh.empcode, wh.dateBegin, po.posname, d1.depName, et.StucName, etp.TypeName, ed.eduname ,
CONCAT(TIMESTAMPDIFF(year,wh.dateBegin,IF(wh.dateEnd_w=0000-00-00,NOW(),wh.dateEnd_w)),' ปี ',
timestampdiff(month,wh.dateBegin,IF(wh.dateEnd_w=0000-00-00,NOW(),wh.dateEnd_w))-(timestampdiff(year,wh.dateBegin,IF(wh.dateEnd_w=0000-00-00,NOW(),wh.dateEnd_w))*12),'  เดือน ',
FLOOR(TIMESTAMPDIFF(DAY,wh.dateBegin,IF(wh.dateEnd_w=0000-00-00,NOW(),wh.dateEnd_w))%30.4375),'  วัน')AS age
FROM work_history wh 
INNER JOIN posid po on po.posId=wh.posid
INNER JOIN department d1 on d1.depId=wh.depid
INNER JOIN empstuc et on et.Emstuc=wh.empstuc
INNER JOIN emptype etp on etp.EmpType=wh.emptype
INNER JOIN education ed on ed.education=wh.education
WHERE wh.empno='$empno' ORDER BY wh.his_id DESC");


$NameDetial = mysql_fetch_assoc($name_detial);

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดประวัติการทำงานของบุคลากร </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            
            
<?php if ($_SESSION[Status] != 'USER') {
    if ($_REQUEST[method] == 'check_page') {
        $depno = $_REQUEST[depno];
        ?> 

                    <li class="active"><a href="Lperson_report.php?depname=<?= $depno ?>"><i class="fa fa-edit"></i> สถิติการลาของของของบุคลากรหน่วยงาน</a></li>
                <?php } elseif ($_REQUEST[method] == 'check_page2') { ?>
                    <li class="active"><a href="statistics_leave.php"><i class="fa fa-edit"></i> สถิติการลา</a></li>
<?php }else{?>
                    <li><a href="pre_Whistory.php"><i class="fa fa-edit"></i> ข้อมูลประวัติการทำงาน</a></li>
<?php }} ?>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลประวัติการทำงานของบุคลากร</li>
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
                 <a class="btn btn-success" download="report_person_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
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
                            <?php
                                 include 'option/function_date.php';
                                ?>
                            </font></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลการศึกษา</h3>
                                </div>
                                <div class="panel-body">
                                    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                                <?php if ($_SESSION[check_dl] == 'check_detial_leave') { ?>
                                            <tr>
                                                <td colspan="9" align="center">ตั้งแต่วันที่
    <?= DateThai1($date01); ?>
                                                    ถึง
    <?= DateThai1($date02); ?></td>
                                            </tr>
<?php } ?>
                                        <tr align="center" bgcolor="#898888">
                                            <td align="center" width="5%"><b>ลำดับ</b></td>
                                            <td align="center" width="10%"><b>เลขที่คำสั่ง</b></td>
                                            <td align="center" width="10%"><b>วันที่เริ่มงาน</b></td>
                                            <td align="center" width="10%"><b>ระยะเวลาทำงาน</b></td>
                                            <td align="center" width="20%"><b>ตำแหน่ง</b></td>
                                            <td align="center" width="10%"><b>หน่วยงาน</b></td>
                                            <td align="center" width="10%"><b>สายงาน</b></td>
                                            <td align="center" width="10%"><b>ประเภทพนักงาน</b></td>
                                            <td align="center" width="10%"><b>วุฒิที่บรรจุ</b></td>
                                            <?php if($_SESSION[Status]=='ADMIN'){?>
                                            <th align="center" width="10%">แก้ไข</th>
                                            <th align="center" width="10%">ลบ</th>
                                            <?php }?>

                                        </tr>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysql_fetch_assoc($detial)) {
                                                        ?>
                                            <tr>
                                                <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                <td align="center"><?= $result[empcode]; ?></td>
                                                <td align="center"><?= DateThai1($result[dateBegin]) ?></td>
                                                <td align="center"><?= $result['age']; ?></td>
                                                <td align="center"><?= $result[posname]; ?></td>
                                                <td align="center"><?= $result[depName]; ?></td>
                                                <td align="center"><?= $result[StucName]; ?></td>
                                                <td align="center"><?= $result[TypeName]; ?></td>
                                                <td align="center"><?= $result[eduname]; ?></td>
                                                <?php if($_SESSION[Status]=='ADMIN'){?>
                                                <td align="center" width="12%"><a href="#" onclick="return popup('add_Whistory.php?id=<?= $empno?>&amp;method=edit_his&amp;his=<?= $result[his_id]?>', popup, 500, 750);">
                                                        <img src='images/tool.png' width='30'></a></td>
                                                        <td align="center" width="12%"><a href='detial_Whistory.php?id=<?= $empno?>&his=<?= $result[his_id]?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' width='30'></a></td>
                                                <?php }?>
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
<?php include 'footer.php'; ?>