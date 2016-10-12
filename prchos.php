<?php @session_start(); ?>
<?php  if(empty($_SESSION[user])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<?php  include'option/jquery.php';?>
<?php  include'header.php';?>
<meta charset="utf-8"> 
<?PHP
 echo "<br><br><br><br>";
 
 
	if($_POST[method]=='update_hos'){
                   $name=$_POST[name];	 	  	 
                   $m_name=$_POST[m_name]; 
                   $url=$_POST['url'];
                function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}
        if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "logo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
            if($image !=''){
                $del_photo=mysql_query("select logo from hospital");
                $del_photo=mysql_fetch_assoc($del_photo);
                if(!empty($del_photo['logo'])){
                $location="logo/".$del_photo['logo'];
                include 'function/delet_file.php';
                fulldelete($location);
                }
		$sqlUpdate=mysql_query("update hospital  SET name='$name',manager='$m_name', url='$url',logo='$image'  "); 	
            }else{
               $sqlUpdate=mysql_query("update hospital  SET name='$name',manager='$m_name', url='$url'");  
            }
	
 							if($sqlUpdate==false){
											 echo "<p>";
											 echo "Update not complete".mysql_error();
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_Hos.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
								}
   
   }
   mysql_close($con); ?>
 
	
	
 
