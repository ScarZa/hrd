<?php
//We've included ../Includes/FusionCharts.php and ../Includes/DBConn.php, which contains
//functions to help us easily embed the charts and connect to a database.
require_once('../../../Connections/conhos.php');
include("../Includes/FusionCharts.php");
include("../Includes/DBConn.php");
$year_now=date('Y');
$fdate=('$ryear-543');
$syear=$_GET['ryear']-1;
$syear1=$_GET['ryear'];
//$year_now=date("Y-10-01", strtotime("-1 year"));
$year_now1 = date ("Y-09-30");

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
	<!--<SCRIPT LANGUAGE="Javascript" SRC="../../FusionCharts/FusionCharts.js"></SCRIPT>-->
    <script language="javascript" src="../JSClass/FusionCharts.js"></script>
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
<CENTER>
<p>
<?php   
    //In this example, we show how to connect FusionCharts to a database.
    //For the sake of ease, we've used a MySQL database containing two
    //tables.

    //Connect to the DB
    $link = connectToDB();

    //$strXML will be used to store the entire XML document generated
    //Generate the graph element 
    $strXML = "<graph caption='Factory Output report' subCaption='By Quantity' decimalPrecision='0' showNames='1' numberSuffix=' Units' pieSliceDepth='30' formatNumberScale='0'>";

    //Fetch all factory records
     $strQuery = "select  concat(DATE_FORMAT(vstdate, '%m'),'-',YEAR(vstdate)+543) AS vstdate,count(distinct(hn)) AS count_hn from vn_stat where vstdate between '$syear-10-01' and '$syear1-09-30' GROUP BY MONTH(vstdate) ORDER BY  MAX(vstdate) ";
    $result = mysql_query($strQuery) or die(mysql_error());

    //Iterate through each factory
    if ($result) {
       while($ors = mysql_fetch_array($result)) {
          //Now create a second query to get details for this factory
           //$strQuery = "select DATE_FORMAT(vstdate, '%Y-%m-%d') AS vstdate,count(distinct(hn)) AS count_hn from vn_stat where DATE_FORMAT(vstdate, '%Y') between '$ryear2' and '$ryear2'  and  DATE_FORMAT(vstdate, '%m') ='$month2' GROUP BY DAY(vstdate)";
          $result2 = mysql_query($strQuery) or die(mysql_error()); 
          $ors2 = mysql_fetch_array($result2); 
          //Generate <set name='..' value='..'/> 
          $strXML .= "<set name='" . $ors['vstdate'] . "' value='" . $ors2['count_hn'] . "' />";
          //free the resultset
          mysql_free_result($result2);
       }
    }
    mysql_close($link);

    //Finally, close <graph> element
    $strXML .= "</graph>";

    //Create the chart - Pie 3D Chart with data from $strXML
    //echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 650, 450);
	echo renderChart("../../../FusionCharts/Charts/FCF_Column2D.swf", "", $strXML, "FactorySum", 650, 450);
 ?>
</BODY>
</HTML>