<?php @session_start(); ?>
<?php include 'connection/connect.php';?>
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
<?php
include_once ('option/funcDateThai.php');
include 'option/function_date.php';

    $empno=$_REQUEST[empno];
    $workid=$_REQUEST[work_id];
    $sql_hos=  mysql_query("SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysql_fetch_assoc($sql_hos);
    $sql=  mysql_query("select w.*,concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,d2.dep_name as depname,p2.posname as posi ,
ty.nameLa as namela,w.tel as telephone
            from work w 
            inner join emppersonal e1 on w.enpid=e1.empno
            inner join pcode p1 on e1.pcode=p1.pcode
            inner join department d1 on e1.depid=d1.depId
            inner join department_group d2 on d2.main_dep=d1.main_dep
            inner join posid p2 on e1.posid=p2.posId
            INNER JOIN typevacation ty on ty.idla=w.typela
            where w.enpid='$empno' and w.workid='$workid'");
    $work=  mysql_fetch_assoc($sql);
    

         /*$sql_leave=  mysql_query("select ty.nameLa as namela, COUNT(w.workid) AS leave_type
            from work w 
                INNER JOIN typevacation ty on ty.idla=w.typela
                    where w.enpid='$empno' GROUP BY ty.idla ");*/
    
     if($date >= $bdate and $date <= $edate){
    $sql_leave=  mysql_query("select ty.nameLa,w.begindate,w.enddate,w.amount FROM print_leave p
INNER JOIN `work` w on w.workid=p.befor_workid
INNER JOIN typevacation ty on w.typela=ty.idla
where p.empno='$empno' and p.workid='$workid' and (w.begindate  BETWEEN '$y-10-01' and '$Yy-09-30')");
     }else{
    $sql_leave=  mysql_query("select ty.nameLa,w.begindate,w.enddate,w.amount FROM print_leave p
INNER JOIN `work` w on w.workid=p.befor_workid
INNER JOIN typevacation ty on w.typela=ty.idla
where p.empno='$empno' and p.workid='$workid' and (w.begindate  BETWEEN '$Y-10-01' and '$y-09-30')");     
     }
 $leave_data=mysql_fetch_assoc($sql_leave); 
 
 $sql_total=  mysql_query("select L3 from leave_day where empno='$empno'");
                                    $leave_total= mysql_fetch_assoc($sql_total);
                                    if($date >= $bdate and $date <= $edate){
                                    $sql_leave_t=  mysql_query("SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and statusla='Y' and
                                                                begindate BETWEEN '$y-10-01' and '$Yy-09-30'");   
                                    }else{
                                    $sql_leave_t=  mysql_query("SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and statusla='Y' and 
                                                                begindate BETWEEN '$Y-10-01' and '$y-09-30'");
                                    }
                                    $sum_leave= mysql_fetch_assoc($sql_leave_t);
                                    $sum_total=$leave_total[L3]+$sum_leave[sum_leave];
?>
<body>
    <?php
require_once('option/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<div class="col-lg-12">
<table width="20%" border="0" align="right">
  <tr>
    <th scope="col">ฝ่ายทรัพยากรบุคคล</th>
  </tr>
  <tr>
      <td align="left">เลขรับ&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $work['leave_no']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td align="left">วันที่................................................</td>
  </tr>
  <tr>
    <td align="left">เวลา................................................</td>
  </tr>
</table>
</div><br>
<div class="col-lg-12" align="right">
เขียนที่<?=$hospital[name]?><br><br>
วันที่ <?= DateThai2($work[reg_date])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

</div>
<br>
<div class="col-lg-12" align="let">
    เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขอลา <?= $work[namela]?> <br><br>
        เรียน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital[name]?><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า <?= $work[fullname]?> ตำแหน่ง <?= $work[posi]?> งาน <?= $work[dep]?> <br>ฝ่าย/กลุ่มงาน <?= $work[depname]?> 
            สังกัดกรมสุขภาพจิต  กระทรวงสาธารณสุข<br>  
            <?php
            if($work[typela]=='3'){
                                ?>
                                 มีวันลาพักผ่อนสะสม<u>&nbsp; <?=$sum_total-10?> &nbsp;</u>วันทำการ  มีสิทธิลาพักผ่อนประจำปีอีก 10 วัน รวมเป็น<u>&nbsp; <?=$sum_total?> &nbsp;</u>วันทำการ <br> 
                             <?php }?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขอลา<u> <?= $work[namela]?> </u>เนื่องจาก<u> <?= $work[abnote]?> </u><br>
                        ตั้งแต่วันที่<u>&nbsp; <?= DateThai2($work[begindate])?>&nbsp; </u>ถึงวันที่<u>&nbsp; <?= DateThai2($work[enddate])?>&nbsp; </u>มีกำหนด<u>&nbsp; <?= $work[amount]?> &nbsp;</u>วัน<br>
                        <?php  if($work[typela]!='3'){?>    
                        ข้าพเจ้าได้ลา<u>&nbsp; <?=$leave_data[nameLa]?> &nbsp;</u>ครั้งสุดท้ายตั้งแต่วันที่
                            <u>&nbsp; <?php if($leave_data[begindate]!=''){ echo DateThai2($leave_data[begindate]);}?> &nbsp;</u>ถึงวันที่
                            <u>&nbsp; <?php if($leave_data[enddate]!=''){ echo DateThai2($leave_data[enddate]);}?> &nbsp;</u>มีกำหนด<u>&nbsp; <?=$leave_data[amount]?> &nbsp;</u>วัน<br>
                            <?php }?>    
                            ในระหว่างการลาจะสามารถติดต่อข้าพเจ้าได้ที่ <?= $work[address]?> โทรศัพท์ <?= $work[telephone]?> <br>
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    
</div> 
                                 <div class="row">
                                 <div class="col-lg-12">
                                     <table width="100%" border="0" cellspacing="0" >
                                         <tr><td>
                                                 <br><p><u>สถิติการลาปีงบประมาณนี้</u></p><br>
                                     <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
  <tr>
    <th scope="col">ประเภทลา</th>
    <th scope="col">ลามาแล้ว</th>
    <th scope="col">ลาครั้งนี้</th>
    <th scope="col">รวมเป็น</th>
  </tr>
  <?php
  $sql_leave2=  mysql_query("select p.*
FROM print_leave p
where p.empno='$empno' and p.workid='$workid' order by print_id desc");
  $leave2=mysql_fetch_assoc($sql_leave2);?>
  
  <?php if($leave2[last_type1]!=''){?>
  <tr>
      
    <th scope="row"><?=$leave2[last_type1]?></th>
    <td align="center"><?=$leave2[last_amount1]?> วัน</td>
    <?php if($work[namela]==$leave2[last_type1]){?>
    <td align="center"><?= $work[amount]?> วัน</td>
    <td align="center"><?= $work[amount]+$leave2[last_amount1]?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2[last_type2]!=''){?>
  <tr>
    <th scope="row"><?=$leave2[last_type2]?></th>
    <td align="center"><?=$leave2[last_amount2]?> วัน</td>
    <?php if($work[namela]==$leave2[last_type2]){?>
    <td align="center"><?= $work[amount]?> วัน</td>
    <td align="center"><?= $work[amount]+$leave2[last_amount2]?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2[last_type3]!=''){?>
  <tr>
    <th scope="row"><?=$leave2[last_type3]?></th>
    <td align="center"><?=$leave2[last_amount3]?> วัน</td>
    <?php if($work[namela]==$leave2[last_type3]){?>
    <td align="center"><?= $work[amount]?> วัน</td>
    <td align="center"><?= $work[amount]+$leave2[last_amount3]?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2[last_type4]!=''){?>
  <tr>
    <th scope="row"><?=$leave2[last_type4]?></th>
    <td align="center"><?=$leave2[last_amount4]?> วัน</td>
    <?php if($work[namela]==$leave2[last_type4]){?>
    <td align="center"><?= $work[amount]?> วัน</td>
    <td align="center"><?= $work[amount]+$leave2[last_amount4]?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2[last_type5]!=''){?>
  <tr>
    <th scope="row"><?=$leave2[last_type5]?></th>
    <td align="center"><?=$leave2[last_amount5]?> วัน</td>
    <?php if($work[namela]==$leave2[last_type5]){?>
    <td align="center"><?= $work[amount]?> วัน</td>
    <td align="center"><?= $work[amount]+$leave2[last_amount5]?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2[last_type6]!=''){?>
  <tr>
    <th scope="row"><?=$leave2[last_type6]?></th>
    <td align="center"><?=$leave2[last_amount6]?> วัน</td>
    <?php if($work[namela]==$leave2[last_type6]){?>
    <td align="center"><?= $work[amount]?> วัน</td>
    <td align="center"><?= $work[amount]+$leave2[last_amount6]?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2[last_type7]!=''){?>
  <tr>
    <th scope="row"><?=$leave2[last_type7]?></th>
    <td align="center"><?=$leave2[last_amount7]?> วัน</td>
    <?php if($work[namela]==$leave2[last_type7]){?>
    <td align="center"><?= $work[amount]?> วัน</td>
    <td align="center"><?= $work[amount]+$leave2[last_amount7]?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php } ?>
  <?php if(($leave2[befor_workid]=='0' or $leave2[befor_workid]=='') and 
          ($leave2[last_type1]!=$work['namela'] and $leave2[last_type2]!=$work['namela'] and $leave2[last_type3]!=$work['namela']
           and $leave2[last_type4]!=$work['namela'] and $leave2[last_type5]!=$work['namela'] and $leave2[last_type6]!=$work['namela']
           and $leave2[last_type7]!=$work['namela'])){?>
  <tr>
    <th scope="row"><?= $work['namela']?></th>
    <td align="center">&nbsp;</td>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']?> วัน</td>
  </tr>
  <?php }?>
</table><br><br>
                                    
                                         <center>(ลงชื่อ)..........................................................ผู้ตรวจสอบ<br><br>
                                         ........../............/............<br><br></center>
                                         ในการลาครั้งนี้ได้มอบหมายให้&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                                         นาย/นาง/น.ส..........................................................<br>
                                         ปฎิบัติงานแทน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                                         <center>(ลงชื่อ)..........................................................ผู้มอบ<br>
                                         ( <?= $work[fullname]?> )<br>
                                          <?= DateThai2($work[reg_date])?><br><br>
                                         (ลงชื่อ)..........................................................ผู้รับมอบ<br><br>
                                         (..........................................................)<br><br>
                                         ........../............/............</center><br><br>
                                         <?php if($work[typela]=='3'){?>
                                         <h5><b>* สำหรับบุคลกรที่ปฏิบัตงานไม่ครบ 6 เดือนไม่ได้รับสิทธิให้ลาพักผ่อน</b></h5><br>
                                         <?php }else{?>
                                         <h5><b>** สำหรับลูกจ้างชั่วคราวภายใน 6 เดือนแรกที่ลาป่วยเกิน 3 วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></h5><br>
                                         <center>ยินยอม&nbsp; (&nbsp; )&nbsp; หักเงินเดือน&nbsp; (&nbsp; )&nbsp; ทำงานชดเชย<br><br>
                                         (ลงชื่อ)..........................................................ผู้ขออนุญาต<br>
                                         ( <?= $work[fullname]?> )<br></center>
                                         <?php }?>
                                         </td>
                                         <td>
                                     <br><br>
                                         <center>ขอแสดงความนับถือ<br><br>
                                                     ..........................................................<br>
                                                     ( <?= $work[fullname]?> )<br>
                                                      <?= DateThai2($work[reg_date])?><br><br></center>
                                         <left> เรียน  หัวหน้า <?= $work[depname]?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                             - เห็นควรเสนอผู้อำนวยการพิจารณาอนุญาต&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br></left>
                                         <center>(ลงชื่อ).............................................หัวหน้างาน/รักษาการ<br><br>
                                             (..........................................................)<br><br>
                                         ........../............/............<br><br></center>
                                         <left>เรียน  ผู้อำนวยการ <?=$hospital[name]?>&nbsp;&nbsp;<br>
                                                     - เพื่อพิจารณาอนุญาต&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br></left>
                                         <center>(ลงชื่อ).............................................หัวหน้าฝ่าย/รักษาการ<br><br>
                                         (..........................................................)<br><br>
                                         ........../............/............<br><br>
                                         <u>คำสั่ง</u>&nbsp; (&nbsp; )&nbsp; อนุญาต &nbsp;    (&nbsp; )&nbsp; ไม่อนุญาต<br><br><br>
                                         (ลงชื่อ)..........................................................ผู้อำนวยการฯ<br><br>
                                         (..........................................................)<br><br>
                                         ........../............/............</center>
                                         <br>
                                         <div class="col-lg-12" align="right">
                                         <?php if($work[typela]=='3'){?>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-AD-018
                                         <?php }else{ ?>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-AD-019
                                         <?php }?>
                                     </div>
                                         
                                                     </td> </tr></table>
                                     
                                 </div>
                                     
                                      </div>
<?php 
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('th', 'A4', '11', 'THSaraban');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output("MyPDF/leave$empno$Code.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/leave$empno$Code.pdf' />";
?>
</body>
</html>