<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php
if ($_REQUEST[work_id] != '') {
    $work_id = $_REQUEST[work_id];
    $sql_delw = "delete from work where workid ='$work_id'";
    mysql_query($sql_delw) or die(mysql_error());
    $del_event = "delete from tbl_event where workid ='$work_id'";
    mysql_query($del_event) or die(mysql_error());
    
} elseif ($_REQUEST[time_id] != '') {
    $time_id = $_REQUEST[time_id];
    $del_photo=mysql_query("select pics_t from timela where id='$time_id'");
                $del_photo=mysql_fetch_assoc($del_photo);
                if(!empty($del_photo['pics_t'])){
                $location="time_l/".$del_photo['pics_t'];
                include 'function/delet_file.php';
                fulldelete($location);}
    
    $sql_delt = "delete from timela where id='$time_id'";
    mysql_query($sql_delt) or die(mysql_error());
}
?>
<?php include 'option/function_date.php';
$empno = $_REQUEST[id];
if ($_SESSION[emp] != '') {
    $empno = $_SESSION[emp];
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
if ($_SESSION[check_dl] == 'check_detial_leave') {
    $date01 = $_SESSION[leave_date1];
    $date02 = $_SESSION[leave_date2];

    $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' and w1.begindate between '$date01' and '$date02' and w1.enddate between '$date01' and '$date02'
                            AND statusla='Y' order by workid desc");

    $detiatl = mysql_query("SELECT * from timela where empno='$empno' and (datela between '$date01' and '$date02') and status='N' order by id desc");
} elseif(!empty($_POST['year'])){
        $y = $_POST['year'] - 543;
        $Y = $y - 1;
        $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' AND statusla='Y'  and w1.begindate BETWEEN '$Y-10-01' and '$y-09-30' order by workid desc");

    $detiatl = mysql_query("SELECT * from timela where empno='$empno' and status='N'  and datela BETWEEN '$Y-10-01' and '$y-09-30' order by id desc");
    }else{
        if($date >= $bdate and $date <= $edate){
    $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' AND statusla='Y'  and w1.begindate BETWEEN '$y-10-01' and '$Yy-09-30' order by workid desc");

    $detiatl = mysql_query("SELECT * from timela where empno='$empno' and status='N'  and datela BETWEEN '$y-10-01' and '$Yy-09-30' order by id desc");
    }else{
    $detial = mysql_query("SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' AND statusla='Y'  and w1.begindate BETWEEN '$Y-10-01' and '$y-09-30' order by workid desc");

    $detiatl = mysql_query("SELECT * from timela where empno='$empno' and status='N'  and datela BETWEEN '$Y-10-01' and '$y-09-30' order by id desc");
}}
$NameDetial = mysql_fetch_assoc($name_detial);

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดข้อมูลการลาของบุคลากร </font></h1> 
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
    <li class="active"><a href="pre_leave.php"><i class="fa fa-edit"></i> ข้อมูลการลา</a></li>
<?php }}else{ ?>
            <li class="active"><a href="pre_leave.php"><i class="fa fa-edit"></i> ข้อมูลการลา</a></li>
<?php }?>
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
                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
                        <form method="post" action="session.php" class="navbar-form navbar-right">
                            <label> เลือกช่วงเวลา : </label>
                            <div class="form-group">
                                <input type="date"   name='check_date01' class="form-control" value='' > 
                            </div>
                            <div class="form-group">
                                <input type="date"   name='check_date02' class="form-control" value='' >
                            </div>
                            <input type="hidden" name="method" value="check_detial_leave">
                            <input type="hidden" name="empno" value="<?= $empno ?>">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                    </div>
                    <br><br></div>
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                        <div class="form-group"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2558; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">ตกลง</button> 						
                    </form>
                
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
                                 
                                 
                                    $sql_total=  mysql_query("select L1,L2,L3 from leave_day where empno='$empno'");
                                    $leave_total= mysql_fetch_assoc($sql_total);
                                    if($date >= $bdate and $date <= $edate){
                                        $sql_leave_t=  mysql_query("SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and 
                                                                begindate BETWEEN '$y-10-01' and '$Yy-09-30' and statusla='Y' and regis_leave!='N'");   
                                    }else{
                                        $sql_leave_t=  mysql_query("SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and 
                                                                begindate BETWEEN '$Y-10-01' and '$y-09-30' and statusla='Y' and regis_leave!='N'");
                                    }
                                    $sum_leave= mysql_fetch_assoc($sql_leave_t);
                                    $sum_total=$leave_total[L3]+$sum_leave[sum_leave];
                                ?>
                            วันลาพักผ่อนปีนี้<u>&nbsp; 10 &nbsp;</u>วัน  วันลาพักผ่อนสะสม<u>&nbsp; <?=$sum_total-10?> &nbsp;</u>รวม<u>&nbsp; <?=$sum_total?> &nbsp;</u>วัน
                            <br />
                            <!--จำนวนวันลาที่เหลือ&nbsp; &nbsp;ลาป่วย<u>&nbsp; <?=$leave_total[L1]?> &nbsp;</u>วัน&nbsp; ลากิจ<u>&nbsp; <?=$leave_total[L2]?> &nbsp;</u>วัน&nbsp;--> ลาพักผ่อน<u>&nbsp; <?=$leave_total[L3]?> &nbsp;</u>วัน
                            <br /><br>
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
                                            <td align="center" width="10%"><b>เลขที่ใบลา</b></td>
                                            <td align="center" width="10%"><b>วันที่เขียนใบลา</b></td>
                                            <td align="center" width="20%"><b>ประเภทการลา</b></td>
                                            <td align="center" width="10%"><b>ตั้งแต่</b></td>
                                            <td align="center" width="10%"><b>ถึง</b></td>
                                            <td align="center" width="6%"><b>จำนวนวัน</b></td>
                                            <td align="center" width="6%"><b>พิมพ์ใบลา</b></td>
                                            <td align="center" width="6%"><b>พิมพ์ใบลากรณีพิเศษ</b></td>
                                            <td align="center" width="6%"><b>ใบลา</b></td>
                                            <td align="center" width="6%"><b>สถานะใบลา</b></td>
                                            <?php if($_SESSION[Status]=='ADMIN'){?>
                                            <td align="center" width="6%"><b>แก้ไข</b></td>
                                            <?php }?>
                                        </tr>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysql_fetch_assoc($detial)) {
                                                        ?>
                                            <tr>
                                                <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                <td align="center"><a href="#" onclick="return popup('leave_detail.php?id=<?= $result[enpid] ?>&amp;&amp;Lno=<?= $result[workid] ?>', popup, 500, 550);">
                                                        <?= $result[leave_no]; ?>
                                                    </a></td>
                                                <td align="center"><a href="#" onclick="return popup('leave_detail.php?id=<?= $result[enpid] ?>&amp;&amp;Lno=<?= $result[workid] ?>', popup, 500, 550);">
                                                    <?= DateThai1($result[reg_date]); ?>
                                                    </a></td>
                                                <td align="center"><a href="#" onclick="return popup('leave_detail.php?id=<?= $result[enpid] ?>&amp;&amp;Lno=<?= $result[workid] ?>', popup, 500, 550);">
                                                    <?= $result[nameLa]; ?>
                                                    </a></td>
                                                <td align="center"><?= DateThai1($result[begindate]); ?></td>
                                                <td align="center"><?= DateThai1($result[enddate]); ?></td>
                                                <td align="center"><?= $result[amount]; ?></td>
                                                <td align="center"><a href="#" onClick="window.open('leave_paper.php?empno=<?= $empno; ?>&amp;work_id=<?= $result[workid]; ?>','','width=700,height=900'); return false;" title="พิมพ์ใบลา"><img src='images/printer.ico' alt="" width='30' /></a></td>
                                                <td align="center"><a href="#" onClick="window.open('special_leave_paper.php?empno=<?= $empno; ?>&amp;work_id=<?= $result[workid]; ?>','','width=700,height=900'); return false;" title="พิมพ์ใบลากรณีพิเศษ"><img src='images/printer.ico' alt="" width='30' /></a></td>
                                                <td align="center"><?php if ($result[pics] != '') {
                                                echo "<a href='myfile/$result[pics]' target='_blank'><span class='fa fa-download'></span> ใบลา" . "<br />";
                                            }
                                                    ?></td>
                                                <td align="center">
                                                    <? if($result[regis_leave]=='W'){ ?>
                            <i class="fa fa-spinner fa-spin" title="รอลงทะเบียนรับใบลา"></i></a>
                            <? } elseif ($result[regis_leave]=='A') {?>
                            <img src="images/email.ico" width="20" title="รออนุมัติใบลา"></a>
                            <? } elseif ($result[regis_leave]=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?} elseif ($result[regis_leave]=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?}?>
                                                </td>
                                                
    <?php if ($_SESSION[Status] == 'ADMIN') { ?>
                                                <td align="center">
                                                    <a href="main_leave.php?id=<?= $result[enpid]; ?>&amp;&amp;method=edit&amp;&amp;leave_no=<?= $result[workid]; ?>"><img src='images/tool.png' alt="" width='30' /></a>
    </td><?php } ?>
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
                                    <h3 class="panel-title">ข้อมูลการลาชั่วโมง</h3>
                                </div>
<?php
if($date >= $bdate and $date <= $edate){
$count_check = mysql_query("select sum(total) as sum from timela where empno='$empno'  and datela BETWEEN '$y-10-01' and '$Yy-09-30' and status='N' ");
}  else {
$count_check = mysql_query("select sum(total) as sum from timela where empno='$empno'and datela BETWEEN '$Y-10-01' and '$y-09-30'  and status='N' ");    
}
$check_tl = mysql_fetch_assoc($count_check);
?>
                                <div class="panel-body">
                                    <form action="transfer_leave.php" method="post" name="form" enctype="multipart/form-data" id="form" >
                                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                            <tr align="center" bgcolor="#898888">
                                                <td align="center" width="5%"><b>ลำดับ</b></td>
                                                <td align="center" width="10%"><b>เลขที่ใบลา</b></td>
                                                <td align="center" width="10%"><b>วันที่ลา</b></td>
                                                <td align="center" width="10%"><b>ตั้งแต่</b></td>
                                                <td align="center" width="10%"><b>ถึง</b></td>
                                                <td align="center" width="10%"><b>จำนวนชั่วโมง</b></td>
                                                <td align="center" width="6%"><b>พิมพ์ใบลา</b></td>
                                                <td width="7%" align="center"><b>ใบลา</b></td>
                                                <td width="10%" align="center"><b>สถานะใบลา</b></td>
                                            <?php if ($_SESSION[Status] == 'ADMIN') { ?>
                                                    <td width="6%" align="center"><b>แก้ไข</b></td>
                                                    <th align="center" width="6%"><b>ลบ</b></th>
    <?php if ($check_tl[sum] >= 8) { ?>
                                                        <td align="center" width="10%"><b>โอนการลา</b></td>
                                                            <?php } ?>
<?php } ?>
                                            </tr>
                                                        <?php
                                                        $i = 1;
                                                        while ($result = mysql_fetch_assoc($detiatl)) {
                                                            ?>
                                                <tr>
                                                    <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                    <td align="center"><a href="#" onclick="return popup('Tleave_detail.php?id=<?= $result[empno] ?>&amp;&amp;Lno=<?= $result[id] ?>', popup, 700, 450);">
                                                        <?= $result[idno]; ?>
                                                        </a></td>
                                                    <td align="center"><a href="#" onclick="return popup('Tleave_detail.php?id=<?= $result[empno] ?>&amp;&amp;Lno=<?= $result[id] ?>', popup, 700, 450);">
                                                    <?= DateThai1($result[datela]); ?>
                                                        </a></td>
                                                    <td align="center"><?= $result[starttime]; ?></td>
                                                    <td align="center"><?= $result[endtime]; ?></td>
                                                    <td align="center"><?= $result[total]; ?></td>
                                                    <td align="center"><a href="#" onClick="window.open('leavet_paper.php?empno=<?= $empno; ?>&amp;Lno=<?= $result[id] ?>','','width=700,height=900'); return false;" title="พิมพ์ใบลาชั่วโมง"><img src='images/printer.ico' alt="" width='30' /></a></td>
                                                    <td align="center"><?php if ($result[pics_t] != '') {
                                                    echo "<a href='time_l/$result[pics_t]' target='_blank'><span class='fa fa-download'></span> ใบลา" . "<br />";
                                                }
                                                    ?></td>
                                                    <td align="center">
                                                    <?php if($result[regis_time]=='W'){ ?>
                            <i class="fa fa-spinner fa-spin" title="รอลงทะเบียนรับใบลา"></i></a>
                            <?php } elseif ($result[regis_time]=='A') {?>
                            <img src="images/email.ico" width="20" title="รออนุมัติใบลา"></a>
                            <?php } elseif ($result[regis_time]=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result[regis_time]=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                                                </td>
                                            <?php if ($_SESSION[Status] == 'ADMIN') { ?>
                                                        <td align="center"><a href='time_leave.php?id=<?= $result[empno]; ?>&amp;&amp;method=edit_Tleave&amp;&amp;leave_no=<?= $result[id]; ?>'><img src='images/tool.png' alt="" width='30' /></a></td>
                                                        <td align="center" width="12%"><a href='detial_leave.php?id=<?= $empno; ?>&time_id=<?= $result[id]; ?>' onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' alt="" width='30' /></a></td>
        <?php if ($check_tl[sum] >= 8) { ?>
                                                            <td align="center"><input id="leave_id[]" name="leave_id[]" type="checkbox" value="<?= $result[id]; ?>"/>
                                                                <input id="check[]" name="check[]" type="hidden" value="<?= $result[empno]; ?>" /></td>
                                                <?php } ?>
                                            <?php } ?>
                                                </tr>
    <?php $i++;
}?>
                                        </table>
<?php if ($_SESSION[Status] != 'USER') { ?>
    <?php if ($check_tl[sum] >= 8) { ?>
                                                <br />
                                                <center>
                                                    <input type="hidden" name="check_id" id="check_id" value="<?= $empno; ?>" />
                                                    <input class="btn btn-warning" name="submit" type="submit"  value="โอน" onClick="return confirm('กรุณายืนยันการโอนอีกครั้ง !!!')"/>
                                                </center>
    <?php } ?>
<?php } ?>
                                    </form>
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