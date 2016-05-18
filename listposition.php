   
<!-- ค้นหา -->

              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ตำแหน่ง</h3>
                    </div>
                  <div class="panel-body">
  <form class="navbar-form navbar-left" role="search" action='Add_Position.php' method='post'  >
       <div class="form-group">
		<input type='text' name='Search_position' placeholder='ตำแหน่ง'  value='' class="form-control"  > 
		<input type='hidden' name='method'  value='search_position'> 
		 </div>
		<button  class="btn btn-warning"><i class="fa fa-search"></i>  ค้นหา</button >
  </form>
 		 
						<!--   <H1>หมายเหตุ รายการที่มีเครื่องหมายดอกจันทร์  (***) จำเป็นต้องระบุให้ครบ</H1> -->
 						

<!------------------------------------------------------------------>

<?php   
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
	$urlfile=""; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
	$per_page=10;
	$num_per_page=floor($chk_page/$per_page);
	$total_end_p=($num_per_page+1)*$per_page;
	$total_start_p=$total_end_p-$per_page;
	$pPrev=$chk_page-1;
	$pPrev=($pPrev>=0)?$pPrev:0;
	$pNext=$chk_page+1;
	$pNext=($pNext>=$total_p)?$total_p-1:$pNext;		
	$lt_page=$total_p-4;
	if($chk_page>0){  
		echo "<a  href='$urlfile?s_page=$pPrev".$querystr."' class='naviPN'>Prev</a>";
	}
	for($i=$total_start_p;$i<$total_end_p;$i++){  
		$nClass=($chk_page==$i)?"class='selectPage'":"";
		if($e_page*$i<=$total){
		echo "<a href='$urlfile?s_page=$i".$querystr."' $nClass  >".intval($i+1)."</a> ";   
		}
	}		
	if($chk_page<$total_p-1){
		echo "<a href='$urlfile?s_page=$pNext".$querystr."'  class='naviPN'>Next</a>";
	}
}   
 
if($_POST[method]=='search_position'){
     $_SESSION[Search_position]=$_POST[Search_position];
}
 $Search_position=trim($_SESSION[Search_position]);
 if($Search_position!='' ){
 
  echo "แสดงคำที่ค้นหา : ".$Search_position;
//คำสั่งค้นหา
     $q="select * from posid
 	  Where  posname like '%$Search_position%'"; 
 }else{
 $q="select * from posid order by posId"; 
 }
	
$qr=mysql_query($q);
if($qr==''){exit();}
$total=mysql_num_rows($qr);
 
$e_page=20; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
if(!isset($_GET['s_page'])){   
	$_GET['s_page']=0;   
}else{   
	$chk_page=$_GET['s_page'];     
	$_GET['s_page']=$_GET['s_page']*$e_page;   
}   
$q.=" LIMIT ".$_GET['s_page'].",$e_page";
$qr=mysql_query($q);
if(mysql_num_rows($qr)>=1){   
	$plus_p=($chk_page*$e_page)+mysql_num_rows($qr);   
}else{   
	$plus_p=($chk_page*$e_page);       
}   
$total_p=ceil($total/$e_page);   
$before_p=($chk_page*$e_page)+1;  
echo mysql_error();
?>
 </head>
<body>
  

 <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">  
 <TR bgcolor='#898888'>
					<th width='10%'><CENTER>ลำดับ</CENTER></th>
					<th width='36%'><CENTER>ตำแหน่ง</CENTER></th>
					<th width='18%'><CENTER>แก้ไข | ลบ</CENTER></th>
 </TR>
<?php 
 
$i=1;
while($result=mysql_fetch_assoc($qr)){
/*	if($bg == "#F9F9F9") { //ส่วนของการ สลับสี 
		$bg = "#FFFFFF";
		}else{
		$bg = "#F9F9F9";
		}
*/
	if($bg == "#F4F4F4") { //ส่วนของการ สลับสี 
		$bg = "#FFFFFF";
		}else{
		$bg = "#F4F4F4";
		}

?>  
 					<tr >	    
                                        <TD height="20" align="center" ><?=($chk_page*$e_page)+$i?></TD>
					<TD><?=$result[posname]; ?></TD>
 					<TD><CENTER>
				    <a href='Add_Position.php?method=update&dep_id=<?=$result[posId]?>' ><i class="fa fa-edit"></i></a> 
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='./prcposition.php?method=delete&dep_id=<?=$result[posId]?>'  title="confirm" onclick="if(confirm('ยืนยันการลบ <?php  echo  $result[name]; ?>&nbsp;ออกจากรายการ ')) return true; else return false;">   
					<i class="fa fa-trash-o"></i></a>

					</tr> 
 
  			 
 		 <?php $i++; } ?>
 		 
</CENTER>
</table>

<?php if($total>0){
echo mysql_error();

?><BR><BR>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/20)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
 </div> 
</div></div>