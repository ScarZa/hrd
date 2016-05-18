<?php @session_start(); ?>
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
<?php include 'connection/connect_i.php';
    if (!$db) {
        die('Connect Failed! :' . mysqli_connect_error());
        exit;
    }
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
    $sql2 = "select re.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from regularity re
        inner join emppersonal em on em.empno=re.empno_regu
        order by regu_id desc";
    $qr2 = mysqli_query($db, $sql2);
if($qr2==''){exit();}
$total=mysqli_num_rows($qr2);
 
$e_page=20; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
if(!isset($_GET['s_page'])){   
	$_GET['s_page']=0;   
}else{   
	$chk_page=$_GET['s_page'];     
	$_GET['s_page']=$_GET['s_page']*$e_page;   
}   
$sql2.=" LIMIT ".$_GET['s_page'].",$e_page";
$qr2=mysqli_query($db,$sql2);
if($total>=1){   
	$plus_p=($chk_page*$e_page)+$total;   
}else{   
	$plus_p=($chk_page*$e_page);       
}   
$total_p=ceil($total/$e_page);   
$before_p=($chk_page*$e_page)+1;  
echo mysqli_error();
    ?>
    <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><center><u><h3><b>ระเบียบ/คำสั่ง</b></h3></u></center></h3>
                            </div>
                            <div class="panel-body">

                                <?php
                                include 'option/funcDateThai.php';
                                while ($topic_regu = mysqli_fetch_assoc($qr2)) {
                                    if ($topic_regu[regu_file] != '') {
                                        $regu_file = $topic_regu[regu_file];
                                        $folder_file = "regu_file/";
                                    } else {
                                        
                                    }
                                    ?>
                                    <p><h4><b><font color='red'>ระเบียบที่ <?= $topic_regu[regu_id] ?></font></b></h4><b>ผู้ประกาศ</b> คุณ<?= $topic_regu[fullname] ?>  <b>ประกาศเมื่อ</b> <?= DateThai1($topic_regu[regu_date]) ?>
                                    <a href="<?= $folder_file . $regu_file ?>" target="_blank"><font color='blue'><h5><li><?= $topic_regu[topic_regu] ?></li></h5></font></a> 
                                    <?php if($_SESSION[Status]=='ADMIN'){?>
                                    <div align='right'><a href="regularity.php?method=edit&regu_id=<?= $topic_regu[regu_id]?>"><img src="images/file_edit.ico" width="20"></a> <img src="images/file_delete.ico" width="20"></div>  
                                    
    <?php }} ?>
                                    <?php if($total>0){
echo mysqli_error();

?>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/20)."&nbsp;<B>หน้า</B></font>" ;
}
?> </div>
                            </div></div></div></div>
<?php include 'footeri.php';?>