<?php @session_start(); ?>
<?php include 'connection/connect_i.php';?>
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
<?php                  
                    function insert_date(&$take_date_conv,&$take_date)
                    {
                        
                         $take_date=explode("/",$take_date_conv);
			 $take_date_year=$take_date[2]-543;
			 $take_date="$take_date_year-$take_date[1]-$take_date[0]";
                    }
?>
<script language="JavaScript" type="text/javascript"> 
var StayAlive = 4; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
function KillMe()
{ 
setTimeout("self.close()",StayAlive * 1000); 
} 
</script>
<body onLoad="KillMe();self.focus();window.opener.location.reload();">
    <?php
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";
    $place=$_POST['place'];
    $province=$_POST['province'];
    $amphur=$_POST['amphur'];
    $take_date_conv = $_POST['start_date'];
    $start_date='';
    insert_date(&$take_date_conv,&$start_date);
    $take_date_conv = $_POST['end_date'];
    $end_date='';
    insert_date(&$take_date_conv,&$end_date);
    $request_date=date('Y-m-d');
    $start_time = $_POST['take_hour_st'].":".$_POST['take_minute_st'];
    $end_time = $_POST['take_hour_en'].":".$_POST['take_minute_en'];
    $amount_date = $_POST['amount_date'];
    $obj = $_POST['obj'];
    $amount = $_POST['amount'];
    $passenger = $_POST['passenger'];
    $wait = $_POST['wait'];
    
    if ($_POST['method'] == 'request_car') {
        $empno_request = $_SESSION[user];  
        
$regis_car=  mysqli_query($db,"select count from count where count_name='regis_car'");
$Regis_car=  mysqli_fetch_assoc($regis_car);
$Ln=$Regis_car['count']+1;
$Y=date('y')+43;
$car_no="$Y/$Ln";
    $update_count=  mysqli_query($db,"update count set count='$Ln' where count_name='regis_car'");
    
    $request = mysqli_query($db,"insert into ss_car set 
            car_no='$car_no', empno_request='$empno_request', obj='$obj', request_date='$request_date', start_date='$start_date', end_date='$end_date',
                start_time='$start_time', end_time='$end_time', amount='$amount', place='$place', province='$province', amphur='$amphur',
                   passenger='$passenger', wait='$wait', amount_date='$amount_date'");
    
    if ($request == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/request_car' >กลับ</a>";
    } else {
                    //echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
    }
}
?>
</body>
</html>