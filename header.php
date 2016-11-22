<?php @session_start(); ?>
<?php include 'connection/connect.php';
//===ชื่อโรงพยาบาล
                    if($con){
                    $sql = mysql_query("select * from  hospital");
                    $resultHos = mysql_fetch_assoc($sql);
                    }
                    if ($resultHos[logo] != '') {
        $pic = $resultHos[logo];
        $fol = "logo/";
    } else {
        $pic = 'agency.ico';
        $fol = "images/";
    }
                    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="<?= $fol . $pic; ?>">
<!-- Bootstrap core CSS -->
<link href="option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="option/css/stylelist.css">
<script src="option/js/excellentexport.js"></script>
 
<!-- InstanceBeginEditable name="head" -->
    <!--<style type="text/css">
html{
-moz-filter:grayscale(100%);
-webkit-filter:grayscale(100%);
filter:gray;
filter:grayscale(100%);
}
</style>-->
<style type="text/css">
.black-ribbon {   position: fixed;   z-index: 9999;   width: 70px; }
@media only all and (min-width: 768px) { .black-ribbon { width: auto; } }

.stick-left { left: 0; }
.stick-right { right: 0; }
.stick-top { top: 0; }
.stick-bottom { bottom: 0; }
</style>
     <script type="text/javascript">
        function resizeIframe(obj)// auto height iframe
    {
        {
            obj.style.height = 0;
        }
        ;
        {
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }
    }
     </script>
    <script type="text/javascript">
            function getRefresh() {
                $("#auto").show("slow");
                $("#autoRefresh").load("count_comm.php", '', callback);
            }

            function callback() {
                $("#autoRefresh").fadeIn("slow");
                setTimeout("getRefresh();", 1000);
            }

            $(document).ready(getRefresh);
        </script>
        <script language="JavaScript">
            var HttPRequest = false;
            function doCallAjax(Sort) {
                HttPRequest = false;
                if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    HttPRequest = new XMLHttpRequest();
                    if (HttPRequest.overrideMimeType) {
                        HttPRequest.overrideMimeType('text/html');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                            HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {
                        }
                    }
                }
                if (!HttPRequest) {
                    alert('Cannot create XMLHTTP instance');
                    return false;
                }
                var url = 'count_comm.php';
                var pmeters = 'mySort=' + Sort;
                HttPRequest.open('POST', url, true);
                HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                HttPRequest.setRequestHeader("Content-length", pmeters.length);
                HttPRequest.setRequestHeader("Connection", "close");
                HttPRequest.send(pmeters);
                HttPRequest.onreadystatechange = function ()
                {
                    if (HttPRequest.readyState == 3)  // Loading Request
                    {
                        document.getElementById("mySpan").innerHTML = "Now is Loading...";
                    }
                    if (HttPRequest.readyState == 4) // Return Request
                    {
                        document.getElementById("mySpan").innerHTML = HttPRequest.responseText;
                    }
                }
            }
        </script>
        
    
    </head>
<?php
                     if (!empty($_GET['popup'])){
                      $project_place= $_GET['project_place'];  
                      $province=  $_GET['province'];
                      $stdate=$_GET['stdate'];
                      $etdate=$_GET['etdate'];
                      $amount=$_GET['amount'];
                      $cod_popup="window.open('popup_request_car.php?project_place=$project_place&province=$province&stdate=$stdate&etdate=$etdate&amount=$amount','','width=600,height=650'); return false;";
                      
                      ?>
    <body onload="<?= $cod_popup?>">
                     <?php }else{ ?>
    <body Onload="bodyOnload();">    
                     <?php }?>
        <!-- Top Left -->
<img src="https://goo.gl/Yl6KNg" class="black-ribbon stick-top stick-left"/>
        <!--<div id="wrapper">-->
            <!-- Sidebar -->
            <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="container-fluid">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                    <a class="navbar-brand logo-mini" href="index.php?unset=1"><img alt="Brand" src="images/kuser.ico" width='35'> 
                        <font color='#ffff00'><b>HRD S</b>ystem V.1.8.1</font>
                    </a>
                </div>
                    </div>
                <?php
                if ($_SESSION[user] != '') {
                    $sqlUser = mysql_query("select Status from member where UserID='$user_id' ");
                    $resultUser = mysql_fetch_assoc($sqlUser);
                    $admin = $resultUser[admin];
                }
                ?>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <!--<ul class="nav  navbar-custom navbar-nav side-nav">
                        <li><a href="./"><img src='images/gohome.ico' width='25'>  หน้าหลัก</a></li> 		
                        <?php if ($_SESSION[user] != '') { ?>
                        
                        <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/kuser.ico' width='25'> ระบบบุคลากร <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?if($_SESSION[Status]=='ADMIN'){?>
                                    <li><a href="pre_person.php"><img src='images/identity.ico' width='25'> ข้อมูลบุคลากร</a></li>
                                    <li><a href="add_person.php"><img src='images/adduser.ico' width='25'> เพิ่มข้อมูลบุคลากร</a></li>
                                <?}else{?>
                                    <li><a href="#" onClick="window.open('detial_person.php','','width=700,height=500'); return false;" title="Code PHP Popup"><i class="fa fa-bar-chart-o"></i> ข้อมูลบุคลากร</a></li>
                                <?}?>
                                </ul>            
                            </li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Letter.png' width='25'> ระบบการลา <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?if($_SESSION[status]=='ADMIN'){?>
                                    <li><a href="receive_leave.php"><img src='images/Lfolder.ico' width='25'> บันทึกทะเบียนรับใบลา</a></li>
                                    <li><a href="pre_leave.php"><img src='images/Lfolder.ico' width='25'> บันทึกการลาบุคลากร</a></li>
                                    <li><a href="conclude_cancle.php"><img src='images/Cfolder.ico' width='25'> ยกเลิกการลา</a></li>
                                    <li><a href="conclude_transfer.php"><img src='images/folder_sent.ico' width='25'> โอนลาชั่วโมง</a></li>
                                    <li><a href="Lperson_report.php"><img src='images/kchart.ico' width='25'> สถิติการลาแยกหน่วยงาน</a></li>
                                    <li><a href="statistics_leave.php"><img src='images/kchart.ico' width='25'> สถิติการลา</a></li>
                            <?}else{?> 
                                    <li><a href="detial_leave.php"><i class="fa fa-bar-chart-o"></i> บันทึกการลาบุคลากร</a></li>
                            <?}?>
                            </ul> 
                        </li>
                        <?if($_SESSION[status]=='ADMIN'){?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/training.ico' width='25'> ระบบฝึกอบรมภายนอก <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="add_project_out.php"><img src='images/add.ico' width='25'></i> บันทึกการฝึกอบรมภายนอก</a></li>
                                    <li><a href="pre_trainout.php"><img src='images/kig.ico' width='25'> รายงานฝึกอบรมภายนอก</a></li>
                                    <li><a href="statistics_trainout.php"><img src='images/kchart.ico' width='25'> ประวัติการฝึกอบรมภายนอก</a></li>
                                </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/trainin.ico' width='25'> ระบบฝึกอบรมภายใน <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                    <li><a href="add_project.php"><img src='images/add.ico' width='25'> บันทึกโครงการ</a></li>
                                    <li><a href="pre_trainin.php"><img src='images/kig.ico' width='25'> บันทึกการฝึกอบรมภายใน</a></li>
                                    <li><a href="statistics_trainin.php"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายใน</a></li>
                                </ul>
                        </li>
                        
                        <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/System2.ico' width='25'> ตั้งค่า <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="Add_User.php"><img src='images/Settings.ico' width='25'> ผู้ใช้งาน</a></li>
                                    <li><a href="Add_Department.php"><img src='images/Settings.ico' width='25'> ฝ่าย/ศูนย์/กลุ่มงาน</a></li>
                                    <li><a href="Add_Position.php"><img src='images/Settings.ico' width='25'> ตำแหน่ง</a></li>
                                </ul>
                            </li>
                        <?}else{?>
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bookmark-o"></i> ประวัติระบบฝึกอบรม <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                    <li><a href="detial_trainin.php"><i class="fa fa-bar-chart-o"></i> ประวัติระบบฝึกอบรม</a></li>
                                </ul>
                        </li><?}?>
<?php } //$_SESSION['user_id']!=''  ?>
                    </ul>-->
                    <ul class="nav navbar-nav navbar-right navbar-user">
                        
                        <?PHP 
                        if ($_SESSION[user] == '') {
                         ?>            	
                            <li> 	
                                <form class="navbar-form navbar-right" action='checkLogin(2).php' method='post'>
                                    <div class="form-group">
                                        <input type="text" placeholder="User Name" name='user_account' class="form-control" value='' required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Password" name='user_pwd' class="form-control"  value='' required>
                                    </div>
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-lock"></i> Sign in</button> 
                                    <div class="form-group">
                                    </div>
                                </form>
                            </li>
                            <?PHP } else { ?>
                                         <script language="JavaScript">
                                            function bodyOnload()
                                            {
                                                doCallAjax('CustomerID')
                                                setTimeout("doLoop();", 10000);
                                            }
                                            function doLoop()
                                            {
                                                bodyOnload();
                                            }
                                        </script>
                                        <ul class="nav navbar-nav navbar-user" id="mySpan"></ul>
                                <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/kuser.ico' width='25'> บุคลากร <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php if($_SESSION[Status]=='ADMIN'){?>
                                    <li><a href="add_person.php?unset=1"><img src='images/adduser.ico' width='25'> เพิ่มข้อมูลบุคลากร</a></li>
                                    <li><a href="pre_person.php?unset=1"><img src='images/identity.png' width='25'> ข้อมูลบุคลากร</a></li>
                                    <li><a href="pre_educate.php?unset=1"><img src='images/Student.ico' width='25'> ประวัติการศึกษา</a></li>
                                    <li><a href="pre_Whistory.php?unset=1"><img src='images/work.ico' width='25'> ประวัติการทำงาน</a></li>
                                    <li><a href="resign_person.php?unset=1"><img src='images/identity-x.png' width='25'> ข้อมูลบุคลากรย้าย/ลาออก</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_person.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติบุคลากร</a></li>
                                    <li><a href="#" onClick="window.open('detial_type.php','','width=470,height=520'); return false;" title="สถิติประเภทพนักงาน"><img src='images/kchart.ico' width='25'> สถิติประเภทพนักงาน</a></li>
                                    <li><a href="#" onClick="window.open('detial_position.php','','width=600,height=680'); return false;" title="สถิติตำแหน่งพนักงาน"><img src='images/kchart.ico' width='25'> สถิติตำแหน่งพนักงาน</a></li>
                                        <?php }else{?>
                                    <li><a href="#" onClick="window.open('detial_person.php','','width=700,height=500'); return false;" title="ข้อมูลบุคลากร"><img src='images/identity.ico' width='25'> ข้อมูลบุคลากร</a></li>
                                    <li><a href="detial_educate.php?unset=1"><img src='images/Student.ico' width='25'> ประวัติการศึกษา</a></li>
                                    <li><a href="detial_Whistory.php?unset=1"><img src='images/work.ico' width='25'> ประวัติการทำงาน</a></li>
                                        <?php } if($_SESSION[Status]=='SUSER' or $_SESSION[Status]=='USUSER'){?>
                                    <li class="divider"></li>
                                    <li><a href="statistics_person.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติบุคลากรในหน่วยงาน</a></li>
                                        <?php }?>
                                </ul>            
                            </li>
        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Letter.png' width='25'> การลา <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php if($_SESSION[Status]=='ADMIN'){?>
                                    <li><a href="receive_leave.php?unset=1"><img src='images/kwrite.ico' width='25'> บันทึกทะเบียนรับใบลา</a></li>
                                    <li><a href="pre_leave.php?unset=1"><img src='images/Lfolder.ico' width='25'> บันทึกการลาบุคลากร</a></li>
                                    <li><a href="conclude_cancle.php?unset=1"><img src='images/Cfolder.ico' width='25'> ยกเลิกการลา</a></li>
                                    <li><a href="conclude_transfer.php?unset=1"><img src='images/folder_sent.ico' width='25'> โอนลาชั่วโมง</a></li>
                                    <li class="divider"></li>
                                    <li><a href="Lperson_report.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลาแยกหน่วยงาน</a></li>
                                    <!--<li><a href="statistics_leave.php"><img src='images/kchart.ico' width='25'> สถิติการลา</a></li>-->
                                    <li><a href="Lperson_report_sum.php?screen=1&unset=1"><img src='images/kchart.ico' width='25'> สรุปวันลาแยกหน่วยงาน</a></li>
                                    <li><a href="Lperson_report_sum.php?screen=2&unset=1"><img src='images/kchart.ico' width='25'> สรุปวันลาแยกประเภทบุคลากร</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_scan.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลืมลงเวลา</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_late.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลงสาย</a></li>
                            <?php }else{?> 
                                    <li><a href="pre_leave.php?unset=1"><img src='images/Lfolder.ico' width='25'> บันทึกการลาบุคลากร</a></li>
                            <?php } if($_SESSION[Status]=='SUSER' or $_SESSION[Status]=='USUSER'){?>
                                    <li class="divider"></li>
                                    <li><a href="Lperson_report.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลาในหน่วยงาน</a></li>
                            <?php }?>
                            </ul> 
                        </li>
                        <?php if($_SESSION[Status]=='ADMIN'){?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/training.ico' width='25'> อบรมภายนอก <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="add_project_out.php?unset=1"><img src='images/add.ico' width='25'></i> บันทึกโครงการฝึกอบรมภายนอก</a></li>
                                    <li><a href="pre_trainout.php?unset=1"><img src='images/kig.ico' width='25'> บันทึกการฝึกอบรมภายนอก</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_trainout.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายนอก</a></li>
                                    <li><a href="pre_trainout(N).php?unset=1"><img src='images/kchart.ico' width='25'> รายงานผู้ที่ยังไม่ได้สรุป</a></li>
                                </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/trainin.ico' width='25'> อบรมภายใน <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                    <li><a href="add_project.php?unset=1"><img src='images/add.ico' width='25'> บันทึกโครงการฝึกอบรมภายใน</a></li>
                                    <li><a href="pre_trainin.php?unset=1"><img src='images/kig.ico' width='25'> บันทึกการฝึกอบรมภายใน</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_trainin.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายใน</a></li>
                                </ul>
                        </li>
                        
                        <?php }else{?>
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/trainin.ico' width='25'> ประวัติระบบฝึกอบรม <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="add_project_out.php?unset=1"><img src='images/add.ico' width='25'></i> บันทึกโครงการฝึกอบรมภายนอก</a></li>
                                        <li><a href="pre_trainout.php?unset=1"><img src='images/kig.ico' width='25'> บันทึกการฝึกอบรมภายนอก</a></li>
                                        <li class="divider"></li>
                                        <li><a href="detial_trainin.php?unset=1"><img src='images/training.ico' width='25'> ประวัติระบบฝึกอบรม</a></li>
                            <?php if($_SESSION[Status]=='SUSER' or $_SESSION[Status]=='USUSER'){?>
                                        <li class="divider"></li>
                                    <li><a href="statistics_trainout.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายนอก</a></li>
                                    <li><a href="statistics_trainin.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายใน</a></li>
                            <?php }?>
                                </ul>
                        </li><?php }?>

                            <li class="dropdown user-dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/personal.ico' width='20'> 
                                    <?php
                                    $user_id = $_SESSION[user];
                                    if ($user_id != '') {
                                        $sql = mysql_query("select concat(firstname,' ',lastname) AS name from emppersonal WHERE empno='$user_id'");
                                        $result = mysql_fetch_assoc($sql);
                                        echo $result[name];
                                    }
                                    ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                <!--  <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                                  <li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">
                                  </span></a></li>
                                  <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>         
                                    --> 
                                    
                                        <li><a href="Add_User.php?user_id=<?= $_SESSION[user] ?>"><img src='images/personal.ico' width='25'> แก้ไขข้อมูลส่วนตัว</a></li>
                                        <?php if($_SESSION[Status]=='ADMIN'){?>
                                        <li class="divider"></li>
                                        <li><a href="Add_Hos.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าองค์กร/ผู้บริหาร</a></li>
                                    <li><a href="Add_User.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าผู้ใช้งาน</a></li>
                                    <li><a href="Add_Department.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าฝ่าย/ศูนย์/กลุ่มงาน</a></li>
                                    <li><a href="Add_Position.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าตำแหน่ง</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" onClick="window.open('regularity.php','','width=1200,height=700'); return false;" title="เพิ่มระเบียบ"><img src='images/sticky-notes.ico' width='25'> ระเบียบ/ข้อบังคับ</a></li>
                                    <li class="divider"></li>
                                    <li><a href="backup.php?unset=1" onclick="return confirm('กรุณายืนยันการสำรองข้อมูลอีกครั้ง !!!')"><img src='images/backup-restore.ico' width='25'> สำรองข้อมูล</a></li>
                                    <li><a href="#" onClick="window.open('openDB.php','','width=400,height=350'); return false;" title="ข้อมูลสำรอง"><img src='images/database.ico' width='25'> ข้อมูลสำรอง</a></li>
                                    <li class="divider"></li> <?php }?>
                                    <li><a href="#" onClick="return popup('fullcalendar/fullcalendar4.php', popup, 820, 710);" title="ดูกิจกรรมส่วนตัว"><img src='images/calendar-clock.ico' width='25'> ปฏิทินกิจกรรมส่วนตัว</a></li>

                                    <li class="divider"></li>
                                    <li><a href="#" onClick="return popup('about.php', popup, 550, 700);" title="เกี่ยวกับเรา"><img src='images/Paper Mario.ico' width='25'> เกี่ยวกับเรา</a></li>
                                    <li class="divider"></li> 
                                    <li><a href="logout.php"><img src='images/exit.ico' width='25'> Log Out</a></li>
                                </ul>
                                </form>
<?PHP }?>
                        </li>
                    </ul>
                <!--</div> /.navbar-collapse -->
            </nav>
            <script src="option/js/jquery.min.js"></script>
            <script src="option/js/bootstrap.js"></script>
            <!--scrip check numberical-->
                <script type="text/javascript">
                    function inputDigits(sensor) {
                        var regExp = /[0-9.-]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวเลขเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }
                </script>
                <!--scrip check ตัวอักษร-->
                <script type="text/javascript">
                    function inputString(sensor) {
                        var regExp = /[A-Za-zก-ฮะ-็่-๋์]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวอักษรเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }

                </script>
                <script language="JavaScript">
                    function chkdel() {
                        if (confirm('  กรุณายืนยันการลบอีกครั้ง !!!  ')) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                </script>
                <script type="text/javascript">
		function popup(url,name,windowWidth,windowHeight){    
				myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
				mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
				properties = "width="+windowWidth+",height="+windowHeight;
				properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
				window.open(url,name,properties);
	}
</script>
<?php                  
                    function insert_date(&$take_date_conv,&$take_date)
                    {
                        
                         $take_date=explode("/",$take_date_conv);
			 $take_date_year=$take_date[2]-543;
			 $take_date="$take_date_year-$take_date[1]-$take_date[0]";
                    }
                    
                    function unset_session(){
                        if(!empty($_SESSION['check_date01'])){
                        unset($_SESSION['check_date01']);}
                        if(!empty($_SESSION['check_date02'])){
                        unset($_SESSION['check_date02']);}
                        if(!empty($_SESSION['txtKeyword'])){
                        unset($_SESSION['txtKeyword']);}
                        if(!empty($_SESSION['check_rec'])){
                        unset($_SESSION['check_rec']);}
                        if(!empty($_SESSION['check_cancle'])){
                        unset($_SESSION['check_cancle']);}
                        if(!empty($_SESSION['check_Lperson'])){
                        unset($_SESSION['check_Lperson']);}
                        if(!empty($_SESSION['dep_Lperson'])){
                        unset($_SESSION['dep_Lperson']);}
                        if(!empty($_SESSION['depname'])){
                        unset($_SESSION['depname']);}
                        if(!empty($_SESSION['check_trainout'])){
                        unset($_SESSION['check_trainout']);}
                        if(!empty($_SESSION['check_out'])){
                        unset($_SESSION['check_out']);}
                        if(!empty($_SESSION['check_trainin'])){
                        unset($_SESSION['check_trainin']);}
                        if(!empty($_SESSION['check_pro'])){
                        unset($_SESSION['check_pro']);}
                        if(!empty($_SESSION['check_stat'])){
                        unset($_SESSION['check_stat']);}
                        if(!empty($_SESSION['empno'])){
                        unset($_SESSION['empno']);}
                    }
?>
<script language="JavaScript" type="text/javascript"> 
var StayAlive = 4; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
function KillMe()
{ 
setTimeout("self.close()",StayAlive * 1000); 
} 
</script>            
<div id="page-wrapper">