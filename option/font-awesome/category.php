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

	require'connect.php';

 
	//ให้คืนค่าจังหวัดไว้เป็นอันดับแรก
	$sql = "SELECT * FROM category  order by category asc";
	$result = mysql_query( $sql );
	echo "[{\"category\":\"";
	echo "<label for='category'> หมวดความเสี่ยง&nbsp;&nbsp; </label><BR>";
	echo " <select name='category'  class='form-control' id='category' onchange='dochange(this)' size='9' multiple  required title='กรุณาเลือกหมวดความเสี่ยง'>";
	 echo "<option value='0'>-----------เลือกหมวดความเสี่ยง-----------</option>";
	while( $fetcharr = mysql_fetch_array( $result ) )
	{   
		$id = $fetcharr[category];
		$name = $fetcharr[name];
		echo "<option value='$id'";
		if ( $category == $id ) //
		{
			echo " selected='selected'";
		};
		echo ">$id - $name</option>";
	};

	echo "</select>\",\"subcategory\":\"";
	//	echo "<br>";

	echo "<label for='subcategory'>รายการความเสี่ยง :</label>";
	echo "<select name='subcategory'  class='form-control'  id='subcategory' onchange='dochange(this)'size='8'  required multiple  title='กรุณาเลือกรายการความเสี่ยง' >";

	//
	if ( $category != "0" && $category != "" )
	{
		echo " <option value='0'>-----------เลือกรายการความเสี่ยง-----------</option>";
		$sql = "SELECT subcategory, name FROM subcategory WHERE category='$category'";
		$result = mysql_query( $sql );
		while( $fetcharr = mysql_fetch_array( $result ) )
		{
			$id = $fetcharr[subcategory];
			$name = $fetcharr[name];
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