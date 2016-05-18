<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>
<body>
 
  
<?    
include'connection/connect.php';

	//ค่าที่ได้รับมาจากการ Submit
	$category = $_POST[category];
	$subcategory = $_POST[subcategory];
 	$tumbon = $_POST[tumbon];
	
	if ( !empty( $subcategory ) )
	{
		echo "<br /><br /><br /<br /หมวดที่เลือก : $category<br อหมวดย่อยที่เลือก : $subcategory <br /><br /><br />\n";
	};
    
	//echo "<form action=\"process_locate.php\" method=\"post\">\n";
	echo '<span id="provinceDiv">';
	
 

	 echo "<label for=\"category\">หมวดความเสี่ยง :</label><input type='radio' name='category' id='category' onchange='dochange(this)'>\n";
	 //echo "<option value=\"$category\">--------------</option> \n" ;
	echo "</select></span>\n";
 //   echo "<br />";
	echo '<span id="amphurDiv">';
	echo "<label for=\"subcategory\">รายการ :</label><select name=\"subcategory\" id=\"subcategory\"\">\n";
	echo "<option value=\"$subcategory\">--------------</option> \n" ;
	echo "</select></span>\n";
 //   echo "<br />";
	//echo '<span id="tumbonDiv">';
	echo "<label for=\"tumbon\"></label><input type='hidden' name=\"tumbon\" id=\"tumbon\">\n"; //รายการสุดท้ายไม่ต้องมี event แล้ว
	//echo "<option value=\"$tumbon\">--------------</option> \n" ;
	echo "</select></span>\n";
  
//	echo " <input type=\"submit\" value=\"    OK    \" name=\"submit\" />\n";
//	echo "</form>\n";
?>
<script type="text/javascript">
//AJAX
function Inint_AJAX()
{
	try
	{
		return new ActiveXObject( "Msxml2.XMLHTTP" );
	}
	catch ( e )
	{
	};

	try
	{
		return new ActiveXObject( "Microsoft.XMLHTTP" );
	}
	catch ( e )
	{
	};

	try
	{
		return new XMLHttpRequest();
	}
	catch ( e )
	{
	};

	alert( "XMLHttpRequest not supported" );
	return null;
};

function dochange( obj )
{
	var req = Inint_AJAX();
	var category = document.getElementById( 'category' ).value;
	var tumbon = document.getElementById( 'tumbon' ).value;
	if ( obj && obj.name == 'category' ) //เมื่อทำการเลือที่จังหวัดมา ให้เคลียร์ค่าอำเภอ
	{
		var subcategory = "";
	}
	else //เลือกรายการอื่น
	{
		var subcategory = document.getElementById( 'subcategory' ).value;
	};
	var data = "category=" + category + "&subcategory=" + subcategory + "&tumbon=" + tumbon;
	req.onreadystatechange = function()
	{
		if ( req.readyState == 4 )
		{
			if ( req.status == 200 )
			{
				var datas = eval( '(' + req.responseText + ')' ); // JSON
				document.getElementById( 'provinceDiv' ).innerHTML = datas[0].category;
				document.getElementById( 'amphurDiv' ).innerHTML = datas[0].subcategory;
				document.getElementById( 'tumbonDiv' ).innerHTML = datas[0].tumbon;
			};
		};
	};
	req.open( "post" , "dep.php" , true ); //สร้าง connection
	req.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ); // set Header
	req.send( data ); //ส่งค่า
};

//โหลดครั้งแรก
window.onload = function()
{
	dochange( '' );
};
</script>
</body>
</html>