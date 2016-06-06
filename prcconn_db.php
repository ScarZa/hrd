<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
        <LINK REL="SHORTCUT ICON" HREF="images/logo.png">
        <!-- Bootstrap core CSS -->
        <link href="option/css/bootstrap.css" rel="stylesheet">
        <!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
        <!-- Add custom CSS here -->
        <link href="option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="option/css/stylelist.css">
        <script language="JavaScript" type="text/javascript">
            var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
            function KillMe()
            {
                setTimeout("self.close()", StayAlive * 1000);
            }
        </script>
    </head>
    <body onLoad="KillMe();
            self.focus();
            window.opener.location.reload();">
        <?php
        $strFileName = "conn_DB.txt";
        $objFopen = fopen($strFileName, 'w');
        $host_name=$_POST['host_name'];
        $strText1 = "$host_name\r\n";
        fwrite($objFopen, $strText1);
        $username=$_POST['username'];
        $strText2 = "$username\r\n";
        fwrite($objFopen, $strText2);
        $password=$_POST['password'];
        $strText3 = "$password\r\n";
        fwrite($objFopen, $strText3);
        $db_name=$_POST['db_name'];
        $strText4 = "$db_name\r\n";
        fwrite($objFopen, $strText4);
        $db_port=$_POST['port'];
        $strText5 = "$db_port\r\n";
        fwrite($objFopen, $strText5);
        if ($objFopen) {
            echo "บันทึกเรียบร้อย";
        } else {
            echo "ไม่สามารถบันทึกได้";
        }

        fclose($objFopen);
        ?>
    </body>
</html>

