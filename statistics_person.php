<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'><img src='images/kchart.ico' width='75'>  สถิติบุคลากรแยกตามหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติบุคลากรแยกตามหน่วยงาน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='images/kchart.ico' width='25'> ตารางสถิติของบุคลากรแยกตามหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <?php if($_SESSION[Status]=='ADMIN'){?>
              <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="statistics_person.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
 				<select name="dep" id="dep"  class="form-control"  onkeydown="return nextbox(event, 'line');"> 
				<?php	$sql = mysql_query("SELECT *  FROM department order by depId");
				 echo "<option value=''>--เลือกหน่วยงาน--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
  				 echo "<option value='$result[depId]' $selected>$result[depName] </option>";
				 } ?>
			 </select></div> 
                                <input type="hidden"   name='method' class="form-control" value='Lperson_dep' >
                                <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> ตกลง</button> </td>


                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>

                <?php }

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    $depno=$_REQUEST[dep];
                    $urlfile = "statistics_person.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
                                ?>  
                                <a  href="<?= $urlfile ?>?s_page=<?= $pPrev . $querystr ?>&&dep=<?= $depno; ?>&&method=Lperson_dep" class="naviPN">Prev</a>
                            <?php
                            }
                            for ($i = $total_start_p; $i < $total_end_p; $i++) {
                                $nClass = ($chk_page == $i) ? "class='selectPage'" : "";
                                if ($e_page * $i <= $total) {
                                    ?>
                                    <a href="<?= $urlfile; ?>?s_page=<?= $i . $querystr; ?>&&dep=<?= $depno; ?>&&method=Lperson_dep" <?= $nClass; ?>  ><?= intval($i + 1); ?></a>  
                                <?php
                                }
                            }
                            if ($chk_page<$total_p-1) {
                                ?>
                                <a href="<?= $urlfile ?>?s_page=<?= $pNext . $querystr ?>&&dep=<?= $depno; ?>&&method=Lperson_dep"  class="naviPN">Next</a>
                            <?php
                            }
                        }
                         if($_SESSION[Status]=='ADMIN'){
                if($_REQUEST[method]=='Lperson_dep'){ 
               $depno=$_REQUEST[dep];
               $code_mdep2="and e.depid='$depno'";
                }else{$depno='';}
                         }elseif ($_SESSION[Status]=='SUSER') {
                             $depno=$_SESSION[dep];
                             $code_mdep2="and e.depid='$depno'";
}elseif ($_SESSION[Status]=='USUSER') {
    $code_mdep1="inner join department d1 on d1.depId=e.depid inner join department_group d2 on d2.main_dep=d1.main_dep";
     $depno=$_SESSION[dep];
     $mdepno=$_SESSION[main_dep];
     $code_mdep2="and d1.main_dep='$mdepno'";
}
                if($depno!=''){
                $q="SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,p1.posname as position ,e1.TypeName as type,e.empno as empno, e.pid as pid
FROM emppersonal e
LEFT OUTER JOIN pcode p ON e.pcode=p.pcode
LEFT OUTER JOIN emptype  e1 ON e1.EmpType=e.emptype
LEFT OUTER JOIN posid p1 ON p1.posId=e.posid
$code_mdep1
WHERE e.status='1' $code_mdep2
ORDER BY position";
                if($_SESSION[Status]!='ADMIN'){
             if ($_SESSION[Status]=='SUSER') {   
                $sql_dep=  mysql_query("select depName as name from department where depId='$depno'");
             }elseif ($_SESSION[Status]=='USUSER') {
                 $sql_dep=  mysql_query("select dep_name as name from department_group where main_dep='$mdepno'");
             }   
$depname = mysql_fetch_assoc($sql_dep);
                }}
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
                 <table align="center" width="100%" border="1">
                    <?php if ($_REQUEST[method]=='Lperson_dep') { ?>
                        <tr>
                            <td colspan="5" align="center"><?= $depname[name]?></td>
                        </tr>
<?php } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="22" align="center"><b>ลำดับ</b></td>
                        <td width="22" align="center"><b>เลขที่</b></td>
                        <td width="22" align="center"><b>ชื่อ-นามสกุล</b></td>
                        <td width="45" align="center"><b>ตำแหน่ง</b></td>
                        <td width="21" align="center"><b>ประเภทพนักงาน</b></td>
                        
                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysql_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= $result[pid]?></td>
                             <td><a href="#" onClick="window.open('detial_person.php?id=<?=$result[empno]?>','','width=700,height=500'); return false;" title="Code PHP Popup">
                              <?= $result[fullname]; ?></a></td>
                            <td align="center"><?= $result[position]; ?></td>
                            <td align="center"><?= $result[type]; ?></td>
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
