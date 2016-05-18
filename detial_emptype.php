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
    <?php
    $emptype=$_REQUEST[emptype];
                            $sql=  mysql_query("SELECT CONCAT(e1.firstname,' ',lastname) as fullname,e2.TypeName as typename
FROM emptype e2
INNER JOIN emppersonal e1 on e1.emptype=e2.EmpType
WHERE e1.emptype='$emptype' and e1.status='1'");
                            
                            
                            
                        ?>
    <body>
        <div class="row">
            <div class="col-lg-12">
                            <ol class="breadcrumb alert-success">
                                <li><a href="detial_type.php"><i class="fa fa-home"></i> ข้อมูลบุคลากร</a></li>
              <li class="active"><i class="fa fa-edit"></i> ข้อมูลประเภทบุคลากร</li>
            </ol>

                <div class="panel panel-primary">
                    <div class="panel-heading" align="center">
                        <h3 class="panel-title">ข้อมูลประเภทบุคลากร</h3>
                    </div>
                    <div class="panel-body">
                        
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                          <tr bgcolor="#898888">
                              <th>ลำดับ</th>
                              <th>ชื่อ-นามสกุล</th>
                              <th>ประเภทพนักงาน</th>
                          </tr>
                          <?php
                              $i = 1;
                                while ($detial_type=  mysql_fetch_assoc($sql)){
                              ?>
                          <tr>
                              <td align="center"><?=$i?></td>
                              <td><?=$detial_type[fullname]?></td>
                              <td align="center"><?=$detial_type[typename]?></td>
                          </tr>
                          <?php
                                $i++; }
                              ?>
                      </table>
                    </div>
                </div>
            </div>
        </div>
<?php include 'footer.php'; ?>