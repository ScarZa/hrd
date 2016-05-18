<?php include 'header.php';?>
<?php if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<div class="row">
          <div class="col-lg-12">
            <h1><font color='blue'>  ผู้เข้าร่วมโครงการ </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_trainout.php"><i class="fa fa-home"></i> บันทึกการฝึกอบรมภายนอกหน่วยงาน</a></li>
              <li class="active"><i class="fa fa-edit"></i> ผู้เข้าร่วมโครงการ</li>
            </ol>
          </div>
      </div>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">โครงการ</h3>
                    </div>
                <div class="panel-body">
                    <?php
                      include_once ('option/funcDateThai.php');
            $project_id = $_REQUEST[id];
            $sql_pro = mysql_query("SELECT t.*, p.PROVINCE_NAME FROM training_out t
            inner join province p on t.provenID=p.PROVINCE_ID
            WHERE tuid='$project_id'");
            $Project_detial = mysql_fetch_assoc($sql_pro);
  
                    ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><b>เลขที่โครงการ : &nbsp; </b><?= $Project_detial[memberbook] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ชื่อโครงการ : &nbsp; </b><?= $Project_detial[projectName] ?></td>
                                </tr>
                                <tr>
                                    <td><b>หน่วยงานที่จัดโครงการ : &nbsp; </b><?= $Project_detial[anProject] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ตั้งแตวันที่ : &nbsp; </b><?= DateThai1($Project_detial[Beginedate]) ?>&nbsp; <b> ถึง &nbsp;</b><?= DateThai1($Project_detial[endDate]) ?>
                                    <b> &nbsp; จำนวน : &nbsp; </b><?= $Project_detial[amount] ?><b>&nbsp; วัน</b>
                                    <b> &nbsp; ณ. &nbsp; </b><?= $Project_detial[stantee] ?><b> &nbsp; จ. </b> &nbsp; <?= $Project_detial[PROVINCE_NAME] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ค่าที่พัก : &nbsp; </b><?= $Project_detial[m1] ?><b>&nbsp;บาท&nbsp; </b>&nbsp;&nbsp;<b>ค่าลงทะเบียน : &nbsp; </b><?= $Project_detial[m2] ?><b>&nbsp;บาท&nbsp; </b>&nbsp;&nbsp;
                                    <b>ค่าเบี้ยเลี้ยง : &nbsp; </b><?= $Project_detial[m3] ?><b>&nbsp;บาท&nbsp; </b><br><b>ค่าพาหนะเดินทาง : &nbsp; </b><?= $Project_detial[m4] ?><b>&nbsp;บาท&nbsp; </b>&nbsp;&nbsp;
                                    <b>ค่าใช้จ่ายอื่นๆ : &nbsp; </b><?= $Project_detial[m5] ?><b>&nbsp;บาท&nbsp; </b></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                <div class="panel-body">
                    <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="add_trainout.php">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div class="form-group">
                    <input type="text" placeholder="ค้นหา ชื่อ/ตำแหน่ง/หน่วยงาน" name='txtKeyword' class="form-control" value="<?php echo $Search_word; ?>" >
                    <input type='hidden' name='method'  value='txtKeyword'>
                    <input type='hidden' name='id'  value='<?=$project_id?>'>
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
        $trainin_id = $_REQUEST['id'];
	$urlfile="add_trainout.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
		echo "<a  href='$urlfile?id=".$trainin_id."&&s_page=$pPrev".$querystr."' class='naviPN'>Prev</a>";
	}
	for($i=$total_start_p;$i<$total_end_p;$i++){  
		$nClass=($chk_page==$i)?"class='selectPage'":"";
		if($e_page*$i<=$total){
		echo "<a href='$urlfile?id=".$trainin_id."&&s_page=$i".$querystr."' $nClass  >".intval($i+1)."</a> ";   
		}
	}		
	if($chk_page<$total_p-1){
		echo "<a href='$urlfile?id=".$trainin_id."&&s_page=$pNext".$querystr."'  class='naviPN'>Next</a>";
	}
}   
 if($_POST[method]=='txtKeyword'){
$_SESSION[Keyword_addT]=$_POST[txtKeyword];
 }
$Search_word=($_SESSION[Keyword_addT]);
 if($Search_word != ""){
//คำสั่งค้นหา
     $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname, d.depName as dep from emppersonal e1 
INNER JOIN posid p1 on e1.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
inner join department d on e1.depid=d.depId
         WHERE e1.posid=p1.posId and (e1.firstname LIKE '%$Search_word%' or p1.posname LIKE '%$Search_word%' or d.depName LIKE '%$Search_word%') and e1.status ='1' order by empno"; 
 }else{
 $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname, d.depName as dep from emppersonal e1 
left outer JOIN posid p1 on e1.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
inner join department d on e1.depid=d.depId
where e1.posid=p1.posId and e1.status ='1'
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
<form action="prctraining.php" method="post" name="form" enctype="multipart/form-data" id="form" >
<br>
<div align="center"><input type="submit" name="submit" id="submit" class="btn btn-success" value="ตกลง" ></div>
<br>
                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <tr align="center" bgcolor="#898888">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="5%">เลือก</th>
                                <th align="center" width="26%">ชื่อ-นามสกุล
                                <th align="center" width="20%">ตำแหน่ง</th>
                                <th align="center" width="20%">หน่วยงาน</th>  
                                <th align="center" width="7%">ระหว่างวันที่</th>
                                <th align="center" width="7%">ถึงวันที่</th>
                                <th align="center" width="10%">จำนวนชั่วโมง</th>
                            </tr>
                            
                            <?php
                             $i=1;
                             $c=0;
while($result=mysql_fetch_assoc($qr)){?>
    <tr>
                                <td align="center"><?=($chk_page*$e_page)+$i?></td>
                                <td align="center">
                                    <input type="checkbox" name="check_ps[]" id="check_ps[]" value="<?=$c?>" />
                                    <input type="hidden" name="empno[]" id="empno[]" value="<?=$result[empno]?>"
                                </td>
                                <td><?=$result[fullname];?></td>
                                <td align="center"><?=$result[posname];?></td>
                                <td align="center"><?=$result[dep];?></td>
                                <td align="center">
                                    <input type="date" name="dates[]" id="dates[]" value='<?=$Project_detial[Beginedate]?>'>
                                </td>
                                <td align="center">
                                    <input type="date" name="datee[]" id="datee[]" value='<?=$Project_detial[endDate]?>'>
                                </td>
                                <td align="center" width="11%">
                                    <input type="text" name="amount[]" id="amount[]" value='<?=$Project_detial[amount]?>' size="2">
                                </td>
                          </tr>
                          <input type="hidden" name="pro_type[]" id="pro_type[]" value='<?=$Project_detial[dt]?>'>
    <?php $i++;
    $c++; } ?>
                                
                        </table>
<input type="hidden" name="id" value="<?=$Project_detial['tuid']?>">
<input type="hidden" name="method" value="add_pro_trainout">
</form>
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
