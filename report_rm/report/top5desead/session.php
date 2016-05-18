  <div data-role="page" data-theme='d' >	
<?php @session_start();
if($_GET[dx]!='' and $_GET[geo_id]==''){
	$_SESSION[dx]=$_GET[dx];
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php'>";	
}else if($_GET[geo_id]!=''){
    $_SESSION[dx]=$_GET[dx];
	$_SESSION[geo_id]=$_GET[geo_id];
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=changwat.php'>";	
}else if($_GET[chwpart]!='' && $_GET[dx_chwpart]!='' && $_GET[choice]=='amphur'){
	$_SESSION[chwpart]=$_GET[chwpart];
	$_SESSION[dx]=$_GET[dx_chwpart];
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=amphur.php'>";	
}else if($_GET[amppart]!=''){
	$_SESSION[amppart]=$_GET[amppart];
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tumbon.php'>";	
}else{
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?dx=0'>";	

}
 ?>

 
  </div>
 
 
 