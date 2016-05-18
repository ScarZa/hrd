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
  <!--<script language="javascript">
function fncSubmit()
	{
	 if(document.form1.name_dep.value=='')
		{
			alert('กรุณากรอกชื่อฝ่าย/ศูนย์/กลุ่มงาน');
			document.form1.name_dep.focus();		
			return false;
		}else{	
			return true;
			document.form1.submit();
		}
}
</script>-->
 <div class="row">
          <div class="col-lg-12">
            <h1><font color="blue">ตั้งค่าฝ่าย/ศูนย์/กลุ่มงาน</font></h1>
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าฝ่าย/ศูนย์/กลุ่มงาน</li>
            </ol>
          </div>
        </div><!-- /.row -->
			<?php include 'connection/connect.php';
			 if($_GET[dep_id]!=''){ 
			 $dep_id=$_GET[dep_id];
                         $mdep_id=$_GET[mdep_id];
			 $sqlGet=mysql_query("select * from  department d1
                             left outer join department_group d2 on d1.main_dep=d2.main_dep
                             where depId='$dep_id' ");
			 $resultGet=mysql_fetch_assoc($sqlGet);
			 }
			   ?>    
    <div class="row">
                  <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มฝ่ายงาน</h3>
                    </div>
                  <div class="panel-body">
    <div class="col-lg-4">       
		<form name='form1' class="navbar-form navbar-left"  action='prcdepartment.php' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
			<div class="form-group">	
			<label>ฝ่ายงาน </label>
			<input type='text' name='name'  id='name_dep' placeholder='ฝ่ายงาน' class='form-control'  value='<?php echo $resultGet[dep_name];?>'onkeydown="return nextbox(event, 'save');" required>
			 </div> 
			 
<?PHP 
	if($_GET[dep_id]!=''){
		echo "<input type='hidden' name='mdep_id' value='$mdep_id'>";
		echo "<input type='hidden' name='method' value='mupdate'>";
	 }else{
                echo "<input type='hidden' name='method' value='inser_mdep'>";
         }
 ?> <br><br>
        <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
		</form>
	  </div>
    </div>
 </div>
 </div>
    <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มศูยน์/กลุ่มงาน</h3>
                    </div>
                  <div class="panel-body">
 
                       <div class="col-lg-4">       
		<form name='form2' class="navbar-form navbar-left"  action='prcdepartment.php' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
		       <div class="form-group">	
			<label>เลือกฝ่ายงาน </label>
                         	<select name="md_name" id="md_name" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysql_query("SELECT * FROM department_group order by main_dep ");
				 echo "<option value=''>-ฝ่ายงาน-</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[main_dep]==$resultGet[main_dep]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[main_dep]' $selected>$result[dep_name] </option>";
				 } ?>
			 </select>

			 </div><br><br> 
 	
                    <div class="form-group">	
			<label>ศูยน์/กลุ่มงาน </label>
			<input type='text' name='name'  id='name_dep' placeholder='ศูยน์/กลุ่มงาน' class='form-control'  value='<?php echo $resultGet[depName];?>'onkeydown="return nextbox(event, 'save');" required>
			 </div> 
			 
<?PHP 
	if($_GET[dep_id]!=''){
                echo "<input type='hidden' name='mdep_id' value='$mdep_id'>";
		echo "<input type='hidden' name='dep_id' value='$dep_id'>";
		echo "<input type='hidden' name='method' value='update'>";
	 }else{
                echo "<input type='hidden' name='method' value='inser_dep'>";
         }
 ?> <br><br>
        <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
		</form>
	  </div>
                  </div>
                  </div>
        </div>
    </div>
      <!--  row of columns -->
 <div class="row">
          <div class="col-lg-12">
          <p> <?PHP   include'listdepartment.php';?></p>  
        </div>
	   </div>
 
 <?PHP include'footer.php';  ?>
