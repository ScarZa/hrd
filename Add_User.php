<?php @session_start(); ?>
<?php include 'header.php';?>
<?php  if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
 <script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
  <script language="javascript">
function fncSubmit()
	{
	 if(document.form1.user_pwd.value != document.form1.user_pwd2.value)
		{
			alert('การยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบ');
			document.form1.user_pwd.focus();		
			return false;
		}else{	
			return true;
			document.form1.submit();
		}
}
</script>
 <div class="row">
          <div class="col-lg-12">
              <h1> <font color="blue">ตั้งค่าผู้ใช้งาน</font></h1>
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าผู้ใช้งาน</li>
            </ol>
          </div>
        </div><!-- /.row -->
			<?php include 'connection/connect.php';
			 if($_GET[user_id]!=''){ 
			 $user_idGet=$_GET[user_id];
                          if($_REQUEST[method]=='update'){
                             $status= $_GET[status];
                         }else{
                         $status=$_SESSION[Status];}
			 $sqlGet=mysql_query("select m.*,concat(e.firstname,' ',e.lastname) as fullname,e.mobile as mobile from  member m
                             inner join emppersonal e on e.empno=m.Name where m.Name='$user_idGet' and m.Status='$status' ");
			 $resultGet=mysql_fetch_assoc($sqlGet);
			 }
			   ?>    
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มผู้ใช้งานระบบ</h3>
                    </div>
                <div class="panel-body">		
                    <form name='form1' class="navbar-form navbar-left"  action='prcuser.php' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
                        <b>ชื่อ-นามสกุล </b><br>
                        <div class="form-group">	
                        <?php if($_SESSION[Status]=='USER'){?>
                        <input type="text" name='names'   id='names' class='form-control' value='<?=$resultGet[fullname]?>'  onkeydown="return nextbox(event, 'save');" readonly >
                            <input type="hidden" name="name" id="name" value="<?=$resultGet[Name]?>">
                            <?php }else{?>
                         	<select name="name" id="name" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysql_query("SELECT empno,concat(firstname,' ',lastname) as fullname  FROM emppersonal order by empno ");
				 echo "<option value=''>เลือกบุคลากร</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[empno]==$resultGet[Name]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[empno]' $selected>$result[fullname] </option>";
				 } ?>
			 </select>
                            <?php }?>
			 </div> 
                        <br>
                        <b>ระดับการใช้งาน</b><br>
		    <div class="form-group">	
			<?php if($_SESSION[Status]=='ADMIN'){?>
                                <select name='admin' id='admin'class='form-control'  onkeydown="return nextbox(event, 'user_account');"  required >
			<?php 		
				echo "<option value=''>เลือกระดับการใช้งาน</option>";			
		 		if( $resultGet[Status]=="ADMIN"){$ok='selected';}
				if( $resultGet[Status]=="SUSER"){$ok2='selected';}
                                if( $resultGet[Status]=="USUSER"){$ok3='selected';}
				if($resultGet[Status]=="USER"){$selected='selected';}
				echo "<option value='USER'  $selected>ผู้ใช้งานทั่วไป</option>";	
				echo "<option value='SUSER'  $ok2 >หัวหน้าหน่วยงาน</option>";
                                echo "<option value='USUSER'  $ok3 >หัวหน้าฝ่ายงาน</option>";
				echo "<option value='ADMIN'  $ok >ผู้ดูแลระบบ</option>";						
				?>
			</select>
                         <?php }else{?>
                                <input type="text" name='admin'   id='admin' class='form-control'  value='<?=$resultGet[Status]?>'  onkeydown="return nextbox(event, 'save');" readonly >
                         <?php }?>
                                </div>
                        <br>                        
                            <?php if($_GET[user_id]!=''){?>
                            <b><font color="red">โทรศัพท์มือถือ (กรุณา update ให้เป็นปัจจุบันด้วย)</font></b><br>
                        <div class="form-group">
                            <input type="text" name='mobile' max="10"  id='mobile' placeholder='หมายเลขปัจจุบัน' size="10" class='form-control'  value='<?=$resultGet[mobile]?>'  onkeydown="return nextbox(event, 'user_pwd2');"    >
			 </div><br>
                        <?php }?>
                        <?php if($_SESSION[Status]=='ADMIN'){
                            $read='';
                        }else{
                            $read='readonly';
                        }
?>
			<div class="form-group">	
			<b>ชื่อผู้ใช้งาน</b>
			<input type='text' name='user_account'  size="4"  id='user_account' placeholder='ชื่อผู้ใช้งาน' class='form-control'  onkeydown="return nextbox(event, 'user_pwd');"   value='<?php echo $resultGet[user_name];?>' required <?= $read?>>
			 </div> 
                        <br>
			<?PHP 
			if($_GET[user_id]!=''){
			 	$pwd=$resultGet[Password];			
			}else{
				$pwd='';
			}
			?> 
			<?php 	if($_GET[user_id]!=''){?>
			<div class="form-group">
			<b>รหัสผ่าน</b>
			<input type="password" name='user_pwd'  size="6"  id='user_pwd' placeholder='รหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'user_pwd2');"    >
			 </div><br>
	 		<div class="form-group">
			<label>ยืนยันรหัสผ่าน</label>
			<input type="password" name='user_pwd2' size="1" id='user_pwd2' placeholder='ยืนยันรหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'save');" >
			 </div><br>
			 <?php }else{?>
			 			<div class="form-group">
			<b>รหัสผ่าน</b>
                        <input type="password" name='user_pwd' size="6"  id='user_pwd' placeholder='รหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'user_pwd2');"   required>
			 </div><br>
	 		<div class="form-group">
			<b>ยืนยันรหัสผ่าน</b>
			<input type="password" name='user_pwd2' size="1"   id='user_pwd2' placeholder='ยืนยันรหัสผ่าน' class='form-control'  value=''   onkeydown="return nextbox(event, 'save');"  required>
			 </div><br>
			 <?php }?>
			 <font color="red"><?php 	if($_GET[user_id]!=''){echo "*หากไม่เปลี่ยนรหัสผ่านไม่ต้องแก้ไข";}?></font>
<?PHP 
	if($_GET[user_id]!=''){
		$get=$_GET[user_id];
                $Get_id=$_GET['ID'];
                echo "<input type='hidden' name='ID' value='$Get_id'>";
		echo "<input type='hidden' name='user_id' value='$get'>";
		echo "<input type='hidden' name='method' value='update'>";
	 }
 ?> <br>
        <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
		</form>

      </div>
    </div>
              </div>
    </div>
         <?php if($_SESSION[Status]=='ADMIN'){?>
        	  <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ผู้ใช้งานระบบ</h3>
                    </div>
                  <div class="panel-body">
                    
<?php include 'listuser.php';?> 
      <!--  row of columns -->
 </div>
       </div></div></div>   
         <?php }?>
 
 <?PHP include'footer.php';  ?>
