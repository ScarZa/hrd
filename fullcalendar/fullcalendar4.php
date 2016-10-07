<?php @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
    <link rel="stylesheet" href="js/fullcalendar-2.1.1/fullcalendar.min.css">
    <link href="../option/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript">
            $(function() {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'month,agendaWeek,agendaDay',
                        center: 'title',
                        right: 'prev,next today'
                    },
                    editable: true,
                    theme: true,
                    events: "data_events4.php?gData=1",
                    loading: function(bool) {
                        if (bool)
                            $('#loading').show();
                        else
                            $('#loading').hide();
                    },
                    eventLimit:true,  
                    lang:'th'// put your options and callbacks here  
                });

            });
        </script>
    <style type="text/css">
    html,body{
        maring:0;padding:0;
        font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;   
        font-size:12px;
    }
	#calendar{
		max-width: 700px;
		margin: 0 auto;
        font-size:13px;
	}        
    </style>
</head>
<body>
<center><u><h3>ปฏิทินกิจกรรมส่วนตัว</h3></u></center>
<div style="margin:auto;width:800px;">
 <div id='calendar'></div>
 </div>
<br>
<div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
include '../connection/connect_calendra.php';
if($_SESSION[Status]=='ADMIN'){
$event= array("0"=>"ลา","1"=>"ไปราชการ","2"=>"","3"=>"","4"=>"ขึ้นเวร","5"=>"อื่นๆ");
$code_color=array("0"=>"#d92727","1"=>"#416cbb","2"=>"#1e6c06","3"=>"#00a6ba","4"=>"purple","5"=>"orange","6"=>"#4e5252");
}  else {
$event= array("0"=>"ลา","1"=>"ไปราชการ");
$code_color=array("0"=>"#d92727","1"=>"#416cbb");
    
}
for($i=0;$i<=count($event);$i++){  ?>
<a style="background-color:<?= $code_color[$i]?>; color: white"><?= $event[$i]?></a> 
<?php }?>
</div>
<?php if($_SESSION[Status]=='ADMIN'){?>
<div align="center">
    <a href="../add_privatet_calendra.php" class="btn btn-success">เพิ่มกิจกรรม</a>
</div><br>
<?php }?>    
<script src="js/fullcalendar-2.1.1/lib/jquery.min.js"></script>    
<script type="text/javascript" src="js/fullcalendar-2.1.1/lib/moment.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/lang/th.js"></script>
<script type="text/javascript" src="script4.js"></script>            
</body>
</html>