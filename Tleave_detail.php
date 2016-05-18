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
<script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
<script type="text/javascript">
		function popup(url,name,windowWidth,windowHeight){    
				myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
				mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
				properties = "width="+windowWidth+",height="+windowHeight;
				properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
				window.open(url,name,properties);
	}
</script>
    </head>
    <body>

<?
    $empno=$_REQUEST[id];
    $Lno=$_REQUEST[Lno];
?>
<form class="navbar-form" role="form" action='cancle_leave.php' enctype="multipart/form-data" method='post'>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">รายละเอียดใบลาของบุคลากร</h3>
                    </div>
                <div class="panel-body" align="center">
                    <div class="form-group" align="center">
                        <?php include_once ('option/funcDateThai.php');
                            $select_det=  mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,t.*
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        inner join timela t on e1.empno=t.empno
                                                        where e1.empno='$empno' and t.id='$Lno'");
                            $detial_l= mysql_fetch_assoc($select_det);
                            $idAdmin=$detial_l[idAdmin];
                            $select_admin=mysql_query("select concat(e.firstname,' ',e.lastname) as adminname
                                                        from emppersonal e
                                                        inner join timela t on e.empno=t.idAdmin
                                                        where t.idAdmin='$idAdmin'");
                            $detial_admin= mysql_fetch_assoc($select_admin);
                        ?>
                        <table align="center" width='100%'>
                        <thead>
              <tr>
                  <td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<?=$detial_l[fullname];?></td>
              </tr>
              <tr>
                  <td align="right"><b>ฝ่าย-งาน : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l[dep];?></td></tr>
              <tr>
                  <td align="right"><b>ตำแหน่ง : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l[posi];?></td></tr>
              <tr>
                <td align="right"><b>เลขที่ใบลา : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[idno];?></td>
              </tr>
              <tr><td align="right"><b>วันที่เขียนใบลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l[vstdate]);?></td>
              </tr>
              <tr>
                  <td align="right"><b>วันที่ลา : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l[datela]);?></td>
              </tr>
              <tr>
                <td align="right"><b>ช่วงเวลาที่ลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=$detial_l[starttime];?> <b>ถึง</b> <?=$detial_l[endtime];?></td>
              </tr>
              <tr>
                <td align="right"><b>รวมจำนวน : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[total];?>&nbsp; <b>ชั่วโมง</b></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เหตุผลการลา : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[comment];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>ผู้บันทึก : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_admin[adminname];?></td>  
              </tr>
              <tr>
                <td align="right" valign="top"><b>วันที่ลงทะเบียนรับ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?php if(!empty($detial_l['regis_date'])){ echo DateThai1($detial_l['regis_date']);}?></td>  
              </tr>
              </thead>
              </table><br>
                                  <div class="form-group">
                        <center><a href="#" class="btn btn-warning" onclick="javascript:window.close();">ปิดหน้าต่าง</a></center>
                    </div>
          
                    </div>
                     </div>
                  </div>
              </div>
    </div>
</form>

<?include 'footer.php';?>