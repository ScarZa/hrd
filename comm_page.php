<?php include 'header.php';?>
<?php
include 'connection/connect_i.php';
include 'option/funcDateThai.php';
if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
     exit;
}
$topic_id= $_REQUEST[post];
if($_REQUEST['method']=='check_recomm'){
    $comm_id=$_REQUEST['comm_id'];
    $sql_re=  mysqli_query($db, "update re_comment set check_recomm='R' where comm_id='$comm_id'");
}
if($_REQUEST['method']=='check_comm'){
    $comm_id=$_REQUEST['comm_id'];
    $sql_comm=  mysqli_query($db, "update comment set check_comm='R' where comm_id='$comm_id'");
}
        $sql = "select tp.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from topic_post tp
        inner join emppersonal em on em.empno=tp.empno_post
        where topic_id='$topic_id'";
        $qr=mysqli_query($db,$sql);
        $topic_post = mysqli_fetch_assoc($qr);
        
        if ($topic_post[photo] != '') {
                                    $photo = $topic_post[photo];
                                    $folder = "photo/";
                                } else {
                                    $photo = 'person.png';
                                    $folder = "images/";
                                }
        if ($topic_post[photo_post] != '') {
                                    $photo_post = $topic_post[photo_post];
                                    $folder_post = "post/";
                                } else {
                                    
                                    }
                                    
                            $file_name = $photo_post ;
                                            $info = pathinfo( $file_name , PATHINFO_EXTENSION ) ;
                                            if($info=='pdf' or $info=='PDF'){
                                                $width='400';
                                                $hight='400';
                                            }else{
                                                $width='20%';
                                                $hight='';
                                            }        
                    ?>
<script type="text/javascript" src="option/js/jquery-latest.min.js"></script><!-- โหลดซ่อนข้อความ --> 
<ol class="breadcrumb alert-success">
    <li class=""><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
    <li class=""><a href="mainpost_page.php"><i class="fa fa-tags"></i> ประชาสัมพันธ์</a></li>
    <li class="active"><i class="fa fa-tags"></i> แสดงความคิดเห็น</li>
</ol>
<div class="row">      
    <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">หัวข้อประชาสัมพันธ์</h3>
                    </div>
                  <div class="panel-body">
                      <img src='<?= $folder . $photo ?>' width="65"> <b><?= $topic_post[fullname]?></b>  <font color='gray'>ประกาศเมื่อ <?= DateThai1($topic_post[post_date])?></font><br>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?= $topic_post[post]?><br><br>
                            <?php if (!empty($topic_post[photo_post])) {
                            $file_name = $photo_post ;
                                            $info = pathinfo( $file_name , PATHINFO_EXTENSION ) ;
                                            if($info=='jpg' or $info=='JPG' or $info=='bmp' or $info=='BMP' or $info=='png' or $info=='PNG'){?>
                      <a href="<?= $folder_post . $photo_post ?>" target="_blank">
                          <embed src="<?= $folder_post . $photo_post ?>" mce_src="<?= $folder_post . $photo_post ?>" width="400" height="100%"></a>
                                            <?php }else {?>
                            <a href="<?= $folder_post . $photo_post ?>" target="_blank"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
                            <?php  }}?>
                            <br>
                      <hr width=90% size=5 color=770088>
                      <form class="" role="form" action='prcpost.php' enctype="multipart/form-data" method='post'>
                          <div class="form-group">
                         <?php
                      $query2=mysqli_query($db,"select photo as photo from emppersonal 
                                        where empno='$_SESSION[user]'");
                         $photo_comm= mysqli_fetch_assoc($query2);
                         if ($photo_comm[photo] != '') {
                                    $photoc = $photo_comm[photo];
                                    $folderc = "photo/";
                                } else {
                                    $photoc = 'person.png';
                                    $folderc = "images/";
                                }
                         ?>
                          <table border="0" width="70%">
                              <tr>
                                  <td align="right" width="10%"><img src='<?= $folderc . $photoc ?>' width="55"></td>
                                  <td width="80%"><input type="text" class="form-control" name="comm" placeholder="แสดงความคิดเห็น"  aria-describedby="sizing-addon1" required="">
                                      <input type="hidden" name="method" value="comment">
                                      <input type="hidden" name="topic_id" value="<?= $topic_id?>"></td>
                                  <td align="left" width="10%"><input class="btn btn-success" type="submit" name="submit" id="submit" value="ตกลง"></td>
                              </tr>
                          </table>
                                    </div>
                          </form>
        <?php
         $query="select c.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from comment c
                    inner join emppersonal em on em.empno=c.empno_comm
                    where c.topic_id='$topic_id'";
            $qr2=mysqli_query($db,$query);
            $i=1;
                        while ($comm = mysqli_fetch_assoc($qr2)) {
                if ($comm[photo] != '') {
                                    $photo = $comm[photo];
                                    $folder = "photo/";
                                } else {
                                    $photo = 'person.png';
                                    $folder = "images/";
                                }
                echo "<b>ความคิดเห็นที่ $i</b> <font color='gray'>&nbsp;&nbsp; วันที่ ".DateThai1($comm[comm_date])."</font><br><img src=$folder$photo width='40'> $comm[fullname]....$comm[comm]<br> ";?>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="return popup('recomment_page.php?comm=<?= $comm[comm_id]?>', popup, 500, 125);" title="ตอบกลับความคิดเห็น">ตอบกลับ</a>
                      <p>
             <?php $i++;  
            
            $query="select rc.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from re_comment rc
                inner join comment c on c.comm_id=rc.comm_id
                    inner join emppersonal em on em.empno=rc.empno_re
                    where c.topic_id='$topic_id' and '$comm[comm_id]'=rc.comm_id";
            $qr3=mysqli_query($db,$query); ?>
         <!--   <a class="dropdown" href="#" style="cursor:pointer;" onclick="$('#a_toggle').toggle();" >
        <td>ข้อความ</td>
    </a>
                  <span style="display:none;" id="a_toggle">   -->     
        <?php    $i2=1;
                        while ($recomm = mysqli_fetch_assoc($qr3)){ 
                                if ($recomm[photo] != '') {
                                    $photore = $recomm[photo];
                                    $folderre = "photo/";
                                } else {
                                    $photore = 'person.png';
                                    $folderre = "images/";
                                } ?>
                
                          
            <?php    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ตอบกลับความคิดเห็นที่ $i2</b> <font color='gray'>&nbsp;&nbsp; วันที่ ".DateThai1($recomm[recomm_date])."</font><br>"
                        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=$folderre$photore width='30'> $recomm[fullname]....$recomm[recomm]<br><p> ";
                        $i2++;  
                       
                              }
                              //echo "</span>";
                                } 
                              ?>
                      </div>
              </div>
    </div>
</div>
<?php include 'footeri.php';?>