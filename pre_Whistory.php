<?php include 'header.php';if(isset($_GET['unset'])){
    unset_session();}?>
<?php if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<div class="row">
          <div class="col-lg-12">
              <h1><img src='images/work.ico' width='75'><font color='blue'>  ข้อมูลประวัติการทำงาน </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> ข้อมูลประวัติการทำงาน</li>
            </ol>
          </div>
      </div>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><img src='images/Lfolder.ico' width='25'> ตารางประวัติการทำงานของบุคลากร</h3>
                    </div>
                <div class="panel-body">
                    <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="pre_Whistory.php">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div class="form-group">
                    <input type="text" placeholder="ค้นหา" name='txtKeyword' class="form-control" value="<?php echo $Search_word; ?>" >
                    <input type='hidden' name='method'  value='txtKeyword'>
                </div> <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Search</button> </td>


        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</form>
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
if($_SESSION[Status]=='ADMIN'){
 if($_POST[method]=='txtKeyword'){
$_SESSION['txtKeyword']=$_POST[txtKeyword];
 }
$Search_word=($_SESSION['txtKeyword']);
 if($Search_word != ""){
//คำสั่งค้นหา
     $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname from emppersonal e1 
inner JOIN work_history wh ON wh.empno=e1.empno
inner JOIN posid p1 ON p1.posId=wh.posid AND p1.posId=(SELECT wh.posid FROM work_history wh WHERE e1.empno=wh.empno ORDER BY wh.his_id DESC LIMIT 1)
inner join pcode p2 on e1.pcode=p2.pcode
         WHERE wh.posid=p1.posId and (firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or pid LIKE '%$Search_word%')
             and e1.status ='1' GROUP BY empno order by empno"; 
 }else{
 $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname from emppersonal e1 
inner JOIN work_history wh ON wh.empno=e1.empno
inner JOIN posid p1 ON p1.posId=wh.posid AND p1.posId=(SELECT wh.posid FROM work_history wh WHERE e1.empno=wh.empno ORDER BY wh.his_id DESC LIMIT 1)
inner join pcode p2 on e1.pcode=p2.pcode
where wh.posid=p1.posId and e1.status ='1' 
GROUP BY empno
ORDER BY empno"; 
 }}else{
     $empno=$_SESSION[user];
   $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname from emppersonal e1 
inner JOIN work_history wh ON wh.empno=e1.empno
inner JOIN posid p1 ON p1.posId=wh.posid AND p1.posId=(SELECT wh.posid FROM work_history wh WHERE e1.empno=wh.empno ORDER BY wh.his_id DESC LIMIT 1)
inner join pcode p2 on e1.pcode=p2.pcode
where wh.posid=p1.posId and e1.empno='$empno' and e1.status ='1' 
GROUP BY empno
ORDER BY empno";  
 }
$qr=mysql_query($q);
if($qr==''){exit();}
$total=mysql_num_rows($qr);
 
$e_page=10; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
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
 
  
                    แสดงคำที่ค้นหา : <?=$Search_word;?>
                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <tr align="center" bgcolor="#898888">
                                <td align="center" width="6%"><b>ลำดับ</b></td>
                                <td align="center" width="10%"><b>เลขที่</b></td>
                                <td align="center" width="20%"><b>ชื่อ-นามสกุล</b></td>
                                <td align="center" width="20%"><b>ตำแหน่ง</b></td>
                                <td align="center" width="10%"><b>เพิ่มประวัติการทำงาน</b></td>
                            </tr>
                            
                            <?php
                             $i=1;
while($result=mysql_fetch_assoc($qr)){?>
    <tr>
                                <td align="center"><?=($chk_page*$e_page)+$i?></td>
                                <td align="center"><?=$result[pid];?></td>
                                <td><a href="detial_Whistory.php?id=<?=$result[empno];?>"><?=$result[fullname];?></a></td>
                                <td align="center"><?=$result[posname];?></td>
                                <td align="center"><a href="#" onclick="return popup('add_Whistory.php?id=<?= $result[empno] ?>', popup, 500, 750);">
                                    <img src='images/edit_add.ico' width='30'></a></td>
        </tr>
    </tr>
    <?php $i++; } ?>
                                
                        </table>
<?php if($total>0){
echo mysql_error();

?><BR><BR>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/10)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
                </div>
              </div>
          </div>
</div>

    <?php include 'footer.php';?>
