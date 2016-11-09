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
        echo $empno=$_REQUEST[id];
        echo $project_id=$_REQUEST[pro_id];
        
$sql_per = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        INNER JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join posid p2 on wh.posid=p2.posId
                                                        where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
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
    <div align="center"><h4 align="center">แบบฟอร์มสรุปรายงานการเป็นวิทยากร</h4></div>
    <table border="0" width="100%" height="454" cellpadding="2" cellspacing="2">
        <tr>
            <td height="25">
    <b>1. ชื่อ-นามสกุล ผู้เป็นวิทยากร</b> <?=$Person_detial[fullname]?>&nbsp;&nbsp;&nbsp;<b>ตำแหน่ง</b> <?=$Person_detial[posi]?> <b>พร้อมคณะ</b> <?= $person_data[count_person]-1?>  <b>คน</b><br>
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
                <b>6. จำนวนผู้เข้าร่วมประชุม &nbsp;</b> <?= $person_data['join_amount'] ?> <b>คน</b><br>
    </td>
        </tr>
        <tr>
            <td height="25">
                <b>7. คะแนนความพึงพอใจของผู้เข้าร่วมประชุม คิดเป็นร้อยละ &nbsp;</b> <?= $person_data['complacency'] ?> <b>%</b><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>8. วัตถุประสงค์ของการเป็นวิทยากร คือ &nbsp;</b><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    &nbsp;&nbsp;&nbsp;<?=$person_data[pj_obj];?><br>
    </td>
        </tr>
           <tr>
            <td height="25">
    <b>9. หัวข้อเรื่อง/สาระสำคัญ คือ &nbsp;</b><br>
    </td>
        </tr>
       <tr>
            <td height="25">
       &nbsp;&nbsp;&nbsp;<?=$person_data['abstract']?><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    <b>10. เอกสารประกอบการประชุม</b><br>
    </td>
        </tr>
    <tr>
            <td height="25">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>powerpoint : </b>( <?=$person_data[book]?> )
 
    <b>เอกสารประกอบ : </b>( <?=$person_data[paper]?> )
 
    <b>CD ข้อมูล : </b>( <?=$person_data[cd]?> )
    </td>
        </tr>
    </table>
    <br><br><div align="right">
        <b>( ลงชื่อ )</b> ............................................ <b>ผู้รายงาน  &nbsp;&nbsp;&nbsp;ว/ด/ป</b> <?= DateThai2($person_data[reg_date])?>&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
        
    F-AD-007</div>
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