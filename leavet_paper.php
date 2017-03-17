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
    $empno=$_REQUEST[empno];
    $workid=$_REQUEST[Lno];
    $sql_hos=  mysql_query("SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysql_fetch_assoc($sql_hos);
    $sql=  mysql_query("select t1.*,concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,d2.dep_name as depname,p2.posname as posi 
            from timela t1 
            inner join emppersonal e1 on t1.empno=e1.empno
            inner join pcode p1 on e1.pcode=p1.pcode
            inner join department d1 on e1.depid=d1.depId
            inner join department_group d2 on d2.main_dep=d1.main_dep
            INNER JOIN work_history wh ON wh.empno=e1.empno
            inner join posid p2 on wh.posid=p2.posId
            where t1.empno='$empno' and t1.id='$workid' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
    $work=  mysql_fetch_assoc($sql);
    
    $sql_leave=  mysql_query("select ty.nameLa,w.begindate,w.enddate,w.amount FROM print_leave p
INNER JOIN `work` w on w.workid=p.befor_workid
INNER JOIN typevacation ty on w.typela=ty.idla
where p.empno='$empno' and p.workid='$workid'");
 $leave_data=mysql_fetch_assoc($sql_leave)                                  
?>
<body>
    <?
require_once('option/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<div class="col-lg-12" align="center">
<table width="20%" border="0" align="right">
  <tr>
    <th scope="col">ฝ่ายทรัพยากรบุคคล</th>
  </tr>
  <tr>
    <td align="left">เลขรับ&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $work['idno']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td align="left">วันที่................................................</td>
  </tr>
  <tr>
    <td align="left">เวลา................................................</td>
  </tr>
</table>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ใบขออนุญาตออกนอกสถานที่ราชการในเวลาราชการ</h3>
</div>
<div class="col-lg-12" align="right">
เขียนที่<?=$hospital[name]?><br><br>
วันที่ <?= DateThai2($work[vstdate])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

</div>
<br>
<div class="col-lg-12" align="let">
        เรียน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital[name]?><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยข้าพเจ้า <?= $work[fullname]?> ตำแหน่ง <?= $work[posi]?> งาน <?= $work[dep]?> <br>ฝ่าย/กลุ่มงาน <?= $work[depname]?> 
            สังกัดกรมสุขภาพจิต  กระทรวงสาธารณสุข<br>  
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขออนุญาตออกนอกสถานที่ราชการในเวลาราชการ เนื่องจาก<u> <?= $work[comment]?> </u><br>
                        ในวันที่วันที่<u>&nbsp; <?= DateThai2($work[datela])?>&nbsp; </u>ตั้งแต่เวลา<u>&nbsp; <?= $work[starttime]?>&nbsp; </u>น. ถึงเวลา<u>&nbsp; <?= $work[endtime]?> &nbsp;</u>น.รวม<u> <?=$work[total]?> </u>ชั่วโมง<br>
                         เมื่อครบกำหนดเวลาดังกล่าวแล้ว ข้าพเจ้าจะกลับมาปฏิบัติหน้าที่ตามปกติ <br><br>
</div>
<div class="col-lg-12" align="center">ขอแสดงความนับถือ<br><br>
                                                     ..........................................................<br>
                                                     ( <?= $work[fullname]?> )<br>
                                                      <?= DateThai2($work[vstdate])?></div><br><br>

                                 <div class="row">
                                 <div class="col-lg-12">
                                     <table width="100%" border="0" cellspacing="0" >
                                         <tr><td valign="top">
                                         <u>สถิติการออกนอกสถานที่ราชการ</u><br><br>
                                     <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
  <tr>
    <th colspan="2" scope="col">ลามาแล้ว</th>
    <th rowspan="2" scope="col">ลาครั้งนี้</th>
    <th rowspan="2" scope="col">รวมเป็น</th>
  </tr>
  <tr>
    <th scope="col">ครั้ง</th>
    <th scope="col">ชั่วโมง</th>
  </tr>
  <?php
  $sql_leave2=  mysql_query("select * FROM print_tleave 
where empno='$empno' and tleave_id='$workid' order by printt_id desc limit 1");
  $leave2=mysql_fetch_assoc($sql_leave2);?>
  <tr>
    <td align="center" scope="row"><?=$leave2[last_tleave]?></td>
    <td align="center" scope="row"><?=$leave2[last_tamount]?></td>
    <td align="center"><?=$work[total]?> ชม.</td>
    <td align="center"><?= $work[total]+$leave2[last_tamount]?> ชม.</td>
   </tr>

</table><br><br>
                                    
                                         <center>(ลงชื่อ)..........................................................ผู้ตรวจสอบ<br><br>
                                         ........../............/............<br><br></center>
                                         </td>
                                         <td>
                                     
                                         
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
                                         <br><div class="col-lg-12" align="right">
                                         
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-AD-017
                                         
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