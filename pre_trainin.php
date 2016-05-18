<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกการฝึกอบรมภายในหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกการฝึกอบรมภายในหน่วยงาน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบันทึกการฝึกอบรมภายในหน่วยงาน</h3>
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
                            <input type="hidden" name="method" value="check_trainin">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                    </div>
                    <br><? //} ?><br></div>
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="pre_trainin.php">
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
                    $urlfile = "pre_trainin.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
                if ($_SESSION[check_trainin] == '') {

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION[Keywords_train] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keywords_train]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT * from trainingin 
         WHERE (in1 LIKE '%$Search_word%' or in2 LIKE '%$Search_word%') and dateBegin BETWEEN '$y-10-01' and '$Yy-09-30'
         order by dateBegin desc";
                    } else {
                        $q = "SELECT * from trainingin where dateBegin BETWEEN '$y-10-01' and '$Yy-09-30' order by dateBegin desc";
                    }
                } else {
                    $date01 = $_SESSION[trainin_date1];
                    $date02 = $_SESSION[trainin_date2];

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION[Keywords_train] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keywords_train]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT * from trainingin 
                                where (dateBegin between '$date01' and '$date02') and (dateEnd between '$date01' and '$date02')
                                    and (in1 LIKE '%$Search_word%' or in2 LIKE '%$Search_word%')
                                order by dateBegin desc ";
                    } else {
                        $q = "SELECT * from trainingin  
                                where (dateBegin between '$date01' and '$date02') and (dateEnd between '$date01' and '$date02')
                                order by dateBegin desc";
                    }
                }
}else{
                    if ($_SESSION[check_trainin] == '') {

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION[Keywords_train] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keywords_train]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT * from trainingin 
         WHERE (in1 LIKE '%$Search_word%' or in2 LIKE '%$Search_word%') and dateBegin BETWEEN '$Y-10-01' and '$y-09-30'
         order by dateBegin desc";
                    } else {
                        $q = "SELECT * from trainingin where dateBegin BETWEEN '$Y-10-01' and '$y-09-30' order by dateBegin desc";
                    }
                } else {
                    $date01 = $_SESSION[trainin_date1];
                    $date02 = $_SESSION[trainin_date2];

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION[Keywords_train] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keywords_train]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT * from trainingin 
                                where (dateBegin between '$date01' and '$date02') and (dateEnd between '$date01' and '$date02')
                                    and (in1 LIKE '%$Search_word%' or in2 LIKE '%$Search_word%')
                                order by dateBegin desc ";
                    } else {
                        $q = "SELECT * from trainingin  
                                where (dateBegin between '$date01' and '$date02') and (dateEnd between '$date01' and '$date02')
                                order by dateBegin desc";
                    }
                }
}
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
                <table align="center" width="100%" border="1">
                    <? if ($_SESSION[check_trainin] == 'check_trainin') { ?>
                        <tr>
                            <td colspan="19" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
<? } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="5%" align="center"><b>ลำดับ</b></td>
                        <td width="45%" align="center"><b>ชื่อโครงการ</b></td>
                        <td width="19%" align="center"><b>หน่วยงานผู้จัด</b></td>
                        <td width="19%" align="center"><b>วันที่จัด</b></td>
                        <td width="6%" align="center"><b>บันทึก</b></td>
                        <td width="6%" align="center"><b>แก้ไข</b></td>
                    </tr>

                    <?
                    $i = 1;
                    while ($result = mysql_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td><a href="#" onclick="return popup('pre_project.php?id=<?= $result[idpi]; ?>',popup,700,500);"><?= $result[in2]; ?></a></td>
                            <td align="center"><?= $result[in3]; ?></td>
                            <td align="center"><?= DateThai1($result[dateBegin]);?> <b>ถึง</b> <?= DateThai1($result[dateEnd]);?></td>
                            <td align="center"><a href="add_trainin.php?id=<?=$result[idpi];?>"><img src='images/save_add.png' width='30'></a></td>
                            <td align="center"><a href="add_project.php?method=edit&&id=<?=$result[idpi];?>"><img src='images/tool.png' width='30'></a></td>
                            
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
