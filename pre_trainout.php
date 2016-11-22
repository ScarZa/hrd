<?php include 'header.php';if(isset($_GET['unset'])){ unset_session();}
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกการฝึกอบรมภายนอกหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกการฝึกอบรมภายนอกหน่วยงาน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบันทึกการฝึกอบรมภายนอกหน่วยงาน</h3>
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
                            <input type="hidden" name="method" value="check_trainout">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                    </div>
                    <br><br></div>
                <?php if($_SESSION[Status]=='ADMIN'){ ?>
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="pre_trainout.php" enctype="multipart/form-data">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="text" placeholder="ค้นหา" name='txtKeyword' class="form-control" value="<?php echo $_POST['txtKeyword']?>" >
                                    <input type='hidden' name='method'  value='txtKeyword'>
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
                    $urlfile = "pre_trainout.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
                if ($_SESSION['check_trainout'] == '') {

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION['txtKeyword'] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION['txtKeyword']);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
         WHERE (memberbook LIKE '%$Search_word%' or projectName LIKE '%$Search_word%') and  t.Beginedate  BETWEEN '$y-10-01' and '$Yy-09-30'
             GROUP BY t.tuid
         order by Beginedate desc";
                    } elseif($_SESSION[Status]=='USER') {
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
where (p.empno='".$_SESSION[user]."' or t.nameAdmin='".$_SESSION[user]."') and  (t.Beginedate  BETWEEN '$y-10-01' and '$Yy-09-30')
GROUP BY t.tuid 
order by Beginedate desc";
                    }elseif($_SESSION[Status]=='ADMIN'){
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
where t.Beginedate  BETWEEN '$y-10-01' and '$Yy-09-30'
GROUP BY t.tuid 
order by Beginedate desc";
                    }
                } else {
                    $date01 = $_SESSION['check_date01'];
                    $date02 = $_SESSION['check_date02'];

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION['txtKeyword'] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION['txtKeyword']);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
                                LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
                                where (Beginedate between '$date01' and '$date02') and (endDate between '$date01' and '$date02')
                                and (memberbook LIKE '%$Search_word%' or projectName LIKE '%$Search_word%')
                                GROUP BY t.tuid
                                order by Beginedate desc";
                    } elseif($_SESSION[Status]=='USER') {
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
                                LEFT OUTER JOIN plan_out p on t.tuid=p.idpo 
                                where (t.Beginedate between '$date01' and '$date02') and (t.endDate between '$date01' and '$date02') and (p.empno='".$_SESSION[user]."'
                                    or t.nameAdmin='".$_SESSION[user]."')
                                GROUP BY t.tuid                                 
                                order by Beginedate desc";
                    }elseif($_SESSION[Status]=='ADMIN'){
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
                                LEFT OUTER JOIN plan_out p on t.tuid=p.idpo 
                                where (t.Beginedate between '$date01' and '$date02') and (t.endDate between '$date01' and '$date02')
                                GROUP BY t.tuid                                 
                                order by Beginedate desc";
                    }
}}else{
if ($_SESSION['check_trainout'] == '') {

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION['txtKeyword'] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION['txtKeyword']);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
         WHERE (memberbook LIKE '%$Search_word%' or projectName LIKE '%$Search_word%') and  t.Beginedate  BETWEEN '$Y-10-01' and '$y-09-30'
             GROUP BY t.tuid
         order by Beginedate desc";
                    } elseif($_SESSION[Status]=='USER') {
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
where (p.empno='".$_SESSION[user]."' or t.nameAdmin='".$_SESSION[user]."') and  (t.Beginedate  BETWEEN '$Y-10-01' and '$y-09-30') 
GROUP BY t.tuid 
order by Beginedate desc";
                    }elseif($_SESSION[Status]=='ADMIN'){
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
where t.Beginedate  BETWEEN '$Y-10-01' and '$y-09-30'
GROUP BY t.tuid 
order by Beginedate desc";
                    }
                } else {
                    $date01 = $_SESSION['check_date01'];
                    $date02 = $_SESSION['check_date02'];

                    if ($_POST[method] == 'txtKeyword') {
                        $_SESSION['txtKeyword'] = $_POST[txtKeyword];
                    }
                    $Search_word = ($_SESSION['txtKeyword']);
                    if ($Search_word != "") {
//คำสั่งค้นหา
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count, p.status_out as status_out from training_out t 
                                LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
                                where (t.Beginedate between '$date01' and '$date02') and (t.endDate between '$date01' and '$date02')
                                and (memberbook LIKE '%$Search_word%' or projectName LIKE '%$Search_word%')
                                GROUP BY t.tuid
                                order by Beginedate desc";
                    } elseif($_SESSION[Status]=='USER') {
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count, p.status_out as status_out from training_out t 
                                LEFT OUTER JOIN plan_out p on t.tuid=p.idpo 
                                where (t.Beginedate between '$date01' and '$date02') and (t.endDate between '$date01' and '$date02') and (p.empno='".$_SESSION[user]."'
                                or t.nameAdmin='".$_SESSION[user]."') 
                                GROUP BY t.tuid                                 
                                order by Beginedate desc";
                    }elseif($_SESSION[Status]=='ADMIN'){
                        $q = "SELECT p.status_out, t.*,COUNT(p.empno) as count, p.status_out as status_out from training_out t 
                                LEFT OUTER JOIN plan_out p on t.tuid=p.idpo 
                                where (t.Beginedate between '$date01' and '$date02') and (t.endDate between '$date01' and '$date02')
                                GROUP BY t.tuid                                 
                                order by Beginedate desc";
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

                    <?php include_once ('option/funcDateThai.php'); ?>
                <?php if($_SESSION[Status]=='ADMIN'){ ?>
                แสดงคำที่ค้นหา : <?= $Search_word; ?>
                <?php }?>
                <table align="center" width="100%" border="1">
                    <?php if ($_SESSION['check_trainout'] == 'check_trainout') { ?>
                        <tr>
                            <td colspan="9" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
<?php } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="5%" align="center"><b>เลขที่หนังสือ</b></td>
                        <td width="30%" align="center"><b>โครงการ</b></td>
                        <td width="15%" align="center"><b>หน่วยงานผู้จัด</b></td>
                        <td width="15%" align="center"><b>วันที่จัด</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้เข้าร่วม</b></td>
                        <td width="6%" align="center"><b>บันทึก</b></td>
                        <td width="6%" align="center"><b>สถานะโครงการ</b></td>
                         <?php if($_SESSION[Status]=='ADMIN'){?>
                        <td width="6%" align="center"><b>สรุป</b></td>
                        <td width="6%" align="center"><b>แก้ไข</b></td>
                        <?php }  else {?>
                        <th align="center" width="7%">พิมพ์คำขอ</th>
                        <td width="6%" align="center"><b>สรุป</b></td>
                        <td width="6%" align="center"><b>สถานะการสรุป</b></td>                    
                         <?php }?>
                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysql_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><a href="#" onclick="return popup('pre_project_out.php?id=<?= $result[tuid]; ?>',popup,700,500);"><?= $result[memberbook]; ?></a>
                            </td>
                            <td><a href="#" onclick="return popup('pre_project_out.php?id=<?= $result[tuid]; ?>',popup,700,500);"><?= $result[projectName]; ?></a></td>
                            <td align="center"><?= $result[anProject]; ?></td>
                            <td align="center"><?= DateThai1($result[Beginedate]);?> <b>ถึง</b> <?= DateThai1($result[endDate]);?></td>
                            <td align="center"><?= $result[count]; ?></td>
                            <td align="center"><a href="add_trainout.php?id=<?= $result[tuid]; ?>"><img src='images/save_add.png' width='30'></a></td>
                            <td align="center">
                           <?php if($result['hboss']=='W'){ ?>
                            <a href="#" onClick="return popup('pre_project_out.php?id=<?= $result[tuid]; ?>',popup,700,500);" title="รออนุมัติ"><i class="fa fa-spinner fa-spin"></i></a>
                            <?php } elseif ($result['hboss']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['hboss']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                                        </td>
                                <?php if($_SESSION[Status]=='ADMIN'){?>
                            <td align="center"><a href="pre_person_trainout.php?id=<?= $result[tuid]; ?>"><img src='images/Sum.png' width='30'></a></td>
                            <td align="center"><a href="add_project_out.php?method=edit&&id=<?=$result['tuid'];?>"><img src='images/tool.png' width='30'></a></td>
                            <?php }else{?>
                            <td align="center">
                                    <?php if(empty($result['status_out'])){ echo '...';}else {?>
                                    <a href="#" onclick="return popup('approval_page1.php?id=<?=$_SESSION[user]?>&&pro_id=<?=$result['tuid']?>',popup,700,900);">หน้า1</a>.,.
                                    <a href="#" onclick="return popup('approval_page2.php?id=<?=$_SESSION[user]?>&&pro_id=<?=$result['tuid']?>',popup,700,900);">หน้า2</a>
                            <?php }?>
                            </td>
                            <td align="center"><a href="pre_person_trainout.php?id=<?= $result[tuid]; ?>"><img src='images/Sum.png' width='30'></a></td>
                            <td align="center">
                            <?php if($result['status_out']!='Y'){ ?>
                                <i class="fa fa-2x fa-spinner fa-spin" title="รอการสรุป"></i>
                            <?php }  elseif ($result['status_out']=='Y') {?>
                            <img src="images/Symbol_-_Check.ico" width="20"  title="สรุปแล้ว">
                            <?php }?>
                            </td>
                            <?php }?>
                            
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

<?php include 'footer.php'; ?>
