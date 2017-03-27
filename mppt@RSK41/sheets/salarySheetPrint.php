<!DOCTYPE HTML>
<html>
<head>
    <title>Margalla Packages Islamabad</title>
    <link rel="shortcut icon" type="image/png" href="../../favicon.png">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/_style.css" rel="stylesheet">
    <style>
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm;  }
        }
    </style>
</head>
<body onload="init()" style="background-color:white;">
<br>
<div class="container addBox salSheetPrint" style="width:100%;">
    <div class="inBox">
        <div class="row">
            <div class="col-md-10">
                <?php
                require "../123321.php";
                if(!isset($_GET['year']) && !isset($_GET['month']))
                {
                    $year = date("Y");
                    $month = date("m");
                }
                else
                {
                    $year = $_GET['year'];
                    $month = $_GET['month'];
                }
                switch ($month) {
                    case 1:
                        $monthT = "Jan";
                        break;
                    case 2:
                        $monthT = "Feb";
                        break;
                    case 3:
                        $monthT = "March";
                        break;
                    case 4:
                        $monthT = "April";
                        break;
                    case 5:
                        $monthT = "May";
                        break;
                    case 6:
                        $monthT = "June";
                        break;
                    case 7:
                        $monthT = "July";
                        break;
                    case 8:
                        $monthT = "Aug";
                        break;
                    case 9:
                        $monthT = "Sep";
                        break;
                    case 10:
                        $monthT = "Oct";
                        break;
                    case 11:
                        $monthT = "Nov";
                        break;
                    case 12:
                        $monthT = "Dec";
                        break;

                    default:
                        $monthT = "Unknown";
                        break;
                }
                $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                ?>


            </div>
            <br><br>
            <div class="row" style="font-size:16px;">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 text-center">
                    <h1>Employees Salary Sheet (<?php echo $monthT."-".$year; ?>)</h1>
                </div>
                <div class="col-sm-3"></div>
            </div>
            <br><br>
            <div class="scrollX">
                <div class="row" style="width:100%;position:relative;margin:0 auto;">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;">Employee</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;">Salary</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;">Sal/d (Absents)</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;font-size: .8vw;text-align: center;padding: 0px;">Deduct Salary</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;text-align: center;padding: 0px;">LD</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;text-align: center;padding: 0px;">HD</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;">LD+HD</div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;">Profit</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;">Advance</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;text-align: center;padding: 0px;">Dur.</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;font-size: .85vw;">Bonus / Trip</div>
                            <div class="col-sm-3 bold" style="border:1px solid black;text-align: center;padding: 0px;">Description</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;text-align: center;padding: 0px;">Salary</div>
                        </div>
                    </div>
                </div>
                <?php

                $qry = "SELECT * FROM `employee` WHERE 1";
                $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                $tot_sal = 0;
                $count = 0;
                $ldTotal = [];
                $hdTotal = [];
                while($data = mysqli_fetch_array($run))
                {

                    $id = $data['id'];
                    $salary = $sal;

                    //$qry = "SELECT i.*,SUM(idd.weices * idd.rate) as total FROM `invoice` i,`invoice_detail` idd WHERE i.salerep = '$id' and i.date >= '".$year."-".$month."-01' and i.date <= '".$year."-".$month."-31' and i.no = idd.ref group by i.no";

                    $qry = "SELECT i.*,c.name as cName FROM `invoice` i, customers c WHERE i.customer = c.id and i.`salerep` = '$id' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' order by i.no";
                    $run1 = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $total_profit = 0;
                    $earned = 0;

                    while($data1 = mysqli_fetch_array($run1))
                    {
                        $advance = intval($data['advance']);


                        $qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data1['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material = 'LD' group by i.id";
                        $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
                        $ldCount = mysqli_num_rows($run2);
                        $data2 = mysqli_fetch_array($run2);

                        $qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data1['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material != 'LD' group by i.id";
                        //echo $qry;
                        $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
                        $hdCount = mysqli_num_rows($run2);
                        $data3 = mysqli_fetch_array($run2);
                        $total_profit += intval($data1['hdRate'])  * floatval($data3['weices']) + intval($data1['ldRate'])  * floatval($data2['weices']);
                        $ldTotal[$id] += floatval($data3['weices']);
                        $hdTotal[$id] += floatval($data2['weices']);



                    }

                    $qry = "SELECT SUM(amount) as amount,SUM(duration) as dur FROM `advance` WHERE employee = '$id' and date >= '$year-$month-01' and date <= '$year-$month-31' group by employee";
                    $run1 = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $advance = 0;
                    $dur = 0;
                    $advdeduct = 0;
                    if(mysqli_num_rows($run1) > 0)
                    {
                        $data1 = mysqli_fetch_array($run1);
                        $advance = $data1['amount'];
                        $dur = $data1['dur'];
                        $advdeduct = intval($advance);

                        ?>
                        <input type="hidden" id='advd_<?php echo $data["id"]; ?>' value='<?php echo $advdeduct ?>'>
                        <?php
                    }

                    $qry = "SELECT * FROM absents WHERE employee = '".$id."' and year = '".$year."' and month = '".$month."'";
                    $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $abs = 0;
                    if(mysqli_num_rows($run2))
                    {
                        $data4 = mysqli_fetch_array($run2);
                        $abs = $data4['absents'];
                    }
                    $sal = 0;
                    //echo $month." - ".date("m"). " ".strcmp($month,date("m"));
                    $sal = $data['salary'];
                    $qry = "SELECT * FROM salaries WHERE employee = '".$id."' and year = '".date('Y')."' and month = '".$month."'";
                    $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));

                    if(mysqli_num_rows($run2))
                    {
                        $data4 = mysqli_fetch_array($run2);
                        $sal = $data4['salary'];
                    }
                    $bonus = 0;
                    $bonusdesc = '--';
                    $qry = "SELECT * FROM bonuses WHERE employee = '".$id."' and year = '".date('Y')."' and month = '".$month."'";
                    $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));

                    if(mysqli_num_rows($run2))
                    {
                        $data4 = mysqli_fetch_array($run2);
                        $bonus = intval($data4['bonus']);
                        $bonusdesc = $data4['desc'];
                    }


                    ?>
                    <div class="row" style="width:100%;position:relative;margin:0 auto;">
                        <div class="col-sm-6">
                            <div class="row">
                                <input type="hidden" id="id_<?php echo $count; ?>" value="<?php echo $data['id']; ?>"/>
                                <div class="col-sm-2" style="border:1px solid black;font-size:10px;"><a  href="javascript:void()" onclick='pageLoad("employees/salSheet.php?id=<?php echo $id; ?>&month=<?php echo $month;?>&year=<?php echo $year; ?>")'><?php echo $data['name']; ?></a></div>
                                <div class="col-sm-2" style="border:1px solid black;padding-left:2px;text-align:left;"><?php echo $sal; ?></div>
                                <div class="col-sm-2" style="text-align:center;padding-left:2px;border:1px solid black;" id='salperdayDIV_<?php echo $data["id"]; ?>'><?php echo round(floatval($sal) / $numberOfDays, 1, PHP_ROUND_HALF_UP); ?> (<?php echo $abs; ?>)</div>
                                <div class="col-sm-2" style="text-align:center;padding-left:2px;border:1px solid black;" id='salDIV_<?php echo $data["id"]; ?>'><?php echo round(floatval($sal) / $numberOfDays * intval($abs), 1, PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-1" style="border:1px solid black;text-align: center;padding: 0px;" id='ldDIV_<?php echo $data["id"]; ?>'><?php echo round($ldTotal[$id], PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-1" style="border:1px solid black;text-align: center;padding: 0px;" id='hdDIV_<?php echo $data["id"]; ?>'><?php echo round($hdTotal[$id], PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-2" style="border:1px solid black;" id='ldhdDIV_<?php echo $data["id"]; ?>'><?php echo round($ldTotal[$id]+$hdTotal[$id], PHP_ROUND_HALF_UP); ?></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2" style="border:1px solid black;" id='profitDIV_<?php echo $data["id"]; ?>'><?php echo round($total_profit, PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-2" style="border:1px solid black;" id='advdeductDIV_<?php echo $data["id"]; ?>'><?php echo $advance; ?></div>
                                <div class="col-sm-1" style="border:1px solid black;"><?php echo $dur; ?></div>
                                <div class="col-sm-2" style="border:1px solid black;padding:0px;"><?php echo $bonus; ?></div>
                                <div class="col-sm-3" style="border:1px solid black;padding:0px;"><?php echo $bonusdesc; ?></div>
                                <div class="col-sm-2" style="border:1px solid black;" id='finalSalDIV_<?php echo $data["id"]; ?>'><?php
                                    $employeeSal = intval($sal) + floatval($total_profit) + intval($bonus) - floatval($advdeduct) - (floatval($sal) / $numberOfDays) * intval($abs);
                                    echo  round($employeeSal,1, PHP_ROUND_HALF_UP);
                                    $tot_sal += $employeeSal;
                                    ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count++;
                }
                ?>
                <input type="hidden" id="count" value="<?php echo $count; ?>"/>
                <div class="row" style="width:100%;position:relative;margin:0 auto;">
                    <div class="col-sm-11" style="border:1px solid black;"><b>Total</b></div>
                    <div class="col-sm-1" style="border:1px solid black;"><b id="finalSalary"><?php echo number_format(round($tot_sal, PHP_ROUND_HALF_UP)); ?></b></div>
                </div>
                <br>

                </div>
        </div></div><br>
</div>
</div>
</body>
<script>
    function init() {
        window.print();
        window.close();
    }
</script>