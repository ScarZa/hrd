<?php
$myfile = fopen("conn_DB.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
if($myfile){
while(!feof($myfile)) {
  $conn_db[]= fgets($myfile);
}
fclose($myfile);

$dbhost = trim($conn_db[0]);
$dbuser = trim($conn_db[1]);
$dbpass = trim($conn_db[2]);
$dbname = trim($conn_db[3]);
$dbport = trim($conn_db[4]);
}
if($conn_db){
$con = mysql_connect("$dbhost:$dbport","$dbuser","$dbpass");
if($con){
$db = mysql_select_db("$dbname",$con);
mysql_query("SET NAMES 'utf8'", $con);
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
}
}
?>
