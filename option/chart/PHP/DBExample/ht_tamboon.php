<?php
//We've included ../Includes/FusionCharts.php and ../Includes/DBConn.php, which contains
//functions to help us easily embed the charts and connect to a database.
require_once('../../../Connections/conhos.php');
include("../Includes/FusionCharts.php");
include("../Includes/DBConn.php");
$d=$_GET['date'];
$d1=$_GET['date1'];
$graph=$_GET['graph_selset'];

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
    <!--<script language="javascript" src="../JSClass/FusionCharts.js"></script>-->
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
<BODY onload="parent.$('#loading').hide();">
<br>
<CENTER>
<h2>จำนวนผู้ป่วยความดันโลหิตสูงมารับบริการ ช่วงวันที่ <?php echo  Thaidate($d);?>   ถึง <?php echo  ThaiDate($d1);?></h2>

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
    $strXML = "<chart caption='' subCaption='' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' คน' animation=' " . $animateChart . "'>";

    // Fetch all factory records
//    $strQuery = "select * from Factory_Master";	
 //   $result = mysql_query($strQuery) or die(mysql_error());
            $strQuery = "SELECT count(distinct(vn.hn)) AS count_hn,th.name  AS tname
FROM patient pt left outer join vn_stat vn ON vn.hn=pt.hn left outer join thaiaddress th ON th.addressid=vn.aid
WHERE pt.chwpart='$jw' AND pt.amppart='$amp'  and (vn.pdx in($htt) or vn.dx0 in($htt) or vn.dx1 in($htt) or vn.dx2 in($htt) or vn.dx3 in($htt) or vn.dx4 in($htt) or vn.dx5 in($htt)) AND vn.vstdate between '$d' and '$d1'
GROUP BY pt.tmbpart
ORDER BY pt.tmbpart ASC ";
            $result2 = mysql_query($strQuery) or die(mysql_error()); 
    //Iterate through each factory
  if ($result2) {
        while($ors2 = mysql_fetch_array($result2)) {
            $strXML .= "<set label='" . $ors2['tname'] . "' value='" . $ors2['count_hn'] . "' />";
        }
    }
    mysql_close($link);

    //Finally, close <chart> element
    $strXML .= "</chart>";

    //Create the chart - Pie 3D Chart with data from strXML
    switch($graph){
case "Pie2D":  		echo renderChart("../../FusionCharts/Pie2D.swf", "", $strXML, "FactorySum", 800, 400, false, false);
			                       	break; 
case "Pie3D":       	echo renderChart("../../FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 800, 400, false, false);
                                    break; 
case "Column2D":  		echo renderChart("../../FusionCharts/Column2D.swf", "", $strXML, "FactorySum", 800, 400, false, false);
			                       	break; 
case "Column3D":       	echo renderChart("../../FusionCharts/Column3D.swf", "", $strXML, "FactorySum", 800, 400, false, false);
                                    break; 
case "Line":  		echo renderChart("../../FusionCharts/Line.swf", "", $strXML, "FactorySum", 800, 400, false, false);
			                       	break; 
case "Area2D":       	echo renderChart("../../FusionCharts/Area2D.swf", "", $strXML, "FactorySum", 800, 400, false, false);
                                    break; 
case "Bar2D":       	echo renderChart("../../FusionCharts/Bar2D.swf", "", $strXML, "FactorySum", 800, 500, false, false);
                                    break; 
default : echo "";
}
?>
<BR><BR>
</CENTER>
</BODY>
</HTML>