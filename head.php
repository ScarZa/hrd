<?php @session_start(); ?>
<?php include 'connection/connect.php';
//===ชื่อโรงพยาบาล
                    if($con){
                    $sql = mysql_query("select * from  hospital");
                    $resultHos = mysql_fetch_assoc($sql);
                    }
                    if ($resultHos[logo] != '') {
        $pic = $resultHos[logo];
        $fol = "logo/";
    } else {
        $pic = 'agency.ico';
        $fol = "images/";
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
<LINK REL="SHORTCUT ICON" HREF="<?= $fol . $pic; ?>">
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
 
<!-- InstanceBeginEditable name="head" -->
<!--<style type="text/css">
html{
-moz-filter:grayscale(100%);
-webkit-filter:grayscale(100%);
filter:gray;
filter:grayscale(100%);
}
</style>-->
<style type="text/css">
.black-ribbon {   position: fixed;   z-index: 9999;   width: 70px; }
@media only all and (min-width: 768px) { .black-ribbon { width: auto; } }

.stick-left { left: 0; }
.stick-right { right: 0; }
.stick-top { top: 0; }
.stick-bottom { bottom: 0; }
</style>     
<script type="text/javascript">
        function resizeIframe(obj)// auto height iframe
    {
        {
            obj.style.height = 0;
        }
        ;
        {
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }
    }
     </script>
    <script type="text/javascript">
            function getRefresh() {
                $("#auto").show("slow");
                $("#autoRefresh").load("count_comm.php", '', callback);
            }

            function callback() {
                $("#autoRefresh").fadeIn("slow");
                setTimeout("getRefresh();", 1000);
            }

            $(document).ready(getRefresh);
        </script>
        <script language="JavaScript">
            var HttPRequest = false;
            function doCallAjax(Sort) {
                HttPRequest = false;
                if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    HttPRequest = new XMLHttpRequest();
                    if (HttPRequest.overrideMimeType) {
                        HttPRequest.overrideMimeType('text/html');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                            HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {
                        }
                    }
                }
                if (!HttPRequest) {
                    alert('Cannot create XMLHTTP instance');
                    return false;
                }
                var url = 'count_comm.php';
                var pmeters = 'mySort=' + Sort;
                HttPRequest.open('POST', url, true);
                HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                HttPRequest.setRequestHeader("Content-length", pmeters.length);
                HttPRequest.setRequestHeader("Connection", "close");
                HttPRequest.send(pmeters);
                HttPRequest.onreadystatechange = function ()
                {
                    if (HttPRequest.readyState == 3)  // Loading Request
                    {
                        document.getElementById("mySpan").innerHTML = "Now is Loading...";
                    }
                    if (HttPRequest.readyState == 4) // Return Request
                    {
                        document.getElementById("mySpan").innerHTML = HttPRequest.responseText;
                    }
                }
            }
        </script>
        
    
    </head>
<?php
                     if (!empty($_GET['popup'])){
                      $project_place= $_GET['project_place'];  
                      $province=  $_GET['province'];
                      $stdate=$_GET['stdate'];
                      $etdate=$_GET['etdate'];
                      $amount=$_GET['amount'];
                      $cod_popup="window.open('popup_request_car.php?project_place=$project_place&province=$province&stdate=$stdate&etdate=$etdate&amount=$amount','','width=600,height=650'); return false;";
                      
                      ?>
    <body onload="<?= $cod_popup?>">
                     <?php }else{ ?>
    <body Onload="bodyOnload();">    
                     <?php }?>
                <!-- Top Left -->
<img src="https://goo.gl/Yl6KNg" class="black-ribbon stick-top stick-left"/>
        <!--<div id="wrapper">-->
            <!-- Sidebar -->
            <script src="option/js/jquery.min.js"></script>
            <script src="option/js/bootstrap.js"></script>
            <!--scrip check numberical-->
                <script type="text/javascript">
                    function inputDigits(sensor) {
                        var regExp = /[0-9.-]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวเลขเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }
                </script>
                <!--scrip check ตัวอักษร-->
                <script type="text/javascript">
                    function inputString(sensor) {
                        var regExp = /[A-Za-zก-ฮะ-็่-๋์]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวอักษรเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }

                </script>
                <script language="JavaScript">
                    function chkdel() {
                        if (confirm('  กรุณายืนยันการลบอีกครั้ง !!!  ')) {
                            return true;
                        } else {
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
<div id="page-wrapper">