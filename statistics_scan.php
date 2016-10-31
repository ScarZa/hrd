<?php include 'header.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<style>
.number{ text-align : center;}
.number div{
	background: #91F7A4;
	color : #ff0000;
}
#test_report th{ background-color : #21BBD6; color : #ffffff;}
#test_report{
	border-right : 1px solid #eeeeee;
	border-bottom : 1px solid #eeeeee;
}
#test_report td,#test_report th{
	border-top : 1px solid #eeeeee;
	border-left : 1px solid #eeeeee;
	padding : 2px;
}
#txt_year{ width : 70px;}
.fail{ color : red;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  สถิติการลืมลงเวลา </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการลืมลงเวลา</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางสถิติการลืมลงเวลาของบุคลากร</h3>
            </div>
            <div class="panel-body"><div class="col-lg-12">
                <div class="alert alert-info alert-dismissable row">
                <?php if($_SESSION[Status]=='ADMIN'){?>
                    <div class="form-group" align="right"> 
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" class="navbar-form navbar-right" enctype="multipart/form-data">
                        <label> ระบุเดือน-ปี : </label>
                        <div class="form-group">
                            <select name="txt_month" class="form-control">
					<option value="">--------------</option>
					<?php
					$month = array('01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
									'05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
									'09' => 'กันยายน ', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');
					$txtMonth = isset($_POST['txt_month']) && $_POST['txt_month'] != '' ? $_POST['txt_month'] : date('m');
					foreach($month as $i=>$mName) {
						$selected = '';
						if($txtMonth == $i) $selected = 'selected="selected"';
						echo '<option value="'.$i.'" '.$selected.'>'. $mName .'</option>'."\n";
					}
					?>
				</select>
                            </div>
                            <div class="form-group">
                            <select name="txt_year" class="form-control">
					<option value="">--------------</option>
					<?php
					$txtYear = (isset($_POST['txt_year']) && $_POST['txt_year'] != '') ? $_POST['txt_year'] : date('Y');

					$yearStart = date('Y');
					$yearEnd = $txtYear-5;

					for($year=$yearStart;$year > $yearEnd;$year--){
						$selected = '';
						if($txtYear == $year) $selected = 'selected="selected"';
						echo '<option value="'.$year.'" '.$selected.'>'. ($year+543) .'</option>'."\n";
					}
					?>
				</select>
                            </div>
                        <input type="submit" class="btn btn-success" value="ตกลง" />
                    </form></div>
                </div></div>
                <a class="btn btn-success" download="scan.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a>
                <table  id="datatable" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php }
                include_once ('option/funcDateThai.php'); 

//รับค่าตัวแปรที่ส่งมาจากแบบฟอร์ม HTML
$year = isset($_POST['txt_year']) ? mysql_real_escape_string($_POST['txt_year']) : '';
$month = isset($_POST['txt_month']) ? mysql_real_escape_string($_POST['txt_month']) : '';
if(isset($_POST['txt_year']) and isset($_POST['txt_month'])){
if($year == '' || $month == '') exit('<p class="fail">กรุณาระบุ "เดือน-ปี" ที่ต้องการเรียกรายงาน</p>');

$sql=mysql_query("select month_name from month where month_id='$month'") or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysql_error());
$month_name=mysql_fetch_assoc($sql);
//ดึงข้อมูลพนักงานทั้งหมด
$allEmpData = array();
$strSQL = "SELECT e.empno,CONCAT(p.pname,e.firstname,'  ',e.lastname)as fullname
FROM emppersonal e
INNER JOIN pcode p ON p.pcode=e.pcode
INNER JOIN fingerprint f on f.empno=e.empno
ORDER BY e.firstname";
$qry = mysql_query($strSQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysql_error());
while($row = mysql_fetch_assoc($qry)){
	$allEmpData[$row['empno']] = $row['fullname'];
}echo '<p>';

//เรียกข้อมูลการจองของเดือนที่ต้องการ
$allReportData = array();
$strSQL = "SELECT f.empno,DAY(f.forget_date)forget_date,if(f.work_scan!='','มม','')work_scan,if(f.finish_work_scan!='','มก','')finish_work_scan,f.exp_status
    FROM fingerprint f 
LEFT JOIN `work` w ON f.empno=w.enpid AND f.forget_date BETWEEN w.begindate AND w.enddate AND w.statusla='Y'
LEFT JOIN plan_out p ON f.empno=p.empno AND f.forget_date BETWEEN p.begin_date AND p.end_date
WHERE ISNULL(w.enpid) AND ISNULL(p.empno) and (f.forget_date LIKE '$year-$month%')
order by f.empno;";
$qry = mysql_query($strSQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysql_error());
while($row = mysql_fetch_assoc($qry)){
	$allReportData[$row['empno']][$row['forget_date']] = $row['work_scan'].'/'.$row['finish_work_scan'];
        $checkReportData[$row['empno']][$row['forget_date']] = $row['exp_status'];
}
echo "<tr><td align='center'><b> เดือน ".$month_name['month_name']." ปี พ.ศ. ".($year+543)."</b></td></tr><tr><td>";
echo "<table width='100%' border='0' id='test_report' cellpadding='0' cellspacing='0'>";
echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
echo '<th>รายชื่อบุคลากร</th>';

//วันที่สุดท้ายของเดือน
$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
$lastDay = date("t", $timeDate);   				//จำนวนวันของเดือน

//สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของดือน
for($day=1;$day<=$lastDay;$day++){
	echo '<th>' . substr("0".$day, -2) . '</th>';
}
echo "</tr>";
foreach($allEmpData as $empCode=>$empName){
	echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
	echo '<td>&nbsp;&nbsp;'. $empName .'</td>';
	//เรียกข้อมูลการจองของพนักงานแต่ละคน ในเดือนนี้
	for($j=1;$j<=$lastDay;$j++){
		$numBook = isset($allReportData[$empCode][$j]) ? '<div>'.$allReportData[$empCode][$j].'</div>' : _;
                $check = ($checkReportData[$empCode][$j]=='W') ? "class='number'" : "align='center'";
		echo "<td $check>".$numBook."</td>";
	}
	echo '</tr>';//ปิดแถวตาราง HTML
}
echo "</table>";
}
?><br><b style="color: red"> * มม = ไม่ลงเวลามา<br> &nbsp; มก = ไม่ลงเวลากลับ</b>
                        </td></tr></table>
            </div></div></div></div>
<?php include 'footer.php'; ?>
