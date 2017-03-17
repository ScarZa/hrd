<?php @session_start(); ?>
<?php include 'connection/connect_i.php'; ?>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading" align="center">
                        <h3 class="panel-title">ข้อมูลตำแหน่งบุคลากร</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                            $sql=  mysqli_query($db,"SELECT p.posname 
,(SELECT count(wh.empno) from work_history wh INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1' WHERE wh.posid=p.posId and wh.emptype=1 and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)))bureaucrat
,(SELECT count(wh.empno) from work_history wh INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1' WHERE wh.posid=p.posId and wh.emptype=2 and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)))permanent_emp
,(SELECT count(wh.empno) from work_history wh INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1' WHERE wh.posid=p.posId and wh.emptype=3 and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)))government_emp
,(SELECT count(wh.empno) from work_history wh INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1' WHERE wh.posid=p.posId and wh.emptype=4 and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)))pgs
,(SELECT count(wh.empno) from work_history wh INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1' WHERE wh.posid=p.posId and wh.emptype=5 and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)))month_emp
,(SELECT count(wh.empno) from work_history wh INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1' WHERE wh.posid=p.posId and wh.emptype=6 and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)))day_emp
,(SELECT count(wh.empno) from work_history wh INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1' WHERE wh.posid=p.posId and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)))total
FROM posid p
INNER JOIN work_history wh ON p.posId=wh.posid 
INNER JOIN emppersonal e1 on e1.empno=wh.empno and e1.status='1'
INNER JOIN emptype e2 on wh.emptype=e2.EmpType
where  (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
GROUP BY p.posId
ORDER BY p.posname desc;"); ?>
                        <a class="btn btn-success" download="detial_position.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'รายละเอียดแยกตำแหน่ง');"><i class="fa fa-print"></i> Export to Excel</a><br><br>
                        <table id="datatable" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <tr style="background-color: #898888">
                              <th>ลำดับ</th>
                              <th>ตำแหน่ง</th>
                              <th>ข้าราชการ</th>
                              <th>ลูกจ้างประจำ</th>
                              <th>พนักงานราชการ</th>
                              <th>พกส.</th>
                              <th>ลจ.รายเดือน</th>
                              <th>ลจ.รายวัน</th>
                              <th>รวม</th>
                          </tr>
                          <?php
                              $i = 1;
                                while ($detial_type=  mysqli_fetch_assoc($sql)){
                              ?>
                          <tr>
                              <td align="center"><?=$i?></td>
                              <td><?=$detial_type['posname']?></td>
                              <td align="center"><?=$detial_type['bureaucrat']?></td>
                              <td align="center"><?=$detial_type['permanent_emp']?></td>
                              <td align="center"><?=$detial_type['government_emp']?></td>
                              <td align="center"><?=$detial_type['pgs']?></td>
                              <td align="center"><?=$detial_type['month_emp']?></td>
                              <td align="center"><?=$detial_type['day_emp']?></td>
                              <td align="center"><?=$detial_type['total']?></td>
                          </tr>
                          <?php
                          $person[0]=$person[0]+$detial_type['bureaucrat'];
                          $person[1]=$person[1]+ $detial_type['permanent_emp'];
                          $person[2]=$person[2]+ $detial_type['government_emp'];
                          $person[3]=$person[3]+ $detial_type['pgs'];
                          $person[4]=$person[4]+ $detial_type['month_emp'];
                          $person[5]=$person[5]+ $detial_type['day_emp'];
                          $person[6]=$person[6]+ $detial_type['total'];
                          $i++; }?>
                          <tr>
                              <th colspan="2">รวม</th>
                              <th align="center"><?=$person[0]?></th>
                              <th align="center"><?=$person[1]?></th>
                              <th align="center"><?=$person[2]?></th>
                              <th align="center"><?=$person[3]?></th>
                              <th align="center"><?=$person[4]?></th>
                              <th align="center"><?=$person[5]?></th>
                              <th align="center"><?=$person[6]?></th>
                          </tr>
                      </table>
                    </div>
                </div>
            </div>
        </div>
<?php include 'footeri.php'; ?>