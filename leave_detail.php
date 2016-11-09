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
<?php
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
                            $select_det=  mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,w.*
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        INNER JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join posid p2 on wh.posid=p2.posId
                                                        inner join work w on e1.empno=w.enpid
                                                        where e1.empno='$empno' and w.workid='$Lno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
                            $detial_l= mysql_fetch_assoc($select_det);
                            $idAdmin=$detial_l[idAdmin];
                            $select_admin=mysql_query("select concat(e.firstname,' ',e.lastname) as adminname
                                                        from emppersonal e
                                                        inner join work w on e.empno=w.idAdmin
                                                        where w.idAdmin='$idAdmin'");
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
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[leave_no];?></td>
              </tr>
              <tr><td align="right"><b>วันที่เขียนใบลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l[reg_date]);?></td>
              </tr>
              <tr>
                  <td align="right"><b>ประเภทการลา : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?php	$sql = mysql_query("SELECT *  FROM typevacation where idla='$detial_l[typela]'  ");
				 $result = mysql_fetch_assoc( $sql );
                                echo $result[nameLa];
				 ?>
                  </td>
              </tr>
              <tr><td align="right"><b>วันที่ลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l[begindate]);?> <b>ถึง</b> <?=DateThai1($detial_l[enddate]);?></td>
              </tr>
              <tr>
                <td align="right"><b>รวมจำนวน : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[amount];?>&nbsp; <b>วัน</b></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เหตุผลการลา : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[abnote];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>สถานที่ติดต่อ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[address];?></td>
              </tr>
              <tr>
                <td align="right"><B>เบอร์ทรศัพท์ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[tel];?></td>
              </tr>
              <tr>
                <td align="right"><b>ใบรับรองแพทย์ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <? 
                    if($detial_l[check_comment]==1){
                        echo '-';
                    }elseif ($detial_l[check_comment]==2) {
                        echo 'มี';  
                      }elseif ($detial_l[check_comment]==3) {
                        echo 'ไม่มี';
                      }
?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>หมายเหตุ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l[comment];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>ผู้บันทึก : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_admin[adminname];?></td>  
              </tr>
              <tr>
                <td align="right" valign="top"><b>วันที่ลงทะบียนรับ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?php if(!empty($detial_l[regis_date])) { echo DateThai1($detial_l[regis_date]);}?></td>    
              </tr>
                        </thead>
              </table><br>
                        <?if($_SESSION[Status]=='ADMIN'){?>
                        <div class="form-group">
                    <input type="hidden" name="Lno" value="<?=$Lno;?>">
                    <input type="hidden" name="id" value="<?=$empno;?>">
                        
                    <input class="btn btn-danger" type="submit" name="submit" value="ยกเลิกใบลา">
                    </div>
                        <?}else{?>
                                                          <div class="form-group">
                        <center><a href="#" class="btn btn-warning" onclick="javascript:window.close();">ปิดหน้าต่าง</a></center>
                    </div>

                        <?}?>
                    </div>
                                        
                     </div>
                  </div>
              </div>
    </div>
</form>

<?include 'footer.php';?>