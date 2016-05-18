 <SCRIPT language=JavaScript>
var OldColor;
function popNewWin (strDest,strWidth,strHeight) {
newWin = window.open(strDest,"popup","toolbar=no,scrollbars=yes,resizable=yes,width=" + strWidth + ",height=" + strHeight);
}
function mOvr(src,clrOver) {
if (!src.contains(event.fromElement)) {
src.style.cursor = 'hand';
OldColor = src.bgColor;
src.bgColor = clrOver;
}
}
function mOut(src) {
if (!src.contains(event.toElement)) {
src.style.cursor = 'default';
src.bgColor = OldColor;
}
}
function mClk(src) {
if(event.srcElement.tagName=='TD') {
src.children.tags('A')[0].click();
}
}
 </SCRIPT>

<?php

//include'../connect.php';
$sql=mysql_query("select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 where  m1.mng_status='Y'   and t1.move_status='N' group by d1.dep_id order by number_risk DESC");	
															
				
?>
<H3>จำนวนการรายงานความเสี่ยงของหน่วยงาน</H3>

<TABLE>
<TR class="ui-widget-header">
	<TD width=100><CENTER><p>ลำดับ</p></CENTER></TD>
	<TD width=255>รายชื่อหน่วยงาน</TD>
	<TD width=100><p align="right">เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></TD>
</TR>
<?php 
$i=1;
while($result=mysql_fetch_assoc($sql)){
	if($bg == "#F4F4F4") { //ส่วนของการ สลับสี 
		$bg = "#FFFFFF";
		}else{
		$bg = "#F4F4F4";
		}
	
	?>	

<tr bgcolor=<?=$bg?> onmouseover="mOvr(this,'#DEF8F0');" onclick=mClk(this); onmouseout=mOut(this); >
	<TD><CENTER><?php echo $i; ?></CENTER></TD>
	<TD><?php echo $result[dep_name];?></TD>
	<TD><p align="right"><?php echo $result[number_risk];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></TD>
</TR>

<?php 
$i++;
}?>
</TABLE>