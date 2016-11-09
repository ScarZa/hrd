<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php
if ($_REQUEST['del_id'] != "") { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    $del_id = $_REQUEST['del_id'];
    $edu=$_REQUEST[edu];
    $sqle_del = "delete from educate where empno = '$del_id' and ed_id='$edu'";
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
                            INNER JOIN work_history wh ON wh.empno=e1.empno
                            inner join posid p2 on wh.posid=p2.posId
                            where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)) order by wh.his_id desc LIMIT 1");


    $detial = mysql_query("SELECT * from educate e1
                        INNER JOIN education e2 on e1.educate=e2.education
                        where e1.empno='$empno' ORDER BY e1.educate DESC");


$NameDetial = mysql_fetch_assoc($name_detial);

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดข้อมูลการศึกษาของบุคลากร </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            
            
<?php if ($_SESSION[Status] != 'USER' or $_SESSION[Status]!='SUSER' or $_SESSION[Status]!='USUSER') {
    if ($_REQUEST[method] == 'check_page') {
        $depno = $_REQUEST[depno];
        ?> 

                    <li class="active"><a href="Lperson_report.php?depname=<?= $depno ?>"><i class="fa fa-edit"></i> สถิติการลาของของของบุคลากรหน่วยงาน</a></li>
                <?php } elseif ($_REQUEST[method] == 'check_page2') { ?>
                    <li class="active"><a href="statistics_leave.php"><i class="fa fa-edit"></i> สถิติการลา</a></li>
<?php }else{?>
    <li><a href="pre_educate.php"><i class="fa fa-edit"></i> ข้อมูลการศึกษา</a></li>
<?php }} ?>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลการศึกษาของบุคลากร</li>
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
                                            <td align="center" width="6%"><b>ลำดับ</b></td>
                                            <td align="center" width="20%"><b>วุฒิการศึกษา/หลักสูตร</b></td>
                                            <td align="center" width="20%"><b>สาขา/วิชาเอก</b></td>
                                            <td align="center" width="30%"><b>สถาบัน</b></td>
                                            <td align="center" width="10%"><b>จบการศึกษาเมื่อ</b></td>
                                            <?php if($_SESSION[Status]=='ADMIN'){?>
                                            <th align="center" width="5%">แก้ไข</th>
                                            <th align="center" width="5%">ลบ</th>
                                            <?php }?>

                                        </tr>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysql_fetch_assoc($detial)) {
                                                        ?>
                                            <tr>
                                                <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                <td align="center"><?php if($result['check_ed']=='1'){ echo $result['eduname'];}elseif ($result['check_ed']=='2') {
                                            $detial2 = mysql_query("SELECT tn.train_name as tname from educate e1
                                                                    INNER JOIN train_nurse tn on e1.educate=tn.train_id
                                                                    where e1.educate='".$result['educate']."' ");
                                            $result2 = mysql_fetch_assoc($detial2);
                                            echo $result2['tname'];} ?></td>
                                                <td align="center"><?= $result['major']?></td>
                                                <td align="center"><?= $result[institute]; ?></td>
                                                <td align="center"><?= DateThai1($result[enddate]); ?></td>
                                                <?php if($_SESSION[Status]=='ADMIN'){?>
                                                <td align="center" width="12%"><a href="#" onclick="return popup('add_educate.php?id=<?= $empno?>&amp;method=edit_edu&amp;edu=<?= $result[ed_id]?>', popup, 500, 550);">
                                                        <img src='images/tool.png' width='30'></a></td>
                                                        <td align="center" width="12%"><a href='detial_educate.php?id=<?= $empno?>&del_id=<?=$result[empno];?>&edu=<?= $result[ed_id]?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' width='30'></a></td>
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