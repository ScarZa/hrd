<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'><img src='images/kchart.ico' width='75'>  สถิติการลา </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการลา</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='images/kchart.ico' width='25'> ตารางสถิติการลาของบุคลากร</h3>
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
                            <input type="hidden" name="checkdate" value="1">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                    </div>
                    <br><? //} ?><br></div>
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="statistics_leave.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="text" placeholder="ค้นหา" name='txtKeyword' class="form-control" value="<?php echo $Search_word; ?>" >
                                    <input type='hidden' name='method'  value='txtKeyword'>
                                </div> <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Search</button> </td>


                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
                <?php

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    $urlfile = "statistics_leave.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
                        echo "<a  href='$urlfile?s_page=$pPrev" . $querystr . "' class='naviPN'>Prev</a>";
                    }
                    for ($i = $total_start_p; $i < $total_end_p; $i++) {
                        $nClass = ($chk_page == $i) ? "class='selectPage'" : "";
                        if ($e_page * $i <= $total) {
                            echo "<a href='$urlfile?s_page=$i" . $querystr . "' $nClass  >" . intval($i + 1) . "</a> ";
                        }
                    }
                    if ($chk_page < $total_p - 1) {
                        echo "<a href='$urlfile?s_page=$pNext" . $querystr . "'  class='naviPN'>Next</a>";
                    }
                }

              /*  if ($_SESSION[checkdate] == '') {

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION[Keywords] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keywords]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(w.amount)  from work w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_sick,
(select SUM(w.amount) from work w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_sick,
(SELECT COUNT(w.amount)  from work w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_leave,
(select SUM(w.amount) from work w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_leave,
(SELECT COUNT(w.amount)  from work w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_vacation,
(select SUM(w.amount) from work w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_vacation,
(SELECT COUNT(w.amount)  from work w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_maternity,
(select SUM(w.amount) from work w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_maternity,
(SELECT COUNT(w.amount)  from work w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_ordain,
(select SUM(w.amount) from work w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_ordain,
(SELECT COUNT(w.amount)  from work w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_educate,
(select SUM(w.amount) from work w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_educate,
(SELECT COUNT(w.amount)  from work w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_dribble,
(select SUM(w.amount) from work w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_dribble,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno) amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno) sum_t
from work w
RIGHT OUTER JOIN emppersonal e1 on w.enpid=e1.empno
INNER JOIN pcode p2 on e1.pcode=p2.pcode
         WHERE (e1.firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or e1.pid LIKE '%$Search_word%') and e1.status ='1'
         GROUP BY e1.empno
         order by e1.empno";
                    } else {
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(w.amount)  from work w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_sick,
(select SUM(w.amount) from work w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_sick,
(SELECT COUNT(w.amount)  from work w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_leave,
(select SUM(w.amount) from work w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_leave,
(SELECT COUNT(w.amount)  from work w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_vacation,
(select SUM(w.amount) from work w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_vacation,
(SELECT COUNT(w.amount)  from work w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_maternity,
(select SUM(w.amount) from work w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_maternity,
(SELECT COUNT(w.amount)  from work w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_ordain,
(select SUM(w.amount) from work w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_ordain,
(SELECT COUNT(w.amount)  from work w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_educate,
(select SUM(w.amount) from work w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_educate,
(SELECT COUNT(w.amount)  from work w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') amonut_dribble,
(select SUM(w.amount) from work w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N') sum_dribble,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno) amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno) sum_t
from work w
RIGHT OUTER JOIN emppersonal e1 on w.enpid=e1.empno
INNER JOIN pcode p2 on e1.pcode=p2.pcode
where e1.status ='1'
 GROUP BY e1.empno
         order by e1.empno";
                    }
                } else {*/
                if(!empty($_SESSION[check_date01]) and !empty($_SESSION[check_date02])){
                    $date01 = $_SESSION[check_date01];
                    $date02 = $_SESSION[check_date02];

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION[Keywords] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keywords]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_sick,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_sick,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_leave,
(select SUM(w.amount) from `work` w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_leave,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_vacation,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_vacation,
(SELECT COUNT(w.amount)  from `work` w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_maternity,
(select SUM(w.amount) from `work` w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_maternity,
(SELECT COUNT(w.amount)  from `work` w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_ordain,
(select SUM(w.amount) from `work` w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_ordain,
(SELECT COUNT(w.amount)  from `work` w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_educate,
(select SUM(w.amount) from `work` w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_educate,
(SELECT COUNT(w.amount)  from `work` w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_dribble,
(select SUM(w.amount) from `work` w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_dribble,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.datela between '$date01' and '$date02') amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.datela between '$date01' and '$date02') sum_t
from `work` w
RIGHT OUTER JOIN emppersonal e1 on w.enpid=e1.empno
INNER JOIN pcode p2 on e1.pcode=p2.pcode
         WHERE (e1.firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or e1.pid LIKE '%$Search_word%')
         GROUP BY e1.empno
         order by e1.empno";
                    } else {
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_sick,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_sick,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_leave,
(select SUM(w.amount) from `work` w where w.typela='2' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_leave,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_vacation,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_vacation,
(SELECT COUNT(w.amount)  from `work` w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_maternity,
(select SUM(w.amount) from `work` w where w.typela='4' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_maternity,
(SELECT COUNT(w.amount)  from `work` w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_ordain,
(select SUM(w.amount) from `work` w where w.typela='5' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_ordain,
(SELECT COUNT(w.amount)  from `work` w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_educate,
(select SUM(w.amount) from `work` w where w.typela='6' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_educate,
(SELECT COUNT(w.amount)  from `work` w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) amonut_dribble,
(select SUM(w.amount) from `work` w where w.typela='7' and e1.empno=w.enpid and w.statusla='Y' and w.regis_leave!='N' and ((w.begindate between '$date01' and '$date02') or (w.enddate between '$date01' and '$date02'))) sum_dribble,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.datela between '$date01' and '$date02') amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.datela between '$date01' and '$date02') sum_t
from `work` w
RIGHT OUTER JOIN emppersonal e1 on w.enpid=e1.empno
INNER JOIN pcode p2 on e1.pcode=p2.pcode
 GROUP BY e1.empno
         order by e1.empno";
                }}
               // }
                $qr = mysql_query($q);
                if ($qr == '') {
                    exit();
                }
                $total = mysql_num_rows($qr);

                $e_page = 30; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
                if (!isset($_GET['s_page'])) {
                    $_GET['s_page'] = 0;
                } else {
                    $chk_page = $_GET['s_page'];
                    $_GET['s_page'] = $_GET['s_page'] * $e_page;
                }
                $q.=" LIMIT " . $_GET['s_page'] . ",$e_page";
                $qr = mysql_query($q);
                if (mysql_num_rows($qr) >= 1) {
                    $plus_p = ($chk_page * $e_page) + mysql_num_rows($qr);
                } else {
                    $plus_p = ($chk_page * $e_page);
                }
                $total_p = ceil($total / $e_page);
                $before_p = ($chk_page * $e_page) + 1;
                echo mysql_error();
                ?>

                    <? include_once ('option/funcDateThai.php'); ?>
                แสดงคำที่ค้นหา : <?= $Search_word; ?>
                <br>
                <a class="btn btn-success" download="report_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br>
                <table align="center" width="100%" border="1" id="datatable">
                    <? if ($_SESSION[checkdate] == '1') { ?>
                        <tr>
                            <td colspan="18" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
<? } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="38" rowspan="2" align="center"><b>ลำดับ</b></td>
                        <td width="157" rowspan="2" align="center"><b>ชื่อ-นามสกุล</b></td>
                        <td colspan="2" align="center"><b>ลาป่วย</b></td>
                        <td colspan="2" align="center"><b>ลากิจ</b></td>
                        <td colspan="2" align="center"><b>ลาพักผ่อน</b></td>
                        <td colspan="2" align="center"><b>ลาคลอด</b></td>
                        <th colspan="2" align="center">ลาบวช</th>
                        <th colspan="2" align="center">ลาศึกษาต่อ</th>
                        <th colspan="2" align="center">ลาเลี้ยงดูบุตร</th>
                        <th colspan="2" align="center" bgcolor="#3399CC">ลาชั่วโมง</th>
                    </tr>
                    <tr align="center" bgcolor="#898888">
                        <td width="45" align="center">ครั้ง</td>
                        <td width="45" align="center">วัน</td>
                        <td width="45" align="center">ครั้ง</td>
                        <td width="45" align="center">วัน</td>
                        <td width="45" align="center">ครั้ง</td>
                        <td width="45" align="center">วัน</td>
                        <td width="45" align="center">ครั้ง</td>
                        <td width="45" align="center">วัน</td>
                        <td width="45" align="center">ครั้ง</td>
                        <td width="45" align="center">วัน</td>
                        <td width="45" align="center">ครั้ง</td>
                        <td width="45" align="center">วัน</td>
                        <td width="45" align="center">ครั้ง</td>
                        <td width="45" align="center">วัน</td>
                        <td width="45" align="center" bgcolor="#3399CC">ครั้ง</td>
                        <td width="45" align="center" bgcolor="#3399CC">ช.ม.</td>
                    </tr>

                    <?
                    $i = 1;
                    while ($result = mysql_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td><a href="detial_leave.php?id=<?= $result[empno]; ?>&method=check_page2"><?= $result[fullname]; ?></a></td>
                            <td align="center"><?= $result[amonut_sick]; ?></td>
                            <td align="center"><?= $result[sum_sick]; ?></td>
                            <td align="center"><?= $result[amonut_leave]; ?></td>
                            <td align="center"><?= $result[sum_leave]; ?></td>
                            <td align="center"><?= $result[amonut_vacation]; ?></td>
                            <td align="center"><?= $result[sum_vacation]; ?></td>
                            <td align="center"><?= $result[amonut_maternity]; ?></td>
                            <td align="center"><?= $result[sum_maternity]; ?></td>
                            <td align="center"><?= $result[amonut_ordain]; ?></td>
                            <td align="center"><?= $result[sum_ordain]; ?></td>
                            <td align="center"><?= $result[amonut_educate]; ?></td>
                            <td align="center"><?= $result[sum_educate]; ?></td>
                            <td align="center"><?= $result[amonut_dribble]; ?></td>
                            <td align="center"><?= $result[sum_dribble]; ?></td>
                            <td align="center"><?= $result[amonut_t]; ?></td>
                            <td align="center"><?= $result[sum_t]; ?></td>
                        </tr>
                    <? $i++;
                }
                ?>

                </table>
<?php
if ($total > 0) {
    echo mysql_error();
    ?><BR><BR>
                    <div class="browse_page">

                        <?php
                        // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                        page_navigator($before_p, $plus_p, $total, $total_p, $chk_page);

                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
                        echo $count = ceil($total / 30) . "&nbsp;<B>หน้า</B></font>";
                    }
                    ?> 
                </div>
            </div>
        </div>
    </div>

<? include 'footer.php'; ?>
