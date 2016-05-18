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
<form class="navbar-form navbar-left" role="form" action='prcleave.php' enctype="multipart/form-data" method='post' onsubmit="return confirm('กรุณายืนยันการยกเลิกอีกครั้ง !!!')">
    <?
        $empno=$_REQUEST[id];
        $Lno=$_REQUEST[Lno];
        
        $select_det=  mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,w.typela as typela,w.amount as amount,w.*
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        inner join work w on e1.empno=w.enpid
                                                        where e1.empno='$empno' and w.workid='$Lno'");
                            $detial_l= mysql_fetch_assoc($select_det);
    ?>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ยกเลิกการลา</h3>
                    </div>
                <div class="panel-body">
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
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l[leave_no];?></td></tr>
                        </thead>
                    </table><br>
                    <div class="form-group"> 
                <label>เหตุผลการยกเลิก &nbsp;</label>
                <TEXTAREA NAME="reason" id="reason"  class="form-control" placeholder="เหตุผลที่ยกเลิก" required ></TEXTAREA>
             	</div><br>
                    <div class="form-group">
                        <label>ใบยกเลิกการลา &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control"/>
                    </div><br><br>
                    <div class="form-group" align="center">
                        <input type="hidden" name="empno" value="<?=$empno?>">
                        <input type="hidden" name="Lno" value="<?=$Lno?>">
                        <input type="hidden" name="typela" value="<?=$detial_l[typela]?>">
                        <input type="hidden" name="amount" value="<?=$detial_l[amount]?>">
                        <input type="hidden" name="method" value="cancle_leave">
                        <input type="submit" name="sumit" value="ยกเลิก" class="btn btn-danger">
                    </div>   
                    </div>
              </div>
          </div>
</div>
</form> 