<? require'connection/connect.php'; ?>
<? $result=$_GET[result];
$select_id=$_GET[select_id];
if ($result == 'amphur') { ?>
    
    <?
    $rstTemp = mysql_query("select * from amphur Where PROVINCE_ID ='" . $select_id . "' Order By AMPHUR_ID ASC");
    echo "<option value=''>---โปรดเลือกอำเภอ---</option>";
    while ($arr_2 = mysql_fetch_array($rstTemp)) {
if($arr_2[AMPHUR_ID]==$edit_person[empure]){$selected='selected';}else{$selected='';}
      echo "<option value='$arr_2[AMPHUR_ID]' $selected>$arr_2[AMPHUR_NAME]</option>";
}
} ?>

    <? if ($result == 'district') { ?>
    <select name='district' id='district'>
        <option value="">---โปรดเลือกตำบล---</option>
        <?
        $rstTemp = mysql_query("select * from district Where AMPHUR_ID ='" . $select_id . "'  Order By DISTRICT_ID ASC");
        while ($arr_2 = mysql_fetch_array($rstTemp)) {
            ?>

            <option value="<?= $arr_2['DISTRICT_ID'] ?>"><?= $arr_2['DISTRICT_NAME'] ?></option>
    <? } ?>
    </select>
<?
}?>