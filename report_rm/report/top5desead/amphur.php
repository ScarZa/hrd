<?php include'../header.php'; ?>
     

 <div data-role="content" data-theme='d' >	


 

<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
 </head>

<body>
 
 <?php
              $dx=$_SESSION[dx];
 			 $sql=mysql_query("select code,name from icd10 where code='$dx'");
			 $icd=mysql_fetch_assoc($sql);
 
 ?>
 
		  <p><h3>  &nbsp;&nbsp;จำแนกโรคตาม อำเภอ :  โรค <?php echo $icd[code]." : ".$icd[name];?></h3></p>
<?php
			
 	   $chwpart=$_SESSION[chwpart]; 
	   $amppart=$_SESSION[amppart]; 
  			if($chwpart!='' and $dx!=''   ){  
				$strQuery = "select t.pt_id  ,t.chwpart,t.amppart,count(d.dx1) as num_dx1  from  pyschosis d,  pt t   where d.dx1='$dx' and t.chwpart='$chwpart'    and  d.pt_id=t.pt_id 	group by   t.amppart  ";
				 
				//Iterate through each factory
 			 	$result = mysql_query($strQuery) or die(mysql_error()); 		
				echo "<label>ดูแต่ละจังหวัดอำเภอ : </label> ";

 			  
					  while($ors2 = mysql_fetch_array($result)){
						   $amphur_id= $ors2[amppart];
						   $sql=mysql_query("select name from thaiaddress where amppart='$amphur_id' and chwpart='$chwpart'");
 						   $amp=mysql_fetch_assoc($sql);
						    $name.="'$amp[name]'".',';
					 	   $countnum.= $ors2[num_dx1].',';
 				
				  
				  
				  //--------------------------------------ลิ้งค์เพื่อดูอำเภอ
				$sql=mysql_query("select name,amppart from thaiaddress where amppart='$amphur_id' and chwpart='$chwpart' and codetype=2");
 				$rs=mysql_fetch_assoc($sql);
 				echo "<label><a href='session.php?amppart=$rs[amppart]&chwpart=$chwpart' title='ดูอำเภอ$rs[name]'>$rs[name]</a></label> | ";
 
				 
					} 
			}

		 
	//ค่าที่นำไปใส่ในกราฟแกน X     $name; 
	//ค่าที่นำไปใส่ในกราฟแกน Y     $count;
  echo mysql_error();
?>


<!-- 		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 -->		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'bar'
            },
            title: {
                text: 'โรค <?php echo $icd[code]." : ".$icd[name];?>'
            },
            subtitle: {
                text: 'จำนวน ราย'
            },
            xAxis: {
                categories: [<?php echo $name ?>],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'จำนวนผู้ป่วย (ราย)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +' ราย';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
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
            credits: {
                enabled: false
            },
            series: [{
                name: 'จำนวนผู้ป่วย',
                data: [<?echo $countnum ?>]
            
            }]
        });
    });
    
});
		</script> 
	</head>

 
<script src="../../highcharts.js"></script>
<script src="../../exporting.js"></script>

<div id="container" style="min-width: 100%; height: 100%; margin: 0 auto"></div>

	 <!-- <form name="form" id="form" action='index.php'>
	<fieldset data-role="fieldcontain"> 
				 
                <select name="amppart" id="jumpMenu" class='required' data-mini="true" data-native-menu="true" onchange="MM_jumpMenu('parent',this,0)"  data-theme='c' />
				<?php 
				$sql=mysql_query("select name from thaiaddress where amppart='$amphur_id' and chwpart='$chwpart' and codetype=2");
 				echo "<option value=''>เลือกอำเภอ</option>";
				 while($rs=mysql_fetch_assoc($sql)){
 					 if($amppart == $rs['amppart']){$sel = 'selected';}else{$sel = '';} 
					echo "<option value='amphur.php?amppart=$rs[amppart]&chwpart=$chwpart'  $sel   >$rs[name]</option>";
					}
 				?>
                </select>
  			</fieldset>
	</form> -->
  </div>

    <!-- footer -->
<div data-role="footer" class="ui-bar" data-position="fixed">
	<a href="session.php" data-role="button" data-icon="back" >กลับหน้าหลัก</a>
</div>
	</body>
</html>
