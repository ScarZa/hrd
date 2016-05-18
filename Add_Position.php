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
            <h1><font color="blue">ตั้งค่าตำแหน่ง</font></h1>
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าตำแหน่ง</li>
            </ol>
          </div>
        </div><!-- /.row -->
			<?php include 'connection/connect.php';
			 if($_GET[dep_id]!=''){ 
			 $dep_id=$_GET[dep_id];
			 $sqlGet=mysql_query("select * from  posid
                             where posId='$dep_id' ");
			 $resultGet=mysql_fetch_assoc($sqlGet);
			 }
			   ?>    
    <div class="row">
                  <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มตำแหน่ง</h3>
                    </div>
                  <div class="panel-body">
    <div class="col-lg-4">       
		<form name='form1' class="navbar-form navbar-left"  action='prcposition.php' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
			<div class="form-group">	
			<label>ตำแหน่ง </label>
			<input type='text' name='name'  id='name' placeholder='ตำแหน่ง' class='form-control'  value='<?php echo $resultGet[posname];?>'onkeydown="return nextbox(event, 'save');" required>
			 </div> 
			 
<?PHP 
	if($_GET[dep_id]!=''){
		echo "<input type='hidden' name='dep_id' value='$dep_id'>";
		echo "<input type='hidden' name='method' value='update'>";
	 }else{
                echo "<input type='hidden' name='method' value='inser_pos'>";
         }
 ?> <br><br>
        <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
		</form>
	  </div>
    </div>
 </div>
 </div>

          <div class="col-lg-12">
          <?PHP   include'listposition.php';?> 
        </div>
	   </div>
 
 <?PHP include'footer.php';  ?>
