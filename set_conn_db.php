<?php
$check=  md5(trim(check));
if($_REQUEST['method']!=$check){
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
</head>
<body>
    <form role="form" action='prcconn_db.php' enctype="multipart/form-data" method='post'>
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><img src='images/phonebook.ico' width='25'> ตั้งค่าเพื่อ Connect Database</h3>
                    </div>
                  <div class="panel-body">
                      <div class="form-group"> 
                <label>HOST Name &nbsp;</label>
                <input type="text" class="form-control" name="host_name" id="host_name" placeholder="host name" required>
             	</div>
                      <div class="form-group"> 
                <label>Username &nbsp;</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
             	</div>
                      <div class="form-group"> 
                <label>Password &nbsp;</label>
                <input type="text" class="form-control" name="password" id="password" placeholder="password" required>
             	</div>
                      <div class="form-group"> 
                <label>Database name &nbsp;</label>
                <input type="text" class="form-control" name="db_name" id="db_name" placeholder="database name" required>
                      </div>
                    <div class="form-group"> 
                        <center>
                        <input type="submit" class="btn btn-success" name="submit" value="ตกลง">
                        </center>
                    </div>
                  </div>
              </div>
          </div>
    </form>
</body>
</html>
