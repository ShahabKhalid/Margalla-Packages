<div class="container addBox" style="width:100%;">
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
                    <select id="yearOpt">
                        <option value="2016" <?php if(intval($year) == 2016) echo "selected"; ?>>2016</option>
                        <option value="2017" <?php if(intval($year) == 2017) echo "selected"; ?>>2017</option>
                    </select>
                    <select id="monthOpt">
                        <option value="1" <?php if(intval($month) == 1) echo "selected"; ?>>Jan</option>
                        <option value="2" <?php if(intval($month) == 2) echo "selected"; ?>>Feb</option>
                        <option value="3" <?php if(intval($month) == 3) echo "selected"; ?>>March</option>
                        <option value="4" <?php if(intval($month) == 4) echo "selected"; ?>>April</option>
                        <option value="5" <?php if(intval($month) == 5) echo "selected"; ?>>May</option>
                        <option value="6" <?php if(intval($month) == 6) echo "selected"; ?>>June</option>
                        <option value="7" <?php if(intval($month) == 7) echo "selected"; ?>>July</option>
                        <option value="8" <?php if(intval($month) == 8) echo "selected"; ?>>Aug</option>
                        <option value="9" <?php if(intval($month) == 9) echo "selected"; ?>>Sep</option>
                        <option value="10" <?php if(intval($month) == 10) echo "selected"; ?>>Oct</option>
                        <option value="11" <?php if(intval($month) == 11) echo "selected"; ?>>Nov</option>
                        <option value="12" <?php if(intval($month) == 12) echo "selected"; ?>>Dec</option>
                    </select>
                    <button onclick="updateSSMonth()">Go</button>
                </div>
                <div class="col-sm-3"></div>
            </div>
            <br><br>
            <div class="scrollX">
                <div class="row" style="width:100%;position:relative;margin:0 auto;">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2 bold" style="border:1px solid black;">Employee</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;">Salary</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">Sal/d</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;">Absents</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">D.Sal</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">LD</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">HD</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;">LD+HD</div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-2 bold" style="border:1px solid black;">Profit</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;">Sub Profit</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;">Advance</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">Dur.</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">Bonus</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">B.Desc</div>
                            <div class="col-sm-1 bold" style="border:1px solid black;">Ded.</div>
                            <div class="col-sm-2 bold" style="border:1px solid black;">Salary</div>
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
                    <div class="row" style="width:98%;position:relative;margin:0 auto;">
                        <div class="col-sm-6">
                            <div class="row">
                                <input type="hidden" id="id_<?php echo $count; ?>" value="<?php echo $data['id']; ?>"/>
                                <div class="col-sm-2" style="border:1px solid black;font-size:12px;"><a href="javascript:void()" onclick='pageLoad("employees/salSheet.php?id=<?php echo $id; ?>&month=<?php echo $month;?>&year=<?php echo $year; ?>")'><?php echo $data['name']; ?></a></div>
                                <div class="col-sm-2" style="border:1px solid black;padding-left:2px;text-align:left;"><input style="width:100%;height:20px;" type="text" id='normsalDIV_<?php echo $data["id"]; ?>' value='<?php echo $sal; ?>' style='width:140px;height:20px;'></div>
                                <div class="col-sm-1" style="text-align:center;padding-left:2px;border:1px solid black;" id='salperdayDIV_<?php echo $data["id"]; ?>'><?php echo round(floatval($sal) / $numberOfDays, 1, PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-2" style="border:1px solid black;padding-left:2px;text-align:left;"><input style="width:100%;height:20px;" type='text' id='absents_<?php echo $data["id"]; ?>' placeholder='Absents' style='width:140px;height:20px;' value='<?php echo $abs; ?>' onchange='deductSal(<?php echo $data["id"]; ?>,<?php echo $year; ?>,<?php echo $month; ?>)'></div>
                                <div class="col-sm-1" style="text-align:center;padding-left:2px;border:1px solid black;" id='salDIV_<?php echo $data["id"]; ?>'><?php echo round(floatval($sal) / $numberOfDays * intval($abs), 1, PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-1" style="border:1px solid black;" id='ldDIV_<?php echo $data["id"]; ?>'><?php echo round($ldTotal[$id], PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-1" style="border:1px solid black;" id='hdDIV_<?php echo $data["id"]; ?>'><?php echo round($hdTotal[$id], PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-2" style="border:1px solid black;" id='ldhdDIV_<?php echo $data["id"]; ?>'><?php echo round($ldTotal[$id]+$hdTotal[$id], PHP_ROUND_HALF_UP); ?></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2" style="border:1px solid black;" id='profitDIV_<?php echo $data["id"]; ?>'><?php echo round($total_profit, PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-2" style="border:1px solid black;" id='salProfitDIV_<?php echo $data["id"]; ?>'><?php echo round((intval($sal) + $total_profit), PHP_ROUND_HALF_UP); ?></div>
                                <div class="col-sm-2" style="border:1px solid black;"><?php echo $advance; ?></div>
                                <div class="col-sm-1" style="border:1px solid black;"><?php echo $dur; ?></div>
                                <div class="col-sm-1" style="border:1px solid black;padding:0px;"><input style="width:100%;height:20px;" type="text" id='bonus_<?php echo $data["id"]; ?>' value='<?php echo $bonus; ?>' style='width:140px;height:20px;' onchange='deductSal(<?php echo $data["id"]; ?>,<?php echo $year; ?>,<?php echo $month; ?>)'></div>
                                <div class="col-sm-1" style="border:1px solid black;padding:0px;"><input style="padding-left:1px;width:100%;height:20px;" type="text" onchange='deductSal(<?php echo $data["id"]; ?>,<?php echo $year; ?>,<?php echo $month; ?>)' id='bonusDesc_<?php echo $data['id']; ?>' value='<?php echo $bonusdesc; ?>' style='width:140px;height:20px;'></div>
                                <div class="col-sm-1" style="border:1px solid black;" id='advdeductDIV_<?php echo $data["id"]; ?>'><?php echo $advdeduct; ?></div>
                                <div class="col-sm-2" style="border:1px solid black;" id='finalSalDIV_<?php echo $data["id"]; ?>'><?php echo  round((intval($sal) + $total_profit + intval($bonus)) - $advdeduct - floatval(floatval($sal) / $numberOfDays * intval($abs)),1, PHP_ROUND_HALF_UP); $tot_sal += (intval($sal) + $total_profit + intval($bonus)) - $advdeduct - floatval(intval($sal) / $numberOfDays * intval($abs));?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count++;
                }
                ?>
                <input type="hidden" id="count" value="<?php echo $count; ?>"/>
                <div class="row" style="width:98%;position:relative;margin:0 auto;">
                    <div class="col-sm-11" style="border:1px solid black;"><b>Total</b></div>
                    <div class="col-sm-1" style="border:1px solid black;"><b><?php echo round($tot_sal, PHP_ROUND_HALF_UP) ?></b></div>
                </div>
                <br>

                <a href="javascript:void()" onclick="return updateSalaries('<?php echo $year;?>','<?php echo $month; ?>')">Update Salary</a>
            </div>
        </div></div><br>
    <p id="esc">Press Escape to go back!</p>
</div>
</div>
<script>
    function updateSalaries(y,m)
    {
        var count = $("#count").val();
        for(var i = 0;i < count;i++)
        {
            var id = $("#id_"+i).val();
            var sal = $("#normsalDIV_"+id).val();
            var advd = $("#advd_"+id).val();
            var bonus = $("#bonus_"+id).val();
            var bonusdesc = $("#bonusDesc_"+id).val();
            updateSalary(id,sal,y,m,advd,bonus,bonusdesc);
        }
        alert("Salaries Updated!");
    }
    function updateSalary(id,sal,y,m,advd,bonus,bonusdesc)
    {
        //alert("id="+id+"&sal="+sal+"&month="+m+"&year="+y+"&advdeduct="+advd+"&ajax");
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                //alert(xhttp.responseText);

            }};
        xhttp.open("POST", "do.php?action=updatesalaries", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id="+id+"&sal="+sal+"&month="+m+"&year="+y+"&advdeduct="+advd+"&ajax");
    }
    function deductSal(id,Y,m)
    {
        var abs = $("#absents_"+id).val();
        var salperday = $("#salperdayDIV_"+id).html();
        var sal = $("#normsalDIV_"+id).val();
        var profit = $("#profitDIV_"+id).html();
        var advdeduct = $("#advdeductDIV_"+id).html();
        var bonus = $("#bonus_"+id).val();

        var bonusdesc = $("#bonusDesc_"+id).val();
        //alert(bonusdesc);
        $("#salDIV_"+id).html("" + Number(parseFloat(sal) - parseFloat(salperday) * parseFloat(abs).toFixed(1)));
        $("#salProfitDIV_"+id).html("" + Number(parseFloat(sal) - parseFloat(salperday) * parseFloat(abs) + parseFloat(profit)).toFixed(1));
        $("#finalSalDIV_"+id).html("" + Number(parseFloat(sal) - parseFloat(salperday) * parseFloat(abs) + parseFloat(profit) - parseFloat(advdeduct) + parseFloat(bonus)).toFixed(1) );

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                alert(xhttp.responseText);

            }};
        xhttp.open("POST", "do.php?action=updateabsents", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id="+id+"&abs="+abs+"&bonus="+bonus+"&bonusdesc="+bonusdesc+"&Y="+Y+"&m="+m+"&ajax");
    }

    function updateSSMonth()
    {
        var month = $("#monthOpt").val();
        var year = $("#yearOpt").val();
        pageLoad('employees/salarysheet.php?year='+year+'&month='+month);
    }

    function printView(id)
    {
        window.open("customers/customer_ledger_print.php?id="+id);
    }
    function viewPayment(id)
    {
        pageLoad("customers/payment_update.php?id="+id);
    }

    function viewInvoice(id)
    {
        pageLoad("customers/invoice_print.php?id="+id);
    }
</script>
