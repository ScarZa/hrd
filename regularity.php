<?php @session_start(); ?>
<?php if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<?php include 'connection/connect_i.php';?>
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
    if(!empty($_GET['method'])){
    $method=$_GET['method'];
    if($method=='delete'){
    $regu_id=$_REQUEST['regu_id'];
    $del_regu= mysqli_query($db, "delete from regularity WHERE regu_id='$regu_id'");
    mysqli_fetch_assoc($del_regu);
    }elseif ($method=='edit') {
    $regu_id=$_REQUEST['regu_id'];
    $sql_regu=  mysqli_query($db,"SELECT regu_id, topic_regu FROM regularity WHERE regu_id='$regu_id'");
    $regu=  mysqli_fetch_assoc($sql_regu);
    }}
    ?>
    <body>
<div class="row">  
    <div class="col-lg-12">
    <div class="col-lg-6">
              <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">หัวข้อระเบียบ/ข้อบังคับ</h3>
                    </div>
                  <form class="navbar-form navbar" role="form" action='prcpost.php' enctype="multipart/form-data" method='post'>
                  <div class="panel-body">
                       
                  <div class="form-group">
                      ข้อความหัวข้อระเบียบ/ข้อบังคับ 
                      <textarea class="form-control" name="regu" required="" cols="50" rows="5" placeholder="กรุณาใส่หัวข้อระเบียบ/ข้อบังคับ ที่ต้องการประกาศ"><?= $regu['topic_regu']?></textarea>
                  </div>
                      <div class="form-group">
                          เอกสารระเบียบ/ข้อบังคับ
                          <input type="file" name="image" class="form-control">
                      </div><p>
                      <div class="form-group" align="center">
                          <?php if($_REQUEST['method']=='edit'){?>
                      <input type="hidden" name="method" value="edit_regularity">
                      <input type="hidden" name="regu_id" value="<?= $regu['regu_id']?>">
                      <input type="submit" name="submit" value="แก้ไข" class="btn btn-warning">
                          <?php }else{?>
                      <input type="hidden" name="method" value="regularity">
                      <input type="submit" name="submit" value="ตกลง" class="btn btn-success">
                          <?php }?>
                      </div>
                      
                  </div></form></div></div>
    <div class="col-lg-6">
<?php  include 'total_regularity.php';?>
    </div></div></div>
