<?php if($_REQUEST[method]=='edit') {?>
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
    <body>

<?php }else{
   include 'header.php'; 
}
    include_once ('option/funcDateThai.php');
    $empno=$_REQUEST[id];
    $project_id=$_REQUEST[pro_id];

    ?>
<?php if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
<script type="text/javascript">
		function popup(url,name,windowWidth,windowHeight){    
				myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
				mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
				properties = "width="+windowWidth+",height="+windowHeight;
				properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
				window.open(url,name,properties);
	}
</script>
<div class="row">
          <div class="col-lg-12">
               <h1><font color='blue'>  สรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนาและศึกษาดูงานภายนอกหน่วยงาน </font></h1> 
               <?php if($_REQUEST[method]=='edit') {?>
            <ol class="breadcrumb alert-success">
              <li><a href="pre_project_out.php?id=<?=$project_id?>"><i class="fa fa-home"></i> รายละเอียดโครงการ</a></li>
              <li class="active"><i class="fa fa-edit"></i> สรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนา</li>
              </ol>
               <?php }else{?>
               <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_person_trainout.php?id=<?=$project_id?>"><i class="fa fa-home"></i> ผู้เข้าร่วมโครงการ</a></li>
              <li class="active"><i class="fa fa-edit"></i> สรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนา</li>
              </ol>
               <?php }?>
              </div>
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">สรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมน</h3>
                    </div>
                <div class="panel-body">
<?php
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
         
            if($_REQUEST[method]=='edit') {
            $sql_trainout=  mysql_query("select * from plan_out where empno='$empno' and idpo='$project_id'");
            $person_data=mysql_fetch_assoc($sql_trainout);
         }  
    ?>
<form class="navbar-form navbar-left" role="form" action='prctraining.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                   
    <center><h3>แบบฟอร์มสรุปรายงานการเข้าร่วม ประชุม/อบรม/สัมมนาและศึกษาดูงานภายนอกหน่วยงาน</h3></center><br>
    <b>ชื่อ-นามสกุล ผู้ได้รับอนุมัติ</b> <?=$Person_detial[fullname]?> <b>ตำแหน่ง</b> <?=$Person_detial[posi]?><br>
    <b>ชื่อโครงการ / กิจกรรม</b> <?=$Project_detial[projectName]?><br>
    <b>หน่วยงานที่จัด</b> <?=$Project_detial[anProject]?><br>
    <b>ระหว่างวันที่</b> <?= DateThai1($Project_detial[Beginedate]) ?>&nbsp; <b> ถึง &nbsp;</b><?= DateThai1($Project_detial[endDate]) ?><br>
    <b>สถานที่</b> <?= $Project_detial[stantee] ?> จ. <?= $Project_detial[PROVINCE_NAME] ?>  <b>ระยะเวลา</b> <?= $Project_detial[amount] ?><b>&nbsp; วัน</b><br>
    <?php if($Project_detial['dt']=='3'){?>
    <div class="form-group"> 
                <b>จำนวนผู้เข้าร่วมประชุม &nbsp;</b>
                <input value='<?=$person_data['join_amount'];?>' NAME="join_amount" id="join_amount"  class="form-control" placeholder="จำนวนผู้ที่เข้าร่วมอบรม">
 </div><br>
 <div class="form-group"> 
                <b>คะแนนความพึงพอใจของผู้เข้าร่วมประชุม คิดเป็นร้อยละ &nbsp;</b>
             	<input value='<?=$person_data['complacency'];?>' NAME="complacency" id="complacency"  class="form-control" placeholder="ร้อยละของความพึงพอใจ">
 </div><br>
    <?php }?>
 <div class="form-group"> 
                <label>วัตถุประสงค์ของการประชุม/อบรม/สัมมนา/ดูงานภายนอกหน่วยงานครั้งนี้ คือ &nbsp;</label>
             	<TEXTAREA value='' NAME="project_obj" id="project_obj"  cols="57" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?=$person_data[pj_obj];?></TEXTAREA>
 </div><br>
 <b>รุปแบบการจัดโครงการ/กิจกรรม </b><?= $Project_detial[tname] ?><br>
 <?php if($_REQUEST[method]=='edit') {?>
 <div class="form-group"> 
                <label>ค่าที่พัก &nbsp;</label>
                <input value='<?=$person_data[abode];?>' type="text" class="form-control" name="cost" id="cost" placeholder="ค่าที่พัก" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าลงทะเบียน &nbsp;</label>
                <input value='<?=$person_data[reg];?>' type="text" class="form-control" name="meals" id="meals" placeholder="ค่าลงทะเบียน" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าเบี่ยเลี้ยง &nbsp;</label>
                <input value='<?=$person_data[allow];?>' type="text" class="form-control" name="expert" id="expert" placeholder="ค่าเบี่ยเลี้ยง" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าพาหนะเดินทาง &nbsp;</label>
                <input value='<?=$person_data[travel];?>' type="text" class="form-control" name="travel" id="travel" placeholder="ค่าพาหนะเดินทาง" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าใช้จ่ายอื่นๆ &nbsp;</label>
                <input value='<?=$person_data[other];?>' type="text" class="form-control" name="material" id="material" placeholder="ค่าใช้จ่ายอื่นๆ" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>

 <?php }else{?>
  <div class="form-group"> 
                <label>ค่าที่พัก &nbsp;</label>
                <input value='<?=$Project_detial[m1];?>' type="text" class="form-control" name="cost" id="cost" placeholder="ค่าที่พัก" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าลงทะเบียน &nbsp;</label>
                <input value='<?=$Project_detial[m2];?>' type="text" class="form-control" name="meals" id="meals" placeholder="ค่าลงทะเบียน" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าเบี่ยเลี้ยง &nbsp;</label>
                <input value='<?=$Project_detial[m3];?>' type="text" class="form-control" name="expert" id="expert" placeholder="ค่าเบี่ยเลี้ยง" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าพาหนะเดินทาง &nbsp;</label>
                <input value='<?=$Project_detial[m4];?>' type="text" class="form-control" name="travel" id="travel" placeholder="ค่าพาหนะเดินทาง" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าใช้จ่ายอื่นๆ &nbsp;</label>
                <input value='<?=$Project_detial[m5];?>' type="text" class="form-control" name="material" id="material" placeholder="ค่าใช้จ่ายอื่นๆ" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
 <?php }?><br>
                <div class="form-group"> 
                    <?php if($Project_detial['dt']=='3'){ echo "<label>หัวข้อเรื่อง/สาระสำคัญ คือ &nbsp;</label>";}else{?>
                    <label>สรุปสาระสำคัญที่ได้จากการประชุม/อบรม/สัมมนา/ดูงาน(แนบเอกสารเพิ่มเติม) &nbsp;</label><?php }?>
             	<TEXTAREA value='' NAME="abstract" id="abstract"  cols="57" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?=$person_data['abstract']?></TEXTAREA>
 </div><br>
 <?php if($Project_detial['dt']!='3'){?>
 <div class="form-group"> 
                <label>การนำมาใช้ประโยชน์ และข้อเสนอแนะ &nbsp;</label>
             	<TEXTAREA value='' NAME="comment" id="comment"  cols="57" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?=$person_data[comment]?></TEXTAREA>
 </div><?php }?><br><br>
 <b>เอกสารประกอบการประชุม</b><br>
 <?php if($Project_detial['dt']=='3'){ echo "<b>powerpoint : </b>";}else{ ?>
 <b>หนังสือ : </b><?php }?>
 <?php if($person_data[book]=='มี'){?>
 <input type="radio" name="book" id="book" value="มี" checked="checked"/>
 <label for="book">มี</label>
 <input type="radio" name="book" id="book" value="ไม่มี" />
 <label for="book">ไม่มี</label>
 <?php }else{?>
 <input type="radio" name="book" id="book" value="มี" />
 <label for="book">มี</label>
 <input type="radio" name="book" id="book" value="ไม่มี" checked="checked"/>
 <label for="book">ไม่มี</label>
 <?php }?>
 <br>
 <b>เอกสารประกอบ : </b>
 <?php if($person_data[paper]=='มี'){?>
 <input type="radio" name="paper" id="paper" value="มี" checked="checked"/>
 <label for="paper">มี</label>
 <input type="radio" name="paper" id="paper" value="ไม่มี" />
 <label for="paper">ไม่มี</label>
 <?php }else{?>
 <input type="radio" name="paper" id="paper" value="มี" />
 <label for="paper">มี</label>
 <input type="radio" name="paper" id="paper" value="ไม่มี" checked="checked"/>
 <label for="paper">ไม่มี</label>
 <?php }?>
 <br>
 <b>CD ข้อมูล : </b>
  <?php if($person_data[cd]=='มี'){?>
 <input type="radio" name="cd" id="cd" value="มี" checked="checked"/>
 <label for="cd">มี</label>
 <input type="radio" name="cd" id="cd" value="ไม่มี" />
 <label for="cd">ไม่มี</label>
 <?php }else{?>
 <input type="radio" name="cd" id="cd" value="มี" />
 <label for="cd">มี</label>
 <input type="radio" name="cd" id="cd" value="ไม่มี" checked="checked"/>
 <label for="cd">ไม่มี</label>
 <?php }?><br>
 <div class="form-group">
                <label>ONE PAGE INFORMATION &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control"/>
                    </div><br><br>
                    <?php if($_REQUEST[method]=='edit') {?>
                        <input type="hidden" name="method" id="method" value="edit_planout">
    <input type="hidden" name="empno" id="empno" value="<?=$empno?>">
    <input type="hidden" name="idpo" id="idpo" value="<?=$project_id?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">

                    <?php }else{?>
    <input type="hidden" name="method" id="method" value="add_planout">
    <input type="hidden" name="amount" id="amount" value="<?= $Project_detial[amount] ?>">
    <input type="hidden" name="begin_date" id="begin_date" value="<?=$Project_detial[Beginedate]?>">
    <input type="hidden" name="empno" id="empno" value="<?=$empno?>">
    <input type="hidden" name="idpo" id="idpo" value="<?=$project_id?>">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
                    <?php }?>
  </form></div>
                   </div></div></div>
<?php include 'footer.php';?>