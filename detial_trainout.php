<?php @session_start(); ?>
<?php include 'connection/connect.php'; ?>
<?php
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
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
        <script src="option/js/excellentexport.js"></script>
        </head>
    <body>
<?php
    include_once ('option/funcDateThai.php');
    $empno=$_REQUEST[id];
    $project_id=$_REQUEST[pro_id];

    ?>
<?php if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
<script type="text/javascript">
		function popup(url,name,windowWidth,windowHeight){    
				myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
				mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
				properties = "width="+windowWidth+",height="+windowHeight;
				properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
				window.open(url,name,properties);
	}
</script>
<div class="row">
          <div class="col-lg-12">
               <h1><font color='blue'>  สรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนาและศึกษาดูงานภายนอกหน่วยงาน </font></h1> 
             <ol class="breadcrumb alert-success">
              <li><a href="pre_project_out.php?id=<?=$project_id?>"><i class="fa fa-home"></i> รายละเอียดโครงการ</a></li>
              <li class="active"><i class="fa fa-edit"></i> สรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนา</li>
              </ol>
               
              </div>
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">สรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนา</h3>
                    </div>
                <div class="panel-body">
<?php
$sql_per = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        where e1.empno='$empno'");
    $sql_pro = mysql_query("SELECT t.*, p.PROVINCE_NAME,t2.tName as tname FROM training_out t
            inner join province p on t.provenID=p.PROVINCE_ID
            inner join trainingtype t2 on t2.tid=t.dt
            WHERE tuid='$project_id'");
    
            $Person_detial = mysql_fetch_assoc($sql_per);
            $Project_detial = mysql_fetch_assoc($sql_pro);
         
            $sql_trainout=  mysql_query("select *,count(empno) as count_person from plan_out where empno='$empno' and idpo='$project_id'");
            $person_data=mysql_fetch_assoc($sql_trainout);
    ?>
                    <table border="1" width="100%">
                        <tr>
                            <td width="40%">เลขที่รายงาน <u><?= $Project_detial[memberbook]?></u></td>
                    <td width="60%">วันที่ส่งคืน ฝ่ายทรัพยากรบุคคล ภายในวันที่ <u><?php 
                    $re_date=$Project_detial['Beginedate'];
                    $check_date = date('Y-m-d', strtotime("$re_date+15 days ")); echo DateThai1($check_date);
                    ?></u></td>
                        </tr>
                    </table>                   
    <center><h4>แบบฟอร์มสรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนาและศึกษาดูงานภายนอกหน่วยงาน</h4></center><br>
    <b>1. ชื่อ-นามสกุล ผู้ได้รับอนุมัติ</b> <u><?=$Person_detial[fullname]?></u> <b>ตำแหน่ง</b> <u><?=$Person_detial[posi]?></u> <b>พร้อมคณะ</b> <?= $person_data[count_person]-1?>  <b>คน</b><br>
    <b>2. ชื่อโครงการ / กิจกรรม</b> <u><?=$Project_detial[projectName]?></u><br>
    <b>3. หน่วยงานที่จัด</b> <u><?=$Project_detial[anProject]?></u><br>
    <b>4. ระหว่างวันที่</b> <u><?= DateThai2($Project_detial[Beginedate]) ?></u>&nbsp; <b> ถึง &nbsp;</b> <u><?= DateThai2($Project_detial[endDate]) ?></u><br>
    <b>5. สถานที่</b> <u><?= $Project_detial[stantee] ?></u> จ. <u><?= $Project_detial[PROVINCE_NAME] ?></u>  <b>ระยะเวลา</b> <u><?= $Project_detial[amount] ?></u><b>&nbsp; วัน</b><br>
    <b>6. วัตถุประสงค์ของการประชุม/อบรม/สัมมนา/ดูงานภายนอกหน่วยงานครั้งนี้ คือ &nbsp;</b><p><u><?=$person_data[pj_obj];?></u></p>
    <b>7. รุปแบบการจัดโครงการ/กิจกรรม </b><u><?= $Project_detial[tname] ?></u><br>
    <b>8. ค่าใช้จ่าย</b><br>
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าที่พัก &nbsp;</b><u><?=$person_data[abode];?></u><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าลงทะเบียน &nbsp;</b><u><?=$person_data[reg];?></u><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าเบี่ยเลี้ยง &nbsp;</b><u><?=$person_data[allow];?></u><b>&nbsp;บาท</b><br>
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าพาหนะเดินทาง &nbsp;</b><u><?=$person_data[travel];?></u><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าใช้จ่ายอื่นๆ &nbsp;</b><u><?=$person_data[other];?></u><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <?php if($Project_detial['Hos_car']=='Y'){ echo 'ใช้';}?> ) &nbsp;<b>ใช้พาหนะโรงพยาบาล</b><br>
    <b>9. สรุปสาระสำคัญที่ได้จากการประชุม/อบรม/สัมมนา/ดูงาน(แนบเอกสารเพิ่มเติม) &nbsp;</b>
    <p><u><?=$person_data['abstract']?></u></p>
    <b>10. การนำมาใช้ประโยชน์ และข้อเสนอแนะ &nbsp;</b>
             	<p><?=$person_data[comment]?></p>
    <b>11. เอกสารประกอบการประชุม</b><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>หนังสือ : </b>( <?=$person_data[book]?> )
 
    <b>เอกสารประกอบ : </b>( <?=$person_data[paper]?> )
 
    <b>CD ข้อมูล : </b>( <?=$person_data[cd]?> )
    <br><br><div align="right">
        <b>( ลงชื่อ ) ............................................ ผู้รายงาน  &nbsp;&nbsp;&nbsp;ว/ด/ป <?= DateThai2($person_data[reg_date])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><br><br>
    <b>( ลงชื่อ ) ............................................ หัวหน้าฝ่าย/งาน  &nbsp;&nbsp;&nbsp;ว/ด/ป ......................</b></div><br>
    <b><u>ความเห็นของผู้อำนวยการ</u> ......................................................................................................</b><br><br>
    <div align="right">
    <b>( ลงชื่อ ) ........................................</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
    <?php $sql_hos=  mysql_query("SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysql_fetch_assoc($sql_hos);
    echo $hospital['fullname'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
    <b> ........................................ </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
    F-AD-111-04</div>
    
    <?php 
    $sql_person=  mysql_query("select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname, po.status_out as status_out from emppersonal e1 
INNER JOIN posid p1 on e1.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
inner join plan_out po on po.empno=e1.empno
where e1.posid=p1.posId and e1.status ='1' and po.idpo='$project_id'
ORDER BY empno");
    ?>
    
    <center><h4>รายชื่อคณะเดินทางไปราชการ</h4></center>
    
    <table border="0" width="100%">
  <?php
                             $i=1;
while($team=  mysql_fetch_assoc($sql_person)){?>
        <tr>
            <td><b><?= $i?>.</b></td>
            <td><?= $team['fullname']?></td>
            <td><b>ตำแหน่ง</b> &nbsp;&nbsp;<?= $team['posname']?></td>
        </tr>
        <?php $i++; } ?>
    </table>
    <br><br><br>
    <b>
        <u>หมายเหตุ</u> &nbsp;1. ให้ส่งรายงานนี้ภายใน 15 วัน หลังเสร็จสิ้นการประชุม/อบรม/สัมมนา/ดูงาน<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. โปรดสรุปสาระสำคัญเพื่อเป็น<u>สาระสำคัญ</u>สำหรับเผยแพร่แก่ จนท. อื่น ตามแบบฟอร์ม One Page Information<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. กรณีมีเอกสารแจกที่น่าสนใจ ขอโปรดอนบมาด้วยเพื่อนำเสนอผู้อำนายการ และอาจสำเนาส่งฝ่าย/งานที่เกี่ยวข้องเพิ่มเติม (ตัวจริงจะคืนเจ้าของ)<br>
    </b>
    <br><br><br>
    <div align="right">F-AD-111-04</div>
    <br><b>ONE PAGE INFORMATION &nbsp;</b>
                <?php if ($person_data[OPI] != '') {
                    echo "<a href='OPI/$person_data[OPI]' target='_blank'><span class='fa fa-download'></span> รายละเอียด" . "<br />";
                }?>
</div>
                   </div></div></div>
