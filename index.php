<?php
include 'header.php';
if(isset($_GET['unset'])){
    unset_session();
}
?>
<?php
if (!$db or ! $con) {
    $check = md5(trim(check));
    ?>
    <center>
        <h3>ยังไม่ได้ตั้งค่า Config <br>กรุณาตั้งค่า Config เพื่อเชื่อมต่อฐานข้อมูล</h3>
        <a href="#" class="btn btn-danger" onClick="return popup('set_conn_db.php?method=<?= $check ?>', popup, 400, 515);" title="Config Database">Config Database</a>

    </center>
<?php
} else {
    $sql = mysql_query("select * from  hospital");
    $resultHos = mysql_fetch_assoc($sql);


    if ($resultHos[logo] != '') {
        $pic = $resultHos[logo];
        $fol = "logo/";
    } else {
        $pic = 'agency.ico';
        $fol = "images/";
    }
    ?><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info">
                <div class="col-lg-1 col-md-2 col-xs-3" align="center"><img src='<?= $fol . $pic; ?>' width="80"></div>
                <div class="col-lg-11 col-md-10 col-xs-9" valign="top">
                    <h2><b>ระบบข้อมูลบุคลากร </b><small><br><b><font color="green">
    <?php echo $resultHos[name]; ?></font></b></small></h2>
                    ยินดีต้อนรับสู่ <a class="alert-link" href="http://startbootstrap.com" target="_blank"> ระบบข้อมูลบุคลากร</a>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>
    <ol class="breadcrumb alert-success">
        <li class="active"><i class="fa fa-home"></i> หน้าหลัก</li>
    </ol>
    <?php if ($_SESSION[user] != '') { ?>
<div class="col-lg-2 col-xs-6 row">
    <?php ?>
                <a href="<?= $resultHos['url'] ?>service&support/process/from_hrd.php?fullname=<?=$_SESSION[fname].' '.$_SESSION[lname]?>
                   &id=<?= $_SESSION[user]?>&dep=<?= $_SESSION[dep]?>" class="btn btn-warning" target="_blank">โปรมแกรมสนับสนุน</a>       
            </div>
        <div align="right">
            <a href="#" class="btn btn-success" onClick="return popup('total_regularity.php', popup, 650, 600);" title="ดูระเบียบ/ข้อบังคับ">ระเบียบ</a>
            <a href="mainpost_page.php" class="btn btn-info" title="ประกาศข่าว/ประชาสัมพันธ์">ประชาสัมพันธ์</a>
            <a href="#" class="btn btn-primary" onClick="return popup('fullcalendar/fullcalendar3.php', popup, 820, 650);" title="ดูวันลาไปราชการ">ปฏิทินไปราชการ</a>
            <a href="#" class="btn btn-info" onClick="return popup('fullcalendar/fullcalendar5.php', popup, 820, 650);" title="ดูวันลาไปราชการ">ปฏิทินอบรมภายใน</a>
            <a href="#" class="btn btn-warning" onClick="return popup('fullcalendar/fullcalendar2.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">ปฏิทินการลา</a>
        <?php if ($_SESSION[Status] == 'ADMIN') { ?>
                <a href="#" class="btn btn-danger" onClick="return popup('fullcalendar/fullcalendar1.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">ปฏิทินการลา</a><?php } ?>
        </div><br>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Leave Statistics:                 
                            <?php
                            include_once ('option/funcDateThai.php');
                            include 'option/function_date.php';
                            $d_start = 01;
                            $m_start = 01;
                            $d = date("d");
                            if ($_POST[year] == '') {

                                if ($date >= $bdate and $date <= $edate) {
                                    $y = $Yy;
                                    $Y = date("Y");
                                } else {
                                    $y = date("Y");
                                    $Y = date("Y") - 1;
                                }
                            } else {
                                $y = $_POST[year] - 543;
                                $Y = $y - 1;
                            }
                            $date_start = "$Y-10-01";
                            $date_end = "$y-09-30";
                            echo $date_start = DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                            echo " ถึง ";
                            echo $date_end = DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
                            ?>	</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                            <div class="form-group col-lg-9 col-md-9 col-xs-8"> 
                                <select name='year'  class="form-control">
                                    <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                    <?php
                                    for ($i = 2558; $i <= 2565; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-xs-4"><button type="submit" class="btn btn-success">ตกลง</button></div> 						
                        </form>
                        <?php
                        if ($_POST[year] == '') {

                            if ($date >= $bdate and $date <= $edate) {
                                $year = $Yy;
                                $years = $year + 543;
                            } else {
                                $year = date('Y');
                                $years = $year + 543;
                            }
                        } else {
                            $year = $_POST[year] - 543;
                            $years = $year + 543;
                        }

                        echo "<center>";



                        echo "รายงานการลา : ทั้งหมด";
                        echo "&nbsp;&nbsp;";
                        echo "ปีงบประมาณ : $years";
                        echo "</center>";

                        $month_start = "$Y-10-01";
                        ;
                        $month_end = "$y-09-30";
                        $I = 10;
                        for ($i = -2; $i <= 9; $i++) {

                            $sqlMonth = mysql_query("select * from month where m_id='$i'");
                            $month = mysql_fetch_assoc($sqlMonth);

                            if ($i <= 0) {
                                $month_start = "$Y-$I-01";
                                $month_end = "$Y-$I-31";
                                /* if(date("Y-m-d")=="$y-$I-$d"){
                                  $month_start = "$y-$I-01";
                                  $month_end = "$y-$I-31";
                                  } */
                            } elseif ($i >= 1 and $i <= 9) {
                                $month_start = "$year-0$i-01";
                                $month_end = "$year-0$i-31";
                            } else {
                                $month_start = "$year-$i-01";
                                $month_end = "$year-$i-31";
                            }

                            $month_start;
                            echo "&nbsp;&nbsp;";
                            $month_end;

                            for ($c = 1; $c <= 7; $c++) {
                                $sql = mysql_query("select count(w.workid) as count from work w   
						 where  w.typela='$c' and    w.begindate between '$month_start' and '$month_end' and statusla='Y' order by count DESC");

                                $rs = mysql_fetch_assoc($sql);

                                $countnum[$c].= $rs[count] . ',';
                            }
                            $name.="'$month[month_short]'" . ',';
                            $I++;
                        }
                        echo mysql_error();
                        /* echo $rs1[count];
                          echo $countnum[1];
                          echo '55555'; */
                        ?>
                        <script type="text/javascript" src="option/js/jquery.min.js"></script>
                        <script src="report_rm/highcharts.js"></script>
                        <script src="report_rm/exporting.js"></script>
                        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function () {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container',
                            type: 'line'
                        },
                        title: {
                            text: 'จำนวนการลาในแต่ละประเภทแยกรายเดือน'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            categories: [<?= $name; ?>
                            ]
                        },
                        yAxis: {
                            title: {
                                text: 'จำนวนครั้ง'
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                        this.x + ': ' + this.y + '';
                            }
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            }
                        },
                        series: [{
                                name: 'ลาป่วย',
                                data: [<?= $countnum[1] ?>]
                            }, {
                                name: 'ลากิจ',
                                data: [<?= $countnum[2] ?>]
                            }, {
                                name: 'ลาพักผ่อน',
                                data: [<?= $countnum[3] ?>]
                            }, {
                                name: 'ลาคลอด',
                                data: [<?= $countnum[4] ?>]
                            }, {
                                name: 'ลาบวช',
                                data: [<?= $countnum[5] ?>]
                            }, {
                                name: 'ลาศึกษาต่อ',
                                data: [<?= $countnum[6] ?>]
                            }, {
                                name: 'ลาเลี้ยงดูบุตร',
                                data: [<?= $countnum[7] ?>]
                            }
                        ]
                    });
                });

            });


                        </script>

                        <div class="col-lg-12" id="container" style="margin: 0 auto"></div>
                        <br>
                        <?php
                        $m_start = "$Y-10-01";
                        $m_end = "$y-09-30";
                        for ($c = 1; $c <= 7; $c++) {
                            $sql = mysql_query("select count(w.workid) as count from work w   
						 where  w.typela='$c' and    w.begindate between '$m_start' and '$m_end' and statusla='Y' order by count DESC");

                            $rs = mysql_fetch_assoc($sql);

                            $count[$c] = $rs[count];
                        }
                        ?>
                        <script type="text/javascript" src="report_rm/jquery.js"></script>
                        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function () {

                    // Radialize the colors
                    Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function (color) {
                        return {
                            radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                            stops: [
                                [0, color],
                                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                            ]
                        };
                    });

                    // Build the chart
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'tainer',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'จำนวนการลาในแต่ละประเภทในปีงบประมาณ <?= $years ?>'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                            percentageDecimals: 1
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    formatter: function () {
                                        return '<b>' + this.point.name + '</b>: ' + this.y + ' ครั้ง';
                                    }
                                }
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'ลาไป',
                                data: [
                                    ['ลาป่วย', <?= $count[1] ?>],
                                    ['ลากิจ', <?= $count[2] ?>],
                                    {
                                        name: 'ลาพักผ่อน',
                                        y: <?= $count[3] ?>,
                                        sliced: true,
                                        selected: true
                                    },
                                    ['ลาคลอด', <?= $count[4] ?>],
                                    ['ลาบวช', <?= $count[5] ?>],
                                    ['ลาศึกษาต่อ', <?= $count[6] ?>],
                                    ['ลาเลี้ยงดูบุตร', <?= $count[7] ?>]
                                ]
                            }]
                    });
                });

            });
                        </script>

                        <div class="col-lg-6" id="tainer" style="margin: 0 auto"></div>

                        <?php
                        $sql = mysql_query("SELECT d.depName as dep_name,
(SELECT round(sum(w.amount)/COUNT(e.empno),2) 
from emppersonal e  
where d.depId=e.depId and w.statusla='Y')count_leave
FROM department d
LEFT OUTER JOIN emppersonal e on e.depid=d.depId
LEFT OUTER JOIN `work` w on e.empno=w.enpid
                                        WHERE w.statusla='Y' and w.begindate between '$m_start' and '$m_end'
                                        GROUP BY d.depId  
order by count_leave DESC limit 10 ");
                        ?>
                        <script type="text/javascript" src="report_rm/jquery.js"></script>
                        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function () {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'contain',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                        },
                        title: {
                            text: '10 อันดับการลาแต่ละหน่วยงานในปีงบประมาณ <br>(ค่าเฉลี่ยวันลาต่อคนในหน่วยงาน) <?= $years ?>'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                            percentageDecimals: 1
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    formatter: function () {
                                        return '<b>' + this.point.name + '</b>: ' + this.y + ' วัน';
                                    }
                                }
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'ลาไป',
                                data: [<?php
                while ($row = mysql_fetch_array($sql)) {
                    $depnamex = $row[dep_name];
                    $countx = $row[count_leave];
                    $sss = "['" . $depnamex . "'," . $countx . "],";
                    echo $sss;
                }
                ?>
                                ]
                            }]
                    });
                });

            });
                        </script>


                        <div class="col-lg-6" id="contain" style="margin: 0 auto"></div>


                        <SCRIPT language=JavaScript>
                            var OldColor;
                            function popNewWin(strDest, strWidth, strHeight) {
                                newWin = window.open(strDest, "popup", "toolbar=no,scrollbars=yes,resizable=yes,width=" + strWidth + ",height=" + strHeight);
                            }
                            function mOvr(src, clrOver) {
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
                                if (event.srcElement.tagName == 'TD') {
                                    src.children.tags('A')[0].click();
                                }
                            }
                        </SCRIPT>


                    </div>
                </div>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Personal </h3> 
                    </div>
                    <div class="panel-body">
                        <?php
                        $sql_nameperson = mysql_query("SELECT dg.dep_name as dep_name
FROM  department_group dg 
inner join department d on dg.main_dep = d.main_dep 
inner join emppersonal em on d.depId = em.depid
GROUP BY dg.main_dep
order by dg.main_dep");
                        $sql_person = mysql_query("SELECT d.main_dep,dg.dep_name as dep_name,COUNT(d.depId) as sum,
COUNT(d1.depId) as d1,
COUNT(d2.depId) as d2,
COUNT(d3.depId) as d3,
COUNT(d4.depId) as d4,
COUNT(d5.depId) as d5,
COUNT(d6.depId) as d6,
COUNT(d7.depId) as d7
FROM emppersonal em
left outer join department d on d.depId = em.depid
left outer join department_group dg on dg.main_dep = d.main_dep
LEFT OUTER JOIN department d1 on d1.depid = em.depid and em.emptype='1'
LEFT OUTER JOIN department d2 on d2.depid = em.depid and em.emptype='2'
LEFT OUTER JOIN department d3 on d3.depid = em.depid and em.emptype='3'
LEFT OUTER JOIN department d4 on d4.depid = em.depid and em.emptype='4'
LEFT OUTER JOIN department d5 on d5.depid = em.depid and em.emptype='5'
LEFT OUTER JOIN department d6 on d6.depid = em.depid and em.emptype='6'
LEFT OUTER JOIN department d7 on d7.depid = em.depid and em.emptype='7'
where em.status='1'
GROUP BY d.main_dep order by dg.main_dep");
                        ?>
                        <script type="text/javascript">
                            $(function () {
                                var chart;
                                $(document).ready(function () {

                                    var colors = Highcharts.getOptions().colors,
                                            categories = [
        <?php
        while ($row1 = mysql_fetch_array($sql_nameperson)) {
            $dep_name = $row1[dep_name];
            $show1 = "'" . $dep_name . "',";
            echo $show1;
        }
        ?>],
                                            name = 'Browser brands',
                                            data = [
        <?php
        $i = 0;

        while ($row2 = mysql_fetch_array($sql_person)) {
            if ($i >= 9) {
                $i = 0;
            }
            $sum = $row2[sum];
            $d1 = $row2[d1];
            $d2 = $row2[d2];
            $d3 = $row2[d3];
            $d4 = $row2[d4];
            $d5 = $row2[d5];
            $d6 = $row2[d6];
            $d7 = $row2[d7];
            $show = "{
         y:" . $sum . ",
         color: colors[" . $i . "],
         drilldown: {
         name: '" . $sum . "',
         categories: ['ข้าราชการ', 'ลูกจ้างประจำ', 'พนักงานราชการ', 'พกส.','ลูกจ้างชั่วคราวรายเดือน','ลูกจ้างชั่วคราวรายวัน','นักศึกษาฝึกงาน'],
         data: [" . $d1 . "," . $d2 . "," . $d3 . "," . $d4 . "," . $d5 . "," . $d6 . "," . $d7 . "],
         color: colors[" . $i . "]}},";
            echo $show;
            $i++;
        }
        ?>

                                            ];


                                    // Build the data arrays
                                    var browserData = [];
                                    var versionsData = [];
                                    for (var i = 0; i < data.length; i++) {

                                        // add browser data
                                        browserData.push({
                                            name: categories[i],
                                            y: data[i].y,
                                            color: data[i].color
                                        });

                                        // add version data
                                        for (var j = 0; j < data[i].drilldown.data.length; j++) {
                                            var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5;
                                            versionsData.push({
                                                name: data[i].drilldown.categories[j],
                                                y: data[i].drilldown.data[j],
                                                color: Highcharts.Color(data[i].color).brighten(brightness).get()
                                            });
                                        }
                                    }

                                    // Create the chart
                                    chart = new Highcharts.Chart({
                                        chart: {
                                            renderTo: 'donut',
                                            type: 'pie'
                                        },
                                        title: {
                                            text: 'บุคลากรในโรงพยาบาลจิตเวชเลยราชนครินทร์'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'บุคลากรในโรงพยาบาลจิตเวชเลยราชนครินทร์'
                                            }
                                        },
                                        plotOptions: {
                                            pie: {
                                                shadow: true
                                            }
                                        },
                                        tooltip: {
                                            valueSuffix: 'คน'
                                        },
                                        series: [{
                                                name: 'จำนวน',
                                                data: browserData,
                                                size: '60%',
                                                dataLabels: {
                                                    formatter: function () {
                                                        return this.y > 5 ? this.point.name : null;
                                                    },
                                                    color: 'white',
                                                    distance: -30
                                                }
                                            }, {
                                                name: 'จำนวน',
                                                data: versionsData,
                                                innerSize: '60%',
                                                dataLabels: {
                                                    formatter: function () {
                                                        // display only if larger than 1
                                                        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y + 'คน' : null;
                                                    }
                                                }
                                            }]
                                    });
                                });

                            });
                        </script>
                        <div class="col-lg-12" id="donut" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
                    </div></div></div></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Training :
                            <?php
                            $date_start = "$Y-10-01";
                            $date_end = "$y-09-30";
                            echo DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                            echo " ถึง ";
                            echo DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
                            ?>
                        </h3> 
                    </div>
                    <div class="panel-body">
                        <center>อบรมภายนอก/ไปราชการในปีงบประมาณ <?= $years ?></center><br>
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive tablesorter divider" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" rules="rows" frame="below">
                                <thead>
                                    <tr align="center" bgcolor="#898888">
                                        <TH><CENTER>เดือน</CENTER> </TH>
                                <TH><CENTER>จำนวนโครงการ</CENTER></TH> 
                                <TH><CENTER>จำนวนคน</CENTER></TH>
                                <TH><CENTER>จำนวนวัน</CENTER></TH>
                                <TH><CENTER>ค่าที่พัก</CENTER></TH>
                                <TH><CENTER>ค่าลงทะเบียน</CENTER></TH>
                                <TH><CENTER>ค่าเบี่ยเลี้ยง</CENTER></TH>
                                <TH><CENTER>ค่าพาหนะเดินทาง</CENTER></TH>
                                <TH><CENTER>ค่าใช้จ่ายอื่นๆ</CENTER></TH>
                                <TH><CENTER>รวมค่าใช้จ่าย</CENTER></TH>
                                </tr>
                                </thead>
        <?php
        $c = 1;
        $I = 10;
        for ($i = -2; $i <= 9; $i++) {

            $sqlMonth = mysql_query("select * from month where m_id='$i' order by m_id desc");
            $month = mysql_fetch_assoc($sqlMonth);

            if ($i <= 0) {
                $month_start = "$Y-$I-01";
                $month_end = "$Y-$I-31";
                /* if(date("Y-m-d")=="$y-$I-$d"){
                  $month_start = "$y-$I-01";
                  $month_end = "$y-$I-31";
                  } */
            } elseif ($i >= 1 and $i <= 9) {
                $month_start = "$year-0$i-01";
                $month_end = "$year-0$i-31";
            } else {
                $month_start = "$year-$i-01";
                $month_end = "$year-$i-31";
            }
            $sql_train = mysql_query("SELECT COUNT(p.empno) as a2,SUM(p.abode) as a4,
SUM(reg) as a5,SUM(allow) as a6,SUM(p.travel) as a7,SUM(p.other) as a8,
(SELECT COUNT(t.tuid) FROM training_out t WHERE t.Beginedate BETWEEN '$month_start' and '$month_end') a1,
(SELECT SUM(t.amount) FROM training_out t WHERE t.Beginedate BETWEEN '$month_start' and '$month_end') a3
FROM plan_out p
WHERE p.begin_date BETWEEN '$month_start' and '$month_end'");
            $rs = mysql_fetch_assoc($sql_train);
            ?>

                                    <tr>
                                        <td><?php echo $month[month_name]; ?></td>
                                        <td align="center"><?php echo $rs[a1]; ?></td> 
                                        <td align="center"><?php echo $rs[a2]; ?></td> 
                                        <td align="center"><?php echo $rs[a3]; ?></td> 
                                        <td align="center"><?php echo $rs[a4]; ?></td> 
                                        <td align="center"><?php echo $rs[a5]; ?></td> 
                                        <td align="center"><?php echo $rs[a6]; ?></td> 
                                        <td align="center"><?php echo $rs[a7]; ?></td> 
                                        <td align="center"><?php echo $rs[a8]; ?></td> 
                                        <td align="center"><?php echo $rs[a4] + $rs[a5] + $rs[a6] + $rs[a7] + $rs[a8]; ?></td> 
                                    </tr>

            <?php $c++;
            $I++;
        } ?>
                                <tfoot>
                                    <?php
                                    $sql_sum = mysql_query("SELECT COUNT(p.empno) as b2,SUM(p.abode) as b4,
SUM(reg) as b5,SUM(allow) as b6,SUM(p.travel) as b7,SUM(p.other) as b8,
(SELECT COUNT(t.tuid) FROM training_out t WHERE t.Beginedate BETWEEN '$date_start' and '$date_end') b1,
(SELECT SUM(t.amount) FROM training_out t WHERE t.Beginedate BETWEEN '$date_start' and '$date_end') b3
FROM plan_out p
WHERE p.begin_date BETWEEN '$date_start' and '$date_end'");
                                    $rsum = mysql_fetch_assoc($sql_sum);
                                    ?>
                                    <tr align="center">
                                        <td align="center" bgcolor="#898888"><b>รวม</b></td>
                                        <td align="center"><?php echo $rsum[b1]; ?></td>
                                        <td align="center"><?php echo $rsum[b2]; ?></td>
                                        <td align="center"><?php echo $rsum[b3]; ?></td>
                                        <td align="center"><?php echo $rsum[b4]; ?></td>
                                        <td align="center"><?php echo $rsum[b5]; ?></td>
                                        <td align="center"><?php echo $rsum[b6]; ?></td>
                                        <td align="center"><?php echo $rsum[b7]; ?></td>
                                        <td align="center"><?php echo $rsum[b8]; ?></td>
                                        <td align="center"><?php echo $rsum[b4] + $rsum[b5] + $rsum[b6] + $rsum[b7] + $rsum[b8]; ?></td>
                                    </tr>   
                                </tfoot>
                            </table>
                        </div>
                    </div></div></div></div>
    <?php
    } else {
        include 'connection/connect_i.php';
        if (!$db) {
            die('Connect Failed! :' . mysqli_connect_error());
            exit;
        }
        $sql = "select tp.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from topic_post tp
        inner join emppersonal em on em.empno=tp.empno_post
        where empno_status='ADMIN' order by topic_id desc limit 5";
        $qr = mysqli_query($db, $sql);



        $sql2 = "select re.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from regularity re
        inner join emppersonal em on em.empno=re.empno_regu
        order by regu_id desc limit 5";
        $qr2 = mysqli_query($db, $sql2);

        $sql3 = mysqli_query($db, "SELECT regu_file  FROM regularity WHERE regu_id='1'");
        $manual = mysqli_fetch_assoc($sql3);
        $Manual = $manual[regu_file];
        $folder_manual = "regu_file/";
        ?>
        <div class="row">
            <div class="col-lg-2 col-xs-6">
                <a href="<?= $resultHos['url'] ?>service&support" class="btn btn-warning" target="_blank">โปรมแกรมสนับสนุน</a>       
            </div>
            <div class="col-lg-8"></div>
            <div class="col-lg-2 col-xs-6" align="right">
                <!--<a href="#" class="btn btn-success" onClick="return popup('<?= $folder_manual . $Manual ?>', popup, 820, 1000);" title="คู่มือการใช้โปรแกรม">คู่มือการใช้งาน</a>-->
                <a href="#" class="btn btn-success" onclick="window.open('<?= $folder_manual . $Manual ?>', '', 'width=820,height=1000');
                            return false;" title="คู่มือการใช้โปรแกรม">คู่มือการใช้งาน</a>
            </div>
            <p><br><br>
            <div class="col-lg-5">
                <div class="row">      
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><center><u><h3><b>ระเบียบ/คำสั่ง</b></h3></u></center></h3>
                            </div>
                            <div class="panel-body">

                                <?php
                                include 'option/funcDateThai.php';
                                while ($topic_regu = mysqli_fetch_assoc($qr2)) {
                                    if ($topic_regu[regu_file] != '') {
                                        $regu_file = $topic_regu[regu_file];
                                        $folder_file = "regu_file/";
                                    }
                                    ?>
                                    <p><h4><b><font color='red'>ระเบียบที่ <?= $topic_regu[regu_id] ?></font></b></h4><b>ผู้ประกาศ</b> คุณ<?= $topic_regu[fullname] ?>  <b>ประกาศเมื่อ</b> <?= DateThai1($topic_regu[regu_date]) ?>
                                    <a href="<?= $folder_file . $regu_file ?>" target="_blank"><font color='blue'><h5><li><?= $topic_regu[topic_regu] ?></li></h5></font></a>                           
        <?php } ?>
                                <center><a href="#" onClick="return popup('total_regularity.php', popup, 820, 650);" title="ดูระเบียบทั้งหมด">อ่านทั้งหมด</a>
                                </center>
                            </div>
                        </div></div></div></div>
            <div class="col-lg-7">
                <div class="row">   
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><center><u><h3><b>ประกาศ/ข่าวประชาสัมพันธ์</b></h3></u></center></h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                while ($topic_post = mysqli_fetch_assoc($qr)) {
                                    if (!empty($topic_post)) {
                                        if (!empty($topic_post['photo_post'])) {
                                            $photo_post = $topic_post['photo_post'];
                                            $folder_post = "post/";
                                        } else {
                                            $photo_post = '';
                                            $folder_post = '';
                                        }
                                        $sql_comm = mysqli_query($db, "select count(topic_id) as comm from comment where topic_id='" . $topic_post['topic_id'] . "'");
                                        $comm = mysqli_fetch_assoc($sql_comm);
                                        ?>
                                        <p><h4><b><font color='red'>ประกาศที่ <?= $topic_post[topic_id] ?></font></b></h4>
                                        <b>ผู้ประกาศ</b> คุณ<?= $topic_post['fullname'] ?>  <b>ประกาศเมื่อ</b> <?= DateThai1($topic_post['post_date']) ?> <b>มีผู้สอบถาม <font color='red'><?= $comm['comm'] ?></font> คน</b><p>
                                            <a href="comm_page.php?post=<?= $topic_post['topic_id'] ?>"><h4><li><?= $topic_post['post'] ?></li></h4></a>
                                            <?php
                                            if (!empty($topic_post['link'])) {
                                                echo "<a href='" . $topic_post['link'] . "' target='_blank'> <i class='fa fa-link'></i> รายละเอียด </a><br><br>";
                                            }
                                            if (!empty($photo_post)) {
                                                $file_name = $photo_post;
                                                $info = pathinfo($file_name, PATHINFO_EXTENSION);
                                                if ($info == 'jpg' or $info == 'JPG' or $info == 'bmp' or $info == 'BMP' or $info == 'png' or $info == 'PNG') {
                                                    ?>
                                                    <a href="comm_page.php?post=<?= $topic_post['topic_id'] ?>"><center>
                                                            <embed src='<?= $folder_post . $photo_post ?>' mce_src='<?= $folder_post . $photo_post ?>' width='100%' height=''>
                                                        </center></a>
                    <?php } else { ?>
                                                    <a href="<?= $folder_post . $photo_post ?>"  target="_blank"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
                    <?php }
                }
            }
            echo "<hr>";
        }
        ?>
                            </div>
                        </div></div></div>
            </div>
        </div>
        <!--<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
           
           <ol class="carousel-indicators">
               <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
               <li data-target="#carousel-example-generic" data-slide-to="1"></li>
               <li data-target="#carousel-example-generic" data-slide-to="2"></li>
           </ol>

          
           <div class="carousel-inner" role="listbox">
               <div class="item active">
                   <img src="images/p1.jpg" width="100%" alt="...">
                   <div class="carousel-caption">
                       โรงพยาบาลจิตเวชเลยราชนครินทร์
                   </div>
               </div>
               <div class="item">
                   <img src="images/p2.jpg" width="100%" alt="...">
                   <div class="carousel-caption">
                       โรงพยาบาลจิตเวชเลยราชนครินทร์
                   </div>
               </div>
               <div class="item">
                   <img src="images/p3.jpg" width="100%" alt="...">
                   <div class="carousel-caption">
                       โรงพยาบาลจิตเวชเลยราชนครินทร์
                   </div>
               </div>

           </div>

          
           <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <!-- <span class="fa fa-chevron-left" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
           </a>
           <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
             <!--<span class="fa fa-chevron-right" aria-hidden="true"></span
               <span class="sr-only">Next</span>
           </a>
        </div>-->
    <?php }
}
?>
<?php include 'footer.php'; ?>