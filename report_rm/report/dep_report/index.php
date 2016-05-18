
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 
<form method="post" action="" enctype="multipart/form-data">
<BR>
 <input type="text" name='take_date1' id="datepicker" placeholder='ตั้งแต่วันที่' class="text ui-widget-content ui-corner-all"  /><input type="text" name='take_date2' id="datepicker2" placeholder='ถึงวันที่ิเกิดเหตุ'  class="text ui-widget-content ui-corner-all" /> 
 
 <select name='mng_status'  class="text ui-widget-content ui-corner-all">
  <option value=''>---เลือกสถานะ---</option>
  <option value='N'>N ยังไม่แก้ไข</option>
  <option value='Y'>Y แก้ไขแล้ว</option>
  </select>
 <?php //include'../../../connect.php';
			
 				$strQuery = "select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 where   t1.move_status='N' group by d1.dep_id order by number_risk DESC";
 			 
				//Iterate through each factory
				$result = mysql_query($strQuery) or die(mysql_error()); 
				if ($result) {

 					  while($rs = mysql_fetch_array($result)){
 						    $name.="'$rs[dep_name]'".',';
					 	    $countnum.= $rs[number_risk].',';
				   }
				}
 

?>
<script src="report_rm/highcharts.js"></script>
<script src="report_rm/exporting.js"></script>
<script src="report_rm/jquery.js"></script>
 <script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: 'จำนวนความเสี่ยงทั้งหมดของหน่วยงาน'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [<? echo $name; ?>
                ],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'จำนวนเรื่อง',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }

            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        'ความเสี่ยงของหน่วยงานจำนวน: '+ Highcharts.numberFormat(this.y, 0) +
                        ' เรื่อง';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
				/*
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
			*/
            credits: {
                enabled: false
            },
            series: [{
                name: 'หน่วยงาน',
                data: [<? echo $countnum; ?>],
                 dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 0,
                    y: 18,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
					}
				}
            }]
        });
    });
    
});
		</script> 
	</head>
	<body>

<div id="container" style="min-width: 700px; height: 500px; margin: 0 auto"></div>



 <SCRIPT language=JavaScript>
var OldColor;
function popNewWin (strDest,strWidth,strHeight) {
newWin = window.open(strDest,"popup","toolbar=no,scrollbars=yes,resizable=yes,width=" + strWidth + ",height=" + strHeight);
}
function mOvr(src,clrOver) {
if (!src.contains(event.fromElement)) {
src.style.cursor = 'hand';
OldColor = src.bgColor;
src.bgColor = clrOver;
}
}
function mOut(src) {
if (!src.contains(event.toElement)) {
src.style.cursor = 'default';
src.bgColor = OldColor;
}
}
function mClk(src) {
if(event.srcElement.tagName=='TD') {
src.children.tags('A')[0].click();
}
}
 </SCRIPT>

<?php

//include'../connect.php';

$take_date1=$_POST[take_date1];
$take_date1=$_POST[take_date2];
$mng_status=$_POST[mng_status];
if($take_date1!='' and $mng_status==''){
 
$sql=mysql_query("select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 where    t1.move_status='N' and t1.take_date between '$take_date1=' and '$take_date2' group by d1.dep_id order by number_risk DESC");	

}else if($take_date1=='' and $mng_status!=''){
$sql=mysql_query("select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 LEFT OUTER JOIN mngrisk m1 on m1.takerisk_id = t1.takerisk_id
				 where   m1.mng_status='$mng_status' and t1.move_status='N'   group by d1.dep_id order by number_risk DESC");	

}else if($take_date1!='' and $mng_status!=''){
$sql=mysql_query("select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 LEFT OUTER JOIN mngrisk m1 on m1.takerisk_id = t1.takerisk_id
				 where   m1.mng_status='$mng_status' and t1.move_status='N' and t1.take_date between '$take_date1=' and '$take_date2' group by d1.dep_id order by number_risk DESC");	

}
$sql=mysql_query("select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 where    t1.move_status='N' group by d1.dep_id order by number_risk DESC");	
															
				
?>
<CENTER>
<!-- <H1>จำนวนการรายงานความเสี่ยงของหน่วยงาน</H1> -->

<TABLE width=600>
<TR class="ui-widget-header">
	<TD width=100><CENTER><p>ลำดับ</p></CENTER></TD>
	<TD width=255>รายชื่อหน่วยงาน</TD>
	<TD width=100><p align="right">เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></TD>
</TR>
<?php 
$i=1;
while($result=mysql_fetch_assoc($sql)){
	if($bg == "#F4F4F4") { //ส่วนของการ สลับสี 
		$bg = "#FFFFFF";
		}else{
		$bg = "#F4F4F4";
		}
	
	?>	

<tr bgcolor=<?=$bg?> onmouseover="mOvr(this,'#DEF8F0');" onclick=mClk(this); onmouseout=mOut(this); >
	<TD><CENTER><?php echo $i; ?></CENTER></TD>
	<TD><?php echo $result[dep_name];?></TD>
	<TD><p align="right"><?php echo $result[number_risk];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></TD>
</TR>

<?php 
$i++;
}?>
</TABLE>
</CENTER>
	</body>
</html>
