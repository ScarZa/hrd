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
            <h1><font color="blue">ตั้งค่าองค์กร/ผู้บริหาร</font></h1>
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าองค์กร/ผู้บริหาร</li>
            </ol>
          </div>
        </div><!-- /.row -->
			<?php include 'connection/connect.php';
			 $sqlGet=mysql_query("select * from  hospital ");
			 $resultGet=mysql_fetch_assoc($sqlGet);
			   ?>    
    <div class="row">
    <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เปลี่ยนแปลงค่า องค์กร/ผู้บริหาร</h3>
                    </div>
                  <div class="panel-body">
 
                       <div class="col-lg-4">       
                           <form name='form2' class="navbar-form navbar-left"  action='prchos.php' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
                    <div class="form-group">	
			<label>องค์กร </label>
                        <input type='text' name='name'  id='name' placeholder='องค์กร' class='form-control'  value='<?= $resultGet[name];?>' size="30" onkeydown="return nextbox(event, 'save');" required>
			 </div><br><br> 
                    		       <div class="form-group">	
			<label>ผู้บริหาร </label>
                         	<select name="m_name" id="m_name" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysql_query("SELECT empno,concat(firstname,' ',lastname) as fullname  FROM emppersonal order by empno ");
				 echo "<option value=''>-เลือกผู้บริหาร-</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[empno]==$resultGet[manager]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[empno]' $selected>$result[fullname] </option>";
				 } ?>
			 </select>

			 </div><br><br> 
                         <div class="form-group">	
			<label>URL </label>
                        <input type='text' name='url'  id='url' placeholder='เช่น http://sample.go.th/' class='form-control'  value='<?= $resultGet[url];?>' size="30" onkeydown="return nextbox(event, 'save');" required>
			 </div><br><br> 
                                         <div class="form-group">
                <label>สัญลักษณ์องค์กร &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control"/>
                    </div>
			  <br><br>
		<input type='hidden' name='method' value='update_hos'>
                <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>

		</form>
	  </div>
                  </div>
                  </div>
        </div>
    </div>
      <!--  row of columns -->
  
 <?PHP include'footer.php';  ?>
