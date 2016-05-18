<?
	header( "Expires: Sat, 1 Jan 2005 00:00:00 GMT" );
	header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
	header( "Cache-Control: no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
	header( "content-type: application/x-javascript; charset=UTF-8" );
	//$geo_id = $_POST[geo_id];
	$category = $_POST[category];
	$subcategory = $_POST[subcategory];
	$tumbon = $_POST[tumbon];

	require'connection/connect.php';

 
	//ให้คืนค่าจังหวัดไว้เป็นอันดับแรก
	$sql = "SELECT * FROM department_group  order by main_dep asc";
	$result = mysql_query( $sql );
	echo "[{\"category\":\"";
	echo "<label for='category'> ฝ่ายงาน&nbsp;&nbsp; </label><BR>";
	echo " <select name='category'  class='form-control' id='category' onchange='dochange(this)' required title='กรุณาเลือกหมวดความเสี่ยง'>";
	 echo "<option value='0'>---เลือกฝ่ายงาน---</option>";
	while( $fetcharr = mysql_fetch_array( $result ) )
	{   
		$id = $fetcharr[main_dep];
		$name = $fetcharr[dep_name];
		echo "<option value='$id'";
		if ( $category == $id ) //
		{
			echo " selected='selected'";
		};
		echo ">$id - $name</option>";
	};

	echo "</select>\",\"subcategory\":\"";
	//	echo "<br>";

	echo "<label for='subcategory'>หน่วยงาน :</label>";
	echo "<select name='subcategory'  class='form-control'  id='subcategory' onchange='dochange(this)' required  title='กรุณาเลือกรายการความเสี่ยง' >";

	//
	if ( $category != "0" && $category != "" )
	{
		echo " <option value='0'>---เลือกหน่วยงาน---</option>";
		$sql = "SELECT depId, depName FROM department WHERE main_dep='$category'";
		$result = mysql_query( $sql );
		while( $fetcharr = mysql_fetch_array( $result ) )
		{
			$id = $fetcharr[depId];
			$name = $fetcharr[depName];
			echo "<option value='$id'";
			if ( $subcategory == $id ) //เลือกอำเภอที่เลือกไว้
			{
				echo " selected='selected'";
			};
		echo ">$name</option>";
		};
	}
	else
	{
		echo "<option value=''>--------------</option>";
	};

	echo "</select>\",\"tumbon\":\"";

	//echo "<label for='tumbon'> </label>";
	echo "<select name='tumbon' id='tumbon'>";

	//

	if ( $amphur != "0" && $amphur != "" )
	{
		echo "<option value='0'>--กรุณาเลือกตำบล--</option>";
		$sql = "SELECT district_id, district_name FROM district WHERE amphur_id=$amphur and province_id=$province";
		$result = mysql_query( $sql );
		while( $fetcharr = mysql_fetch_array( $result ) )
		{
			$id = $fetcharr[district_id];
			$name = $fetcharr[district_name];
			echo "<option value='$id'";
			if ( $tumbon == $id ) //เลือกตำบลที่เลือกไว้
			{
				echo " selected='selected'";
			};
		echo ">$id - $name</option>";
		};
	}
	else
	{
		echo "<option value=''>--------------</option>";
	};
	echo "</select>\"}]";

	mysql_close();
?>