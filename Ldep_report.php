<?php include 'header.php';?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
 <div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายงานแสดงภาพรวมการลาแยกหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการลาของหน่วยงาน</li>
        </ol>
    </div>
</div>
 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางสถิติการลาของหน่วยงาน</h3>
            </div>
            <div class="panel-body">
<form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
            <div class="form-group">
             <input type="date"   name='take_date1' class="form-control" value='' >
            </div>
            <div class="form-group">
              <input type="date"   name='take_date2' class="form-control" value='' >
            </div>   
			<button type="submit" class="btn btn-success">ตกลง</button> 						
</form>
 

 <?php         
	        $take_date1=$_POST[take_date1];
	        $take_date2=$_POST[take_date2];
   		
                include_once ('option/funcDateThai.php');
		$take_rec_date= "$result[take_rec_date]";
		DateThai1($take_date1); //-----แปลงวันที่เป็นภาษาไทย
		DateThai2($take_date2); //-----แปลงวันที่เป็นภาษาไทย
if($take_date1!=''){  
	echo "<p>&nbsp;</p><center>";
 	echo "ตั้งแต่วันที่ ".DateThai1($take_date1);
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "ถึงวันที่ ".DateThai2($take_date2);
	echo "<p>&nbsp;</p></center>";
$sql=mysql_query("select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 where    t1.move_status='N' and t1.take_date between '$take_date1' and '$take_date2' group by d1.dep_id order by number_risk DESC");	

}else if($take_date1=='' and $mng_status==''){  
	echo "<p>&nbsp;</p><center>";
	echo "แสดงทั้งหมด<BR>";	
	echo "<p>&nbsp;</p></center>";

			
 				$sql = mysql_query("SELECT COUNT(w.workid) AS count_leave,d.depName as dep_name FROM department d
                                        LEFT OUTER JOIN emppersonal e ON d.depId=e.depid
                                        LEFT OUTER JOIN `work` w on e.empno=w.enpid
                                        WHERE w.statusla='Y' GROUP BY d.depId  order by count_leave DESC");
 }					 
  
 //Iterate through each factory
			//	$result = mysql_query($strQuery) or die(mysql_error()); 
 
 					  while($rs = mysql_fetch_assoc($sql)){
 						    $name.="'$rs[dep_name]'".',';
					 	    $countnum.= $rs[count_leave].',';
 				}
 


?>
<script src="report_rm/highcharts.js"></script>
<script src="report_rm/exporting.js"></script>
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
                text: 'จำนวนการลาของหน่วยงาน'
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
                    text: 'จำนวนครั้ง',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }

            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        'การลาของหน่วยงานจำนวน: '+ Highcharts.numberFormat(this.y, 0) +
                        ' ครั้ง';
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
                color: '#991100',
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
                <!--<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
    
        var colors = Highcharts.getOptions().colors,
            categories = ['<? echo $countnum; ?>'],
            name = 'หน่วยงาน',
            data = [{
                    y: 55.11,
                    color: colors[0],
                    drilldown: {
                        name: 'MSIE versions',
                        categories: ['MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0'],
                        data: [<? echo $countnum; ?>],
                        color: colors[0]
                    }
                }, {
                    y: 21.63,
                    color: colors[1],
                    drilldown: {
                        name: 'Firefox versions',
                        categories: ['Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0'],
                        data: [<? echo $countnum; ?>],
                        color: colors[1]
                    }
                }, {
                    y: 11.94,
                    color: colors[2],
                    drilldown: {
                        name: 'Chrome versions',
                        categories: ['Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0', 'Chrome 8.0', 'Chrome 9.0',
                            'Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0'],
                        data: [0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22],
                        color: colors[2]
                    }
                }, {
                    y: 7.15,
                    color: colors[3],
                    drilldown: {
                        name: 'Safari versions',
                        categories: ['Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari/Maxthon',
                            'Safari 3.1', 'Safari 4.1'],
                        data: [4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14],
                        color: colors[3]
                    }
                }, {
                    y: 2.14,
                    color: colors[4],
                    drilldown: {
                        name: 'Opera versions',
                        categories: ['Opera 9.x', 'Opera 10.x', 'Opera 11.x'],
                        data: [ 0.12, 0.37, 1.65],
                        color: colors[4]
                    }
                }, {
                    y: 2.14,
                    color: colors[5],
                    drilldown: {
                        name: 'Opera versions',
                        categories: ['Opera 9.x', 'Opera 10.x', 'Opera 11.x'],
                        data: [ 0.12, 0.37, 1.65],
                        color: colors[5]
                    }
                }, {
                    y: 2.14,
                    color: colors[6],
                    drilldown: {
                        name: 'Opera versions',
                        categories: ['Opera 9.x', 'Opera 10.x', 'Opera 11.x'],
                        data: [ 0.12, 0.37, 1.65],
                        color: colors[6]
                    }
                }];
    
        function setChart(name, categories, data, color) {
			chart.xAxis[0].setCategories(categories, false);
			chart.series[0].remove(false);
			chart.addSeries({
				name: name,
				data: data,
				color: color || 'white'
			}, false);
			chart.redraw();
        }
    
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: 'ข้อมูลการลาของบุคลากรแต่ละหน่วยงาน'
            },
            subtitle: {
                text: 'Click เพื่อดูรายชื่อผู้ลา Click อีกครั้งเพื่อกลับมาดูหน่วยงาน'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'จำนวนครั้ง'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    setChart(name, categories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y +'%';
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +':<b>'+ this.y +'% market share</b><br/>';
                    if (point.drilldown) {
                        s += 'Click to view '+ point.category +' versions';
                    } else {
                        s += 'Click to return to browser brands';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: 'white'
            }],
            exporting: {
                enabled: false
            }
        });
    });
    
});
		</script>-->
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


															
				
?>
<CENTER>
<!-- <H1>จำนวนการรายงานความเสี่ยงของหน่วยงาน</H1> -->

<div class="table-responsive">
<table align="center" width="100%" border="1">
<tr align="center" bgcolor="#898888">
                        <td width="3%" rowspan="2" align="center"><b>ลำดับ</b></td>
                        <td width="15%" rowspan="2" align="center"><b>หน่วยงาน</b></td>
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
 
if($take_date1!=''){  
$sql=mysql_query("select count(mngrisk_id) as number_risk,d1.dep_id,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 where    t1.move_status='N' and t1.take_date between '$take_date1' and '$take_date2' group by d1.dep_id order by number_risk DESC");	
}else  if($take_date1==''){ 			
 				$sql = mysql_query("SELECT d.depId as depid,  d.depName as name,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1' and w.depId=d.depId and w.statusla='Y') amonut_sick,
(select SUM(w.amount) from `work` w where w.typela='1' and w.depId=d.depId and w.statusla='Y') sum_sick,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and w.depId=d.depId and w.statusla='Y') amonut_leave,
(select SUM(w.amount) from `work`w where w.typela='2' and w.depId=d.depId and w.statusla='Y') sum_leave,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and w.depId=d.depId and w.statusla='Y') amonut_vacation,
(select SUM(w.amount) from `work` w where w.typela='3' and w.depId=d.depId and w.statusla='Y') sum_vacation,
(SELECT COUNT(w.amount)  from `work` w where w.typela='4' and w.depId=d.depId and w.statusla='Y') amonut_maternity,
(select SUM(w.amount) from `work` w where w.typela='4' and w.depId=d.depId and w.statusla='Y') sum_maternity,
(SELECT COUNT(w.amount)  from `work` w where w.typela='5' and w.depId=d.depId and w.statusla='Y') amonut_ordain,
(select SUM(w.amount) from `work` w where w.typela='5' and w.depId=d.depId and w.statusla='Y') sum_ordain,
(SELECT COUNT(w.amount)  from `work` w where w.typela='6' and w.depId=d.depId and w.statusla='Y') amonut_educate,
(select SUM(w.amount) from `work` w where w.typela='6' and w.depId=d.depId and w.statusla='Y') sum_educate,
(SELECT COUNT(w.amount)  from `work` w where w.typela='7' and w.depId=d.depId and w.statusla='Y') amonut_dribble,
(select SUM(w.amount) from `work` w where w.typela='7' and w.depId=d.depId and w.statusla='Y') sum_dribble,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and t.depId=d.depId) amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and t.depId=d.depId) sum_t
from `work` w
RIGHT OUTER JOIN emppersonal e1 on w.enpid=e1.empno
RIGHT OUTER JOIN department d on e1.depid=d.depId
GROUP BY d.depId
         order by depId");
 }	

?>
        <?
                    $i = 1;
                    while ($result = mysql_fetch_assoc($sql)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td><a href="#.php?id=<?= $result[depid]; ?>"><?= $result[name]; ?></a></td>
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
                    <? $i++;
                }
                ?>
</TABLE>
</CENTER>
</div></div>	</div>	</div>								
 			<?PHP include'footer.php';  ?>			