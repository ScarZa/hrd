<?php
//We've included ../Includes/FusionCharts.php and ../Includes/DBConn.php, which contains
//functions to help us easily embed the charts and connect to a database.
require_once('../../../Connections/connect.php');
include("../Includes/FusionCharts.php");
include("../Includes/DBConn.php");
$year_now=date('Y');
$month_now=date('m');
?>
<HTML>
<HEAD>
	<TITLE>
	ผู้ป่วย
	</TITLE>
	<?php
	//You need to include the following JS file, if you intend to embed the chart using JavaScript.
	//Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	//When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
	?>	
	<SCRIPT LANGUAGE="Javascript" SRC="../../FusionCharts/FusionCharts.js"></SCRIPT>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></HEAD>
<BODY>
<?php
if ($month2=='01')
{ 
$m ="มกราคม";
}
else if ($month2=='02')
{
$m ="กุมภาพันธ์";
}
else if ($month2=='03')
{
$m ="มีนาคม";
}
else if ($month2=='04')
{
$m ="เมษายน";
}
else if ($month2=='05')
{
$m ="พฤษภาคม";
}
else if ($month2=='06')
{
$m ="มิถุนายน";
}
else if ($month2=='07')
{
$m ="กรกฏาคม";
}
else if ($month2=='08')
{
$m ="สิงหาคม";
}
else if ($month2=='09')
{
$m ="กันยายน";
}
else if ($month2=='10')
{
$m ="ตุลาคม";
}
else if ($month2=='11')
{
$m ="พฤศจิกายน";
}
else if ($month2=='12')
{
$m ="ธันวาคม";
}
?>
<CENTER>
<h2>จำนวนผู้ป่วยที่มารับบริการที่ผู้ป่วยนอก</h2>
<h3>โรงพยาบาลนาโพธิ์  เดือน <?php echo $m;?>  พ.ศ. <? echo $ryear2+543;?></h3>
<?php
    //In this example, we show how to connect FusionCharts to a database.
    //For the sake of ease, we've used an MySQL databases containing two
    //tables.

    // Connect to the DB
    $link = connectToDB();

    //We also keep a flag to specify whether we've to animate the chart or not.
    //If the user is viewing the detailed chart and comes back to this page, he shouldn't
    //see the animation again.
    $animateChart = $_GET['animate'];
    //Set default value of 1
    if ($animateChart=="")
        $animateChart = "1";

    //$strXML will be used to store the entire XML document generated
    //Generate the chart element
    $strXML = "<chart caption='จำนวนผู้ป่วย แยกตามรายเดือน' subCaption='' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' คน' animation=' " . $animateChart . "'>";

    // Fetch all factory records
//    $strQuery = "select * from Factory_Master";	
 //   $result = mysql_query($strQuery) or die(mysql_error());
            $strQuery = "select DATE_FORMAT(vstdate, '%d') AS vstdate,count(distinct(hn)) AS count_hn from vn_stat where DATE_FORMAT(vstdate, '%Y') between '$ryear2' and '$ryear2'  and  DATE_FORMAT(vstdate, '%m') ='$month2' GROUP BY DAY(vstdate)";
            $result2 = mysql_query($strQuery) or die(mysql_error()); 
    //Iterate through each factory
  if ($result2) {
        while($ors2 = mysql_fetch_array($result2)) {
            $strXML .= "<set label='" .$ors2['vstdate'] . "' value='" . $ors2['count_hn'] . "' />";
        }
    }
    mysql_close($link);

    //Finally, close <chart> element
    $strXML .= "</chart>";

    //Create the chart - Pie 3D Chart with data from strXML
    echo renderChart("../../FusionCharts/Bar2D.swf", "", $strXML, "FactorySum", 580, 340, false, false);
?>
<BR><BR>
</CENTER>
</BODY>
</HTML>