<br><br>
<div class="container addBox" style="width:95%">
    <div class="inBox2">
        <br>
        <?php
        require "../123321.php";
        if (intval($_SESSION['level']) < 2 ) {
            echo "<br><br><br><h1>No access, sorry!</h1><br><br><br><br><br><br><br><br><br><br><br><br>";
        }
        else
        {

            require "closingBalance.php";
            if (!isset($_GET['year']) && !isset($_GET['month'])) {
                $year = date("Y");
                $month = date("m");
            } else {
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
            ?>
            <br><br>
            <div class="row" style="font-size:16px;">
                <div class="col-sm-12">
                    <select id="yearOpt">
                        <option value="2016" <?php if (intval($year) == 2016) echo "selected"; ?>>2016</option>
                        <option value="2017" <?php if (intval($year) == 2017) echo "selected"; ?>>2017</option>
                    </select>
                    <select id="monthOpt">
                        <option value="1" <?php if (intval($month) == 1) echo "selected"; ?>>Jan</option>
                        <option value="2" <?php if (intval($month) == 2) echo "selected"; ?>>Feb</option>
                        <option value="3" <?php if (intval($month) == 3) echo "selected"; ?>>March</option>
                        <option value="4" <?php if (intval($month) == 4) echo "selected"; ?>>April</option>
                        <option value="5" <?php if (intval($month) == 5) echo "selected"; ?>>May</option>
                        <option value="6" <?php if (intval($month) == 6) echo "selected"; ?>>June</option>
                        <option value="7" <?php if (intval($month) == 7) echo "selected"; ?>>July</option>
                        <option value="8" <?php if (intval($month) == 8) echo "selected"; ?>>Aug</option>
                        <option value="9" <?php if (intval($month) == 9) echo "selected"; ?>>Sep</option>
                        <option value="10" <?php if (intval($month) == 10) echo "selected"; ?>>Oct</option>
                        <option value="11" <?php if (intval($month) == 11) echo "selected"; ?>>Nov</option>
                        <option value="12" <?php if (intval($month) == 12) echo "selected"; ?>>Dec</option>
                    </select>
                    <button onclick="updateISMonth()">Go</button>
                </div>
            </div>
        <h1 style="font-size:28px;">Margalla Packages Islamabad</h1>
        <h1>Income Statement</h1>
            <h1 style="font-size:22px;">For Month Ended <?php echo $monthT." ".$year; ?></h1>
            <?php
            $qry = "SELECT SUM(idd.weices * idd.rate + idd.charges) as total FROM `invoice` i,`invoice_detail` idd WHERE i.no = idd.ref and i.date >= '$year-$month-01' and i.date <= '$year-$month-31'";
            $run = mysqli_query($con, $qry) or die(mysqli_error($con));
            $data = mysqli_fetch_array($run);
            $custInvTot = floatval($data['total']);
            ?>
            <div class="row incomeSatementTable">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 bold">Sales Revenue (Invoices)</div>
                <div class="col-sm-5"><?php echo "Rs. " . number_format(round($custInvTot, 2, PHP_ROUND_HALF_EVEN)); ?></div>
                <div class="col-sm-1"></div>
            </div>
            <?php
            $qry = "SELECT SUM(bd.weices * bd.rate) as total,v.name as name FROM `bill` b,`bill_detail` bd,`vendor` v WHERE v.id = b.vendor and b.id = bd.ref and b.date >= '$year-$month-01' and b.date <= '$year-$month-31' and v.name = 'Factory' group by b.vendor ";
            $run = mysqli_query($con, $qry) or die(mysqli_error($con));
            $fac_bill = 0;
            if (mysqli_num_rows($run) > 0) {
                $data = mysqli_fetch_array($run);
                $fac_bill = floatval($data['total']);
            }
            $qry = "SELECT SUM(bd.weices * bd.rate) as total,v.name as name FROM `bill` b,`bill_detail` bd,`vendor` v WHERE v.id = b.vendor and b.id = bd.ref and b.date >= '$year-$month-01' and b.date <= '$year-$month-31' and v.name = 'Block' group by b.vendor ";
            $run = mysqli_query($con, $qry) or die(mysqli_error($con));
            $block_bill = 0;
            if (mysqli_num_rows($run) > 0) {
                $data = mysqli_fetch_array($run);
                $block_bill = floatval($data['total']);
            }
            $costOfGoodsSold = $fac_bill + $block_bill;
            $grossMargin = $custInvTot - $costOfGoodsSold;
            ?>
            <div class="row incomeSatementTable">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 bold">Cost of goods sold (Block + Factory Bills)</div>
                <div class="col-sm-5"><?php echo "Rs. " . number_format(round($costOfGoodsSold, 2, PHP_ROUND_HALF_EVEN)); ?></div>
                <div class="col-sm-1"></div>
            </div>
            <div class="row incomeSatementTable">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 bold">Gross Margin (Revenue - Cost of goods)</div>
                <div class="col-sm-5"><?php echo "Rs. " . number_format(round($grossMargin, 2, PHP_ROUND_HALF_EVEN)); ?></div>
                <div class="col-sm-1"></div>
            </div>
            <?php
            $qry = "SELECT a.name,SUM(e.amount) as total FROM `expAccounts` a, expences e WHERE a.id = e.acc_id  and e.date >= '$year-$month-01' and e.date <= '$year-$month-31' group by a.id";
            $run = mysqli_query($con, $qry) or die(mysqli_error($con));
            $exp_tot = 0;
            while ($data = mysqli_fetch_array($run)) {
            if($data['name'] === "Income Tax") {
                $incomeTax = floatval($data['total']);
                continue;
            }
            ?>
                <div class="row incomeSatementTable">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-5 bold"><span style="color:red;">(Expence)</span> <?php echo $data['name']; ?></div>
                    <div class="col-sm-5"><?php echo "Rs." . number_format(floatval($data['total']));
                                                $exp_tot += floatval($data['total']);?></div>
                    <div class="col-sm-1"></div>
                </div>
            <?php
            }
            $qry = "SELECT * FROM `employee` WHERE 1";
            $run = mysqli_query($con, $qry) or die(mysqli_error($con));
            $tot_sal_all = 0;
            $count = 0;
            while ($data = mysqli_fetch_array($run)) {

                $id = $data['id'];
                $salary = $sal;

                $qry = "SELECT i.*,c.name as cName FROM `invoice` i, customers c WHERE i.customer = c.id and i.`salerep` = '$id' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' order by i.no";
                $run1 = mysqli_query($con, $qry) or die(mysqli_error($con));
                $total_profit = 0;
                $earned = 0;

                while ($data1 = mysqli_fetch_array($run1)) {
                    $advance = intval($data['advance']);


                    $qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '" . $data1['no'] . "' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material = 'LD' group by i.id";
                    $run2 = mysqli_query($con, $qry) or die(mysqli_error($con));
                    $ldCount = mysqli_num_rows($run2);
                    $data2 = mysqli_fetch_array($run2);

                    $qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '" . $data1['no'] . "' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material != 'LD' group by i.id";
                    //echo $qry;
                    $run2 = mysqli_query($con, $qry) or die(mysqli_error($con));
                    $hdCount = mysqli_num_rows($run2);
                    $data3 = mysqli_fetch_array($run2);
                    $total_profit += intval($data1['hdRate']) * floatval($data3['weices']) + intval($data1['ldRate']) * floatval($data2['weices']);


                }

                $qry = "SELECT SUM(amount) as amount,SUM(duration) as dur FROM `advance` WHERE employee = '$id' and date > '$year-$month-01' and date < '$year-$month-31' group by employee";
                $run1 = mysqli_query($con, $qry) or die(mysqli_error($con));
                $advance = 0;
                $dur = 0;
                $advdeduct = 0;
                if (mysqli_num_rows($run1) > 0) {
                    $data1 = mysqli_fetch_array($run1);
                    $advance = $data1['amount'];
                    $dur = $data1['dur'];
                    if (intval($advance) > 0) {
                        if (intval($dur) > 0) {
                            $advdeduct = intval($advance) / intval($dur);
                        } else {
                            $advdeduct = intval($advance);
                        }
                    }


                }

                $qry = "SELECT * FROM absents WHERE employee = '" . $id . "' and year = '" . $year . "' and month = '" . $month . "'";
                $run2 = mysqli_query($con, $qry) or die(mysqli_error($con));
                $abs = 0;
                if (mysqli_num_rows($run2)) {
                    $data4 = mysqli_fetch_array($run2);
                    $abs = $data4['absents'];
                }
                $sal = 0;
                $sal = $data['salary'];
                $qry = "SELECT * FROM salaries WHERE employee = '" . $id . "' and year = '" . $year . "' and month = '" . $month . "'";
                $run2 = mysqli_query($con, $qry) or die(mysqli_error($con));

                if (mysqli_num_rows($run2)) {
                    $data4 = mysqli_fetch_array($run2);
                    $sal = $data4['salary'];
                }
                $bonus = 0;
                $bonusdesc = '--';
                $qry = "SELECT * FROM bonuses WHERE employee = '" . $id . "' and year = '" . $year . "' and month = '" . $month . "'";
                $run2 = mysqli_query($con, $qry) or die(mysqli_error($con));

                if (mysqli_num_rows($run2)) {
                    $data4 = mysqli_fetch_array($run2);
                    $bonus = intval($data4['bonus']);
                    $bonusdesc = $data4['desc'];
                }
                $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $tot_sal += (intval($sal) + $total_profit + intval($bonus)) - $advdeduct - floatval(intval($sal) / $numberOfDays * intval($abs));
                $tot_sal_all += (intval($sal) + $total_profit + intval($bonus)) - $advdeduct - floatval(intval($sal) / $numberOfDays * intval($abs));
                $count++;
                $operatingEarning = $grossMargin - $exp_tot - $tot_sal_all;
            }
            ?>
            <div class="row incomeSatementTable">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 bold"><span style="color:red;">(Expence)</span> Employee Salaries</div>
                <div class="col-sm-5"><?php echo "Rs. " . number_format(round($tot_sal_all, 2, PHP_ROUND_HALF_EVEN)); ?></div>
                <div class="col-sm-1"></div>
            </div>
            <div class="row incomeSatementTable">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 bold">Operating Earning</div>
                <div class="col-sm-5 bold" style="color:green;"><?php echo "Rs. " . number_format(round($operatingEarning, 2, PHP_ROUND_HALF_EVEN)); ?></div>
                <div class="col-sm-1"></div>
            </div>
            <div class="row incomeSatementTable">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 bold"><span style="color:red;">(Expence)</span> Income Tax Expence</div>
                <div class="col-sm-5"><?php echo "Rs. " . number_format(round($incomeTax, 2, PHP_ROUND_HALF_EVEN)); $netIncome = $operatingEarning - $incomeTax; ?></div>
                <div class="col-sm-1"></div>
            </div>
            <div class="row incomeSatementTable">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 bold">Net Income</div>
                <div class="col-sm-5 bold" style="color:darkgreen;"><?php echo "Rs. " . number_format(round($netIncome, 2, PHP_ROUND_HALF_EVEN)); ?></div>
                <div class="col-sm-1"></div>
            </div>
            <br><br><br>
        <?php
        }
        ?>
    </div>
</div>
<script>
function updateISMonth() {
    var month = $("#monthOpt").val();
    var year = $("#yearOpt").val();
    pageLoad('sheets/incomestatement.php?year=' + year + '&month=' + month);
}

</script>