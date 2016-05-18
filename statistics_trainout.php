<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  สถิติการฝึกอบรมภายนอก </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการฝึกอบรมภายนอก</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางสถิติการฝึกอบรมภายนอกของบุคลากร</h3>
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
                            <input type="hidden" name="method" value="check_pro_trainout">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                    </div>
                    <br><? //} ?><br></div>
                <?php if($_SESSION[Status]=='ADMIN'){?>
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="statistics_trainout.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="text" placeholder="ค้นหา" name='txtKeyword' class="form-control" value="<?php echo $Search_word; ?>" >
                                    <input type='hidden' name='method'  value='Keyword_project'>
                                </div> <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Search</button> </td>


                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
                <?php }?>
                <?php

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    $urlfile = "statistics_trainout.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
        if($_SESSION[Status]=='ADMIN'){
            $code_inner="";
            $code_dep="";
        }elseif($_SESSION[Status]=='SUSER'){
            $code_inner="";
            $dep=$_SESSION[dep];
            $code_dep="and e1.depid='$dep'";
        }elseif($_SESSION[Status]=='USUSER'){
            $code_inner="inner join department d1 on d1.depId=e1.depid inner join department_group d2 on d2.main_dep=d1.main_dep";
            $mdep=$_SESSION[main_dep];
            $code_dep="and d1.main_dep='$mdep'";
        }       
include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
                if ($_SESSION[check_out] == '') {

                    if ($_POST[method] == 'Keyword_project') {
                        $_SESSION[Keyword_out] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keyword_out]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30') and tout.dt!='9' ) project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30') and tout.dt!='9' ) amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
         WHERE (e1.firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or e1.pid LIKE '%$Search_word%')  and e1.status ='1' and (p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30') and tout.dt!='9'
         GROUP BY e1.empno";
                    } else {
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30') and tout.dt!='9' ) project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30') and tout.dt!='9' ) amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
$code_inner
where e1.status ='1'  and (p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30') and tout.dt!='9' $code_dep
GROUP BY e1.empno";
                    }
                } else {
                    $date01 = $_SESSION[out_date1];
                    $date02 = $_SESSION[out_date2];

                    if ($_POST[method] == 'Keyword_project') {
                        $_SESSION[Keyword_out] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keyword_out]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
         WHERE (e1.firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or e1.pid LIKE '%$Search_word%') and tout.dt!='9' 
         GROUP BY e1.empno";
                    } else {
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
$code_inner
where  tout.dt!='9' $code_dep
 GROUP BY e1.empno";
                    }
                }
}else{
    if ($_SESSION[check_out] == '') {

                    if ($_POST[method] == 'Keyword_project') {
                        $_SESSION[Keyword_out] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keyword_out]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt!='9' ) project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt!='9' ) amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
         WHERE (e1.firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or e1.pid LIKE '%$Search_word%')  and e1.status ='1' and (p.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt!='9'
         GROUP BY e1.empno";
                    } else {
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt!='9' ) project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt!='9' ) amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
$code_inner
where e1.status ='1'  and (p.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt!='9' $code_dep
GROUP BY e1.empno";
                    }
                } else {
                    $date01 = $_SESSION[out_date1];
                    $date02 = $_SESSION[out_date2];

                    if ($_POST[method] == 'Keyword_project') {
                        $_SESSION[Keyword_out] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION[Keyword_out]);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
         WHERE (e1.firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or e1.pid LIKE '%$Search_word%') and tout.dt!='9' 
         GROUP BY e1.empno";
                    } else {
                        $q = "SELECT e1.empno as empno,  concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname,
(SELECT COUNT(p.idpo) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') project,
(SELECT SUM(p.amount) FROM plan_out p
inner join training_out tout on tout.tuid=p.idpo
WHERE p.empno=e1.empno  and p.status_out='Y'  and (p.begin_date between '$date01' and '$date02') and tout.dt!='9') amount
FROM emppersonal e1
LEFT OUTER JOIN plan_out p on e1.empno=p.empno
inner join training_out tout on tout.tuid=p.idpo
INNER JOIN pcode p2 on e1.pcode=p2.pcode
$code_inner
where  tout.dt!='9' $code_dep
 GROUP BY e1.empno";
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
                    <? if ($_SESSION[check_out] == 'check_pro_trainout') { ?>
                        <tr>
                            <td colspan="5" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
<? } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="16%" align="center"><b>ลำดับ</b></td>
                        <td width="40%" align="center"><b>ชื่อ-นามสกุล</b></td>
                        <td width="22%" align="center"><b>จำนวนโครงการ</b></td>
                        <td width="22%" align="center"><b>จำนวนชั่วโมง</b></td>
                    </tr>
                    <?php
                    $i = 1;
                    while ($result = mysql_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td><a href="detial_trainin.php?id=<?= $result[empno]; ?>&method=check&train=out"><?= $result[fullname]; ?></a></td>
                            <td align="center"><?= $result[project]; ?></td>
                            <td align="center"><?= $result[amount]*7; ?></td>
                        </tr>
                    <?php $i++;
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
