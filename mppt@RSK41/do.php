<?php

require "123321.php";
function getDays($date,$paymentTime)
{
	list($year, $month, $day) = explode('-', $date);
	$currentdate = date("Y-m-d");
	list($c_year, $c_month, $c_day) = explode('-', $currentdate);
	$d_year = intval($year) - intval($c_year);
	$d_month = intval($month) - intval($c_month);
	$d_day = intval($day) - intval($c_day);
	$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	$d = $d_day + $d_month * $numberOfDays + $d_year * 356 + $paymentTime;
	return $d;

}


function addLog($log,$con)
{
	$qry = "INSERT INTO `logs`(`id`, `date`, `time`,`admin`, `log`) VALUES (NULL,'".date('Y-m-d')."','".date("h:i:s")."','".$_SESSION['mppt_admin']."','".$log."')";
	mysqli_query($con,$qry) or die(mysqli_error($con));
}

if(isset($_POST['ajax']))
{


	if(isset($_GET['action']))
	{
		$action = $_GET['action'];

		switch ($action) {
				case 'login':
				if(isset($_POST['email']))
					{
						$qry = "SELECT * FROM `alpha` WHERE `username` = '".htmlspecialchars($_POST['email'])."' and `password` = '".md5(htmlspecialchars($_POST['pass']))."' and `securityPin` = '".md5(htmlspecialchars($_POST['pin']))."'";
						//echo $qry;
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0)
						{
							$data = mysqli_fetch_array($run);
							$_SESSION['mppt_admin'] = $data['id'];
                            $_SESSION['access'] = $data['access'];
                            $_SESSION['level'] = $data['level'];
							echo "1";
							$qry = "INSERT INTO `login_log`(`id`, `date`, `time`, `ip`, `userName`, `pass`, `pin`, `fail`) VALUES (NULL,'".date('Y-m-d')."','".date("h:i:s")."','".$_SERVER['REMOTE_ADDR']."','".$_POST['email']."','----','-----','0')";
						}
						else
						{
							echo "0";
							$qry = "INSERT INTO `login_log`(`id`, `date`, `time`, `ip`, `userName`, `pass`, `pin`, `fail`) VALUES (NULL,'".date('Y-m-d')."','".date("h:i:s")."','".$_SERVER['REMOTE_ADDR']."','".htmlspecialchars($_POST['email'])."','".htmlspecialchars($_POST['pass'])."','".htmlspecialchars($_POST['pin'])."','1')";

						}
						mysqli_query($con,$qry) or die(mysqli_error($con));
					}
					break;
				case 'updateabsents':
					$qry = "SELECT * FROM absents WHERE year = '".$_POST['Y']."' and month = '".$_POST['m']."' and employee = '".$_POST['id']."'";
					//echo $qry;
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					//echo mysqli_num_rows($run);
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$qry = "UPDATE `absents` SET `absents`='".$_POST['abs']."' WHERE `id`='".$data['id']."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "updated!";
					}
					else
					{
						$qry = "INSERT INTO `absents`(`id`, `year`, `month`, `employee`, `absents`) VALUES (NULL,'".$_POST['Y']."','".$_POST['m']."','".$_POST['id']."','".$_POST['abs']."')";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "added!";
					}

					$qry = "SELECT * FROM bonuses WHERE year = '".$_POST['Y']."' and month = '".$_POST['m']."' and employee = '".$_POST['id']."'";
					//echo $qry;
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					//echo mysqli_num_rows($run);
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$qry = "UPDATE `bonuses` SET `bonus`='".$_POST['bonus']."',`desc`='".$_POST['bonusdesc']."' WHERE `id`='".$data['id']."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "updated!";
					}
					else
					{
						$qry = "INSERT INTO `bonuses`(`id`, `year`, `month`, `employee`, `bonus`,`desc`) VALUES (NULL,'".$_POST['Y']."','".$_POST['m']."','".$_POST['id']."','".$_POST['bonus']."','".$_POST['bonusdesc']."')";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "added!";
					}
					break;
				case 'updatesalaries':
					$qry = "SELECT * FROM salaries WHERE year = '".$_POST['year']."' and month = '".$_POST['month']."' and employee = '".$_POST['id']."'";
					//echo $qry;
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					//echo mysqli_num_rows($run);
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$qry = "UPDATE `salaries` SET `salary`='".$_POST['sal']."' WHERE `id`='".$data['id']."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "updated!";
					}
					else
					{
						$qry = "INSERT INTO `salaries`(`id`, `year`, `month`, `employee`, `salary`) VALUES (NULL,'".$_POST['year']."','".$_POST['month']."','".$_POST['id']."','".$_POST['sal']."')";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "added!";
					}
					if(strcmp($_POST['year'],date("Y")) == 0 && strcmp($_POST['month'],date("m")) == 0)
					{
						$qry = "UPDATE `employee` SET `salary`='".$_POST['sal']."' WHERE `id`='".$_POST['id']."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
					}
					$qry = "SELECT * FROM advance WHERE `employee` = '".$_POST['id']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					if(strcmp($_POST['advdeduct'],"undefined") !== 0)
					{
						$qry = "UPDATE `advance` SET `amount`='".(floatval($data['amount']) - floatval($_POST['advdeduct']))."',`duration`='".(intval($data['duration']) - 1)."',`date`='"
						.date("Y-m-d")."' WHERE `employee`='".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
					}



					break;
				case 'addadmin':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "INSERT INTO `alpha`(`id`, `fname`, `lname`, `username`, `email`, `password`, `securityPin`, `level`, `securityQuestion`, `securityAnswer`, `phoneNo`,`regIP`, `lastIP`, `lastLogTime`, `lastLogDate`, `dp`, `access`) VALUES (NULL,'".$_POST['fname']."','".$_POST['lname']."','".$_POST['uname']."','--','".md5($_POST['pass'])."','".md5($_POST['pin'])."','".$_POST['post']."','None','None','--','--','--','--','--','dps/default.jpg','".$_POST['access']."')";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					addLog("New Admin \'".$_POST['uname']."\' added!",$con);
					echo "1";
					break;


				case 'addcustomer':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "INSERT INTO `customers`(`id`, `name`, `contact`, `address`,`opening_balance`,`saleRep`,`rateBy`,`paymentMethod`,`ldRate`,`hdRate`,`date`) VALUES (NULL,'".$_POST['name']."','".$_POST['contact']."','".$_POST['addr']."','".$_POST['openbalance']."','".$_POST['salerep']."','".$_POST['weices']."','".$_POST['paymentMethod']."','".$_POST['ldRate']."','".$_POST['hdRate']."','".date("Y-m-d")."')";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					addLog("New Customer \'".$_POST['name']."\' added ".date("Y-m-d")."!",$con);
					echo "1";
					break;

                case 'deleteBill':
                    if(!isset($_SESSION['mppt_admin']))
                    {
                        header('location: index.php');
                    }
                    $id = $_POST["id"];
                    $qry = "DELETE FROM bill_detail WHERE ref = '$id'";
                    mysqli_query($con,$qry) or die(mysqli_error($con));
                    $qry = "DELETE FROM bill WHERE id = '$id'";
                    mysqli_query($con,$qry) or die(mysqli_error($con));
                    echo "1";
                    break;

					case 'deleteAdvance':
							if(!isset($_SESSION['mppt_admin']))
							{
								header('location: index.php');
							}
							$id = $_POST["id"];
							$qry = "DELETE FROM advance WHERE id = '$id'";
							mysqli_query($con,$qry) or die(mysqli_error($con));
							echo "1";
							break;

				case 'addAdvance':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$advance = $_POST['advance'];
						$dur = $_POST['duration'];
						$advancePerMonth = intval($advance) / intval($dur);
						$startDate = date('Y-m-d',strtotime($_POST['startDate']));
						$startDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($startDate)) . " +0 month"));


						for ($i=0; $i < intval($dur); $i++) {
							$startDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($startDate)) . " +$i month"));
							$qry = "INSERT INTO `advance`(`id`, `employee`, `amount`,`duration`,`date`) VALUES (NULL,'".$_POST['name']."','".$advancePerMonth."','".$dur."','".$startDate."')";
							//echo $qry;
							mysqli_query($con,$qry) or die(mysqli_error($con));
							addLog("New Advance \'".$_POST['advance']."\' for employee  \'".$_POST['name']."\', (".$startDate.") added!",$con);
						}
						echo "1";
						break;

						case 'updateAdvance':
								if(!isset($_SESSION['mppt_admin']))
								{
									header('location: index.php');
								}

								$qry = "UPDATE `advance` SET employee = '".$_POST['name']."',amount = '".$_POST['advance']."',duration = '".$_POST['duration']."',date = '".$_POST['startDate']."' WHERE id = '".$_POST['id']."'";
								mysqli_query($con,$qry) or die(mysqli_error($con));
								addLog("Update Advance \'".$_POST['advance']."\' for employee  \'".$_POST['name']."\'!",$con);
								echo "1";
								break;
				case 'addexpence':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "INSERT INTO `expences`(`id`, `acc_id`, `date`, `description`, `amount`) VALUES (NULL,'".$_POST['account']."','".$_POST['date']."','".$_POST['desc']."','".$_POST['amount']."')";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'addLbill':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "INSERT INTO `Ledgers_bill`(`id`, `ref`, `amount`, `date`,`bill`,`particular`) VALUES (NULL,'".$_POST['account']."','".$_POST['amount']."','".$_POST['date']."','1','".$_POST['particular']."')";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;
				case 'addVanLedger':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['partyName']."'";
						//echo $qry;
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0)
						{
							$data = mysqli_fetch_array($run);
							$cId = $data['id'];
						}

						$qry = "INSERT INTO `vanledger`(`id`, `SenderName`, `PartyName`, `Location`, `Rate`, `Toll`, `Rent`, `Ledger`, `Petrol`, `InHand`,`Date`) VALUES (NULL,'".$_POST['senderName']."','".$cId."','".$_POST['Location']."','".$_POST['Rate']."','".$_POST['Toll']."','".$_POST['Rent']."','".$_POST['Ledger']."','".$_POST['Petrol']."','".$_POST['InHand']."','".$_POST['date']."')";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;
				case 'deleteVanLedgerEntry':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}


						$qry = "DELETE FROM `vanledger` WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'deleteLedgerEntry':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}


						$qry = "DELETE FROM `Ledgers_bill` WHERE `id` = '".$_POST['id']."'";
						echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'addPettyCash':
								if(!isset($_SESSION['mppt_admin']))
								{
									header('location: index.php');
								}
								$qry = "INSERT INTO `expences`(`id`, `acc_id`, `date`, `description`, `amount`) VALUES (NULL,'-1','".$_POST['date']."','".$_POST['desc']."','".$_POST['amount']."')";
								//echo $qry;
								mysqli_query($con,$qry) or die(mysqli_error($con));
								echo "1";
								break;

				case 'addLPayment':
								if(!isset($_SESSION['mppt_admin']))
								{
									header('location: index.php');
								}
								$qry = "INSERT INTO `Ledgers_bill`(`id`, `ref`, `amount`, `date`,`bill`,`particular`) VALUES (NULL,'".$_POST['account']."','".$_POST['amount']."','".$_POST['date']."','0','".$_POST['particular']."')";
								//echo $qry;
								mysqli_query($con,$qry) or die(mysqli_error($con));
								echo "1";
								break;
				case 'addexpaccount':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "INSERT INTO `expAccounts`(`id`, `name`,`parent`) VALUES (NULL,'".$_POST['name']."','".$_POST['id']."')";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'addledgeraccount':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "INSERT INTO `Ledgers`(`id`, `name`) VALUES (NULL,'".$_POST['name']."')";
						//echo $qry;`
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;
				case 'addvendor':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "INSERT INTO `vendor`(`id`, `name`, `contact`, `address`) VALUES (NULL,'".$_POST['name']."','".$_POST['contact']."','".$_POST['addr']."')";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;
				case 'getsalerep':
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['customer']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$qry2 = "SELECT * FROM `employee` WHERE `id` = '".$data['saleRep']."'";
						$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
						if(mysqli_num_rows($run2) > 0)
						{
							$data2 = mysqli_fetch_array($run2);
							echo $data2['name'];
						}

					}
					break;
				case 'getrateby':
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['customer']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						echo $data['rateBy'];
					}
					break;

				case 'getpaymentmethod':
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['customer']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						echo $data['paymentMethod'];
					}
					break;

				case 'getlastinvoicestatus':
					$anyBill = 0;
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['customer']."'";

					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						if($data['paymentMethod'] == "0")
						{
							echo "-1";
							break;
						}

						$qry = "SELECT * FROM `invoice` WHERE `customer` = '".$data['id']."'  order by `no` DESC LIMIT 1";
						//echo $qry;
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						$data = mysqli_fetch_array($run);
						//echo $data['rateby'];
						$invoice_no = $data['no'];
						$qry2 = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$data['id']."'";
						//echo $qry2;
						$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
						$total_weight = 0;
						$total_rate = 0;
						$total_blockCharges = 0;
						$total_otherCharges = 0;
						$total_ = 0;
						while($row2 = mysqli_fetch_array($run2))
						{
							$total_weight += intval($row2['weices']);
							$total_rate += intval($row2['rate']);

							if($row2['exp_name'] == "Block") {
								$total_blockCharges += intval($row2['charges']);
							}
							else {
								$total_otherCharges += intval($row2['charges']);
							}
							$total_here = intval($row2['weices']) * intval($row2['rate']) + intval($row2['charges']);
							$total_ += $total_here;

							$advance = intval($row['advance']);
							$qry2 = "SELECT * FROM `payments_recv` WHERE `inv_no` = '".$invoice_no."'";
							//echo $qry2;
							$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
							$total_amount = 0;
							while($row2 = mysqli_fetch_array($run2))
							{
								$total_amount += intval($row2['amount']);
							}

							$qry2 = "SELECT * FROM `customers` WHERE `id` = '".$row['customer']."'";
							$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
							$row2 = mysqli_fetch_array($run2);



							if($total_ - $advance - $total_amount > 0)
							{
								$anyBill = 1;
							}
						}
					}
					echo $anyBill;



					break;
				case 'addpayable':
					$dataCount = intval($_POST['dataCount']);
					$month = intval($_POST['month']);
					$year = intval($_POST['year']);
					for($i = 1;$i <= $dataCount;$i++)
						{
							$data = json_decode($_POST['data_'.$i], true);
							//echo $_POST['data_'.$i].'\n';
							$name = $data['name'];
							$amount = $data['amount'];

							$qry = "SELECT * FROM `monthPayable` WHERE `name` = '$name' and `month` = '$month' and `year` = '$year'";
							//echo $qry.'\n';
							$run = mysqli_query($con,$qry) or die(mysqli_error($con));
							//echo mysqli_num_rows($run).'\n';
							if(mysqli_num_rows($run) < 1)
							{
								$qry = "INSERT INTO `monthPayable`(`id`, `name`, `amount`, `month`, `year`) VALUES (NULL,'$name','$amount','$month','$year')";
								//echo $qry.'\n';
								mysqli_query($con,$qry) or die(mysqli_error($con));
							}
							else {
								$data = mysqli_fetch_array($run);
								$id = $data['id'];
								if(!strcmp($amount,'0')) {
									$qry = "DELETE FROM `monthPayable` WHERE `id` = '$id'";
								}
								else {
								$qry = "UPDATE `monthPayable` SET `name` = '$name', `amount` = '$amount' WHERE `id` = '$id'";
								}
								//echo $qry.'\n';
								mysqli_query($con,$qry) or die(mysqli_error($con));
							}

							//echo $data['size'];
						}
					break;

				case 'addinvoice':
					$dataCount = intval($_POST['data_count']);

					//Getting customer id
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['cName']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$cId = $data['id'];
						$ldRate = $data['ldRate'];
						$hdRate = $data['hdRate'];
					}



					//Getting saleRep id
					$qry = "SELECT * FROM `employee` WHERE `name` = '".$_POST['saleRep']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$sRepId = $data['id'];
					}


					$qry = "INSERT INTO `invoice`(`no`,`id`, `customer`, `salerep`, `date`, `rateby`,`paymentTime`,`ldRate`,`hdRate`) VALUES (NULL,'".$_POST['refNo']."','".$cId."','".$sRepId."','".$_POST['date']."','".$_POST['weices']."','".$_POST['paymentTime']."','".$ldRate."','".$hdRate."')";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));

						$qry = "SELECT * FROM `invoice` WHERE `id` = '".$_POST['refNo']."' order by `no` DESC LIMIT 1";

						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0)
						{
							$data = mysqli_fetch_array($run);
							$inv_no = $data['no'];
						}

						if(intval($_POST['advance']) > 0) {
							$qry = "INSERT INTO `payments_recv`(`id`, `customer`, `receiver`, `inv_no`, `ref_no`, `amount`, `entry_date`, `rec_date`,`advance`) VALUES (NULL,'".$cId."','1','".$inv_no."','".$_POST['refNo']."007','".$_POST['advance']."','".date('Y-m-d')."','".$_POST['date']."','1')";
							$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						}

						for($i = 1;$i <= $dataCount;$i++)
						{
							$data = json_decode($_POST['data_'.$i], true);
							$qry = "INSERT INTO `invoice_detail`(`id`, `ref`, `size`,`material`,`exp_name`, `charges`, `weices`, `rate`, `bag`) VALUES (NULL,'".$inv_no."','".$data['size']."','".$data['mat']."','".$data['type']."','".$data['charges']."','".$data['weices']."','".$data['rate']."','".$data['bag']."')";
							//echo $qry;
							mysqli_query($con,$qry) or die(mysqli_error($con));
							//echo $data['size'];
						}
						echo $inv_no;

					break;

				case 'addbill':
					$dataCount = intval($_POST['data_count']);

					//Getting customer id
					$qry = "SELECT * FROM `vendor` WHERE `name` = '".$_POST['vendor']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$vId = $data['id'];
					}



					$qry = "INSERT INTO `bill`(`id`,`ref`, `vendor`, `date`) VALUES (NULL,'".$_POST['refNo']."','".$vId."','".$_POST['date']."')";
					mysqli_query($con,$qry) or die(mysqli_error($con));
					$qry = "SELECT id FROM `bill` WHERE 1 order by id DESC";
					$result = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $billIdNew = mysqli_fetch_array($result)['id'];
					for($i = 1;$i <= $dataCount;$i++)
					{


						$data = json_decode($_POST['data_'.$i], true);
						//Getting saleRep id
						$qry = "SELECT * FROM `customers` WHERE `name` = '".$data['billName']."'";
						$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run2) > 0)
						{
							$data2 = mysqli_fetch_array($run2);
							$billerId = $data2['id'];
						}
						$qry = "INSERT INTO `bill_detail`(`id`, `ref`,`ref2`, `biller_id`,`particular`, `weices`, `rate`) VALUES (NULL,'".$billIdNew."','".$data['ref2']."','".$billerId."','".$data['particular']."','".$data['weices']."','".$data['rate']."')";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						//echo $data['size'];
					}
					echo "1";
					break;

				case 'updatebill':
					$dataCount = intval($_POST['data_count']);

					//Getting customer id
					$qry = "SELECT * FROM `vendor` WHERE `name` = '".$_POST['vendor']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$vId = $data['id'];
					}



					$qry = "UPDATE `bill` SET `ref`='".$_POST['refNo']."',`vendor`='".$vId."',`date`='".$_POST['date']."' WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					//mysqli_query($con,$qry) or die(mysqli_error($con));

					for($i = 1;$i <= $dataCount;$i++)
					{


						$data = json_decode($_POST['data_'.$i], true);

						//Getting saleRep id
						$qry = "SELECT * FROM `customers` WHERE `name` = '".$data['billName']."'";
						$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run2) > 0)
						{
							$data2 = mysqli_fetch_array($run2);
							$billerId = $data2['id'];
						}

						$data = json_decode($_POST['data_'.$i], true);
						$qry = "SELECT * FROM `bill_detail` WHERE `ref` = '".$_POST['id']."'";
						//echo $qry;
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0) {
							$qry = "UPDATE `bill_detail` SET `ref`='".$_POST['id']."',`ref2`='".$data['ref2']."',`biller_id` = '".$billerId."',`particular` = '".$data['particular']."',`weices` = '".$data['weices']."',`rate` = '".$data['rate']."' WHERE `id` = '".$data['id']."'";
							//echo $qry;
							mysqli_query($con,$qry) or die(mysqli_error($con));
						}
						else
						{
							$qry = "INSERT INTO `bill_detail`(`id`, `ref`,`ref2`, `biller_id`,`particular`, `weices`, `rate`) VALUES (NULL,'".$_POST['id']."','".$data['ref2']."','".$billerId."','".$data['particular']."','".$data['weices']."','".$data['rate']."')";
							//echo $qry;
							mysqli_query($con,$qry) or die(mysqli_error($con));
							//echo $data['size'];
						}
					}
					echo "1";
					break;


				case 'updateinvoice':
					$dataCount = intval($_POST['data_count']);

					//Getting customer id
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['cName']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$cId = $data['id'];

					}


					//Getting saleRep id
					$qry = "SELECT * FROM `employee` WHERE `name` = '".$_POST['saleRep']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						$sRepId = $data['id'];
						$ldRate = $data['ldRate'];
						$hdRate = $data['hdRate'];
					}
					$qry = "UPDATE `invoice` SET `id`='".$_POST['refNo']."',`customer`='".$cId."',`salerep`='".$sRepId."',`date`='".$_POST['date']."',`rateby`='".$_POST['weices']."',`paymentTime`='".$_POST['paymentTime']."',`ldRate`='".$ldRate."',`hdRate`='".$hdRate."' WHERE no = '".$_POST['oldNo']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));


					$no = $_POST['oldNo'];

					if(intval($_POST['advance']) > 0) {
						$qry = "SELECT * FROM payments_recv WHERE advance = 1 and inv_no = '".$no."'";

						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0) {
							$row = mysqli_fetch_array($run);
							$pid = $row['id'];

							$qry = "UPDATE `payments_recv` SET `customer`='".$cId."',`receiver`='1',`inv_no`='".$no."',`amount`='".$_POST['advance']."',`ref_no`='".$_POST['refNo']."007',`entry_date`='".$_POST['date']."',`rec_date`='".$_POST['paymentTime']."' WHERE id = '".$pid."'";

							$run = mysqli_query($con,$qry) or die(mysqli_error($con));
							//echo $qry;
						}
						else
						{

							$qry = "INSERT INTO `payments_recv`(`id`, `customer`, `receiver`, `inv_no`, `ref_no`, `amount`, `entry_date`, `rec_date`,`advance`) VALUES (NULL,'".$cId."','1','".$no."','".$_POST['refNo']."007','".$_POST['advance']."','".date('Y-m-d')."','".$_POST['date']."','1')";
							$run = mysqli_query($con,$qry) or die(mysqli_error($con));
							//echo $qry;
						}
					}
					if(intval($_POST['advance']) == 0)
					{
						$qry = "SELECT * FROM payments_recv WHERE advance = 1 and inv_no = '".$no."'";

						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0) {
							$row = mysqli_fetch_array($run);
							$pid = $row['id'];
							$qry = "DELETE FROM `payments_recv` WHERE id = '".$pid."'";
							//echo $qry;
							$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						}
					}
					
					for($i = 1;$i <= $dataCount;$i++)
					{
						$data = json_decode($_POST['data_'.$i], true);
						$qry = "SELECT * FROM `invoice_detail` WHERE `id` = '".$data['id']."'";
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0) {
							$qry = "UPDATE `invoice_detail` SET `size`='".$data['size']."',`material`='".$data['mat']."',`exp_name`='".$data['type']."',`charges`='".$data['charges']."',`weices`='".$data['weices']."',`rate`='".$data['rate']."',`bag`='".$data['bag']."' WHERE `id` = '".$data['id']."'";
							//echo $qry;
							mysqli_query($con,$qry) or die(mysqli_error($con));
						}
						else
						{
							$qry = "INSERT INTO `invoice_detail`(`id`, `ref`, `size`,`material`,`exp_name`, `charges`, `weices`, `rate`, `bag`) VALUES (NULL,'".$no."','".$data['size']."','".$data['mat']."','".$data['type']."','".$data['charges']."','".$data['weices']."','".$data['rate']."','".$data['bag']."')";
							//echo $qry;
							mysqli_query($con,$qry) or die(mysqli_error($con));
						}
						//echo $data['size'];
					}
					echo "1";
					break;

				case 'addpayment':
					//echo $_POST['Customer'];
					$qry = "SELECT * FROM `customers` WHERE `name` = '".mysqli_real_escape_string($con,$_POST['Customer'])."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$custId = $data['id'];
					$qry = "SELECT * FROM `employee` WHERE `name` = '".mysqli_real_escape_string($con,$_POST['Receiver'])."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$recId = $data['id'];
					$qry = "INSERT INTO `payments_recv`(`id`, `customer`, `receiver`, `inv_no`, `ref_no`, `amount`, `entry_date`, `rec_date`,`advance`,`payMethod`,`checkNo`)
									VALUES (NULL,'".$custId."','".$recId."','".$_POST['invNo']."','".$_POST['refNo']."','".$_POST['Amount']."','".$_POST['todaysDate']."',
									'".$_POST['Date']."','0','".$_POST['payMethod']."','".$_POST['checkNo']."')";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";

					break;

				case 'paypayment':
					$qry = "SELECT * FROM `vendor` WHERE `name` = '".$_POST['Vendor']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$custId = $data['id'];
					$qry = "SELECT * FROM `employee` WHERE `name` = '".$_POST['Payer']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$recId = $data['id'];
					$qry = "INSERT INTO `payments_paid`(`id`, `vendor`, `payer`, `bill_no`, `ref_no`, `amount`, `entry_date`, `paid_date`) VALUES (NULL,'".$custId."','".$recId."','".$_POST['billNo']."','".$_POST['refNo']."','".$_POST['Amount']."','".$_POST['todaysDate']."','".$_POST['Date']."')";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";

					break;

				case 'updatepayment':
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['Customer']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$custId = $data['id'];
					$qry = "SELECT * FROM `employee` WHERE `name` = '".$_POST['Receiver']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$recId = $data['id'];

					$qry = "UPDATE `payments_recv` SET `customer`='".$custId."',`receiver`='".$recId."',`inv_no`='".$_POST['invNo']."',`ref_no`='".$_POST['refNo']."',`amount`='".$_POST['Amount']."',
									`entry_date`='".$_POST['todaysDate']."',`rec_date`='".$_POST['Date']."',payMethod
									= '".$_POST['payMethod']."',checkNo = '".$_POST['checkNo']."' WHERE `id` = '".$_POST['id']."'";

					//echo $qry;
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";

					break;

				case 'updatepaypayment':
					$qry = "SELECT * FROM `vendor` WHERE `name` = '".$_POST['Vendor']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$custId = $data['id'];
					$qry = "SELECT * FROM `employee` WHERE `name` = '".$_POST['Payer']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$recId = $data['id'];

					$qry = "UPDATE `payments_paid` SET `vendor`='".$custId."',`payer`='".$recId."',`bill_no`='".$_POST['billNo']."',`ref_no`='".$_POST['refNo']."',`amount`='".$_POST['Amount']."',`entry_date`='".$_POST['todaysDate']."',`paid_date`='".$_POST['Date']."' WHERE `id` = '".$_POST['id']."'";

					//echo $qry;
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";

					break;

				case 'getadvance':
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['customer']."'";
					$run0 = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run0) > 0)
					{
						$data0 = mysqli_fetch_array($run0);
						$payment = 0;
						$bill = 0;
						$qry = "SELECT * FROM `invoice` WHERE `customer` = '".$data0['id']."'";
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						while($data = mysqli_fetch_array($run))
						{
							$qry = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$data['id']."'";
							$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));

							while($data2 = mysqli_fetch_array($run2))
							{
								if($data2['exp_name'] != "--") {
									$bill += intval($data2['charges']);
								}
								else
								{
									$bill += intval($data2['weices']) * intval($data2['rate']);
								}
							}

							$qry = "SELECT * FROM `payments_recv` WHERE `inv_no` = '".$data['no']."'";
							$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));

							while($data2 = mysqli_fetch_array($run2))
							{
								$payment += intval($data2['amount']);
							}
						}
						$advance = intval($data0['opening_balance']) + $payment - $bill;
						if($advance < 0)
							$advance = "0";
						echo $advance;
					}
					break;
				case 'getlastinv':
					$qry = "SELECT * FROM `customers` WHERE `name` = '".$_POST['customer']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$custId = $data['id'];
					$qry = "SELECT * FROM `invoice` WHERE `customer` = '$custId' order by `no` DESC limit 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						echo $data['no'];
					}
					break;
				case 'getlastbill':
					$qry = "SELECT * FROM `vendor` WHERE `name` = '".$_POST['vendor']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);
					$custId = $data['id'];
					//echo $custId;
					$qry = "SELECT * FROM `bill` WHERE `vendor` = '$custId' order by `id` DESC limit 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run) > 0)
					{
						$data = mysqli_fetch_array($run);
						echo $data['id'];
					}
					break;
				case 'addsize':
					$qry = "INSERT INTO `sizes`(`id`, `size`) VALUES (NULL,'".$_POST['size']."')";
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;
				case 'deletesize':
					$qry = "DELETE FROM `sizes` WHERE `id` = '".$_POST['id']."'";
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;


				case 'addemployee':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "INSERT INTO `employee`(`id`, `name`, `contact`, `address`,`ldRate`,`hdRate`,`salary`) VALUES (NULL,'".$_POST['name']."','".$_POST['contact']."','".$_POST['addr']."','".$_POST['ldRate']."','".$_POST['hdRate']."','".$_POST['salary']."')";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;

				case 'updateexpaccount':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "UPDATE `expAccounts` SET `name`='".$_POST['name']."' WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'updateLaccount':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "UPDATE `Ledgers` SET `name`='".$_POST['name']."' WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'updatecustomer':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "SELECT * FROM `employee` WHERE `name` = '".$_POST['saleRep']."'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$data = mysqli_fetch_array($run);

					$qry = "UPDATE `customers` SET `name`='".$_POST['name']."',`contact`='".$_POST['contact']."',`address`='".$_POST['addr']."',`saleRep`='".$data['id']."',`opening_balance`='".$_POST['opening_balance']."',ldRate = '".$_POST['ldRate']."', hdRate = '".$_POST['hdRate']."' WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					if (strcmp($_POST['updateOldInv'],"true") === 0)
					{
						$qry2 = "UPDATE invoice SET salerep = '".$data['id']."' WHERE customer = '".$_POST['id']."'";
						mysqli_query($con,$qry2) or die(mysqli_error($con));
					}
					if (strcmp($_POST['updateRateOldInv'],"true") === 0)
					{
						$qry2 = "UPDATE invoice SET ldRate = '".$_POST['ldRate']."', hdRate = '".$_POST['hdRate']."' WHERE customer = '".$_POST['id']."'";
						mysqli_query($con,$qry2) or die(mysqli_error($con));
						//echo $qry2;
					}
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;

				case 'updateExpence':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "UPDATE `expences` SET `acc_id`='".$_POST['account']."',`date`='".$_POST['date']."',`description`='".$_POST['desc']."',`amount`='".$_POST['amount']."' WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;


				case 'updateLBill':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "UPDATE `Ledgers_bill` SET `date`='".$_POST['date']."',`particular`='".$_POST['particular']."',`amount`='".$_POST['amount']."' WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;



				case 'updatePettyCash':
								if(!isset($_SESSION['mppt_admin']))
								{
									header('location: index.php');
								}
								$qry = "UPDATE `expences` SET `date`='".$_POST['date']."',`description`='".$_POST['desc']."',`amount`='".$_POST['amount']."' WHERE `id` = '".$_POST['id']."'";
								//echo $qry;
								mysqli_query($con,$qry) or die(mysqli_error($con));
								echo "1";
								break;

				case 'updatevendor':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "UPDATE `vendor` SET `name`='".$_POST['name']."',`contact`='".$_POST['contact']."',`address`='".$_POST['addr']."' WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;

				case 'updateemployee':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "UPDATE `employee` SET `name`='".$_POST['name']."',`contact`='".$_POST['contact']."',`address`='".$_POST['addr']."',`ldRate`='".$_POST['ldRate']."',`hdRate`='".$_POST['hdRate']."',`salary`='".$_POST['salary']."' WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;

				case 'deletecustomer':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "DELETE FROM `customers` WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));

					echo "1";
					break;


				case 'deleteinvoice':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "DELETE FROM `invoice` WHERE `no` = '".$_POST['id']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;


				case 'deletepayment':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "DELETE FROM `payments_recv` WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;


				case 'deleteExpence':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "DELETE FROM `expences` WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;


				case 'deleteLBill':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "DELETE FROM `Ledgers_bill` WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;


				case 'deleteexpaccount':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "DELETE FROM `expAccounts` WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'deleteLaccount':
						if(!isset($_SESSION['mppt_admin']))
						{
							header('location: index.php');
						}
						$qry = "DELETE FROM `Ledgers` WHERE `id` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						$qry = "DELETE FROM `Ledgers_bill` WHERE `ref` = '".$_POST['id']."'";
						//echo $qry;
						mysqli_query($con,$qry) or die(mysqli_error($con));
						echo "1";
						break;

				case 'deletevendor':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "DELETE FROM `vendor` WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;

				case 'deleteemployee':
					if(!isset($_SESSION['mppt_admin']))
					{
						header('location: index.php');
					}
					$qry = "DELETE FROM `employee` WHERE `id` = '".$_POST['id']."'";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;


				case 'update_ceomsg':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}
					$qry = "UPDATE `misc` SET `text` = '".$_POST['text']."' WHERE `misc`.`name` = 'ceo_msg';";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";
					break;

				case 'addadmin':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}
					$qry = "INSERT INTO `admin`(`id`, `fname`, `lname`, `title`, `email`, `password`, `dp`) VALUES (NULL,'".$_POST['fname']."','".$_POST['lname']."','".$_POST['level']."','".$_POST['email']."','".md5($_POST['pass'])."','male.png')";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					header("location: index.php?page=admins");
					break;

				case 'deleteaccount':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}
					$qry = "DELETE FROM `admin` WHERE `id` = '".$_GET['id']."'";
					mysqli_query($con,$qry) or die(mysqli_error($con));
					header("location: index.php?page=admins");
					break;


				case 'updatePaymentTable':
					$filter_qry = "";
					$year = $_POST['year'];
					$month = $_POST['month'];
					if(isset($_POST['f_inv'])) $filter_qry .= "and `inv_no` LIKE '".$_POST['f_inv']."%'";
					if(isset($_POST['f_ref'])) $filter_qry .= "and `ref_no` LIKE '".$_POST['f_ref']."%'";
					if(isset($_POST['f_edate'])) $filter_qry .= "and `entry_date` LIKE '".$_POST['f_edate']."%'";
					if(isset($_POST['f_customer'])) $filter_qry .= "and c.name LIKE '%".$_POST['f_customer']."%'";
					if(isset($_POST['f_receiver'])) $filter_qry .= "and e.name LIKE '%".$_POST['f_receiver']."%'";
					if(isset($_POST['f_rdate'])) $filter_qry .= "and `rec_date` LIKE '".$_POST['f_rdate']."%'";
					if(isset($_POST['f_amount'])) $filter_qry .= "and `amount` LIKE '".$_POST['f_amount']."%'";

					if(isset($_POST['f_paymentOnly']))
						$filter_qry .= "and `advance` = '0'";

					if(isset($_POST['f_advanceOnly']))
						$filter_qry .= "and `advance` = '1'";


					if(intval($year) != 0) $qry = "SELECT p.id,p.ref_no,p.inv_no,p.advance,p.payMethod,c.name as cname,e.name as ename,p.amount,p.rec_date,p.entry_date FROM `payments_recv` p,customers c,employee e WHERE p.customer = c.id and p.receiver = e.id and rec_date > '$year-$month-01' and rec_date < '$year-$month-31' ".$filter_qry." order by `".$_POST['orderBy']."` ";
					else $qry = "SELECT p.id,p.ref_no,p.inv_no,p.advance,p.payMethod,c.name as cname,e.name as ename,p.amount,p.rec_date,p.entry_date FROM `payments_recv` p,customers c,employee e WHERE p.customer = c.id and p.receiver = e.id ".$filter_qry." order by `".$_POST['orderBy']."` ";
					//echo $qry;
					$count = 0;
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					while($data = mysqli_fetch_array($run))
					{

					if($count++ % 2 == 0) $color = "rgba(0,0,0,0.05);";
					else $color = "rgba(0,0,0,0.15);";
					?>
					<div class="row" id="inv_data"
					<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/payment_update.php') !== false) { ?>
					onclick="viewPayment('<?php echo $data['id'] ?>')" <?php } ?> style="background-color:<?php echo $color; ?>;width:95%;position:relative;margin:0 auto;">
					    <div class="col-sm-1 no-border" style="border:1px solid black;"><?php echo $count; ?></div>
					    <div class="col-sm-1 no-border" style="border:1px solid black;"><?php if(intval($data['advance']) == 0) echo "PY-"; else echo "AD-"; echo $data['id'];  if(intval($data['payMethod']) == 1) echo " (CHECK)"; ?></div>
					    <div class="col-sm-1 no-border" style="border:1px solid black;"><?php echo $data['ref_no']; ?></div>
					    <div class="col-sm-1 no-border" style="border:1px solid black;">INV-<?php echo $data['inv_no']; ?></div>
					    <div class="col-sm-2 no-border" style="border:1px solid black;"><?php echo $data['cname']; ?></div>
					    <div class="col-sm-2 no-border" style="border:1px solid black;"><?php echo $data['ename']; ?></div>
					    <div class="col-sm-1 no-border" style="border:1px solid black;"><?php echo $data['rec_date']; ?></div>
					    <div class="col-sm-1 no-border" style="border:1px solid black;"><?php echo $data['entry_date']; ?></div>
					    <div class="col-sm-2 no-border" style="border:1px solid black;">Rs. <?php echo $data['amount']; ?></div>
					</div>
					<?php
					}
					break;

				case 'updatePaidPaymentTable':
					$filter_qry = "";
					if(isset($_POST['f_bill'])) $filter_qry .= "and `nill_no` LIKE '".$_POST['f_inv']."%'";
					if(isset($_POST['f_ref'])) $filter_qry .= "and `ref_no` LIKE '".$_POST['f_ref']."%'";
					if(isset($_POST['f_edate'])) $filter_qry .= "and `entry_date` LIKE '".$_POST['f_edate']."%'";
					if(isset($_POST['f_vendor'])) $filter_qry .= "and v.name LIKE '".$_POST['f_vendor']."%'";
					if(isset($_POST['f_payer'])) $filter_qry .= "and e.name LIKE '".$_POST['f_payer']."%'";
					if(isset($_POST['f_pdate'])) $filter_qry .= "and `paid_date` LIKE '".$_POST['f_pdate']."%'";
					if(isset($_POST['f_amount'])) $filter_qry .= "and `amount` LIKE '".$_POST['f_amount']."%'";



					$qry = "SELECT p.id,p.ref_no,p.bill_no,v.name as vname,e.name as ename,p.amount,p.paid_date,p.entry_date FROM `payments_paid` p,vendor v,employee e WHERE p.vendor = v.id and p.payer = e.id ".$filter_qry." order by `".$_POST['orderBy']."` ";
					//echo $qry;
					$count = 0;
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					while($data = mysqli_fetch_array($run))
					{

					if($count++ % 2 == 0) $color = "rgba(0,0,0,0.05);";
					else $color = "rgba(0,0,0,0.15);";
					?>
					<div class="row" id="inv_data"
					<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/payment_update.php') !== false) { ?>
					onclick="viewPayment('<?php echo $data['id'] ?>')" <?php } ?> style="background-color:<?php echo $color; ?>;width:95%;position:relative;margin:0 auto;">
					    <div class="col-sm-1 no-border"><?php echo $count; ?></div>
					    <div class="col-sm-1 no-border"><?php echo "PD-"; echo $data['id']; ?></div>
					    <div class="col-sm-1 no-border"><?php echo $data['ref_no']; ?></div>
					    <div class="col-sm-1 no-border">Bill-<?php echo $data['bill_no']; ?></div>
					    <div class="col-sm-2 no-border"><?php echo $data['vname']; ?></div>
					    <div class="col-sm-2 no-border"><?php echo $data['ename']; ?></div>
					    <div class="col-sm-1 no-border"><?php echo $data['paid_date']; ?></div>
					    <div class="col-sm-1 no-border"><?php echo $data['entry_date']; ?></div>
					    <div class="col-sm-2 no-border">Rs. <?php echo $data['amount']; ?></div>
					</div>
					<?php
					}
					break;

				case 'updateCustomerTable':

					$filter_qry = "";
					if(isset($_POST['f_id'])) $filter_qry .= "and `id` LIKE '".$_POST['f_id']."%'";
					if(isset($_POST['f_name'])) $filter_qry .= "and `name` LIKE '%".$_POST['f_name']."%'";
					if(isset($_POST['f_contact'])) $filter_qry .= "and `contact` LIKE '".$_POST['f_contact']."%'";
					if(isset($_POST['f_addr'])) $filter_qry .= "and `address` LIKE '".$_POST['f_addr']."%'";
					$qry = "SELECT c.* FROM `customers` c WHERE 1 ".$filter_qry." order by `".$_POST['orderBy']."`";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$count = 1;

					while($row = mysqli_fetch_array($run))
					{
						$id = $row['id'];


						$qry = "SELECT * FROM employee WHERE id = '".$row['saleRep']."'";
						$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$saleRepName = "NONE";
						if(mysqli_num_rows($run2) > 0)
						{
							$emp = mysqli_fetch_array($run2);
							$saleRepName = $emp['name'];
						}

						$open_balance = $row['opening_balance'];
						$total_balance = $open_balance;
						$qry = "DELETE FROM `tmp` WHERE 1 ";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						$qry = "INSERT INTO tmp (id,ref,date,amount,type)
						SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.no,i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.no = idd.ref GROUP BY idd.ref ) sub, invoice i,customers c WHERE i.no = sub.no and c.id = i.customer and c.id = '".$id."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						$qry = "INSERT INTO tmp (id,ref,date,amount,type)
						SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv WHERE `customer` = '".$id."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						$qry = "SELECT * FROM tmp";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$prev_inv_no = 0;
						while($data = mysqli_fetch_array($run3))
						{

						if($data['type'] == "invoice") {  if($prev_inv_no !== $data['id']) { $total_balance += floatval($data['amount']); } $prev_inv_no = $data['id']; }
						else if($data['type'] == "pay") { $prev_inv_no = 0;  $total_balance -= floatval($data['amount']); }

						}
							if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
						else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';


						$qry = "SELECT * FROM `invoice` WHERE `customer` = '".$row['id']."' order by no DESC LIMIT 1";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$data = mysqli_fetch_array($run3);
						$inv_result = mysqli_num_rows($run3);
						$inv_date = $data['date'];
						$qry = "SELECT SUM(charges + weices * rate) as tot FROM invoice_detail WHERE ref = '".$data['no']."' GROUP BY ref";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$data = mysqli_fetch_array($run3);
						$tot = $data['tot'];

						$qry = "SELECT * FROM `payments_recv` WHERE `customer` = '".$row['id']."' order by id DESC LIMIT 1";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$data = mysqli_fetch_array($run3);
						$pay_result = mysqli_num_rows($run3);
						$pay_date = $data['rec_date'];
						$pay_amount = $data['amount'];



						?>
						<div onclick='pageLoad("customers/customer_ledger.php?id=<?php echo $id; ?>")'>
						<div class="col-md-1" style="border:1px solid black;"><?php echo $count++; ?></div>
						<div class="col-md-1" style="border:1px solid black;"><?php echo "MPC-".$row['id']; ?></div>
						<div class="col-md-2" style="border:1px solid black;"><?php if(strlen($row['name']) > 13) echo substr($row['name'],0,13)."..."; else echo $row['name']; ?></div>
						<div class="col-md-1" style="border:1px solid black;""><?php if(strlen($saleRepName) > 13) echo substr($saleRepName,0,13)."..."; else echo  $saleRepName; ?></div>
						<div class="col-md-2" style="border:1px solid black;<?php
							if(strcmp($inv_date,date("Y-m-d")) == 0)
							{
								echo "font-weight:bold;color:white;background-color:black;";
							}
						 	?>"><?php if($inv_result > 0) echo "Rs. ".round( $tot, 2, PHP_ROUND_HALF_EVEN)." (".$inv_date.")"; else echo "--"; ?></div>
						<div class="col-md-2" style="border:1px solid black<?php
							if(strcmp($pay_date,date("Y-m-d")) == 0)
							{
								echo "font-weight:bold;color:white;background-color:black;";
							}
						 	?>;"><?php if($pay_result > 0) echo "Rs. ".round( $pay_amount, 2, PHP_ROUND_HALF_EVEN)." (".$pay_date.")"; else echo "--"; ?></div>
						<div class="col-md-2" style="border:1px solid black;">Rs. <?php echo round( $total_balance, 2, PHP_ROUND_HALF_EVEN); ?></div>
						</div>

						<div class="col-md-1" style="border:1px solid black;">
						<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/edit.php') !== false) { ?>
						<a href="javascript:void()" onclick='pageLoad("customers/edit.php?id=<?php echo $id; ?>")'>Edit</a>
						<?php } else echo "N/A"; ?>
						</div>
						</div>
						<?php
					}

					break;

					case 'updateVendorTable':

						$filter_qry = "";
						if(isset($_POST['f_id'])) $filter_qry .= "and `id` LIKE '".$_POST['f_id']."%'";
						if(isset($_POST['f_name'])) $filter_qry .= "and `name` LIKE '".$_POST['f_name']."%'";
						if(isset($_POST['f_contact'])) $filter_qry .= "and `contact` LIKE '".$_POST['f_contact']."%'";
						if(isset($_POST['f_addr'])) $filter_qry .= "and `address` LIKE '".$_POST['f_addr']."%'";
						$qry = "SELECT * FROM `vendor` WHERE 1 ".$filter_qry." order by `".$_POST['orderBy']."`";
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						$count = 1;

						while($row = mysqli_fetch_array($run))
						{
							$id = $row['id'];
							if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
							else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
							?>
							<div onclick='pageLoad("vendors/vendor_ledger.php?id=<?php echo $id; ?>")'>
							<div class="col-md-1"><?php echo $count++; ?></div>
							<div class="col-md-1"><?php echo "MPC-".$row['id']; ?></div>
							<div class="col-md-3"><?php echo $row['name']; ?></div>
							<div class="col-md-2"><?php echo $row['contact']; ?></div>
							<div class="col-md-4"><?php echo $row['address']; ?></div>
							</div>
							<div class="col-md-1">
							<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/edit.php') !== false) { ?>
							<a href="javascript:void()" onclick='pageLoad("vendors/edit.php?id=<?php echo $id; ?>")'>Edit</a><?php } else echo "N/A"; ?></div>
							</div>
							<?php
						}

						break;

				case 'updateExpencesTable':

						$filter_qry = "";
						$year = $_POST['year'];
						$month = $_POST['month'];
						if(isset($_POST['f_id'])) $filter_qry .= "and e.id LIKE '".$_POST['f_id']."%'";
						if(isset($_POST['f_name'])) $filter_qry .= "and a.name LIKE '".$_POST['f_name']."%'";
						if(isset($_POST['f_description'])) $filter_qry .= "and e.description LIKE '".$_POST['f_description']."%'";
						if(isset($_POST['f_amount'])) $filter_qry .= "and e.amount LIKE '".$_POST['f_amount']."%'";
						if(intval($year) == 0) $qry = "SELECT e.*,a.name FROM `expences` e,`expAccounts` a WHERE e.acc_id = a.id and e.acc_id != '-1' ".$filter_qry." order by `".$_POST['orderBy']."`";
						else $qry = "SELECT e.*,a.name FROM `expences` e,`expAccounts` a WHERE e.date >= '$year-$month-01' and e.date <= '$year-$month-31' and e.acc_id = a.id and e.acc_id != '-1' ".$filter_qry." order by `".$_POST['orderBy']."`";
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						$count = 1;

						while($row = mysqli_fetch_array($run))
						{
							$id = $row['id'];
							if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
							else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
							?>
							<div class="col-md-1"><?php echo $count++; ?></div>
							<div class="col-md-1"><?php echo "MPC-".$row['id']; ?></div>
							<div class="col-md-3"><?php echo $row['name']; ?></div>
							<div class="col-md-2"><?php echo $row['amount']; ?></div>
							<div class="col-md-4"><?php echo $row['description']; ?></div>
							<div class="col-md-1"><a href="javascript:void()" onclick='pageLoad("expences/edit.php?id=<?php echo $id; ?>")'>Edit</a></div>
							</div>
							<?php
						}

						break;


					case 'updateLBillsTable':

						$filter_qry = "";
						if(isset($_POST['f_id'])) $filter_qry .= "and e.id LIKE '".$_POST['f_id']."%'";
						if(isset($_POST['f_name'])) $filter_qry .= "and a.name LIKE '".$_POST['f_name']."%'";
						if(isset($_POST['f_amount'])) $filter_qry .= "and e.amount LIKE '".$_POST['f_amount']."%'";
						$qry = "SELECT e.*,a.name FROM `Ledgers_bill` e,`Ledgers` a WHERE e.ref = a.id and e.bill = '1' ".$filter_qry." order by `".$_POST['orderBy']."`";
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						$count = 1;

						while($row = mysqli_fetch_array($run))
						{
							$id = $row['id'];
							if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
							else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
							?>
							<div class="col-md-1"><?php echo $count++; ?></div>
							<div class="col-md-2"><?php echo "MPC-".$row['id']; ?></div>
							<div class="col-md-4"><?php echo $row['name']; ?></div>
							<div class="col-md-3"><?php echo $row['amount']; ?></div>
							<div class="col-md-2"><a href="javascript:void()" onclick='pageLoad("ledgers/editbill.php?id=<?php echo $id; ?>")'>Edit</a></div>
							</div>
							<?php
						}

						break;



						case 'updatePettyCashTable':

								$filter_qry = "";
								if(isset($_POST['f_id'])) $filter_qry .= "and `id` LIKE '".$_POST['f_id']."%'";
								if(isset($_POST['f_description'])) $filter_qry .= "and `description` LIKE '".$_POST['f_description']."%'";
								if(isset($_POST['f_amount'])) $filter_qry .= "and `amount` LIKE '".$_POST['f_amount']."%'";
								$qry = "SELECT * FROM `expences` WHERE `acc_id` = '-1' ".$filter_qry." order by `".$_POST['orderBy']."`";
								$run = mysqli_query($con,$qry) or die(mysqli_error($con));
								$count = 1;

								while($row = mysqli_fetch_array($run))
								{
									$id = $row['id'];
									if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
									else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
									?>
									<div class="col-md-1"><?php echo $count++; ?></div>
									<div class="col-md-1"><?php echo "PC-".$row['id']; ?></div>
									<div class="col-md-3"><?php echo $row['amount']; ?></div>
									<div class="col-md-6"><?php echo $row['description']; ?></div>
									<div class="col-md-1"><a href="javascript:void()" onclick='pageLoad("expences/editpc.php?id=<?php echo $id; ?>")'>Edit</a></div>
									</div>
									<?php
								}

								break;

					case 'updateLPaymentTable':

								$filter_qry = "";
								if(isset($_POST['f_id'])) $filter_qry .= "and e.id LIKE '".$_POST['f_id']."%'";
								if(isset($_POST['f_name'])) $filter_qry .= "and a.name LIKE '".$_POST['f_name']."%'";
								if(isset($_POST['f_amount'])) $filter_qry .= "and e.amount LIKE '".$_POST['f_amount']."%'";
								$qry = "SELECT e.*,a.name FROM `Ledgers_bill` e,`Ledgers` a WHERE e.ref = a.id and e.bill = '0' ".$filter_qry." order by `".$_POST['orderBy']."`";
								$run = mysqli_query($con,$qry) or die(mysqli_error($con));
								$count = 1;

								while($row = mysqli_fetch_array($run))
								{
									$id = $row['id'];
									if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
									else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
									?>
									<div class="col-md-1"><?php echo $count++; ?></div>
									<div class="col-md-2"><?php echo "PC-".$row['id']; ?></div>
									<div class="col-md-4"><?php echo $row['name']; ?></div>
									<div class="col-md-3"><?php echo $row['amount']; ?></div>
									<div class="col-md-2"><a href="javascript:void()" onclick='pageLoad("ledgers/editpay.php?id=<?php echo $id; ?>")'>Edit</a></div>
									</div>
									<?php
								}

								break;

					case 'updateAccountTable':

						$filter_qry = "";
						if(isset($_POST['f_id'])) $filter_qry .= "and `id` LIKE '".$_POST['f_id']."%'";
						if(isset($_POST['f_name'])) $filter_qry .= "and `name` LIKE '".$_POST['f_name']."%'";
						if(isset($_POST['pid'])) $filter_qry .= "and `parent` = '".$_POST['pid']."'";
						else $filter_qry .= "and `parent` = '0'";
						$qry = "SELECT * FROM `expAccounts`  WHERE 1 ".$filter_qry." order by `".$_POST['orderBy']."`";

						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						$count = 1;

						while($row = mysqli_fetch_array($run))
						{
							$id = $row['id'];
							$qry = "SELECT SUM(amount) as exp FROM expences WHERE acc_id = '$id' GROUP by acc_id";

							$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
							$exp = 0;
							if(mysqli_num_rows($run2) > 0)
							{
								$data = mysqli_fetch_array($run2);

								$exp += floatval($data['exp']);



							}

							$qry = "SELECT * FROM `expAccounts`  WHERE parent = '$id'";

							$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
							while($data = mysqli_fetch_array($run3))
							{
								$id2 = $data['id'];
								$qry = "SELECT SUM(amount) as exp FROM expences WHERE acc_id = '$id2' GROUP by acc_id";
								$run4 = mysqli_query($con,$qry) or die(mysqli_error($con));
								if(mysqli_num_rows($run4) > 0)
								{
									$data2 = mysqli_fetch_array($run4);
									$exp += floatval($data2['exp']);

								}

							}




							$qry = "SELECT * FROM expAccounts WHERE parent = '$id'";
							$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
							$subAccounts = mysqli_num_rows($run2);

							if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
							else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
							?>
							<div onclick='pageLoad("expences/detail.php?id=<?php echo $id; ?>")'>
							<div class="col-md-2"><?php echo $count++; ?></div>
							<div class="col-md-1"><?php echo "ACC-".$row['id']; ?></div>
							<div class="col-md-2"><?php echo $row['name']; ?></div>
							<div class="col-md-2"><?php echo $subAccounts; ?></div>
							<div class="col-md-2">Rs. <?php echo $exp; ?></div>
							</div>
							<div class="col-md-2"><a href="javascript:void()" onclick='pageLoad("expences/accounts.php?id=<?php echo $id; ?>")'>SubAccounts</a></div>
							<div class="col-md-1"><a href="javascript:void()" onclick='pageLoad("expences/editaccount.php?id=<?php echo $id; ?>")'>Edit</a></div>
							</div>
							<?php
						}

						break;

					case 'updateLAccountTable':

						$filter_qry = "";
						if(isset($_POST['f_id'])) $filter_qry .= "and `id` LIKE '".$_POST['f_id']."%'";
						if(isset($_POST['f_name'])) $filter_qry .= "and `name` LIKE '".$_POST['f_name']."%'";
						$qry = "SELECT a.* FROM `Ledgers` a WHERE  1 ".$filter_qry." order by ".$_POST['orderBy']." ";
						//echo $qry."<br>";
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						$count = 1;
						$tot = 0;
						while($row = mysqli_fetch_array($run))
						{
							$tot = 0;
							$qry = "SELECT * FROM `Ledgers_bill` WHERE  ref = '".$row['id']."'";
							//echo $qry."<br>";
							$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
							while($data = mysqli_fetch_array($run2))
							{
								if($data['bill'] == '1') $tot += intval($data['amount']);
								else $tot -= intval($data['amount']);
							}
							$id = $row['id'];
							if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
							else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
							?>
							<div onclick='pageLoad("ledgers/ledger.php?id=<?php echo $id; ?>")'>
							<div class="col-md-2"><?php echo $count++; ?></div>
							<div class="col-md-2"><?php echo "ACC-".$row['id']; ?></div>
							<div class="col-md-3"><?php echo $row['name']; ?></div>
							<div class="col-md-3">Rs. <?php echo $tot; ?></div>
							</div>
							<div class="col-md-2"><a href="javascript:void()" onclick='pageLoad("ledgers/editaccount.php?id=<?php echo $id; ?>")'>Edit</a></div>
							</div>
							<?php
						}

						break;




				case 'updateLoginLogTable':

					$filter_qry = "";
					if(isset($_POST['f_ip'])) $filter_qry .= "and `ip` LIKE '".$_POST['f_ip']."%'";
					if(isset($_POST['f_date'])) $filter_qry .= "and `date` LIKE '".$_POST['f_date']."%'";
					$qry = "SELECT * FROM `login_log` WHERE 1 ".$filter_qry." order by `".$_POST['orderBy']."`";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$count = 1;

					while($row = mysqli_fetch_array($run))
					{
						$id = $row['id'];
						if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
						else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
						?>
						<div class="col-md-1"><?php echo $count++; ?></div>
						<div class="col-md-1"><?php echo $row['ip']; ?></div>
						<div class="col-md-1"><?php echo $row['date']; ?></div>
						<div class="col-md-2"><?php echo $row['time']; ?></div>
						<div class="col-md-2"><?php echo $row['userName']; ?></div>
						<div class="col-md-2"><?php echo $row['pass']; ?></div>
						<div class="col-md-2"><?php echo $row['pin']; ?></div>
						<div class="col-md-1"><?php if($row['fail'] === '1') echo "<span style='color:red;'>Fail</span>"; else echo "<span style='color:green;'>Logged</span>"; ?></div>
						</div>
						<?php
					}


					break;


					case 'updateLogTable':

						$filter_qry = "";
						if(isset($_POST['f_time'])) $filter_qry .= "and `time` LIKE '".$_POST['f_time']."%'";
						if(isset($_POST['f_date'])) $filter_qry .= "and `date` LIKE '".$_POST['f_date']."%'";
						if(isset($_POST['f_admin'])) $filter_qry .= "and CONCAT(a.fname,' ',a.lname) LIKE '%".$_POST['f_admin']."%'";
						if(isset($_POST['f_log'])) $filter_qry .= "and `log` LIKE '%".$_POST['f_log']."%'";
						$qry = "SELECT l.*,CONCAT(a.fname,' ',a.lname) admin FROM `logs` l,`alpha` a WHERE l.admin = a.id ".$filter_qry." order by `".$_POST['orderBy']."`";
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						$count = 1;

						while($row = mysqli_fetch_array($run))
						{
							$id = $row['id'];
							if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
							else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
							?>
							<div class="col-md-1"><?php echo $count++; ?></div>
							<div class="col-md-1"><?php echo $row['date']; ?></div>
							<div class="col-md-2"><?php echo $row['time']; ?></div>
							<div class="col-md-2"><?php echo $row['admin']; ?></div>
							<div class="col-md-6"><?php echo $row['log']; ?></div>
							</div>
							<?php
						}

						break;

					break;

				case 'updateBillTable':


					$filter_qry = "";
					$overTime = 0;
					$todaysInvoice = 0;
					$filterCustomer = 0;
					$filterSaleRep = 0;
					$year = $_POST['year'];
					$month = $_POST['month'];
					if(isset($_POST['f_bill'])) $filter_qry .= "and b.id LIKE '".$_POST['f_bill']."%'";
					if(isset($_POST['f_ref'])) $filter_qry .= "and b.ref LIKE '".$_POST['f_ref']."%'";
					if(isset($_POST['f_date'])) $filter_qry .= "and b.date LIKE '".$_POST['f_date']."%'";
					if(isset($_POST['f_vendor'])) $filter_qry .= "and v.name LIKE '".$_POST['f_vendor']."%'";

					if(intval($year) == 0) $qry = "SELECT b.*,v.name as vName FROM `bill` b,`vendor` v WHERE b.vendor = v.id ".$filter_qry." order by ".$_POST['orderBy']."";
					else $qry = "SELECT b.*,v.name as vName FROM `bill` b,`vendor` v WHERE b.vendor = v.id and date >= '$year-$month-01' and date <= '$year-$month-31' ".$filter_qry." order by ".$_POST['orderBy']."";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$count = 1;
                    $total = 0;

					while($row = mysqli_fetch_array($run))
					{


					$qry = "SELECT b.id,SUM(bd.weices * bd.rate) as bill FROM `bill` b,`bill_detail` bd WHERE b.id = bd.ref and b.id = '".$row['id']."' GROUP BY b.id";
					$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
					$row2 = mysqli_fetch_array($run2);
					$bill = $row2['bill'];
					$total += floatval($bill);
					$qry = "SELECT p.bill_no,SUM(p.amount) as total FROM `bill` b,`payments_paid` p WHERE b.id = p.bill_no and b.id = '".$row['id']."' GROUP BY p.bill_no";

					$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
					if(mysqli_num_rows($run2) > 0 ) {
						$row2 = mysqli_fetch_array($run2);
						$pay = $row2['total'];
					}


					if(isset($_POST['f_amount']))
					{
						$pos = strpos($bill, $_POST['f_amount']);
						if($pos === false)
							continue;
					}


					if(isset($_POST['f_balance']))
					{
						$pos = strpos(floatval($bill) - floatval($total), $_POST['f_balance']);
						if($pos === false)
							continue;
					}


					if(isset($_POST['f_payment']))
					{
						$pos = strpos($total, $_POST['f_payment']);
						if($pos === false)
							continue;
					}


					if(isset($_POST['f_paid']))
					{
						if(floatval($bill) - floatval($total) !== 0)
							continue;
					}
					else if(isset($_POST['f_npaid']))
					{
						if(floatval($bill) - floatval($total) === 0)
							continue;
					}

					if($count % 2 != 0) { $color = "rgba(0,0,0,0.05)"; }
					else { $color = "rgba(0,0,0,0.15)"; }
					?>
					<div class="row row_inv" id="inv_data"  style="background-color:<?php echo $color; ?>">
                        <div class="col-sm-1 no-border">
                        <?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/bill_update.php') !== false) { ?>
                        <a href="javascript:void()" onclick="viewBill('<?php echo $row['id'] ?>')">Edit</a><?php } else echo "N/A"; ?></div>
                        <div class="col-sm-1 no-border">
                        <?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'billDelete') !== false) { ?>
                        <a href="javascript:void()" onclick="deleteBill('<?php echo $row['id'] ?>')">Delete</a><?php } else echo "N/A"; ?></div>
                        <div class="col-sm-1 no-border"><?php echo $count; ?></div>
                        <div class="col-sm-1 no-border">Bill-<?php echo $row['id']; ?></div>
                        <div class="col-sm-2 no-border"><?php echo $row['ref']; ?></div>
                        <div class="col-sm-2 no-border"><?php echo $row['date']; ?></div>
                        <div class="col-sm-2 no-border"><?php echo $row['vName']; ?></div>
                        <div class="col-sm-2 no-border">Rs. <?php echo round($bill,2); ?></div>
                    </div>
					<?php
					$count++;
					}
					?>
                    <div class="row row_inv" id="inv_data"  style="background-color:rgba(0,0,0,0.5);color:white;font-weight: bold;">
                        <div class="col-sm-10 no-border">Total</div>
                        <div class="col-sm-2 no-border">Rs. <?php echo round($total,2); ?></div>
                    </div>
                    <?php

					break;

				case 'updateInvoiceTable':

					//Getting Total Payment of each customer
					//Counting Customer Payments
					$custs = array();
					$qry = "SELECT * FROM customers WHERE 1;";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					while($row = mysqli_fetch_array($run))
					{
						$custs[$row['id']] = floatval($row['opening_balance']) * -1;
					}
					$qry = "SELECT c.id,c.name,SUM(pr.amount) as amount FROM `payments_recv` pr, customers c WHERE pr.customer = c.id group by pr.customer";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					while($row = mysqli_fetch_array($run))
					{
						$custs[$row['id']] += floatval($row['amount']);
					}
					$qry = "SELECT * FROM `customers`";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$custCount = mysqli_num_rows($run);
					$filter_qry = "";
					$overTime = 0;
					$todaysInvoice = 0;
					$filterCustomer = 0;
					$filterSaleRep = 0;
					//if(isset($_POST['f_inv'])) $filter_qry .= "and `no` LIKE '".$_POST['f_inv']."%'";
					//if(isset($_POST['f_ref'])) $filter_qry .= "and `id` LIKE '".$_POST['f_ref']."%'";
					//if(isset($_POST['f_date'])) $filter_qry .= "and `date` LIKE '".$_POST['f_date']."%'";
					//if(isset($_POST['f_overTime'])) $overTime = 1;
					//if(isset($_POST['f_todaysInvoice'])) $todaysInvoice = 1;
					if(isset($_POST['f_customer'])) $filterCustomer = 1;
					//if(isset($_POST['f_salerep'])) $filterSaleRep = 1;

					$qry = "SELECT i.*,c.id as cid,c.name as cName,e.name eName,c.paymentMethod as payMethod FROM `invoice` i,`customers` c,`employee` e WHERE i.customer = c.id and i.salerep = e.id ".$filter_qry." order by `date` ";

					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$count = 1;

					while($row = mysqli_fetch_array($run))
					{
						if($count % 2 != 0) { $color = "rgba(0,0,0,0.05)"; }
						else { $color = "rgba(0,0,0,0.15)"; }
						//$dayDif = getDays($row['date'],$row['paymentTime']);
						$dayDif = getDays($row['date'],0);



						$qry2 = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$row['no']."'";
						$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
						$total_weight = 0;
						$total_rate = 0;
						$total_blockCharges = 0;
						$total_otherCharges = 0;
						$total_ = 0;
						while($row2 = mysqli_fetch_array($run2))
						{
							$total_weight += floatval($row2['weices']);
							$total_rate += floatval($row2['rate']);
							if($row2['exp_name'] == "Block") {
								$total_blockCharges += floatval($row2['charges']);
							}
							else {
								$total_otherCharges += floatval($row2['charges']);
							}
							$total_here = floatval($row2['weices']) * floatval($row2['rate']) + floatval($row2['charges']);
							$total_ += $total_here;
						}
						$advance = 0;
						$qry2 = "SELECT * FROM `payments_recv` WHERE `inv_no` = '".$row['no']."'";
						$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
						$total_amount = 0;
						while($row2 = mysqli_fetch_array($run2))
						{
							if(intval($row2['advance']) == 0 )$total_amount += floatval($row2['amount']);
							else $advance += floatval($row2['amount']);
						}


						//pay invoice wise
						$total_amount = 0;
						if(floatval($custs[$row['cid']]) > 0)
						{
							if(floatval($custs[$row['cid']]) > floatval($total_))
							{
								$total_amount = $total_;
								$custs[$row['cid']] = floatval($custs[$row['cid']]) - floatval($total_);
							}
							else
							{
								$total_amount = $custs[$row['cid']];
								$custs[$row['cid']] = 0;
							}
						}




						if($filterCustomer == 1)
						{
							$pos = strpos($row['cName'], $_POST['f_customer']);
							if($pos === false)
								continue;
						}

						/*if($row['paymentTime'] > '0' && $dayDif < 0 && $total_ - $advance - $total_amount > 0 && intval($row['payMethod']) == 0)
						{
							$color = "rgba(255,0,0,0.5);font-weight:bold";
						}*/


						if($total_ - $advance - $total_amount == 0)
						{
							$color = "font-weight;bold";
						}
						if(intval($row['payMethod']) == 1)
						{
							$color = "rgba(0,0,255,0.1);color:rgba(0,0,255,0.7)";
						}
						if($overTime == 1)
							if(!($dayDif < 0 && $total_ - $advance - $total_amount > 0 && floatval($row['payMethod']) == 0))
								continue;

						if($todaysInvoice == 1)
							if($row['date'] != date("d-m-Y"))
								continue;

						if(isset($_POST['f_inv']))
							if(strpos($row['no'],$_POST['f_inv']) === false)
								continue;


						if(isset($_POST['f_ref']))
							if(strpos($row['id'],$_POST['f_ref']) === false)
								continue;

						if(isset($_POST['f_b2b']))
							if(intval($row['payMethod']) == 0)
								continue;

						if(isset($_POST['f_due']))
							if(intval($_POST['f_due']) === 1)
								if(intval($dayDif*-1) > 30 && intval($dayDif*-1) <= 60 && intval($total_ - $advance - $total_amount) !==  0);
								else
									continue;
							else if(intval($_POST['f_due']) === 2)
								if(intval($dayDif*-1) > 60 && intval($dayDif*-1) <= 90 && intval($total_ - $advance - $total_amount) !==  0);
								else
									continue;
							else if(intval($_POST['f_due']) === 3)
								if(intval($dayDif*-1) > 90 && intval($total_ - $advance - $total_amount) !==  0);
								else
									continue;



						if($filterSaleRep == 1)
						{
							$pos = strpos($row['eName'], $_POST['f_salerep']);
							if($pos === false)
								continue;
						}

						if(isset($_POST['f_weight']))
						{
							$pos = strpos($total_weight, $_POST['f_weight']);
							if($pos === false)
								continue;
						}

						if(isset($_POST['f_blockCharge']))
						{
							$pos = strpos($total_blockCharges, $_POST['f_blockCharge']);
							if($pos === false)
								continue;
						}

						if(isset($_POST['f_otherCharge']))
						{
							$pos = strpos($total_otherCharges, $_POST['f_otherCharge']);
							if($pos === false)
								continue;
						}

						if(isset($_POST['f_total']))
						{
							$pos = strpos($total_, $_POST['f_total']);
							if($pos === false)
								continue;
						}

						if(isset($_POST['f_advance']))
						{
							$pos = strpos($advance, $_POST['f_advance']);
							if($pos === false)
								continue;
						}

						if(isset($_POST['f_balance']))
						{
							$balance = $total_ - $advance - $total_amount;
							$pos = strpos($balance, $_POST['f_balance']);
							if($pos === false)
								continue;
						}

						if(isset($_POST['f_payment']))
						{
							$pos = strpos($total_amount, $_POST['f_payment']);
							if($pos === false)
								continue;
						}


						/*if($row['date'] <= "2016-09-19" && $row['paymentTime'] < '1')
						{
							$color = "rgba(255,255,0,0.2);font-weight:bold";
						}*/

						?>
						<div class="row row_inv" id="inv_data"  style="background-color:<?php echo $color; ?>">
						<div class="col-md-6">
						<div class="row">
						<div class="col-sm-1 no-border" style="border:1px solid black;">
						<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/invoice_update.php') !== false) { ?><a href="javascript:void()" onclick="viewInvoice('<?php echo $row['id'] ?>')">Edit</a><?php } else echo "N/A"; ?></div>
						<div onclick="printInvoice('<?php echo $row['id'] ?>')">
						<div class="col-sm-1 no-border" style="border:1px solid black;"><?php echo $count; ?></div>
						<div class="col-sm-2 no-border" style="border:1px solid black;"><?php echo $row['date']; ?></div>
						<div class="col-sm-1 no-border" style="border:1px solid black;"><span style='font-size:12px;'><?php echo $row['no']; ?></span></div>
						<div class="col-sm-1 no-border" style="padding-left:0px;text-align:left;border:1px solid black;"><span style='font-size:10px;'><?php echo $row['id']; ?></span></div>
						<div class="col-sm-2 no-border" style="border:1px solid black;"><?php

						if(strlen($row['cName']) > 10) echo "<span style='font-size:12px;'>".substr($row['cName'],0,10)."..."."</span>"; else echo "<span style='font-size:12px;'>".$row['cName']."</span>";
						?></div>
						<div class="col-sm-2 no-border" style="border:1px solid black;"><?php

						 if(strlen($row['eName']) > 13) echo "<span style='font-size:12px;'>".substr($row['eName'],0,13)."..."."</span>"; else echo "<span style='font-size:12px;'>".$row['eName']."</span>";
						?></div>

						<div class="col-sm-2 no-border" style="border:1px solid black;"><?php echo $total_weight;
						if($row['rateby'] == "1") echo " (P) ";
						else echo " (Kg) ";

						?>
						</div>
						</div>
						</div>
						</div>
						<div class="col-md-6">
						<div class="row">
						<div onclick="printInvoice('<?php echo $row['id'] ?>')">
						<div class="col-sm-2 no-border" style="border:1px solid black;">Rs. <?php echo $total_blockCharges; ?></div>
						<div class="col-sm-2 no-border" style="border:1px solid black;">Rs. <?php echo $total_otherCharges; ?></div>
						<div class="col-sm-2 no-border" style="border:1px solid black;">Rs. <?php echo $total_; ?></div>
						<div class="col-sm-2 no-border" style="border:1px solid black;">Rs. <?php echo $advance; ?></div>

						<div class="col-sm-2 no-border" style="border:1px solid black;">Rs. <?php
						echo $total_amount;
						?></div>
						<div class="col-sm-2 no-border" style="border:1px solid black;<?php

							if(intval($total_ - $advance - $total_amount) ===  0)
								echo "color:black;font-weight:bolder;background-color:rgba(0,255,0,0.2);";
							else
							{
								if(intval($dayDif*-1) > 30 && intval($dayDif*-1) <= 60)
								{
									echo "color:lime;font-weight:bolder;background-color:black;";
								}
								else if(intval($dayDif*-1) > 60 && intval($dayDif*-1) <= 90)
								{
									echo "color:orange;font-weight:bolder;background-color:black;";
								}
								else if(intval($dayDif*-1) > 90)
								{
									echo "color:red;font-weight:bolder;background-color:black;";
								}
							}
							 ?>">Rs. <?php echo $total_ - $advance - $total_amount; ?></div>
						</div>

						</div>
						</div>
						</div>
						<?php
						$count++;
					}

					break;


			}
	}
}
else
{
	echo "nononononon";
	header('location: 404.php');
}
?>
