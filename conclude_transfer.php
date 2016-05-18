<?php include 'header.php'; ?>
<?php if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
<?php include 'option/function_date.php';
$Year=$_POST['year'];

if($date >= $bdate and $date <= $edate){
    $this_year=date("Y")+544;
    if(empty($Year)){
$detiatl = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno,t.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            inner join timela t on e1.empno=t.empno
                            where t.status='Y' and t.datela BETWEEN '$y-10-01' and '$Yy-09-30' order by fullname");

    }else{
       $year=$Year-543; 
       $Y=$year-1;
       $YY=$year;
$detiatl = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno,t.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            inner join timela t on e1.empno=t.empno
                            where t.status='Y' and t.datela BETWEEN '$Y-10-01' and '$YY-09-30' order by fullname");        
    }
    }else{
        $this_year=date("Y")+543;
if(empty($Year)){
$detiatl = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno,t.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            inner join timela t on e1.empno=t.empno
                            where t.status='Y' and t.datela BETWEEN '$Y-10-01' and '$y-09-30'  order by fullname");    
}else{
       $year=$Year-543; 
       $Y=$year-1;
       $YY=$year;
$detiatl = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno,t.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            inner join timela t on e1.empno=t.empno
                            where t.status='Y' and t.datela BETWEEN '$Y-10-01' and '$YY-09-30' order by fullname");        
    }}

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'><img src='images/Transfer.ico' width='75'>  รายละเอียดลาชั่วโมงที่ถูกโอนของบุคลากร </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดลาชั่วโมงที่ถูกโอน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><img src='images/folder_sent.ico' width='25'> ข้อมูลการโอนลาชั่วโมง</h3>
                    </div>
                                        <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                        <div class="form-group"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2557; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">ตกลง</button> 						
                    </form>

                    <?php 
                    $count_check=  mysql_query("select sum(total) as sum from timela where empno='$empno' and status='N' ");
                    $check_tl=  mysql_fetch_assoc($count_check);
                    ?>
                    <div class="panel-body">
                        <center>ปีงบประมาณ <?php if(empty($Year)){ echo $this_year;}else{ echo $Year;}?></center>
                        <form action="transfer_leave.php" method="post" name="form" enctype="multipart/form-data" id="form" >
                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <tr align="center" bgcolor="#898888">
                                <td align="center" width="7%"><b>ลำดับ</b></td>
                                <td align="center" width="12%"><b>เลขที่ใบลา</b></td>
                                <td align="center" width="24%"><b>ชื่อ-นามสกุล</b></td>
                                <td align="center" width="12%"><b>วันที่ลา</b></td>
                                <td align="center" width="12%"><b>ตั้งแต่</b></td>
                                <td align="center" width="12%"><b>ถึง</b></td>
                                <td align="center" width="12%"><b>จำนวนชั่วโมง</b></td>
                                <td width="9%" align="center"><b>ใบลา</b></td>
                            </tr>
<?php $i = 1;
while ($result = mysql_fetch_assoc($detiatl)) {
    ?>
                                <tr>
                                    <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                     <td align="center"><a href="#" onclick="return popup('Tleave_detail.php?id=<?= $result[empno]?>&&Lno=<?= $result[id]?>',popup,700,450);"><?= $result[idno]; ?></a></td>
                                     <td align="center"><a href="#" onclick="return popup('Tleave_detail.php?id=<?= $result[empno]?>&&Lno=<?= $result[id]?>',popup,700,450);"><?= $result[fullname]; ?></a></td>
                                    <td align="center"><a href="#" onclick="return popup('Tleave_detail.php?id=<?= $result[empno]?>&&Lno=<?= $result[id]?>',popup,700,450);"><?= $result[vstdate]; ?></a></td>
                                    <td align="center"><?= $result[starttime]; ?></td>
                                    <td align="center"><?= $result[endtime]; ?></td>
                                    <td align="center"><?= $result[total]; ?></td>
                                    <td align="center">
                                      <?php if ($result[pics_t] != '') {
        echo "<a href='time_l/$result[pics_t]' target='_blank'><span class='fa fa-download'></span> ใบลา" . "<br />";
    } ?>
                                    </td>
                                </tr>
    <?php $i++;
} ?>

                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php include 'footer.php'; ?>