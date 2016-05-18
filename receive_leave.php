<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><img src='images/kwrite.ico' width='75'><font color='blue'>  บันทึกทะเบียนรับใบลา </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกทะเบียนรับใบลา</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='images/bookcase.ico' width='25'> บันทึกทะเบียนรับใบลา</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
                        <form name="form1" method="post" action="session.php" class="navbar-form navbar-right">
                            <label> เลือกช่วงเวลา : </label>
                            <div class="form-group">
                                <input type="date"   name='check_date01' class="form-control" value='' > 
                            </div>
                            <div class="form-group">
                                <input type="date"   name='check_date02' class="form-control" value='' >
                            </div>
                            <input type="hidden" name="method" value="check_receive">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                        </div><br><br>
                </div>
               <div class="row">        
                <form name="form2" method="post" action="receive_leave.php" class="navbar-form navbar-right">
                            <div class="form-group">
                                <select name="select_status" id="select_status" class="form-control">
                                    <option value="">เลือกสถานะใบลา</option>
                                    <option value="W">รอลงทะเบียน</option>
                                    <option value="A">รออนุมัติ</option>
                                    <option value="Y">อนุมัติ</option>
                                    <option value="N">ไม่อนุมัติ</option>
                                </select>
                            </div>
                                                            <input type="hidden" name="method" value="status_leave">
                            <button type="submit" class="btn btn-success">ตกลง</button>

                        </form>
                </div>
                <?php

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    $regis=$_REQUEST[select_status];
                    $urlfile = "receive_leave.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
                    $per_page = 30;
                    $num_per_page = floor($chk_page / $per_page);
                    $total_end_p = ($num_per_page + 1) * $per_page;
                    $total_start_p = $total_end_p - $per_page;
                    $pPrev = $chk_page - 1;
                    $pPrev = ($pPrev >= 0) ? $pPrev : 0;
                    $pNext = $chk_page + 1;
                    $pNext = ($pNext >= $total_p) ? $total_p - 1 : $pNext;
                    $lt_page = $total_p - 4;
                    if ($chk_page > 0) {
                        echo "<a  href='$urlfile?select_status=$regis&method=status_leave&s_page=$pPrev" . $querystr . "' class='naviPN'>Prev</a>";
                    }
                    for ($i = $total_start_p; $i < $total_end_p; $i++) {
                        $nClass = ($chk_page == $i) ? "class='selectPage'" : "";
                        if ($e_page * $i <= $total) {
                            echo "<a href='$urlfile?select_status=$regis&method=status_leave&s_page=$i" . $querystr . "' $nClass  >" . intval($i + 1) . "</a> ";
                        }
                    }
                    if ($chk_page < $total_p - 1) {
                        echo "<a href='$urlfile?select_status=$regis&method=status_leave&s_page=$pNext" . $querystr . "'  class='naviPN'>Next</a>";
                    }
                }
                include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
                if ($_SESSION[check_rec] != "") {
                    $date01=$_SESSION[receive_date1];
                    $date02=$_SESSION[receive_date2];
//คำสั่งค้นหา
                    if($_REQUEST[method]=='status_leave' and $_REQUEST[select_status]!=''){
                        $regis=$_REQUEST[select_status];
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where w.statusla='Y' and (begindate between '$date01' and '$date02') and (enddate between '$date01' and '$date02') and regis_leave='$regis'
order by w.workid desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where (datela between '$date01' and '$date02') and regis_time='$regis'
                            order by t.id desc";
                    
                    }elseif($_REQUEST[method]=='' or $_REQUEST[method]=='status_leave' and $_REQUEST[select_status]==''){
                     $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where w.statusla='Y' and (begindate between '$date01' and '$date02') and (enddate between '$date01' and '$date02')
order by w.workid desc";  
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where datela between '$date01' and '$date02'
                            order by t.id desc";
                     
                    }
                } else {
                    if($_REQUEST[method]=='status_leave' and $_REQUEST[select_status]!=''){
                        $regis=$_REQUEST[select_status];
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where w.statusla='Y' and regis_leave='$regis'
order by w.workid desc,reg_date desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where regis_time='$regis'
                            order by t.id desc,vstdate desc";
                    }elseif($_REQUEST[method]=='' or $_REQUEST[method]=='status_leave' and $_REQUEST[select_status]==''){
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where w.statusla='Y' and begindate BETWEEN '$y-10-01' and '$Yy-09-30'
order by w.workid desc,reg_date desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where datela BETWEEN '$y-10-01' and '$Yy-09-30'
                            order by t.id desc,vstdate desc";
                    }
                    
                }
}else{
                if ($_SESSION[check_rec] != "") {
                    $date01=$_SESSION[receive_date1];
                    $date02=$_SESSION[receive_date2];
//คำสั่งค้นหา
                    if($_REQUEST[method]=='status_leave' and $regis=$_REQUEST[select_status]!=''){
                        $regis=$_REQUEST[select_status]."111";
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where w.statusla='Y' and (begindate between '$date01' and '$date02') and (enddate between '$date01' and '$date02') and regis_leave='$regis'
order by w.workid desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where (datela between '$date01' and '$date02') and regis_time='$regis'
                            order by t.id desc";
                    
                    }elseif($_REQUEST[method]=='' or $_REQUEST[method]=='status_leave' and $_REQUEST[select_status]==''){
                     $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where w.statusla='Y' and (begindate between '$date01' and '$date02') and (enddate between '$date01' and '$date02')
order by w.workid desc";  
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where datela between '$date01' and '$date02'
                            order by t.id desc";
                     
                    }
                } else {
                    if($_REQUEST[method]=='status_leave' and $regis=$_REQUEST[select_status]!=''){
                        $regis=$_REQUEST[select_status];
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where w.statusla='Y' and regis_leave='$regis'
order by w.workid desc,reg_date desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where regis_time='$regis'
                            order by t.id desc,vstdate desc";
                    }elseif($_REQUEST[method]=='' or $_REQUEST[method]=='status_leave' and $_REQUEST[select_status]==''){
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where  w.statusla='Y'
order by w.workid desc,reg_date desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            order by t.id desc,vstdate desc";
                    }
                    
                }}
                $qr = mysql_query($q);
                $qr2 = mysql_query($q2);
                if ($qr == '' and $qr2 == '') {
                    exit();
                }
                $total = mysql_num_rows($qr);
                $total2 = mysql_num_rows($qr2);

                $e_page = 30; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
                if (!isset($_GET['s_page'])) {
                    $_GET['s_page'] = 0;
                } else {
                    $chk_page = $_GET['s_page'];
                    $_GET['s_page'] = $_GET['s_page'] * $e_page;
                }
                $q.=" LIMIT " . $_GET['s_page'] . ",$e_page";
                $q2.=" LIMIT " . $_GET['s_page'] . ",$e_page";
                $qr = mysql_query($q);
                $qr2 = mysql_query($q2);
                if (mysql_num_rows($qr) >= 1 and mysql_num_rows($qr2) >= 1) {
                    $plus_p = ($chk_page * $e_page) + mysql_num_rows($qr);
                    $plus_p2 = ($chk_page * $e_page) + mysql_num_rows($qr2);
                } else {
                    $plus_p = ($chk_page * $e_page);
                    $plus_p2 = ($chk_page * $e_page);
                }
                $total_p = ceil($total / $e_page);
                $before_p = ($chk_page * $e_page) + 1;
                $total_p2 = ceil($total / $e_page);
                $before_p2 = ($chk_page * $e_page) + 1;
                echo mysql_error();
                ?>

                <? include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table id="datatable" align="center" width="100%" border="1">
                    <? if ($_SESSION[check_rec] == 'check_receive') { ?>
                        <tr>
                            <td colspan="9" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
                    <? } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="4%" align="center"><b>ลำดับ</b></td>
                        <td width="10%" align="center"><b>เลขทะเบียนรับ</b></td>
                        <td width="15%" align="center"><b>ที่</b></td>
                        <td width="10%" align="center"><b>ลงวันที่</b></td>
                        <td width="15%" align="center"><b>จาก</b></td>
                        <td width="9%" align="center"><b>ถึง</b></td>
                        <td width="10%" align="center"><b>เรื่อง</b></td>
                        <td width="20%" align="center"><b>การปฏิบัติ</b></td>
                        <td width="7%" align="center"><b>รับใบลา</b></td>

                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysql_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= $result[leave_no]; ?></td>
                            <td align="center"><?= $result[depname]; ?></a></td>
                            <td align="center"><?= DateThai1($result[reg_date]); ?></td>
                            <td>&nbsp;&nbsp; <?= $result[fullname]; ?></td>
                            <td align="center"> ผู้อำนวยการ </td>
                            <td align="center"><?= $result[namela]; ?></td>
                            <td align="center"><?= DateThai1($result[begindate]); ?> <b>ถึง</b> <?= DateThai1($result[enddate]); ?></td>
                            <td align="center">
                           <? if($result[regis_leave]=='W'){ ?>
                            <a href="#" onClick="return popup('regis_leave.php?id=<?= $result[enpid]?>&Lno=<?= $result[workid]?>', popup, 450, 600);" title="รอลงทะเบียนรับใบลา"><i class="fa fa-spinner fa-spin"></i></a>
                            <? } elseif ($result[regis_leave]=='A') {?>
                            <a href="#" onClick="return popup('regis_leave.php?method=confirm_leave&id=<?= $result[enpid]?>&Lno=<?= $result[workid]?>', popup, 450, 600);" title="รออนุมัติใบลา">
                                    <img src="images/email.ico" width="20"></a>
                            <? } elseif ($result[regis_leave]=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?} elseif ($result[regis_leave]=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?}?>
                                        </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>

                </table>
                <?php
                if ($total > 0) {
                    echo mysql_error();
                    ?>
                    <div class="browse_page">

                        <?php
                        // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                        page_navigator($before_p, $plus_p, $total, $total_p, $chk_page);

                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
                        echo $count = ceil($total / 30) . "&nbsp;<B>หน้า</B></font>";
                    }
                    ?> 
                </div>
                <a class="btn btn-success" download="report_time_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable2', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table id="datatable2" align="center" width="100%" border="1">
                        <? if ($_SESSION[check_rec] == 'check_receive') { ?>
                        <tr>
                            <td colspan="9" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
<? } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="4%" align="center"><b>ลำดับ</b></td>
                        <td width="10%" align="center"><b>เลขทะเบียนรับ</b></td>
                        <td width="15%" align="center"><b>ที่</b></td>
                        <td width="10%" align="center"><b>ลงวันที่</b></td>
                        <td width="15%" align="center"><b>จาก</b></td>
                        <td width="9%" align="center"><b>ถึง</b></td>
                        <td width="10%" align="center"><b>เรื่อง</b></td>
                        <td width="20%" align="center"><b>การปฏิบัติ</b></td>
                        <td width="7%" align="center"><b>รับใบลา</b></td>

                    </tr>

                    <?
                    $i = 1;
                    while ($result2 = mysql_fetch_assoc($qr2)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= $result2[idno]; ?></td>
                            <td align="center"><?= $result2[depname]; ?></a></td>
                            <td align="center"><?= DateThai1($result2[vstdate]); ?></td>
                            <td>&nbsp;&nbsp; <?= $result2[fullname]; ?></td>
                            <td align="center"> ผู้อำนวยการ </td>
                            <td align="center">ลาชั่วโมง</td>
                            <td align="center"><?= DateThai1($result2[datela]); ?>&nbsp; <?= $result2[starttime]; ?> <b>ถึง</b> <?= $result2[endtime]; ?></td>
                            <td align="center">
                           <? if($result2[regis_time]=='W'){ ?>
                            <a href="#" onClick="return popup('regis_tleave.php?id=<?= $result2[empno]?>&Lno=<?= $result2[id]?>', popup, 450, 550);" title="รอลงทะเบียนรับใบลา"><i class="fa fa-spinner fa-spin"></i></a>
                            <? } elseif ($result2[regis_time]=='A') {?>
                            <a href="#" onClick="return popup('regis_tleave.php?method=confirm_tleave&id=<?= $result2[empno]?>&Lno=<?= $result2[id]?>', popup, 450, 580);" title="รออนุมัติใบลา">
                                    <img src="images/email.ico" width="20"></a>
                            <? } elseif ($result2[regis_time]=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?} elseif ($result2[regis_time]=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?}?>
                                        </td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>

                </table>
                <?php
                if ($total > 0) {
                    echo mysql_error();
                    ?>
                    <div class="browse_page">

                        <?php
                        // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                        page_navigator($before_p2, $plus_p2, $total2, $total_p2, $chk_page);

                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total2 รายการ</B> จำนวนหน้าทั้งหมด ";
                        echo $count = ceil($total2 / 30) . "&nbsp;<B>หน้า</B></font>";
                    }
                    ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
