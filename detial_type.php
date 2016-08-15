<?php @session_start(); ?>
<?php include 'connection/connect.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
        <LINK REL="SHORTCUT ICON" HREF="images/logo.png">
        <!-- Bootstrap core CSS -->
        <link href="option/css/bootstrap.css" rel="stylesheet">
        <!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
        <!-- Add custom CSS here -->
        <link href="option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="option/css/stylelist.css">
        <script src="option/js/excellentexport.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading" align="center">
                        <h3 class="panel-title">ข้อมูลบุคลากร</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                         $date_total=$_POST['date_total'];
                         if(empty($date_total)){
                             $code='';
                         }  else {
                             $code="and (e.dateBegin BETWEEN '1947-01-01' AND '$date_total' AND (e.dateEnd > '$date_total' or e.dateEnd='0000-00-00'))";
                         }
                            $sql=  mysql_query("SELECT COUNT(e.empno) AS sum,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='1' and e.status='1' $code) d1,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='2' and e.status='1' $code) d2,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='3' and e.status='1' $code) d3,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='4' and e.status='1' $code) d4,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='5' and e.status='1' $code) d5,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='6' and e.status='1' $code) d6,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='7' and e.status='1' $code) d7
FROM emppersonal e
INNER JOIN emptype e2 on e.emptype=e2.EmpType
where e.status='1' $code");
                            $detial_type=  mysql_fetch_assoc($sql);
                            
                            
                        ?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td colspan="2" align="center" valign="middle"><h4><b>ประเภทของพนักงานในองค์กร</b></h4></td>
                          </tr>
                          <tr>
                              <td align="right" valign="middle" width="50%"><b><a href="detial_emptype.php?emptype=1">ข้าราชการ : </a></b></td>
                            <td align="left" valign="middle"width="50%"><b> <font color="red">&nbsp; <?=$detial_type[d1]?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=2">ลูกจ้างประจำ : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type[d2]?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=3">พนักงานราชการ : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type[d3]?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=4">พกส. : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type[d4]?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=5">ลูกจ้างชั่วคราวรายเดือน : </a></a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type[d5]?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=6">ลูกจ้างชั่วคราวรายวัน : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type[d6]?></font> คน</b></td>
                          </tr>
                          <tr>
                              <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=7">นักศึกษาฝึกงาน : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type[d7]?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b>รวม : </b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type[sum]?></font> คน</b></td>
                          </tr>
                      </table>
                       
                        <form class="navbar-form navbar-right" name="frmdate" role="date" method="post" action="detial_type.php">
                            <div class="col-lg-6">
                                <b>ยอดบุคลากรในแต่ละเดือน</b><br> 
    <div class="input-group">
      <input type="date" name="date_total" placeholder="เลือกวันที่" class="form-control">
      <span class="input-group-btn">
          <button class="btn btn-success" type="submit">ตกลง</button>
      </span>
    </div><!-- /input-group -->
  </div>
                        </form>
                        <?php
                        include 'option/funcDateThai.php';
                        
                        if(!empty($date_total)) {
                            $total=  mysql_query("SELECT COUNT(empno) as total FROM emppersonal  
WHERE status='1' and (dateBegin BETWEEN '1947-01-01' AND '$date_total' AND (dateEnd > '$date_total' or dateEnd='0000-00-00'))");
                       $total_person=  mysql_fetch_assoc($total);
                        ?>
                        <center><b>วันที่ <?= DateThai2($date_total)?> มีบุคลากรทั้งหมด <font color="red"><?= $total_person['total']?></font> คน</b></center>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
<?php include 'footer.php'; ?>