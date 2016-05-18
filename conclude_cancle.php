<?php include 'header.php'; ?>
<?php if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
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
include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><img src='images/Cfolder.ico' width='75'><font color='blue'>  รายละเอียดยกเลิกการลาของบุคลากร </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดยกเลิกการลา</li>
        </ol>
    </div>
</div>
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
                            <input type="hidden" name="method" value="check_date_cancle">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                    </div>
                    <br><br></div>
<div class="row">
    <div class="col-lg-12">

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><img src='images/Cfolder.ico' width='25'> ข้อมูลยกเลิกการลา</h3>
                    </div>
                    <div class="panel-body">
                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <?php include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
                            if($_SESSION[check_cancle]==''){
$detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno,w.*,c.*,t1.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join work w on e1.empno=w.enpid
                            inner join cancle c on w.workid=c.workid
                            inner join typevacation t1 on w.typela=t1.idla
                            where statusla='N' and begindate BETWEEN '$y-10-01' and '$Yy-09-30' order by fullname");
}else{
    $dates=$_SESSION[cancle_date1];
    $datee=$_SESSION[cancle_date2];
   $detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno,w.*,c.*,t1.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join work w on e1.empno=w.enpid
                            inner join cancle c on w.workid=c.workid
                            inner join typevacation t1 on w.typela=t1.idla
                            where statusla='N' and cancledate between '$dates' and '$datee' order by fullname"); 
}}  else {
                            if($_SESSION[check_cancle]==''){
$detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno,w.*,c.*,t1.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join work w on e1.empno=w.enpid
                            inner join cancle c on w.workid=c.workid
                            inner join typevacation t1 on w.typela=t1.idla
                            where statusla='N'and begindate BETWEEN '$Y-10-01' and '$y-09-30' order by fullname");
}else{
    $dates=$_SESSION[cancle_date1];
    $datee=$_SESSION[cancle_date2];
   $detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno,w.*,c.*,t1.*
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join work w on e1.empno=w.enpid
                            inner join cancle c on w.workid=c.workid
                            inner join typevacation t1 on w.typela=t1.idla
                            where statusla='N' and cancledate between '$dates' and '$datee' order by fullname"); 
}}
                            if($_SESSION[check_cancle]!=''){?>
                            <tr>
                                <td colspan="9" align="center"><b>ตั้งแต่วันที่ <?=DateThai1($dates)?> ถึง <?=DateThai1($dates)?> </b></td>
                            </tr>
                            <?php }?>
                            <tr align="center" bgcolor="#898888">
                                <td align="center" width="6%"><b>ลำดับ</b></td>
                                <td align="center" width="10%"><b>เลขที่ใบลา</b></td>
                                <td align="center" width="24%"><b>ชื่อ-นามสกุล</b></td>
                                <td align="center" width="15%"><b>ประเภทการลา</b></td>
                                <td align="center" width="10%"><b>ตั้งแต่</b></td>
                                <td align="center" width="10%"><b>ถึง</b></td>
                                <td align="center" width="7%"><b>จำนวนวัน</b></td>
                                <td width="10%" align="center"><b>ผู้ยกเลิก</b></td>
                                <td width="8%" align="center"><b>ใบยกเลิก</b></td>
                            </tr>
<?php 
$i = 1;
if(!empty($detial)){
while ($result = mysql_fetch_assoc($detial)) {
    ?>
                                <tr>
                                    <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                                    <td align="center"><a href="#" onclick="return popup('cancle_detail.php?id=<?=$result[enpid]?>&&Lno=<?=$result[workid]?>',popup,700,530);"><?= $result[leave_no]; ?></a></td>
                                    <td align="center"><a href="#" onclick="return popup('cancle_detail.php?id=<?=$result[enpid]?>&&Lno=<?=$result[workid]?>',popup,700,530);"><?= $result[fullname]; ?></a></td>
                                    <td align="center"><a href="#" onclick="return popup('cancle_detail.php?id=<?=$result[enpid]?>&&Lno=<?=$result[workid]?>',popup,700,530);"><?= $result[nameLa]; ?></a></td>
                                    <td align="center"><?= $result[begindate]; ?></td>
                                    <td align="center"><?= $result[enddate]; ?></td>
                                    <td align="center"><?= $result[amount]; ?></td>
                                    <?php
                                        $namE=  mysql_query("select e.firstname as name from emppersonal e 
                                                                inner join cancle c on e.empno=c.admin_cancle
                                                                where c.workid='$result[workid]'");
                                        $NamE=  mysql_fetch_assoc($namE);
                                    ?>
                                    <td align="center"><?= $NamE[name]; ?></td>
                                    <td align="center">
                                        <?php if ($result[pics_cancle] != '') {
        echo "<a href='cancle/$result[pics_cancle]' target='_blank'><span class='fa fa-download'></span> ใบลา" . "<br />";
    } ?>
                                    </td>
                                </tr>
    <?php $i++;
}} ?>

                        </table>
                    </div>
                </div>
                
            </div>
        </div>
<?php include 'footer.php'; ?>