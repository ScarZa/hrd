<?PHP @session_start(); ?>
<META content="text/html; charset=utf8" http-equiv=Content-Type>
<DIV  align="center"><IMG src="images/tororo_exercise.gif" width="350"></DIV>
<?php
if ($_POST[checkdate] == '1' and $_POST[check_date01]!='')  {
    $_SESSION[checkdate] = $_POST[checkdate];
    $_SESSION[check_date01]=$_POST[check_date01];
    $_SESSION[check_date02]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=statistics_leave.php' />";
}elseif ($_POST[checkdate] == '1' and $_POST[check_date01]=='') {
    $_SESSION[checkdate] = '';
    $_SESSION[check_date01]= '';
    $_SESSION[check_date02]='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_leave.php' />";

    
}elseif ($_POST[method]=='check_date_cancle' and $_POST[check_date01]!='') {
    $_SESSION['check_cancle']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=conclude_cancle.php' />";
}elseif ($_POST[method]=='check_date_cancle' and $_POST[check_date01]=='') {
    $_SESSION['check_cancle'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=conclude_cancle.php' />";

    
}elseif ($_POST[method]=='check_trainin' and $_POST[check_date01]!='') {
    $_SESSION['check_trainin']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=pre_trainin.php' />";
}elseif ($_POST[method]=='check_trainin' and $_POST[check_date01]=='') {
    $_SESSION['check_trainin'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=pre_trainin.php' />";

    
}elseif ($_POST[method]=='check_pro_trainin' and $_POST[check_date01]!='') {
    $_SESSION['check_pro']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainin.php' />";
}elseif ($_POST[method]=='check_pro_trainin' and $_POST[check_date01]=='') {
    $_SESSION['check_pro'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainin.php' />";

    
}elseif ($_POST[method]=='check_trainout' and $_POST[check_date01]!='') {
    $_SESSION['check_trainout']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=pre_trainout.php' />";
}elseif ($_POST[method]=='check_trainout' and $_POST[check_date01]=='') {
    $_SESSION['check_trainout'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=pre_trainout.php' />";

    
}elseif ($_POST[method]=='check_pro_trainout' and $_POST[check_date01]!='') {
    $_SESSION['check_out']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainout.php' />";
}elseif ($_POST[method]=='check_pro_trainout' and $_POST[check_date01]=='') {
    $_SESSION['check_out'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainout.php' />";

    
}elseif ($_POST[method]=='check_statistics_trainout' and $_POST[check_date01]!='') {
    $_SESSION['check_stat']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    $emp=$_POST['empno'];
    
    echo "<meta http-equiv='refresh' content='0;url=detial_trainin.php?&id=$emp&method=check' />";
}elseif ($_POST[method]=='check_statistics_trainout' and $_POST[check_date01]=='') {
    $_SESSION['check_stat'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    $emp=$_POST['empno'];
    echo "<meta http-equiv='refresh' content='0;url=detial_trainin.php?&id=$emp&method=check' />";

    
}elseif ($_POST[method]=='check_detial_leave' and $_POST[check_date01]!='') {
    $_SESSION[check_dl]=$_POST[method];
    $_SESSION[leave_date1]=$_POST[check_date01];
    $_SESSION[leave_date2]=$_POST[check_date02];
    $emp=$_POST[empno];
    echo "<meta http-equiv='refresh' content='0;url=detial_leave.php?&id=$emp' />";
}elseif ($_POST[method]=='check_detial_leave' and $_POST[check_date01]=='') {
    $_SESSION[check_dl] = '';
    $_SESSION[leave_date1]='';
    $_SESSION[leave_date2]='';
    $emp=$_POST[empno];
    echo "<meta http-equiv='refresh' content='0;url=detial_leave.php?&id=$emp' />";

    
}elseif ($_POST[method]=='check_receive' and $_POST[check_date01]!='') {
    $_SESSION['check_rec']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=receive_leave.php' />";
}elseif ($_POST[method]=='check_receive' and $_POST[check_date01]=='') {
    $_SESSION['check_rec'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=receive_leave.php' />";

    
}elseif ($_POST[method]=='check_receive_app' and $_POST[check_date01]!='') {
    $_SESSION['check_rec']=$_POST[method];
    $_SESSION['check_date01']=$_POST[check_date01];
    $_SESSION['check_date02']=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=receive_trainout.php' />";
}elseif ($_POST[method]=='check_receive_app' and $_POST[check_date01]=='') {
    $_SESSION['check_rec'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=receive_trainout.php' />";

    
}elseif ($_POST[method]=='Lperson_date' and $_POST[take_date01]!='') {
    $_SESSION['check_Lperson']=$_POST[method];
    $_SESSION['check_date01']=$_POST[take_date01];
    $_SESSION['check_date02']=$_POST[take_date02];
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";
}elseif ($_POST[method]=='Lperson_date' and $_POST[take_date01]=='') {
    $_SESSION['check_Lperson'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";

    
}elseif ($_POST[method]=='Lperson_dep' and $_POST[dep]!='') {
    $_SESSION['dep_Lperson']=$_POST[method];
    $depname=$_POST[dep];
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php?&depname=$depname' />";
}elseif ($_POST[method]=='Lperson_dep' and $_POST[dep]=='') {
    $_SESSION['dep_Lperson'] = '';
    $_SESSION['depname']='';
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";

    
}
 ?>   