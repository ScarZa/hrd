<?php @session_start(); ?>
<?php if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} 
include'header.php'; 
include 'connection/connect.php';

$tout=  mysql_query("select endDate, tuid from training_out");
echo $num_tout=  mysql_num_rows($tout);
for($i=1;$i <= $num_tout;$i++){
    while($tout_id=  mysql_fetch_assoc($tout)){
        echo $tout_id['endDate'];
        mysql_query("update plan_out set end_date='".$tout_id['endDate']."' where idpo='".$tout_id['tuid']."'");
    }
}
include 'footer.php';
?>
