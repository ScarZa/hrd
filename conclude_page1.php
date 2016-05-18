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
    include_once ('option/funcDateThai.php');
        $empno=$_REQUEST[id];
        $project_id=$_REQUEST[pro_id];
        
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
         
            $sql_trainout=  mysql_query("select *,
                    (select count(empno) from plan_out where idpo='$project_id') count_person from plan_out where idpo='$project_id' and empno='$empno'");
            $person_data=mysql_fetch_assoc($sql_trainout);
            
require_once('option/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
    ?>
                    <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
                        <tr>
                            <td width="40%">เลขที่รายงาน <u><?= $Project_detial[memberbook]?></u></td>
                    <td width="60%">วันที่ส่งคืน ฝ่ายทรัพยากรบุคคล ภายในวันที่ <u><?php 
                    $re_date=$Project_detial['endDate'];
                    $check_date = date('Y-m-d', strtotime("$re_date+15 days ")); echo DateThai1($check_date);
                    ?></u></td>
                        </tr>
                    </table>                   
    <div align="center"><h4 align="center">แบบฟอร์มสรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนาและศึกษาดูงานภายนอกหน่วยงาน</h4></div>
    <table border="0" width="100%" height="454" cellpadding="2" cellspacing="2">
        <tr>
            <td height="25">
    <b>1. ชื่อ-นามสกุล ผู้ได้รับอนุมัติ</b> <?=$Person_detial[fullname]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ตำแหน่ง</b> <?=$Person_detial[posi]?> <b>พร้อมคณะ</b> <?= $person_data[count_person]-1?>  <b>คน</b><br>
            </td>
        </tr>
        <tr>
            <td height="25">
    <b>2. ชื่อโครงการ / กิจกรรม</b> <?=$Project_detial[projectName]?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>3. หน่วยงานที่จัด</b> <?=$Project_detial[anProject]?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>4. ระหว่างวันที่</b> <?= DateThai2($Project_detial[Beginedate]) ?>&nbsp; <b> ถึง &nbsp;</b> <?= DateThai2($Project_detial[endDate]) ?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>5. สถานที่</b> <?= $Project_detial[stantee] ?> จ. <?= $Project_detial[PROVINCE_NAME] ?>  <b>ระยะเวลา</b> <?= $Project_detial[amount] ?><b>&nbsp; วัน</b><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>6. วัตถุประสงค์ของการประชุม/อบรม/สัมมนา/ดูงานภายนอกหน่วยงานครั้งนี้ คือ &nbsp;</b><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    &nbsp;&nbsp;&nbsp;<?=$person_data[pj_obj];?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>7. รุปแบบการจัดโครงการ/กิจกรรม </b><?= $Project_detial[tname] ?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>8. ค่าใช้จ่าย</b><br>
    </td>
        </tr>
        <tr>
            <td height="25">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าที่พัก &nbsp;</b><?=$person_data['abode'];?><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>&nbsp;&nbsp;&nbsp;ค่าลงทะเบียน &nbsp;</b><?=$person_data['reg'];?><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>&nbsp;&nbsp;&nbsp;ค่าเบี้ยเลี้ยง &nbsp;</b><?=$person_data['allow'];?><b>&nbsp;บาท</b><br>
    </td>
        </tr>
        <tr>
            <td height="25">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าพาหนะเดินทาง &nbsp;</b><?=$person_data['travel'];?><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>&nbsp;&nbsp;&nbsp;ค่าใช้จ่ายอื่นๆ &nbsp;</b><?=$person_data['other'];?><b>&nbsp;บาท</b>&nbsp;&nbsp;&nbsp;&nbsp;
       &nbsp;&nbsp;&nbsp;&nbsp;( <?php if($Project_detial['Hos_car']=='Y'){ echo 'ใช้';}?> ) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ใช้พาหนะโรงพยาบาล</b><br>
       </td>
        </tr>
       <tr>
            <td height="25">
    <b>9. สรุปสาระสำคัญที่ได้จากการประชุม/อบรม/สัมมนา/ดูงาน(แนบเอกสารเพิ่มเติม) &nbsp;</b><br>
    </td>
        </tr>
       <tr>
            <td height="25">
       &nbsp;&nbsp;&nbsp;<?=$person_data['abstract']?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>10. การนำมาใช้ประโยชน์ และข้อเสนอแนะ &nbsp;</b><br>
    </td>
        </tr>
    <tr>
            <td height="25">
       &nbsp;&nbsp;&nbsp;<?=$person_data[comment]?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>11. เอกสารประกอบการประชุม</b><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>หนังสือ : </b>( <?=$person_data[book]?> )
 
    <b>เอกสารประกอบ : </b>( <?=$person_data[paper]?> )
 
    <b>CD ข้อมูล : </b>( <?=$person_data[cd]?> )
    </td>
        </tr>
    </table>
    <br><br><div align="right">
        <b>( ลงชื่อ )</b> ............................................ <b>ผู้รายงาน  &nbsp;&nbsp;&nbsp;ว/ด/ป</b> <?= DateThai2($person_data[reg_date])?>&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
        <b>( ลงชื่อ )</b> ............................................ <b>หัวหน้าฝ่าย/งาน  &nbsp;&nbsp;&nbsp;ว/ด/ป</b> ......................&nbsp;</div><br>
        <b><u>ความเห็นของผู้อำนวยการ</u></b><br><br> ....................................................................................................................................................................................<br><br><br>
    <div align="right">
        <b>( ลงชื่อ )</b> ........................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
    ( <?php $sql_hos=  mysql_query("SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysql_fetch_assoc($sql_hos);
    //echo $hospital['fullname'];?>............................................ )&nbsp;&nbsp;<br><br>
     ............/.............../........... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
    F-AD-111-04</div>
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