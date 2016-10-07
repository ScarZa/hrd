<?php include 'header.php';?>
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
              <?php if($_REQUEST[method]=='edit'){?>
            <h1><font color='blue'>  แก้ไขข้อมูลโครงการ </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_trainout.php"><i class="fa fa-edit"></i> บันทึกการฝึกอบรมภายนอกหน่วยงาน</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขข้อมูลโครงการ</li>
              <?php }else{?>
            <h1><font color='blue'>  เพิ่มโครงการอบรม/ขออนุมัติไปราชการ </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เพิ่มโครงการอบรม</li>
              <?php }?>
            </ol>
          </div>
      </div>
<?php
    if($_REQUEST[method]=='edit'){
        $edit_id=$_REQUEST[id];
        $edit_per=  mysql_query("select * from training_out t1 
            where t1.tuid='$edit_id'");
        $edit_person=  mysql_fetch_assoc($edit_per);
    }
     include_once'option/DatePicker/index.php'; ?>
<form class="navbar-form navbar-left" role="form" action='prctraining.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">บันทึกประวัติการฝึกอบรม/ไปราชการ ภายนอกหน่วยงาน</h3>
                    </div>
                <div class="panel-body">
                      <?php if($_SESSION[Status]=='ADMIN'){?>
                    <div class="form-group"> 
                        <?php
 		if($_GET[method]!=''){
 			$take_date=$edit_person['datein'];
 			edit_date($take_date);
                        }
 		?>
                <label>วันที่ขออนุมัติ &nbsp;</label>
                <input value='<?=$take_date?>' placeholder="รูปแบบ 2015-01-31" type="text" class="form-control" name="reg_date" id="datepicker-th" onkeydown="return nextbox(event, 'address')" required>
             	</div>
                    <div class="form-group"> 
                <label>เลขที่หนังสือ &nbsp;</label>
                <input value='<?=$edit_person[memberbook];?>' type="text" class="form-control" name="project_no" id="project_no" placeholder="เลขที่หนังสือ" onkeydown="return nextbox(event, 'cidid')" required>
                      </div><br> <?php }?>
                    <div class="form-group"> 
                    <label>โครงการ &nbsp;</label>
                <input value='<?=$edit_person[projectName];?>' type="text" class="form-control" size="100" name="project_name" id="project_name" placeholder="โครงการ" onkeydown="return nextbox(event, 'pname')" required>
             	</div><br>
                <div class="form-group"> 
                    <label>หน่วยงานที่จัด &nbsp;</label>
                <input value='<?=$edit_person[anProject];?>' type="text" class="form-control"  size="95" name="project_dep" id="project_dep" placeholder="หน่วยงานที่จัด" onkeydown="return nextbox(event, 'pname')" required>
             	</div><br> 
                <div class="form-group"> 
                <label>สถานที่จัด &nbsp;</label>
                <input value='<?=$edit_person[stantee];?>' type="text" class="form-control" name="project_place" id="project_place" placeholder="สถานที่จัด" onkeydown="return nextbox(event, 'lname')" required>
             	</div>
                    <div class="form-group">
         			<label>จังหวัด &nbsp;</label>
 				<select name="province" id="province" class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysql_query("SELECT *  FROM province order by PROVINCE_NAME  ");
				 echo "<option value=''>--เลือกจังหวัด--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[PROVINCE_ID]==$edit_person[provenID]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[PROVINCE_ID]' $selected>$result[PROVINCE_NAME] </option>";
				 } ?>
			 </select>
                    </div><br><p></p>
                <div class="form-group">
                    <b>ฝึกอบรมระหว่างวันที่ &nbsp;</b>
                    <div class="form-group">
                    <?php
 		if($_GET[method]!=''){
 			$take_date1=$edit_person['Beginedate'];
 			edit_date($take_date1);
                        }
 		?>
                        <input value='<?=$take_date1?>' size="12" placeholder="31/01/2559" type="text" name="Pdates" id="datepicker-th-1" class="form-control" required>
                       </div>
                    <b>ถึงวันที่ &nbsp;</b>
                    <div class="form-group">
                     <?php
 		if($_GET[method]!=''){
 			$take_date2=$edit_person['endDate'];
 			edit_date($take_date2);
                        }
 		?>   
                        <input value='<?=$take_date2?>' size="12" placeholder="31/01/2559" type="text" name="Pdatee" id="datepicker-th-2" class="form-control" required>
                    </div>
                         </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <div class="form-group">
                             <b>เดินทางไปราชการตั้งแต่วันที่ &nbsp;</b>
                    <div class="form-group">
                        <?php
 		if($_GET[method]!=''){
 			$take_date3=$edit_person['stdate'];
 			edit_date($take_date3);
                        }
 		?>
                        <input value='<?=$take_date3?>' size="12" placeholder="31/01/2559" type="text" name="stdate" id="datepicker-th-3" class="form-control" required>
                       </div> 
                             <b>ถึงวันที่ &nbsp;</b>
                    <div class="form-group">
                        <?php
 		if($_GET[method]!=''){
 			$take_date4=$edit_person['etdate'];
 			edit_date($take_date4);
                        }
 		?>
                        <input value='<?=$take_date4?>' size="12" placeholder="31/01/2559" type="text" name="etdate" id="datepicker-th-4" class="form-control" required>
                    </div>
                         </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>ใช้พาหนะโรงพยาบาล&nbsp;&nbsp;</label>
                         <div class="form-group">
                             <?php if($edit_person['Hos_car']=='Y'){?>
                             <input type="checkbox" name="Hos_car" value="Y" checked="">    
                             <?php }else{?>
                             <input type="checkbox" name="Hos_car" value="Y">
                             <?php }?>
                         </div><br>
                    <div class="form-group"> 
                <label>จำนวนวันที่อบรม &nbsp;</label>
                <input value='<?=$edit_person[amount];?>' type="text" class="form-control" size="1" name="amountd" id="amountd" placeholder="จำนวนวันที่อบรม" onkeydown="return nextbox(event, 'lname')" onKeyUp="javascript:inputDigits(this);" required>
             	</div>
                <div class="form-group">
         			<label>รูปแบบ &nbsp;</label>
 				<select name="format" id="format" required  class="form-control"  onkeydown="return nextbox(event, 'bday');">
                                    <?php	$sql = mysql_query("SELECT *  FROM trainingtype order by tName  ");
				 echo "<option value=''>--เลือกรูปแบบ--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[tid]==$edit_person[dt]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[tid]' $selected>$result[tName] </option>";
				 } ?>
				 </select>
			 </div>
                                             <div class="form-group">
         			<label>ประเภทเนื้อหา &nbsp;</label>
 				<select name="type_know" id="type_know" required  class="form-control"  onkeydown="return nextbox(event, 'line');"> 
				<?php	$sql = mysql_query("SELECT *  FROM traininglevel order by lid");
				 echo "<option value=''>--เลือกเนื้อหา--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[lid]==$edit_person[material]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[lid]' $selected>$result[lname] </option>";
				 } ?>
			 </select>
			 </div> 
                         
                
                </div>
                </div>


          </div>
</div>
    <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ค่าใช้จ่าย</h3>
                    </div>
                <div class="panel-body">
                    <div class="form-group"> 
                <label>ค่าที่พัก &nbsp;</label>
                <input value='<?=$edit_person[m1];?>' type="text" class="form-control" name="cost" id="cost" placeholder="ค่าที่พัก" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าลงทะเบียน &nbsp;</label>
                <input value='<?=$edit_person[m2];?>' type="text" class="form-control" name="meals" id="meals" placeholder="ค่าลงทะเบียน" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าเบี่ยเลี้ยง &nbsp;</label>
                <input value='<?=$edit_person[m3];?>' type="text" class="form-control" name="expert" id="expert" placeholder="ค่าเบี่ยเลี้ยง" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าพาหนะเดินทาง &nbsp;</label>
                <input value='<?=$edit_person[m4];?>' type="text" class="form-control" name="travel" id="travel" placeholder="ค่าพาหนะเดินทาง" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าใช้จ่ายอื่นๆ &nbsp;</label>
                <input value='<?=$edit_person[m5];?>' type="text" class="form-control" name="material" id="material" placeholder="ค่าใช้จ่ายอื่นๆ" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                  <div class="form-group">
         			<label>แหล่งงบประมาณ &nbsp;</label>
 				<select name="source" id="source" class="form-control"  onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysql_query("SELECT *  FROM trainingmoney order by id");
				 echo "<option value=''>--เลือกงบประมาณ--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[id]==$edit_person[budget]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[id]' $selected>$result[name] </option>";
				 } ?>
			 </select>
			 </div>
                    
                </div>
              </div>
          </div>
</div>
      <?php if($_REQUEST[method]=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit_trainout">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person[tuid];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="add_trainout">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }?>
</form>
         