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
<body>
    
    <?php
    
    $empno=$_REQUEST[id];
    $project_id=$_REQUEST[pro_id];
    $sql_person=  mysql_query("select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname, po.status_out as status_out 
        from emppersonal e1 
INNER JOIN work_history wh ON wh.empno=e1.empno
inner join posid p1 on wh.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
inner join plan_out po on po.empno=e1.empno
where e1.posid=p1.posId and e1.status ='1' and po.idpo='$project_id' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
ORDER BY empno");
    require_once('option/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
    ?>
    
    <div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4 align="center">รายชื่อคณะเดินทางไปราชการ</h4></div>
    
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
        <u>หมายเหตุ</u><br>&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. ให้ส่งรายงานนี้ภายใน 15 วัน หลังเสร็จสิ้นการประชุม/อบรม/สัมมนา/ดูงาน<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. โปรดสรุปสาระสำคัญเพื่อเป็น<u>สาระสำคัญ</u>สำหรับเผยแพร่แก่ จนท. อื่น ตามแบบฟอร์ม One Page Information<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. กรณีมีเอกสารแจกที่น่าสนใจ ขอโปรดอนบมาด้วยเพื่อนำเสนอผู้อำนายการ และอาจสำเนาส่งฝ่าย/งานที่เกี่ยวข้องเพิ่มเติม (ตัวจริงจะคืนเจ้าของ)<br>
    </b>
    <br><br><br>
    <div align="right">F-AD-111-04</div>
    <?php
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('th', 'A4', '10', 'THSaraban');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output("MyPDF/conclude1$empno$Code.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/conclude1$empno$Code.pdf' />";
?>
</body>
</html>