<?PHP include'header.php';include 'function/string_to_ascii.php';?>
<?PHP
 echo "<br><br><br><br>";
 
      $user_name=$_POST[name];	 	  	 
      $admin=$_POST[admin];	
      //เข้ารหัส ascii//$user_account=md5(string_to_ascii(trim($_POST['user_account'])));
      $user_account=md5(trim($_POST['user_account']));
      $username=$_POST[user_account];
      //เข้ารหัส ascii//$user_pwd= md5(string_to_ascii(trim($_POST['user_pwd'])));
      $user_pwd= md5(trim($_POST['user_pwd']));

 	  
	if($_POST[method]=='update'){
        $ID=$_POST['ID'];    
	$user_idPOST=$_POST[user_id];
        $mobile=$_POST[mobile];
 
		if($_POST[user_pwd]!=''){
 		$sqlUpdate=mysql_query("update member set Name='$user_name' ,  
 		Status='$admin', Username='$user_account' , Password='$user_pwd',user_name='$username'  
		where Name='$user_idPOST' and UserID='$ID' "); 
		}else{ 
		$sqlUpdate=mysql_query("update member set Name='$user_name' ,user_name='$username',  
 		Status='$admin', Username='$user_account'   
		where Name='$user_idPOST' and UserID='$ID' "); 	
		}
	
 							if($sqlUpdate==false){
											 echo "<p>";
											 echo "Update not complete ".mysql_error();
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
		
								}else{
                                                                    $mobile_update=  mysql_query("update emppersonal set mobile='$mobile'
                                                                            where empno='$user_idPOST'");
                                                                    if($sqlUpdate==false){
                                                                         echo "<p>";
											 echo "Update not complete".mysql_error();
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
                                                                    }
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
									echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";					
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_User.php'>";
								}
   
   }//-----------------------------------------end update
   else if($_REQUEST[method]=='delete'){
       $ID=$_REQUEST['ID'];
       $user_idGet=$_REQUEST[user_id];	 	  
		$sqlDelete=mysql_query("delete from member  
		where Name='$user_idGet' and UserID='$ID' "); 
				
 							if($sqlDelete==false){
											 echo "<p>";
											 echo "Delete not complete".mysql_error();
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
									echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";								
							 		 	echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_User.php'>";
								}
 				 
   }//-----------------------------------------end delete
   else{
 	 	$sqlInsert=mysql_query("insert into member  SET    Name='$user_name' ,  
 		Status='$admin', Username='$user_account' , Password='$user_pwd',user_name='$username'  "); 

	
 							if($sqlInsert==false){
											 echo "<p>";
											 echo "Insert not complete".mysql_error();
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>เพิ่มผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_User.php'>";
								}  	
   }
?>		
<?php	  mysql_close($con); ?>
 
	
	
 