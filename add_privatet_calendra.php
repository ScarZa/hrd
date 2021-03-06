<?php @session_start(); ?>
<?php include 'connection/connect.php'; 
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}?>
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
        if($_REQUEST['method']=='edit_event'){
        $event_id=$_REQUEST['id'];
        $method=$_REQUEST['method'];
        $sql_event=  mysql_query("select * from tbl_event where event_id='$event_id'");
        $event=  mysql_fetch_assoc($sql_event);
        if($event['event_allDay']=='true'){
        $event_end=date('Y-m-d', strtotime($event['event_end']."-1 days "));
        }  else {
            $event_end=$event['event_end'];
        }
        }
        ?>
    <div class="col-lg-12">
        <h3><font color='blue'>  เพิ่มรายการกิจกรรม </font></h3> 
        <ol class="breadcrumb alert-success">
            <li><a href="fullcalendar/fullcalendar4.php"><i class="fa fa-home"></i> ปฏิทินกิจกรรม</a></li>
            <li class="active"><i class="fa fa-edit"></i> เพิ่มรายการกิจกรรม</li>
        </ol>
    </div>
<div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  align="center">
                <h3 class="panel-title">เพิ่มรายการกิจกรรมส่วนตัว</h3>
            </div>
            <div class="panel-body">
               <form class="navbar" role="form" action='prcevent.php' enctype="multipart/form-data" method='post'> 
               <div class="form-group">
                <label for="massege"> ข้อความ</label>
                <div class="col-lg-12">
                    <textarea class="form-control" type="text" name="massege" id="massege" placeholder="ข้อความที่ต้องการให้แสดง" rows="6"><?= $event['event_title']?></textarea>
                </div></div> 
                <label for="massege"> วันที่เริ่ม</label>
                <div class="form-group">              
                    <div class="col-lg-6 col-xs-6"><input class="form-control" type="date" name="event_start_date" id="event_start_date" value="<?= substr($event['event_start'], 0, 10)?>" required></div>                
                    <div class="col-lg-6 col-xs-6"><input class="form-control" type="time" name="event_start_time" id="event_start_time" value="<?= substr($event['event_start'], 11, 19)?>"></div>
                </div><br><br> 
                <label for="massege"> วันที่สิ้นสุด</label>
                <div class="form-group">              
                    <div class="col-lg-6 col-xs-6"><input class="form-control" type="date" name="event_end_date" id="event_end_date" value="<?= substr($event_end, 0, 10)?>" required></div>                
                <div class="col-lg-6 col-xs-6"><input class="form-control" type="time" name="event_end_time" id="event_end_time" value="<?= substr($event['event_end'], 11, 19)?>"></div>
                </div><br><br>
                <div class="col-lg-6 col-xs-6">
                <label for="massege"> ช่วงเวลา</label>
                <div class="form-group">              
                    <select class="form-control" name="range" id="range">
                        <?php if($event['event_allDay']=='false'){$select1='';$select2='selected';}else{ $select1='selected';$select2='';}?>
                        <option value="true" <?= $select1?>> ทั้งวัน</option>
                        <option value="false"<?= $select2?>> ไม่ทั้งวัน</option>
                    </select>
                </div>
                </div>
                <div class="col-lg-6 col-xs-6">
                <label for="massege"> ลักษณะกิจกรรม</label>
                <div class="form-group">  
                    <?php if($event['process']=='4'){ $select1='selected';$select2='';}elseif($event['process']=='5'){$select1='';$select2='selected';}?>
                    <select class="form-control" name="type_event" id="type_event">
                        <option value="4"<?= $select1?>> ขึ้นเวร</option>
                        <option value="5"<?= $select2?>> อื่นๆ</option>
                    </select>
                </div> 
                </div>
                <?php if(!$method){?>
                <input type="hidden" name="method" value="add_event">
                <center>
                <input type="submit" class="btn btn-success" value="ตกลง">
                </center>
                <?php }else {?>
                <input type="hidden" name="event_id" value="<?= $event_id?>">
                <input type="hidden" name="method" value="edit_event">
                <center>
                <input type="submit" class="btn btn-warning" value="แก้ไข">
                <a href="prcevent.php?id=<?= $event_id?>&method=delete_event" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')" class="btn btn-danger">ลบ</a>
                </center>
                <?php }?>
               </form>
            </div>
        </div>
</div>
        
<?php include 'footer.php'; ?>
