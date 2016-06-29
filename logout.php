<?php @session_start(); 
include 'header.php';
echo "<DIV  align='center'><IMG src='images/tororo_run.gif' width='300'></DIV><p>&nbsp;</p>
    <div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-danger'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>ออกจากระบบเรียบร้อย</center></a> 
</div>";								
session_destroy();

 echo "<meta http-equiv='refresh' content='1;url=./'/>";
?>
 