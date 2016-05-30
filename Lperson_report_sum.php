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
                        <form method="post" action="Lperson_report_sum.php" enctype="multipart/form-data" class="navbar-form navbar-right">
            <div class="form-group">
                <select name="month" id="month"  class="form-control" required=""> 
				<?php	$sql = mysql_query("SELECT month_id, month_name FROM month order by m_id");
				 echo "<option value=''>--เลือกเดือน--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
  				 echo "<option value='".$result['month_id']."' $selected>".$result['month_name']." </option>";
				 } ?>
			 </select>
            </div> 
    <div class="form-group">
        <select name="dep" id="dep"  class="form-control"  required=""> 
                <?php $screen=$_REQUEST['screen'];
            if($screen=='1'){	$sql = mysql_query("SELECT *  FROM department order by depId");
				 echo "<option value=''>--เลือกฝ่ายงาน--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
  				 echo "<option value='$result[depId]' $selected>$result[depName] </option>";
				 }}else {
                                     $sql = mysql_query("SELECT *  FROM emptype order by EmpType");
				 echo "<option value=''>--เลือกประเภทบุคลากร--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
  				 echo "<option value='".$result['EmpType']."' $selected>".$result['TypeName']." </option>";
				 }
            }?>
			 </select>
    </div> 
                <input type="hidden"   name='method' class="form-control" value='Lperson_date' >
                <input type="hidden"   name='screen' class="form-control" value='<?= $screen?>' >
			<button type="submit" class="btn btn-success">ตกลง</button>

                                           
</form></div> <br><br></div>

 <?php         
                include 'option/funcDateThai.php';
                include 'option/function_date.php';
    if($date >= $bdate and $date <= $edate){
                $take_month=$_POST['month'];
                $depno=$_POST['dep'];
                       
               
                             $y= $Yy;
                             $Y= date("Y");
                             $take_month1="$Y-$take_month-01";
                             if($take_month=='4' or $take_month=='6' or $take_month=='9' or $take_month=='11'){
                               $take_month2="$Y-$take_month-30";  
                             }elseif ($take_month=='2') {
                               $take_month2="$Y-$take_month-29"; 
                            }else{
                             $take_month2="$Y-$take_month-31";
                            }
                             $take_date1="$Y-10-01";
                             $take_date2="$y-09-30";
    }  else {
                $take_month=$_POST['month'];
                $depno=$_POST['dep'];
                
                if($take_month=='1' or $take_month=='2' or $take_month=='3' or $take_month=='4' or $take_month=='5' or $take_month=='6' or $take_month=='7' or $take_month=='8' or $take_month=='9'){
                 $this_year=$y;
                 $ago_year=$Y;
                  $take_month1="$this_year-$take_month-01";
                   if($take_month=='4' or $take_month=='6' or $take_month=='9'){
                               $take_month2="$this_year-$take_month-30";  
                             }elseif ($take_month=='2') {
                               $take_month2="$this_year-$take_month-29"; 
                            }else{
                             $take_month2="$this_year-$take_month-31";
                            }
                             $take_date1="$ago_year-10-01";
                             $take_date2="$this_year-09-30";
                }  elseif($take_month=='10' or $take_month=='11' or $take_month=='12') {
                 $this_year=$y;
                 $ago_year=$Y;
                 $next_year=$Yy;
                  $take_month1="$ago_year-$take_month-01";
                   if($take_month=='11'){
                               $take_month2="$ago_year-$take_month-30";  
                             }else{
                             $take_month2="$ago_year-$take_month-31";
                            }
                             $take_date1="$ago_year-10-01";
                             $take_date2="$this_year-09-30";
                }  else {
                 $this_year=$y;
                 $ago_year=$Y;   
                }
    }  
    if($screen=='1'){
        $code1="e1.depid='$depno'";
        $code2="LEFT OUTER JOIN department d on w.depId=d.depId";
        $code3="t.depId='$depno'";
        $code4="select depName as name from department where depId='$depno'";
    }  else {
        $code1="e1.emptype='$depno'";
        $code2="LEFT OUTER JOIN emptype e2 on e1.emptype=e2.EmpType";
        $code3="e1.emptype='$depno'";
        $code4="select TypeName as name from emptype where EmpType='$depno'";
}
    $sql=mysql_query("SELECT CONCAT(e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno, ld.L3,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1'and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_sick,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_sick,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_leave,
(select SUM(w.amount) from `work`w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_leave,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_vacation,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_vacation,
(SELECT COUNT(w.amount)  from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_maternity,
(select SUM(w.amount) from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_maternity,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1'and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_sick_total,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_sick_total,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_leave_total,
(select SUM(w.amount) from `work`w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_leave_total,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_vacation_total,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_vacation_total,
(SELECT COUNT(w.amount)  from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_maternity_total,
(select SUM(w.amount) from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_maternity_total,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno and $code3 and t.datela between '$take_date1' and '$take_month2' and e1.status ='1') amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno and $code3 and t.datela between '$take_date1' and '$take_month2' and e1.status ='1') sum_t,
(SELECT SUM(w.amount) FROM `work` w WHERE $code1 and e1.empno=w.enpid and w.typela='3' and ((w.begindate between '$take_date1' and '$take_date2') or  (w.enddate between '$take_date1' and '$take_date2')) and w.statusla='Y' and w.regis_leave!='N') leave_total
from emppersonal e1
$code2
LEFT OUTER JOIN leave_day ld ON e1.empno=ld.empno
where $code1 and e1.status ='1'
GROUP BY e1.empno
order by e1.empno");

    
$sql_dep=  mysql_query($code4);
$depname = mysql_fetch_assoc($sql_dep);

                                ?>

<!-- <H1>จำนวนการรายงานความเสี่ยงของหน่วยงาน</H1> -->

<div class="table-responsive">
    <a class="btn btn-success" download="report_dep_leave_total.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
<table  id="datatable" align="center" width="100%" border="1">
                        <tr>
                            <th colspan="23" align="center">สรุปวันลาของข้าราชการ ลูกจ้างประจำ พนักงานราชการ พนักงานกระทรวงฯ ลูกจ้างรายวัน</th>
                        </tr>
                        <tr>
                            <th colspan="23" align="center"><?= $depname['name'];?></th>
                        </tr>
                        <tr>
                          <td width="3%" rowspan="3" align="center"><b>ลำดับ</b></td>
                          <td width="9%" rowspan="3" align="center"><b>ชื่อ-นามสกล</b></td>
                          <th colspan="8" align="center">เดือนนี้ ( <?php if(!empty($take_month)){ echo DateThai2($take_month1) ." ถึง ". DateThai2($take_month2); }?> )</th>
                          <th colspan="8" align="center">ตั้งแต่ต้นปี ( <?= DateThai2($take_date1); ?> ถึง <?= DateThai2($take_date2); ?> )</th>
                          <th width="4%" rowspan="3" align="center">พักผ่อนสะสม</th>
                          <th width="4%" rowspan="3" align="center">พักผ่อนปีนี้</th>
                          <th width="4%" rowspan="3" align="center">รวม</th>
                          <th width="4%" rowspan="3" align="center">เหลือ</th>
                          <th width="4%" rowspan="3" align="center">ลาชั่วโมง</th>
                        </tr>
<tr align="center">
                        <td colspan="2" align="center"><b>ลาป่วย</b></td>
                        <td colspan="2" align="center"><b>ลากิจ</b></td>
                        <td colspan="2" align="center"><b>ลาพักผ่อน</b></td>
                        <td colspan="2" align="center"><b>ลาคลอด/บวช</b></td>
                        <td colspan="2" align="center"><b>ลาป่วย</b></td>
                        <td colspan="2" align="center"><b>ลากิจ</b></td>
                        <td colspan="2" align="center"><b>ลาพักผ่อน</b></td>
                        <td colspan="2" align="center"><b>ลาคลอด/บวช</b></td>
                    </tr>
                    <tr align="center">
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                        <td width="4%" align="center">ครั้ง</td>
                        <td width="4%" align="center">วัน</td>
                    </tr>

 
 
 <?php         
 
	

                    $i = 1;
                    while ($result = mysql_fetch_assoc($sql)) {
                        $sum_total=$result['L3']+$result['leave_total'];
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td><?= $result['fullname']; ?></td>
                            <td align="center"><?= $result['amonut_sick']; ?></td>
                            <td align="center"><?= $result['sum_sick']; ?></td>
                            <td align="center"><?= $result['amonut_leave']; ?></td>
                            <td align="center"><?= $result['sum_leave']; ?></td>
                            <td align="center"><?= $result['amonut_vacation']; ?></td>
                            <td align="center"><?= $result['sum_vacation']; ?></td>
                            <td align="center"><?= $result['amonut_maternity']; ?></td>
                            <td align="center"><?= $result['sum_maternity']; ?></td>
                            <td align="center"><?= $result['amonut_sick_total']; ?></td>
                            <td align="center"><?= $result['sum_sick_total']; ?></td>
                            <td align="center"><?= $result['amonut_leave_total']; ?></td>
                            <td align="center"><?= $result['sum_leave_total']; ?></td>
                            <td align="center"><?= $result['amonut_vacation_total']; ?></td>
                            <td align="center"><?= $result['sum_vacation_total']; ?></td>
                            <td align="center"><?= $result['amonut_maternity_total']; ?></td>
                            <td align="center"><?= $result['sum_maternity_total']; ?></td>
                            <td align="center"><?=$sum_total-10?></td>
                            <td align="center">10</td>
                            <td align="center"><?=$sum_total?></td>
                            <td align="center"><?=$sum_total-$result['sum_vacation_total']?></td>
                            <td align="center"><?= $result['sum_t']; ?></td>
                        </tr>
                    <?php $i++;
                }
                ?>
</TABLE>

</div></div>	</div>	</div>	
      <?PHP include'footer.php';  ?>
 						