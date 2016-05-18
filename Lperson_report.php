<?php include 'header.php';?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
 <div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'><img src='images/kchart.ico' width='75'>  รายงานแสดงการลาของบุคลากรแยกหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการลาของของของบุคลากรหน่วยงาน</li>
        </ol>
    </div>
</div>
 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='images/kchart.ico' width='25'> ตารางสถิติการลาของของบุคลากรหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
<form method="post" action="session.php" enctype="multipart/form-data" class="navbar-form navbar-right">
            <div class="form-group">
             <input type="date"   name='take_date01' class="form-control" value='' >
            </div>
            <div class="form-group">
              <input type="date"   name='take_date02' class="form-control" value='' >
            </div> 
                <input type="hidden"   name='method' class="form-control" value='Lperson_date' >
			<button type="submit" class="btn btn-success">ตกลง</button>

                                           
</form></div> <br><br></div>
                  <?php if($_SESSION[Status]=='ADMIN' or $_SESSION[Status]=='USUSER'){?>
                        <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="session.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
 				<select name="dep" id="dep"  class="form-control"  onkeydown="return nextbox(event, 'line');"> 
				<?php
                                if($_SESSION[Status]=='USUSER'){
                                    $mdep=$_SESSION[main_dep];
                                    $code="where main_dep='$mdep'";
                                }else{
                                    $code="";
                                }
                                $sql = mysql_query("SELECT *  FROM department $code order by depId");
				 echo "<option value=''>--เลือกฝ่ายงาน--</option>";
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
                  <?php }?>

 <?php         
   		$take_date1=$_SESSION[Lperson_date1];
                $take_date2=$_SESSION[Lperson_date2];
                include_once ('option/funcDateThai.php');
		$take_rec_date= "$result[take_rec_date]";
		DateThai1($take_date1); //-----แปลงวันที่เป็นภาษาไทย
		DateThai2($take_date2); //-----แปลงวันที่เป็นภาษาไทย
               
                if($_SESSION[Status]=='ADMIN' or $_SESSION[Status]=='USUSER'){
               if($_SESSION[dep_Lperson]=='Lperson_dep'){ 
               $depno=$_REQUEST[depname];}else{$depno='';}
                }elseif ($_SESSION[Status]=='SUSER') {
                    $depno=$_SESSION[dep];
                }
                if($take_date1!='' and $depno!=''){  
$sql=mysql_query("SELECT CONCAT(e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1'and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_sick,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_sick,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_leave,
(select SUM(w.amount) from `work`w where w.typela='2' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_leave,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_vacation,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_vacation,
(SELECT COUNT(w.amount)  from `work` w where w.typela='4' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_maternity,
(select SUM(w.amount) from `work` w where w.typela='4' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_maternity,
(SELECT COUNT(w.amount)  from `work` w where w.typela='5' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_ordain,
(select SUM(w.amount) from `work` w where w.typela='5' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_ordain,
(SELECT COUNT(w.amount)  from `work` w where w.typela='6' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_educate,
(select SUM(w.amount) from `work` w where w.typela='6' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_educate,
(SELECT COUNT(w.amount)  from `work` w where w.typela='7' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_dribble,
(select SUM(w.amount) from `work` w where w.typela='7' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_dribble,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.depId='$depno' and t.datela between '$take_date1' and '$take_date2' and e1.status ='1') amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.depId='$depno'and t.datela between '$take_date1' and '$take_date2' and e1.status ='1') sum_t
from emppersonal e1
LEFT OUTER JOIN `work` w on w.depId=e1.depid
LEFT OUTER JOIN department d on w.depId=d.depId
where w.statusla='Y' and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and e1.status ='1'
GROUP BY e1.empno
order by e1.empno");	
$sql_dep=  mysql_query("select depName as name from department where depId='$depno'");
$depname = mysql_fetch_assoc($sql_dep);

}elseif($depno!=''){
    include 'option/function_date.php';
    if($date >= $bdate and $date <= $edate){
                             $y= $Yy;
                             $Y= date("Y");
                             $take_date1="$Y-10-01";
                             $take_date2="$y-09-30";
    $sql=mysql_query("SELECT CONCAT(e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1'and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_sick,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_sick,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_leave,
(select SUM(w.amount) from `work`w where w.typela='2' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_leave,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_vacation,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_vacation,
(SELECT COUNT(w.amount)  from `work` w where w.typela='4' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_maternity,
(select SUM(w.amount) from `work` w where w.typela='4' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_maternity,
(SELECT COUNT(w.amount)  from `work` w where w.typela='5' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_ordain,
(select SUM(w.amount) from `work` w where w.typela='5' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_ordain,
(SELECT COUNT(w.amount)  from `work` w where w.typela='6' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_educate,
(select SUM(w.amount) from `work` w where w.typela='6' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_educate,
(SELECT COUNT(w.amount)  from `work` w where w.typela='7' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') amonut_dribble,
(select SUM(w.amount) from `work` w where w.typela='7' and e1.empno=w.enpid and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and e1.status ='1') sum_dribble,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.depId='$depno' and t.datela between '$take_date1' and '$take_date2' and e1.status ='1') amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno and t.depId='$depno'and t.datela between '$take_date1' and '$take_date2' and e1.status ='1') sum_t
from emppersonal e1
LEFT OUTER JOIN `work` w on w.depId=e1.depid
LEFT OUTER JOIN department d on w.depId=d.depId
where w.statusla='Y' and e1.depid='$depno' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and e1.status ='1'
GROUP BY e1.empno
order by e1.empno");

$sql_dep=  mysql_query("select depName as name from department where depId='$depno'");
$depname = mysql_fetch_assoc($sql_dep);
}}


?>

<!-- <H1>จำนวนการรายงานความเสี่ยงของหน่วยงาน</H1> -->
<br><br>
<div class="table-responsive">
    <a class="btn btn-success" download="report_dep_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
<table  id="datatable" align="center" width="100%" border="1">
    <?php if ($_SESSION[check_Lperson]=='Lperson_date') { ?>
                        <tr>
                            <td colspan="18" align="center">ตั้งแต่วันที่ <?= DateThai1($take_date1); ?> ถึง <?= DateThai2($take_date2); ?></td>
                        </tr>
<?php } ?>
                        <tr>
                            <td colspan="18" align="center"><?= $depname[name];?></td>
                        </tr>
<tr align="center" bgcolor="#898888">
                        <td width="3%" rowspan="2" align="center"><b>ลำดับ</b></td>
                        <td width="15%" rowspan="2" align="center"><b>ชื่อ-นามสกล</b></td>
                        <td width="10.25%" colspan="2" align="center"><b>ลาป่วย</b></td>
                        <td width="10.25%" colspan="2" align="center"><b>ลากิจ</b></td>
                        <td width="10.25%" colspan="2" align="center"><b>ลาพักผ่อน</b></td>
                        <td width="10.25%" colspan="2" align="center"><b>ลาคลอด</b></td>
                        <th width="10.25%" colspan="2" align="center">ลาบวช</th>
                        <th width="10.25%" colspan="2" align="center">ลาศึกษาต่อ</th>
                        <th width="10.25%" colspan="2" align="center">ลาเลี้ยงดูบุตร</th>
                        <th width="10.25%" colspan="2" align="center" bgcolor="#3399CC">ลาชั่วโมง</th>
                    </tr>
                    <tr align="center" bgcolor="#898888">
                        <td width="5.1%" align="center">ครั้ง</td>
                        <td width="5.1%" align="center">วัน</td>
                        <td width="5.1" align="center">ครั้ง</td>
                        <td width="5.1%" align="center">วัน</td>
                        <td width="5.1%" align="center">ครั้ง</td>
                        <td width="5.1%" align="center">วัน</td>
                        <td width="5.1%" align="center">ครั้ง</td>
                        <td width="5.1%" align="center">วัน</td>
                        <td width="5.1%" align="center">ครั้ง</td>
                        <td width="5.1%" align="center">วัน</td>
                        <td width="5.1%" align="center">ครั้ง</td>
                        <td width="5.1%" align="center">วัน</td>
                        <td width="5.1%" align="center">ครั้ง</td>
                        <td width="5.1%" align="center">วัน</td>
                        <td width="5.1%" align="center" bgcolor="#3399CC">ครั้ง</td>
                        <td width="5.1%" align="center" bgcolor="#3399CC">ช.ม.</td>
                    </tr>

 
 
 <?php         
 
	

                    $i = 1;
                    while ($result = mysql_fetch_assoc($sql)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td><a href="detial_leave.php?id=<?= $result[empno]; ?>&method=check_page&depno=<?=$depno?>"><?= $result[fullname]; ?></a></td>
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
                    <?php $i++;
                }
                ?>
</TABLE>

</div></div>	</div>	</div>	
      <?PHP include'footer.php';  ?>
 						