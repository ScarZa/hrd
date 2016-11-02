<?php include 'head.php'; 
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
if(isset($_GET['id'])){
$empno = $_GET['id'];
$name_detial = mysql_query("select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno, e2.TypeName as typename,e2.EmpType as emptype
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            inner join emptype e2 on e2.EmpType=e1.emptype
                            where e1.empno='$empno'");
$NameDetial = mysql_fetch_assoc($name_detial);
}
if(isset($_GET['method'])){
    $method=$_GET['method'];
} 
include_once ('option/funcDateThai.php');
include 'option/DatePicker/index.php';
?>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php if($method=='approve_sign'){echo 'อนุมัติการชี้แจง';}else{echo 'บันทึกการลงเวลา';}?></h3>
            </div>
            <div class="panel-body">

<font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial['fullname']?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial['posi']?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial['dep']?>
                            <br />
                            ประเภทพนักงาน :
<?= $NameDetial['typename']?>
                            <p />
                            <form class="navbar-form navbar-left" role="form" action='prcscan.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">                          

<?php if ($method=='approve_sign') {
    //mysql_query("update fingerprint set see='Y' where empno=$empno and finger_id=".$_GET['scan_id']."");
    $sql=mysql_query("select * from fingerprint where empno=$empno and finger_id=".$_GET['scan_id']."");
    $detial_scan=mysql_fetch_assoc($sql);?>
            ลืมลงเวลาวันที่ <?= DateThai1($detial_scan['forget_date'])?><p>
            โดยลืมลงเวลา <?php if(!empty($detial_scan['work_scan'])){echo 'มาทำงาน';} echo ' &nbsp;&nbsp;'; if(!empty($detial_scan['finish_work_scan'])){echo 'เลิกงาน';}?>
            <div class="form-group">
                <label>เหตุผล</label>
                <?php if(!empty($detial_scan['reason_forget'])){echo $detial_scan['reason_forget'];}?>
            </div>
                <div align="center" class="well well-sm">
                <b>ยืนยันการอนมัติใบชี้แจง</b>
                <div class="form-group">
                    <input type="radio" name="exp_status" id="exp_status" value="Y" required="">&nbsp;&nbsp; อนุมัติ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="exp_status" id="exp_status" value="N" required="">&nbsp;&nbsp; ไม่อนุมัติ
                </div>
                </div>

            <input type="hidden" name="method" id="method" value="approve_scan">
            <input type="hidden" name="empno" id="empno" value="<?=$empno?>">
            <input type="hidden" name="id" id="id" value="<?=$_GET['scan_id']?>">
<?php }elseif ($method=='approve_late') {
    //mysql_query("update late set see='Y' where empno=$empno and late_id=".$_GET['late_id']."");
    $sql=mysql_query("select * from late where empno=$empno and late_id=".$_GET['late_id']."");
    $detial_late=mysql_fetch_assoc($sql);?>
            ลงเวลาสายวันที่ <?= DateThai1($detial_late['late_date'])?>
            ลงเวลา <?=$detial_late['late_time']?> น.
            <div class="form-group">
                <label>เหตุผล</label>
                <?php if(!empty($detial_late['reason_late'])){echo $detial_late['reason_late'];}?>
            </div>
                <div align="center" class="well well-sm">
                <b>ยืนยันการอนมัติใบชี้แจง</b>
                <div class="form-group">
                    <input type="radio" name="exp_status" id="exp_status" value="Y" required="">&nbsp;&nbsp; อนุมัติ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="exp_status" id="exp_status" value="N" required="">&nbsp;&nbsp; ไม่อนุมัติ
                </div>
                </div>
            <input type="hidden" name="method" id="method" value="approve_late">
            <input type="hidden" name="empno" id="empno" value="<?=$empno?>">
            <input type="hidden" name="id" id="id" value="<?=$_GET['late_id']?>">
<?php }?>
                             <div align="center"><input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก"></div>
                             </form>                            
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>