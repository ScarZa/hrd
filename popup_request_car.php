<?php @session_start(); ?>
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
<body>
    <?php include_once'option/DatePicker/index.php'; ?>
<?php
                    $project_place = $_GET['project_place'];  
                    $province =  $_GET['province'];
                    $stdate = $_GET['stdate'];
                    $etdate = $_GET['etdate'];
                    $amount = $_GET['amount'];
                    
        $empno=$_SESSION[user];
        $edit_per=  mysqli_query($db,"select concat(e1.firstname,' ',e1.lastname) as fullname, d.depName
            from emppersonal e1 
            inner join department d on d.depId=e1.depid
            where e1.empno='$empno'");
        $edit_person=  mysqli_fetch_assoc($edit_per);
    $sql = mysqli_query($db,"select * from  hospital");
                            $resultHos = mysqli_fetch_assoc($sql);
    $sql2=  mysqli_query($db, "select depName from department where depId='".$_SESSION[dep]."'"); 
    $resultDep = mysqli_fetch_assoc($sql2);
?>
            <form class="navbar-form" role="form" action='prccar.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
    <div class="col-lg-2"></div>
          <div class="col-lg-8">
              <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title"><img src='images/phonebook.ico' width='25'> <font color='brown'>เขียนขอใช้รถยนต์</font></h3>
                    </div>
                <div class="panel-body">
                    <div align='center'>
                                <h4>แบบฟอร์มการขออนุญาตใช้รถส่วนกลาง</h4><p>
                    </div>
                    <b>เรียน ผู้อำนวยการ <?= $resultHos['name']?></b><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    ข้าพเจ้า <b><?= $edit_person['fullname']?></b> 
                                    ฝ่าย/งาน/กลุ่มงาน <b><?= $resultDep['depName']?></b> ขออนุญาตใช้รถราชการ<p>
<p>
                    <div class="form-group" > 
                        <label for="place">เพื่อไปที่ &nbsp;</label>
                        <input value="<?=$project_place?>" NAME="place" id="place"  class="form-control" onkeydown="return nextbox(event, 'start_date')" placeholder="สถานที่ที่ต้องไป" size="80" required>
                    </div><p>
                        <div class="form-group" > 
                            <?php include 'address.php';?>
                        </div>
                    <div class="form-group">
                    <label>ในวันที่ &nbsp;</label>
                <?php
 			$take_date=$stdate;
 			edit_date($take_date);
 		?>
                    <input name="start_date" type="text" id="datepicker-th-1"  placeholder='รูปแบบ 2016-01-31' class="form-control"  value="<?= $take_date?>" required>
                    </div>
                <div class="form-group">
                    <label for="end_date">ถึงวันที่ &nbsp;</label>
                    <?php
 			$take_date2=$etdate;
 			edit_date($take_date2);
 		?>
                    <input name="end_date" type="text" id="datepicker-th-2"  placeholder='รูปแบบ 2016-01-31' class="form-control"  value="<?= $take_date2?>" required>
                </div><p>
                <div class="row">  
                <div class="form-group col-lg-5 col-xs-12">  <label for="take_hour_st">ตั้งแต่&nbsp;</label>  
                <div class="form-group sm"> 
                <select name="take_hour_st" id="take_hour" class="form-control">
                    <option value="">ชั่วโมง</option>
                    <?php for($i=0;$i<=23;$i++){
                        if((!empty($edit_person['start_time']))and($i== substr($edit_person['start_time'],0,2))){$selected='selected';}else{$selected='';}
                        if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                </div>
                    <div class="form-group">
                <select name="take_minute_st" id="take_minute" class="form-control">
                    <option value="">นาที</option>
                    <?php for($i=0;$i<=59;$i++){
                        if((!empty($edit_person['start_time']))and($i== substr($edit_person['start_time'],3,2))){$selected='selected';}else{$selected='';}
                    if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                    </div></div>
                <div class="form-group col-lg-5 col-xs-12"> <label for="take_hour_st">ถึงเวลา </label>   
                <div class="form-group"> 
                <select name="take_hour_en" id="take_hour" class="form-control">
                    <option value="">ชั่วโมง</option>
                    <?php for($i=0;$i<=23;$i++){
                        if((!empty($edit_person['end_time']))and($i== substr($edit_person['end_time'],0,2))){$selected='selected';}else{$selected='';}
                        if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                </div>
                    <div class="form-group"> 
                <select name="take_minute_en" id="take_minute" class="form-control">
                    <option value="">นาที</option>
                    <?php for($i=0;$i<=59;$i++){
                        if((!empty($edit_person['end_time']))and($i== substr($edit_person['end_time'],3,2))){$selected='selected';}else{$selected='';}
                    if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                    </div></div></div>
                     <div class="form-group">
                        <label for="amount_date">จำนวนวันที่ไป</label>
                        <input name="amount_date" id="amount_date" type="text" value="<?= $amount?>" size="1" onkeyup="javascript:inputDigits(this);" class="form-control" placeholder='จำนวนวัน'>
                        <font color="red"><b>** หากไม่ถึงครึ่งวัน ไม่ต้องใส่</b></font>
                     </div>
                <div class="form-group" > 
                        <label for="obj">เพื่อ &nbsp;</label>
                        <input value="" NAME="obj" id="obj"  class="form-control" onkeydown="return nextbox(event, 'start_date')" placeholder="วัตถุประสงค์" size="80" required>
                    </div><p>
                    <div class="form-group">
                        <label for="amount">จำนวนผู้ร่วมทาง</label>
                        <input name="amount" id="amount" type="number" value="" required="" size="1" class="form-control" placeholder='จำนวนคน'>
                    </div>
                   <div class="form-group">
                        <label for="passenger">เพื่อให้</label>
                        <select name="passenger" id="passenger" required  class="form-control" onkeydown="return nextbox(event, 'dep');"> 
				<?php include 'connection/connect_i.php';
                                $sql = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname, empno  FROM emppersonal 
                                            order by firstname");
        
				 echo "<option value=''>--เลือกผู้ควบคุม--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
				 echo "<option value='".$result['empno']."'>".$result['fullname'] ."</option>";
				 } ?>
			 </select> เป็นผู้ควบคุม
                    </div>
                    <div>
                        <b>การใช้รถครั้งนี้ขอให้พนักงานขับรถ</b><br>
                    <div class="form-group">
                        <input type="radio" name="wait" id="wait" value="N"> 
                        ไม่รอรับ </div>
                    <div class="form-group">
                                <input type="radio" name="wait" id="wait" value="Y"> 
                    รอรับ </div>
                    </div>
                    <div align="center">
   <input type="hidden" name="method" id="method" value="request_car">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   </div>
                </div>
                </div>


          </div>
    
</div>
</form>
</body>
</html>