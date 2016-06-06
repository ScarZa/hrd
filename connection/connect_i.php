<?php
$myfile = fopen("conn_DB.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($myfile)) {
  $conn_db[]= fgets($myfile);
}
fclose($myfile);
/*$text = file('conn_DB.txt');
foreach($text as $value){
    $conn_db[]= $value;
}*/

$dbhost = trim($conn_db[0]);
$dbuser = trim($conn_db[1]);
$dbpass = trim($conn_db[2]);
$dbname = trim($conn_db[3]);
$dbport = trim($conn_db[4]);

if($conn_db){
$db=new mysqli($dbhost,$dbuser,$dbpass,$dbname,$dbport);
if($db->connect_errno) die ('Connect Failed! :'.mysqli_connect_error ());
$db->set_charset('utf8');
}
?>
