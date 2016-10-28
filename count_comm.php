<?php session_start(); 
include 'connection/connect_i.php';

$sql = mysqli_query($db,"select count(re.recomm_id) AS countrecomm from re_comment re
        inner join comment comm on comm.comm_id=re.comm_id
        WHERE re.check_recomm='N' and re.empno_re!='$_SESSION[user]' and comm.empno_comm='$_SESSION[user]'");
                                    $result = mysqli_fetch_assoc($sql);
                                    echo mysqli_error($db);
                                    if($result['countrecomm']!='0'){
                                ?>
<li class="dropdown alerts-dropdown">
<a href="JavaScript:doCallAjax('countrecomm')" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Bell.ico' width='18'> มีคนตอบกลับ   
<span class="badge_alert" ><?php echo $result['countrecomm']; ?></span><b class="caret"></b></a>

<ul class="dropdown-menu">
                                            <?php 
                                            $sql2 = mysqli_query($db,"SELECT comm.topic_id,re.comm_id, LEFT( re.recomm, 20 ) AS detail, concat(e.firstname,' ',e.lastname) as fullname, re.recomm_date
                                                                        FROM re_comment re
                                                                        inner join comment comm on comm.comm_id=re.comm_id
                                                                        INNER JOIN emppersonal e ON e.empno = re.empno_re
                                                                        WHERE re.check_recomm='N' and re.empno_re!='$_SESSION[user]' and comm.empno_comm='$_SESSION[user]'
                                                                        ORDER BY re.recomm_id");
                                            while ($result2 = mysqli_fetch_assoc($sql2)) {
                                                ?>
                                                <li><a href="comm_page.php?post=<?= $result2['topic_id']; ?>&comm_id=<?= $result2['comm_id']; ?>&method=check_recomm">
                                                    <span class="name"><b><?php echo $result2['fullname']; ?>:</b></span>
                                                    <span class="message"><?php echo $result2['detail']; ?>...</span><br>
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?php
                                                        include_once ('option/funcDateThai.php');
                                                        echo DateThai1($result2['recomm_date']) ; //-----แปลงวันที่เป็นภาษาไทย  
                                                        ?></span>
                                                    </a></li><li class="divider"></li>
                                            <?php } ?>
                                            
                                            <!--<li><a href="index.php?page=car/pre_request">ดูทั้งหมด</a></li>-->
                                        </ul>
</li>
<?php }
$sql3 = mysqli_query($db,"select count(comm.comm_id) AS countcomm from comment comm
        inner join topic_post top on comm.topic_id=top.topic_id
        WHERE comm.check_comm='N' and comm.empno_comm!='$_SESSION[user]' and top.empno_post='$_SESSION[user]'");
                                    $result3 = mysqli_fetch_assoc($sql3);
                                    echo mysqli_error($db);
                                    if($result3['countcomm']!='0'){
                                ?>
<li class="dropdown alerts-dropdown">
<a href="JavaScript:doCallAjax('countrecomm')" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Bell.ico' width='18'> มีคนแสดงความคิดเห็น   
<span class="badge_alert" ><?php echo $result3['countcomm']; ?></span><b class="caret"></b></a>

<ul class="dropdown-menu">
                                            <?php 
                                            $sql4 = mysqli_query($db,"SELECT comm.topic_id,comm.comm_id, LEFT( comm.comm, 20 ) AS detail, concat(e.firstname,' ',e.lastname) as fullname, comm.comm_date
                                                                        FROM comment comm 
                                                                        inner join topic_post top on comm.topic_id=top.topic_id
                                                                        INNER JOIN emppersonal e ON e.empno = comm.empno_comm
                                                                        WHERE comm.check_comm='N' and comm.empno_comm!='$_SESSION[user]' and top.empno_post='$_SESSION[user]'
                                                                        ORDER BY comm.comm_id");
                                            while ($result4 = mysqli_fetch_assoc($sql4)) {
                                                ?>
                                                <li><a href="comm_page.php?post=<?= $result4['topic_id']; ?>&comm_id=<?= $result4['comm_id']; ?>&method=check_comm">
                                                    <span class="name"><b><?php echo $result4['fullname']; ?>:</b></span>
                                                    <span class="message"><?php echo $result4['detail']; ?>...</span><br>
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?php
                                                        include_once ('option/funcDateThai.php');
                                                        echo DateThai1($result4['comm_date']) ; //-----แปลงวันที่เป็นภาษาไทย  
                                                        ?></span>
                                                    </a></li><li class="divider"></li>
                                            <?php } ?>
                                            
                                            <!--<li><a href="index.php?page=car/pre_request">ดูทั้งหมด</a></li>-->
                                        </ul>
</li>
<?php }
$sql5 = mysqli_query($db,"select count(f.finger_id) AS countfinger from fingerprint f
LEFT JOIN `work` w ON f.empno=w.enpid AND f.forget_date BETWEEN w.begindate AND w.enddate AND w.statusla='Y'
LEFT JOIN plan_out p ON f.empno=p.empno AND f.forget_date BETWEEN p.begin_date AND p.end_date
WHERE ISNULL(w.enpid) AND ISNULL(p.empno) and f.empno='$_SESSION[user]' and f.see='N'");
                                    $result5 = mysqli_fetch_assoc($sql5);
                                    echo mysqli_error($db);
                                    if($result5['countfinger']!='0'){
                                ?>
<li class="dropdown alerts-dropdown">
<a href="JavaScript:doCallAjax('countrecomm')" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Bell.ico' width='18'> ลืมลงเวลา   
<span class="badge_alert" ><?php echo $result5['countfinger']; ?></span><b class="caret"></b></a>

<ul class="dropdown-menu">
                                            <?php include_once ('option/funcDateThai.php');
                                            $sql6 = mysqli_query($db,"SELECT f.finger_id,f.empno, f.forget_date,if(work_scan='N','ไม่ลงเวลามา','')as wscan,
                                                                    if(finish_work_scan='N','ไม่ลงเวลากลับ','')as fwscan
                                                                        FROM fingerprint f 
                                                                        LEFT JOIN `work` w ON f.empno=w.enpid AND f.forget_date BETWEEN w.begindate AND w.enddate AND w.statusla='Y'
                                                                        LEFT JOIN plan_out p ON f.empno=p.empno AND f.forget_date BETWEEN p.begin_date AND p.end_date
                                                                        WHERE ISNULL(w.enpid) AND ISNULL(p.empno) and f.empno='$_SESSION[user]' and f.see='N'
                                                                        ORDER BY f.finger_id desc");
                                            while ($result6 = mysqli_fetch_assoc($sql6)) {
                                                ?>
                                                <li><a href="#" onClick="return popup('add_sign.php?id=<?=$result6['empno']?>&scan_id=<?= $result6['finger_id']?>&method=exp_sign', popup, 450, 500);" title="เขียนใบชี้แจง">
                                                        <span class="name"><b>ลืมลงเวลา วันที่ <?php echo DateThai1($result6['forget_date']); ?></b></span><br>
                                                        <?php if(!empty($result6['wscan'])){?>
                                                    <span class="message"><?php echo $result6['wscan']; ?></span><br>
                                                        <?php } if(!empty($result6['fwscan'])){?>
                                                    <span class="message"><?php echo $result6['fwscan']; ?></span><br>
                                                        <?php }?>
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?php
                                                        
                                                        //echo DateThai1($result6['comm_date']) ; //-----แปลงวันที่เป็นภาษาไทย  
                                                        ?></span>
                                                    </a></li><li class="divider"></li>
                                            <?php } ?>
                                            
                                            <!--<li><a href="index.php?page=car/pre_request">ดูทั้งหมด</a></li>-->
                                        </ul>
</li>
<?php }
$sql5 = mysqli_query($db,"select count(l.late_id) AS countlate from late l
WHERE l.empno='$_SESSION[user]' and l.see='N'");
                                    $result5 = mysqli_fetch_assoc($sql5);
                                    echo mysqli_error($db);
                                    if($result5['countlate']!='0'){
                                ?>
<li class="dropdown alerts-dropdown">
<a href="JavaScript:doCallAjax('countrecomm')" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Bell.ico' width='18'> ลืมลงเวลา   
<span class="badge_alert" ><?php echo $result5['countlate']; ?></span><b class="caret"></b></a>

<ul class="dropdown-menu">
                                            <?php include_once ('option/funcDateThai.php');
                                            $sql6 = mysqli_query($db,"SELECT l.late_id,l.empno, l.late_date,l.late_time
                                                                        FROM late l
                                                                        WHERE l.empno='$_SESSION[user]' and l.see='N'
                                                                        ORDER BY l.late_id desc");
                                            while ($result6 = mysqli_fetch_assoc($sql6)) {
                                                ?>
                                                <li><a href="#" onClick="return popup('add_sign.php?id=<?=$result6['empno']?>&late_id=<?= $result6['late_id']?>&method=exp_late', popup, 450, 500);" title="เขียนใบชี้แจง">
                                                        <span class="name"><b>ลงเวลาสาย วันที่ <?php echo DateThai1($result6['late_date']); ?></b></span><br>
                                                        <span class="message">ลงเวลา <?php echo substr($result6['late_time'], 0,5); ?> น.</span><br>
                                                        <span class="time"><i class="fa fa-clock-o"></i> <?php
                                                        
                                                        //echo DateThai1($result6['comm_date']) ; //-----แปลงวันที่เป็นภาษาไทย  
                                                        ?></span>
                                                    </a></li><li class="divider"></li>
                                            <?php } ?>
                                            
                                            <!--<li><a href="index.php?page=car/pre_request">ดูทั้งหมด</a></li>-->
                                        </ul>
</li>
<?php }?>

