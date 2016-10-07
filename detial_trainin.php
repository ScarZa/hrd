<?php include 'header.php'; ?>
        <script type="text/javascript">
            function popup(url, name, windowWidth, windowHeight) {
                myleft = (screen.width) ? (screen.width - windowWidth) / 2 : 100;
                mytop = (screen.height) ? (screen.height - windowHeight) / 2 : 100;
                properties = "width=" + windowWidth + ",height=" + windowHeight;
                properties += ",scrollbars=yes, top=" + mytop + ",left=" + myleft;
                window.open(url, name, properties);
            }
        </script>
        <?php
        include_once ('option/funcDateThai.php');
        if(!empty($_REQUEST[id])){
        $empno = $_REQUEST[id];
        }else{
        if($_SESSION[emp]!=''){
        $empno = $_SESSION[emp];
            
        }elseif ($_SESSION[Status]=='USER' or $_SESSION[Status]=='SUSER') {
    $empno = $_SESSION[user];
        } }
                    $name_detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            where e1.empno='$empno'");
include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    if($_REQUEST['train']=='in'){
            $date01=$_SESSION[pro_date1];
            $date02=$_SESSION[pro_date2];
            }elseif ($_REQUEST['train']=='out') {
            $date01=$_SESSION[out_date1];
            $date02=$_SESSION[out_date2];
        }  else {                    
            $date01=$_SESSION[stat_date1];
            $date02=$_SESSION[stat_date2];
        }
        if ($date01!='' and $date02!='') {
            
            $detial = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and (bdate between '$date01' and '$date02') and (edate between '$date01' and '$date02') order by p.bdate desc");

            $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate 
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and (begin_date between '$date01' and '$date02') order by t.memberbook desc");
            
            $detiatl2 = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME 
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and t.dt='9' and (begin_date between '$date01' and '$date02') order by t.memberbook desc");

            $count_pj = mysql_query("select count(pjid) as pjid,
                                   (select sum(amount) from plan p where p.type_id='$empno' and (bdate between '$date01' and '$date02') and (edate between '$date01' and '$date02'))amount
                                    from plan 
                                    where type_id='$empno' and (bdate between '$date01' and '$date02') and (edate between '$date01' and '$date02')");


            $sum_abode = mysql_query("select sum(abode) as sum_abode,
(select sum(reg) from plan_out p1 where p1.empno='$empno' and p1.status_out='Y' and (begin_date between '$date01' and '$date02'))sum_reg,
(select sum(allow) from plan_out p2 where p2.empno='$empno' and p2.status_out='Y' and (begin_date between '$date01' and '$date02'))sum_allow,
(select sum(travel) from plan_out p3 where p3.empno='$empno' and p3.status_out='Y' and (begin_date between '$date01' and '$date02'))sum_travel,
(select sum(other) from plan_out p4 where p4.empno='$empno' and p4.status_out='Y' and (begin_date between '$date01' and '$date02'))sum_other,
(select sum(amount) from plan_out p5 where p5.empno='$empno' and p5.status_out='Y' and (begin_date between '$date01' and '$date02'))sum_amount 
 from plan_out where empno='$empno' and status_out='Y' and (begin_date between '$date01' and '$date02')");
            
             $sum_abode2 = mysql_query("select sum(abode) as sum_abode,
(select sum(reg) from plan_out p1
inner join training_out tout on tout.tuid=p1.idpo 
where p1.empno='$empno' and p1.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_reg,
(select sum(allow) from plan_out p2
inner join training_out tout on tout.tuid=p2.idpo 
where p2.empno='$empno' and p2.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_allow,
(select sum(travel) from plan_out p3
inner join training_out tout on tout.tuid=p3.idpo 
where p3.empno='$empno' and p3.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_travel,
(select sum(other) from plan_out p4
inner join training_out tout on tout.tuid=p4.idpo 
where p4.empno='$empno' and p4.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_other,
(select sum(p5.amount) from plan_out p5
inner join training_out tout on tout.tuid=p5.idpo 
where p5.empno='$empno' and p5.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_amount 
from plan_out p0
inner join training_out tout on tout.tuid=p0.idpo 
where p0.empno='$empno' and p0.status_out='Y' and (p0.begin_date between '$date01' and '$date02') and tout.dt='9'");
        } else {
            $detial = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and p.bdate BETWEEN '$y-10-01' and '$Yy-09-30' order by p.bdate desc");

            $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate 
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y'  and p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30' order by t.memberbook desc");
            
            $detiatl2 = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME 
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
        where p.empno='$empno' and p.status_out='Y' and t.dt='9'  and p.begin_date BETWEEN '$y-10-01' and '$Yy-09-30' order by t.memberbook desc");

            $count_pj = mysql_query("select count(pjid) as pjid,
                                    (select sum(amount) from plan p where p.type_id='$empno' and (p.bdate BETWEEN '$y-10-01' and '$Yy-09-30'))amount
                                      from plan 
                                        where type_id='$empno'  and (bdate BETWEEN '$y-10-01' and '$Yy-09-30')");


            $sum_abode = mysql_query("select sum(abode) as sum_abode,
(select sum(reg) from plan_out p1 where p1.empno='$empno' and p1.status_out='Y'  and p1.begin_date BETWEEN '$y-10-01' and '$Yy-09-30')sum_reg,
(select sum(allow) from plan_out p2 where p2.empno='$empno' and p2.status_out='Y' and p2.begin_date BETWEEN '$y-10-01' and '$Yy-09-30')sum_allow,
(select sum(travel) from plan_out p3 where p3.empno='$empno' and p3.status_out='Y' and p3.begin_date BETWEEN '$y-10-01' and '$Yy-09-30')sum_travel,
(select sum(other) from plan_out p4 where p4.empno='$empno' and p4.status_out='Y' and p4.begin_date BETWEEN '$y-10-01' and '$Yy-09-30')sum_other,
(select sum(amount) from plan_out p5 where p5.empno='$empno' and p5.status_out='Y' and p5.begin_date BETWEEN '$y-10-01' and '$Yy-09-30')sum_amount 
 from plan_out where empno='$empno' and status_out='Y' and begin_date BETWEEN '$y-10-01' and '$Yy-09-30'");
            
            $sum_abode2 = mysql_query("select sum(p0.abode) as sum_abode,
(select sum(reg) from plan_out p1 
inner join training_out tout on tout.tuid=p1.idpo
where p1.empno='$empno' and p1.status_out='Y'  and p1.begin_date BETWEEN '$y-10-01' and '$Yy-09-30' and tout.dt='9')sum_reg,
(select sum(allow) from plan_out p2 
inner join training_out tout on tout.tuid=p2.idpo
where p2.empno='$empno' and p2.status_out='Y' and p2.begin_date BETWEEN '$y-10-01' and '$Yy-09-30' and tout.dt='9')sum_allow,
(select sum(travel) from plan_out p3 
inner join training_out tout on tout.tuid=p3.idpo
where p3.empno='$empno' and p3.status_out='Y' and p3.begin_date BETWEEN '$y-10-01' and '$Yy-09-30' and tout.dt='9')sum_travel,
(select sum(other) from plan_out p4 
inner join training_out tout on tout.tuid=p4.idpo
where p4.empno='$empno' and p4.status_out='Y' and p4.begin_date BETWEEN '$y-10-01' and '$Yy-09-30' and tout.dt='9')sum_other,
(select sum(p5.amount) from plan_out p5
inner join training_out tout on tout.tuid=p5.idpo 
where p5.empno='$empno' and p5.status_out='Y' and (p5.begin_date BETWEEN '$y-10-01' and '$Yy-09-30') and tout.dt='9')sum_amount 
from plan_out p0
inner join training_out tout on tout.tuid=p0.idpo
where p0.empno='$empno' and p0.status_out='Y' and p0.begin_date BETWEEN '$y-10-01' and '$Yy-09-30' and tout.dt='9'");
        }
}  else {
    if($_REQUEST['train']=='in'){
            $date01=$_SESSION[pro_date1];
            $date02=$_SESSION[pro_date2];
            }elseif ($_REQUEST['train']=='out') {
            $date01=$_SESSION[out_date1];
            $date02=$_SESSION[out_date2];
        }  else {                    
            $date01=$_SESSION[stat_date1];
            $date02=$_SESSION[stat_date2];
        }
        if ($date01!='' and $date02!='') {
            
            $detial = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and (bdate between '$date01' and '$date02') and (edate between '$date01' and '$date02') order by p.bdate desc");

            $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and t.dt!='9' and (begin_date between '$date01' and '$date02') order by t.memberbook desc");
            
            $detiatl2 = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME 
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
where p.empno='$empno' and p.status_out='Y' and t.dt='9' and (begin_date between '$date01' and '$date02') order by t.memberbook desc");

            $count_pj = mysql_query("select count(pjid) as pjid,
                                   (select sum(amount) from plan p where p.type_id='$empno' and (bdate between '$date01' and '$date02') and (edate between '$date01' and '$date02'))amount
                                    from plan 
                                    where type_id='$empno' and (bdate between '$date01' and '$date02') and (edate between '$date01' and '$date02')");


            $sum_abode = mysql_query("select sum(abode) as sum_abode,
(select sum(reg) from plan_out p1
inner join training_out tout on tout.tuid=p1.idpo 
where p1.empno='$empno' and p1.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt!='9')sum_reg,
(select sum(allow) from plan_out p2
inner join training_out tout on tout.tuid=p2.idpo 
where p2.empno='$empno' and p2.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt!='9')sum_allow,
(select sum(travel) from plan_out p3
inner join training_out tout on tout.tuid=p3.idpo 
where p3.empno='$empno' and p3.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt!='9')sum_travel,
(select sum(other) from plan_out p4
inner join training_out tout on tout.tuid=p4.idpo 
where p4.empno='$empno' and p4.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt!='9')sum_other,
(select sum(p5.amount) from plan_out p5
inner join training_out tout on tout.tuid=p5.idpo 
where p5.empno='$empno' and p5.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt!='9')sum_amount 
from plan_out p0
inner join training_out tout on tout.tuid=p0.idpo 
where p0.empno='$empno' and p0.status_out='Y' and (p0.begin_date between '$date01' and '$date02') and tout.dt!='9'");
            $sum_abode2 = mysql_query("select sum(abode) as sum_abode,
(select sum(reg) from plan_out p1
inner join training_out tout on tout.tuid=p1.idpo 
where p1.empno='$empno' and p1.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_reg,
(select sum(allow) from plan_out p2
inner join training_out tout on tout.tuid=p2.idpo 
where p2.empno='$empno' and p2.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_allow,
(select sum(travel) from plan_out p3
inner join training_out tout on tout.tuid=p3.idpo 
where p3.empno='$empno' and p3.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_travel,
(select sum(other) from plan_out p4
inner join training_out tout on tout.tuid=p4.idpo 
where p4.empno='$empno' and p4.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_other,
(select sum(p5.amount) from plan_out p5
inner join training_out tout on tout.tuid=p5.idpo 
where p5.empno='$empno' and p5.status_out='Y' and (begin_date between '$date01' and '$date02') and tout.dt='9')sum_amount 
from plan_out p0
inner join training_out tout on tout.tuid=p0.idpo 
where p0.empno='$empno' and p0.status_out='Y' and (p0.begin_date between '$date01' and '$date02') and tout.dt='9'");
        } else {
            $detial = mysql_query("SELECT p.*,t.in1,t.in2 from plan p
                        inner join trainingin t on p.pjid=t.idpi
                        where type_id='$empno' and p.bdate BETWEEN '$Y-10-01' and '$y-09-30' order by p.bdate desc");

            $detiatl = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME,
                t.stdate,t.etdate
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
        where p.empno='$empno' and p.status_out='Y' and t.dt!='9'  and p.begin_date BETWEEN '$Y-10-01' and '$y-09-30' order by t.memberbook desc");
            $detiatl2 = mysql_query("SELECT p.*,t.projectName,t.anProject,t.Beginedate,t.endDate,t.stantee,p2.PROVINCE_NAME 
    from plan_out p 
        inner join training_out t on t.tuid=p.idpo
        inner join province p2 on p2.PROVINCE_ID=t.provenID
        where p.empno='$empno' and p.status_out='Y' and t.dt='9'  and p.begin_date BETWEEN '$Y-10-01' and '$y-09-30' order by t.memberbook desc");
            

            $count_pj = mysql_query("select count(pjid) as pjid,
                                    (select sum(amount) from plan p where p.type_id='$empno' and (p.bdate BETWEEN '$Y-10-01' and '$y-09-30'))amount
                                      from plan 
                                        where type_id='$empno'  and (bdate BETWEEN '$Y-10-01' and '$y-09-30')");


            $sum_abode = mysql_query("select sum(p0.abode) as sum_abode,
(select sum(reg) from plan_out p1 
inner join training_out tout on tout.tuid=p1.idpo
where p1.empno='$empno' and p1.status_out='Y'  and p1.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt!='9')sum_reg,
(select sum(allow) from plan_out p2 
inner join training_out tout on tout.tuid=p2.idpo
where p2.empno='$empno' and p2.status_out='Y' and p2.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt!='9')sum_allow,
(select sum(travel) from plan_out p3 
inner join training_out tout on tout.tuid=p3.idpo
where p3.empno='$empno' and p3.status_out='Y' and p3.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt!='9')sum_travel,
(select sum(other) from plan_out p4 
inner join training_out tout on tout.tuid=p4.idpo
where p4.empno='$empno' and p4.status_out='Y' and p4.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt!='9')sum_other,
(select sum(p5.amount) from plan_out p5
inner join training_out tout on tout.tuid=p5.idpo 
where p5.empno='$empno' and p5.status_out='Y' and (p5.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt!='9')sum_amount 
from plan_out p0
inner join training_out tout on tout.tuid=p0.idpo
where p0.empno='$empno' and p0.status_out='Y' and p0.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt!='9'");
            $sum_abode2 = mysql_query("select sum(p0.abode) as sum_abode,
(select sum(reg) from plan_out p1 
inner join training_out tout on tout.tuid=p1.idpo
where p1.empno='$empno' and p1.status_out='Y'  and p1.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt='9')sum_reg,
(select sum(allow) from plan_out p2 
inner join training_out tout on tout.tuid=p2.idpo
where p2.empno='$empno' and p2.status_out='Y' and p2.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt='9')sum_allow,
(select sum(travel) from plan_out p3 
inner join training_out tout on tout.tuid=p3.idpo
where p3.empno='$empno' and p3.status_out='Y' and p3.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt='9')sum_travel,
(select sum(other) from plan_out p4 
inner join training_out tout on tout.tuid=p4.idpo
where p4.empno='$empno' and p4.status_out='Y' and p4.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt='9')sum_other,
(select sum(p5.amount) from plan_out p5
inner join training_out tout on tout.tuid=p5.idpo 
where p5.empno='$empno' and p5.status_out='Y' and (p5.begin_date BETWEEN '$Y-10-01' and '$y-09-30') and tout.dt='9')sum_amount 
from plan_out p0
inner join training_out tout on tout.tuid=p0.idpo
where p0.empno='$empno' and p0.status_out='Y' and p0.begin_date BETWEEN '$Y-10-01' and '$y-09-30' and tout.dt='9'");
            }
}
        $NameDetial = mysql_fetch_assoc($name_detial);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1><font color='blue'>  รายละเอียดการฝึกอบรมของบุคลากร </font></h1>
                <?php if ($_REQUEST[method] == 'no_show'){}else{?>
                <ol class="breadcrumb alert-success">
                    <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
                    <?php if($_SESSION[Status]!='USER' or $_SESSION[Status]!='SUSER'){?>
                    <?php if ($_REQUEST[method] == 'check') { ?>
                        <li class="active"><a href="statistics_trainout.php"><i class="fa fa-edit"></i> สถิติการฝึกอบรมภายนอก</a></li>
                    <?php } else { ?>
                        <li class="active"><a href="statistics_trainin.php"><i class="fa fa-edit"></i> สถิติการฝึกอบรมภายใน</a></li>
                    <?php }} ?>
                    <li class="active"><i class="fa fa-edit"></i> รายละเอียดการฝึกอบรมของบุคลากร</li>
                </ol><?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">ข้อมูลการฝึกอบรมบุคลากร</h3>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-info alert-dismissable">
                            <div class="form-group" align="right"> 
                                <form method="post" action="session.php" class="navbar-form navbar-right">
                                    <label> เลือกช่วงเวลา : </label>
                                    <div class="form-group">
                                        <input type="date"   name='check_date01' class="form-control" value='' > 
                                    </div>
                                    <div class="form-group">
                                        <input type="date"   name='check_date02' class="form-control" value='' >
                                    </div>
                                    <input type="hidden" name="method" value="check_statistics_trainout">
                                    <input type="hidden" name="empno" value="<?=$empno?>">
                                    <button type="submit" class="btn btn-success">ตกลง</button>
                                </form>
                            </div>
                            <br><br></div>
                        <div>
                        <a class="btn btn-success" download="report_training.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>

                        <table id="datatable" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                        ชื่อ นามสกุล : <?= $NameDetial[fullname]; ?><br>
                        ตำแหน่ง : <?= $NameDetial[posi]; ?><br>
                        ฝ่าย-งาน : <?= $NameDetial[dep]; ?><br><br>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลการฝึกอบรมภายใน</h3>
                            </div>
                            <div class="panel-body">
                                <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <?php if ($date01!='' and $date02!='') { ?>
                        <tr>
                            <td colspan="6" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
                            <?php } ?>
                                    <tr align="center" bgcolor="#898888">
                                        <td align="center" width="7%"><b>ลำดับ</b></td>
                                        <td align="center" width="10%"><b>เลขที่โครงการ</b></td>
                                        <td width="51%" align="center" bgcolor="#898888"><b>ชื่อโครงการ</b></td>
                                        <td align="center" width="10%"><b>ตั้งแต่</b></td>
                                        <td align="center" width="10%"><b>ถึง</b></td>
                                        <td align="center" width="6%"><b>จำนวนชั่วโมง</b></td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    while ($result = mysql_fetch_assoc($detial)) {
                                        ?>
                                        <tr>
                                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                            <td align="center"><a href="#" onclick="return popup('pre_project.php?id=<?= $result[pjid] ?>', popup, 700, 500);"><?= $result[in1]; ?></a></td>
                                            <td><a href="#" onclick="return popup('pre_project.php?id=<?= $result[pjid] ?>', popup, 700, 500);"><?= $result[in2]; ?></a></td>
                                            <td align="center"><?= DateThai1($result[bdate]); ?></td>
                                            <td align="center"><?= DateThai1($result[edate]); ?></td>
                                            <td align="center"><?= $result[amount]; ?></td>
                                        </tr>

    <?php $i++;
}
?>
                                    <tr>
                                        <td colspan="4" align="center" bgcolor="#898888"><b>รวม</b></td>
<?php
$Count_pj = mysql_fetch_assoc($count_pj);
?>
                                        <td align="center"><?= $Count_pj[pjid] ?> <b>ครั้ง</b></td>
                                        <td align="center"><?= $Count_pj[amount] ?> <b>ชม.</b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลการฝึกอบรมภายนอก</h3>
                            </div>
                            <div class="panel-body">
                                <form action="transfer_leave.php" method="post" name="form" enctype="multipart/form-data" id="form" >
                                    <h4 align='center'>ไปราชการ(ฝึกอบรม/ประชุม/สัมมนา)</h4>
                                     <table align="center" width="100%" border="1" cellspacing="0" cellpadding="0" class="" rules="" frame="">
                                        <tr align="center" bgcolor="#898888">
                                            <td width="4%" rowspan="2" align="center"><b>ลำดับ</b></td>
                                            <td width="25%" rowspan="2" align="center"><b>โครงการ</b></td>
                                            <td width="20%" rowspan="2" align="center" bgcolor="#898888"><b>หน่วยงานที่จัด/สถานที่</b></td>
                                            <td width="10%" rowspan="2" align="center"><b>ตั้งแต่</b></td>
                                            <td width="10%" rowspan="2" align="center"><b>วันเดินทาง</b></td>
                                            <td colspan="5" align="center"><b>ค่าใช้จ่าย</b><b></b></td>
                                            <td width="8%" rowspan="2" align="center"><b>รวมค่าใช้จ่าย<br>(บาท)</b></td>
                                            <td width="7%" rowspan="2" align="center"><b>ระยะเวลา<br>(ชม.)</b></td>
                                        </tr>
                                        <tr align="center" bgcolor="#898888">
                                            <td width="5%" align="center"><b>ที่พัก</b></td>
                                            <td width="6%" align="center"><b>ลงทะเบียน</b></td>
                                            <td width="5%" align="center"><b>เบี้ยเลี้ยง</b></td>
                                            <td width="5%" align="center"><b>เดินทาง</b></td>
                                            <td width="5%" align="center"><b>อื่นๆ</b></td>
                                        </tr>
<?php
$i = 1;
while ($result = mysql_fetch_assoc($detiatl)) {
    ?>
                                            <tr>
                                                <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                <td><a href="#" onclick="return popup('pre_project_out.php?id=<?= $result[idpo] ?>', popup, 700, 450);"><?= $result[projectName]; ?></a></td>
                                                <td align="center"><a href="#" onclick="return popup('pre_project_out.php?id=<?= $result[idpo] ?>', popup, 700, 450);"><?= $result[anProject]; ?> / <?= $result[stantee]; ?> จ. <?= $result[PROVINCE_NAME]; ?></a></td>
                                                <td align="center"><?= DateThai1($result[Beginedate]); ?><br> ถึง <br><?= DateThai1($result[endDate]); ?></td>
                                                <td align="center"><?= DateThai1($result[stdate]); ?><br> ถึง <br><?= DateThai1($result[etdate]); ?></td>
                                                <td align="center"><?= $result[abode]; ?></td>
                                                <td align="center"><?= $result[reg]; ?></td>
                                                <td align="center"><?= $result[allow]; ?></td>
                                                <td align="center"><?= $result[travel]; ?></td>
                                                <td align="center"><?= $result[other]; ?></td>
    <?php
    $total = $result[abode] + $result[reg] + $result[allow] + $result[travel] + $result[other];
    ?>
                                                <td align="center"><?= $total ?></td>
                                                <td align="center"><?= $result[amount] * 7; ?></td>
                                            </tr>
                                                <?php $i++;
                                            }
                                            ?>
                                        <tr>
                                            <td colspan="5" align="center" bgcolor="#898888"><b>รวม</b></td>
<?php
$Sum = mysql_fetch_assoc($sum_abode);
?>
                                            <td align="center"><?= $Sum[sum_abode] ?></td>
                                            <td align="center"><?= $Sum[sum_reg] ?></td>
                                            <td align="center"><?= $Sum[sum_allow] ?></td>
                                            <td align="center"><?= $Sum[sum_travel] ?></td>
                                            <td align="center"><?= $Sum[sum_other] ?></td>
<?php $Total = $Sum[sum_abode] + $Sum[sum_reg] + $Sum[sum_allow] + $Sum[sum_travel] + $Sum[sum_other]; ?>
                                            <td align="center"><?= $Total ?></td>
                                            <td align="center"><?= $Sum[sum_amount] * 7 ?></td>
                                        </tr>

                                     </table>
                                     <h4 align='center'>ไปราชการ(ออกหน่วย/ติดตามผู้ป่วย)</h4>
                                     <table align="center" width="100%" border="1" cellspacing="0" cellpadding="0" class="" rules="" frame="">
                                        <tr align="center" bgcolor="#898888">
                                            <td width="4%" rowspan="2" align="center"><b>ลำดับ</b></td>
                                            <td width="25%" rowspan="2" align="center"><b>โครงการ</b></td>
                                            <td width="20%" rowspan="2" align="center" bgcolor="#898888"><b>หน่วยงานที่จัด/สถานที่</b></td>
                                            <td width="10%" rowspan="2" align="center"><b>ตั้งแต่</b></td>
                                            <td colspan="5" align="center"><b>ค่าใช้จ่าย</b><b></b></td>
                                            <td width="8%" rowspan="2" align="center"><b>รวมค่าใช้จ่าย<br>(บาท)</b></td>
                                            <td width="7%" rowspan="2" align="center"><b>ระยะเวลา<br>(ชม.)</b></td>
                                        </tr>
                                        <tr align="center" bgcolor="#898888">
                                            <td width="5%" align="center"><b>ที่พัก</b></td>
                                            <td width="6%" align="center"><b>ลงทะเบียน</b></td>
                                            <td width="5%" align="center"><b>เบี้ยเลี้ยง</b></td>
                                            <td width="5%" align="center"><b>เดินทาง</b></td>
                                            <td width="5%" align="center"><b>อื่นๆ</b></td>
                                        </tr>
<?php
$i = 1;
while ($result2 = mysql_fetch_assoc($detiatl2)) {
    ?>
                                            <tr>
                                                <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                                <td><a href="#" onclick="return popup('pre_project_out.php?id=<?= $result2[idpo] ?>', popup, 700, 450);"><?= $result2[projectName]; ?></a></td>
                                                <td align="center"><a href="#" onclick="return popup('pre_project_out.php?id=<?= $result2[idpo] ?>', popup, 700, 450);"><?= $result2[anProject]; ?> / <?= $result2[stantee]; ?> จ. <?= $result[PROVINCE_NAME]; ?></a></td>
                                                <td align="center"><?= DateThai1($result2[Beginedate]); ?><br> ถึง <br><?= DateThai1($result2[endDate]); ?></td>
                                                <td align="center"><?= $result2[abode]; ?></td>
                                                <td align="center"><?= $result2[reg]; ?></td>
                                                <td align="center"><?= $result2[allow]; ?></td>
                                                <td align="center"><?= $result2[travel]; ?></td>
                                                <td align="center"><?= $result2[other]; ?></td>
    <?php
    $total2 = $result2[abode] + $result2[reg] + $result2[allow] + $result2[travel] + $result2[other];
    ?>
                                                <td align="center"><?= $total2 ?></td>
                                                <td align="center"><?= $result2[amount] * 7; ?></td>
                                            </tr>
                                                <?php $i++;
                                            }
                                            ?>
                                        <tr>
                                            <td colspan="4" align="center" bgcolor="#898888"><b>รวม</b></td>
<?php
$Sum2 = mysql_fetch_assoc($sum_abode2);
?>
                                            <td align="center"><?= $Sum2[sum_abode] ?></td>
                                            <td align="center"><?= $Sum2[sum_reg] ?></td>
                                            <td align="center"><?= $Sum2[sum_allow] ?></td>
                                            <td align="center"><?= $Sum2[sum_travel] ?></td>
                                            <td align="center"><?= $Sum2[sum_other] ?></td>
<?php $Total2 = $Sum2[sum_abode] + $Sum2[sum_reg] + $Sum2[sum_allow] + $Sum2[sum_travel] + $Sum2[sum_other]; ?>
                                            <td align="center"><?= $Total2 ?></td>
                                            <td align="center"><?= $Sum2[sum_amount] * 7 ?></td>
                                        </tr>

                                    </table>
                                </form>
                            </div>
                        </div>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include 'footer.php'; ?>