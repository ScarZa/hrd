<?php include 'header.php';?>
<?php if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<ol class="breadcrumb alert-success">
    <li class=""><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
    <li class="active"><i class="fa fa-tags"></i> ประชาสัมพันธ์</li>
</ol>
<?php include 'connection/connect_i.php';
                    if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
     exit;
}
if($_REQUEST[edit_id]=='' and $_REQUEST[del_id]==''){
$empno=$_SESSION[user];
$sql=$db->prepare("select empno_post from topic_post where empno_post=?");
$sql->bind_param("i",$empno);
$sql->execute();
$sql->bind_result($empno_poster);
$sql->fetch();
$db->close();

}elseif($_REQUEST[edit_id]!=''){
$edit_id=$_REQUEST[edit_id];
$sql=$db->prepare("select empno_post,post,link from topic_post where topic_id=?");
$sql->bind_param("i",$edit_id);
$sql->execute();
$sql->bind_result($empno_post,$post,$link);
$sql->fetch();
$db->close();

}elseif ($_REQUEST[del_id]!='') {
 $del_id=$_REQUEST[del_id];
$sql=$db->prepare("delete from topic_post where topic_id=?");
$sql->bind_param("i",$del_id);
$sql->execute();
$db->close();   
}
?>
        <div class="row">
       <div class="col-lg-4">
<div class="row">      
    <div class="col-lg-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งหัวข้อประชาสัมพันธ์</h3>
                    </div>
                  <div class="panel-body">
                      <form class="navbar-form navbar" role="form" action='prcpost.php' enctype="multipart/form-data" method='post'> 
                  <div class="form-group">
                      ข้อความ 
                      <textarea class="form-control" name="post" required="" cols="50" rows="5" placeholder="กรุณาใส่ข้อความที่ต้องการประชาสัมพันธ์"><?= $post;?></textarea>
                  </div><br><br>
                  <div class="form-group">
                          Link
                          <input type="text" name="link" id="link" size="50" class="form-control" value="<?= $link?>" placeholder="https://sample.com">
                      </div><br><br>
                      <div class="form-group">
                          รูปภาพที่ต้องการประชาสัมพันธ์
                          <input type="file" name="image" class="form-control">
                      </div><br><br>
                      
                      <div class="form-group" align="center">
                      <?php
                      if(empty($edit_id)){?>
                      <input type="hidden" name="method" value="post">
                      <input type="submit" name="submit" value="ตกลง" class="btn btn-success">
                      <?php }else{ ?>
                      <input type="hidden" name="topic_id" value="<?= $edit_id?>">
                      <input type="hidden" name="method" value="edit_post">
                      <input type="submit" name="submit" value="แก้ไข" class="btn btn-warning">

                      <?php } ?>
                      
                      </div></form>
                  </div></div></div></div>
    
      </div>
      <div class="col-lg-8">
           <div class="row">      
    <div class="col-lg-12">
              <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">หัวข้อประชาสัมพันธ์</h3>
                    </div>
                  <div class="panel-body">
                    
                    <?php include 'connection/connect_i.php';
                    if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
     exit;
}
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
	$urlfile=""; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
	$per_page=5;
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
$query="select tp.*,CONCAT(em.firstname,' ',em.lastname) as fullname from topic_post tp
        inner join emppersonal em on em.empno=tp.empno_post order by tp.topic_id desc";
$qr=mysqli_query($db,$query);
if($qr==''){exit();}
$total=mysqli_num_rows($qr);
 
$e_page=5; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
if(!isset($_GET['s_page'])){   
	$_GET['s_page']=0;   
}else{   
	$chk_page=$_GET['s_page'];     
	$_GET['s_page']=$_GET['s_page']*$e_page;   
}   
$query.=" LIMIT ".$_GET['s_page'].",$e_page";
$qr=mysqli_query($db,$query);
if(mysqli_num_rows($qr)>=1){   
	$plus_p=($chk_page*$e_page)+mysqli_num_rows($qr);   
}else{   
	$plus_p=($chk_page*$e_page);       
}   
$total_p=ceil($total/$e_page);   
$before_p=($chk_page*$e_page)+1;  
echo mysql_error();

while ($topic_post = mysqli_fetch_assoc($qr)) {
    $sql_comm=mysqli_query($db,"select count(topic_id) as comm from comment where topic_id='".$topic_post['topic_id']."'");
    $comm=  mysqli_fetch_assoc($sql_comm);
       
    echo "<a href='comm_page.php?post=$topic_post[topic_id]'><b>ประกาศที่ $topic_post[topic_id]....</b>$topic_post[post]<br>
            <b>ประกาศโดย</b> คุณ$topic_post[fullname] <b>มีผู้สอบถาม <font color='red'>".$comm['comm']."</font> คน</b><p>";
                                        if ($topic_post['link'] != '') {
                                        echo "<a href='".$topic_post['link']."' target='_blank'><i class='fa fa-link'></i>  รายละเอียด </a> <br>";
                                    }
    if ($topic_post['photo_post'] != '') {
                                    $pic = $topic_post['photo_post'];
                                    $fol = "post/";
                                    
                                            $file_name = $pic ;
                                            $info = pathinfo( $file_name , PATHINFO_EXTENSION ) ;
                                            if($info=='jpg' or $info=='JPG' or $info=='bmp' or $info=='BMP' or $info=='png' or $info=='PNG'){?>
                                                <embed src='<?= $fol.$pic?>' mce_src='<?= $fol.$pic?>' width='100' height=''>
                                            <?php }else{?>
                                                <a href="<?= $fol.$pic ?>" target="_blank"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
                                            <?php }?>
                                    
                                 <?php   echo " ";
                                }else{
                                    echo "</a>";
                                }
                                if($empno_poster==$topic_post[empno_post] or $_SESSION[Status]=='ADMIN'){?> 
                                <div align='right'>
                                <a href='mainpost_page.php?edit_id=<?=$topic_post[topic_id]?>' title='แก้ไขประชาสัมพันธ์'><img src='images/file_edit.ico' width='20'></a>
                                <a href='mainpost_page.php?del_id=<?= $topic_post[topic_id]?>' title='ลบประชาสัมพันธ์' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/file_delete.ico' width='20'></a>
                                </div>
                                
<?php } echo"<hr width=90% size=5 color=770088>"; } ?>
                            
<?php if($total>0){
echo mysql_error();

?>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/5)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
 </div>                     
                      
                  </div>
              </div>
    </div>
        </div>
      </div>

</div>

<?php  include 'footeri.php';?>