<?php
include 'excel_reader.php';     // include the class
//$con = mysqli_connect("localhost","root","raftaar","bashsofts_mppt_default_db") or die(mysqli_error());

$con = mysqli_connect("localhost","bashsoft_shahab","AshaSha41","bashsoft_mppt_default_db");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
// creates an object instance of the class, and read the excel file data
$excel = new PhpExcelReader;
$excel->read('less3.xls');
#Rahat-khanna
#Rahat Pwd
$SheetName = 'Rahat GulzarEQuaid';
$final_bal = 0;
// Excel file data is stored in $sheets property, an Array of worksheets
/*
The data is stored in 'cells' and the meta-data is stored in an array called 'cellsInfo'

Example (firt_sheet - index 0, second_sheet - index 1, ...):

$sheets[0]  -->  'cells'  -->  row --> column --> Interpreted value
         -->  'cellsInfo' --> row --> column --> 'type' (Can be 'date', 'number', or 'unknown')
                                            --> 'raw' (The raw data that Excel stores for that data cell)
*/

// this function creates and returns a HTML table with excel rows and columns data
// Parameter - array with excel worksheet data


function changeDateformat($date)
{
  //$d = explode("-",$date);
  //return $d[2]."-".$d[0]."-".$d[1];
  return $date;
}

function sheetData($sheet) {
  $json = "";
  $re = '<table>';     // starts html table

  $x = 1;
  while($x <= $sheet['numRows']) {
    $re .= "<tr>\n";
    $y = 1;

      if(strtolower($sheet['cells'][$x][2]) == "previous balance")
          {
            if(strlen($sheet['cells'][$x][6]) < 1) $sheet['cells'][$x][6] = 0;
            $json.='"Opening_Balanace":"'.$sheet['cells'][$x][6].'","data":{';
          }
          else {
            if(strlen($sheet['cells'][$x][1]) > 0)
            { 

     
            $pos2 = strpos(strtolower($sheet['cells'][$x][3]), "bill");
              if($pos2 === false)  { $type = "Payment"; $amount =  $sheet['cells'][$x][5]; $billRef = '';}
             else { $type = "Invoice"; $amount = $sheet['cells'][$x][4]; $billRef = preg_replace("/[^0-9]/","",$sheet['cells'][$x][3]);}
            $d = explode("/",$sheet['cells'][$x][2]);
            if(strlen($sheet['cells'][$x][2]) < 10)
            {
              $d[2] = '20'.$d[2];
              if($d[1] < 10) $d[1] = '0'.$d[1];
              if($d[0] < 10) $d[0] = '0'.$d[0];
            }
            if($d[2] === '1616') $d[2] = '2016';
            if($d[2] === '1615') $d[2] = '2015';
            if(intval($d[1]) > 12)
            {
              $tmp = $d[1];
              $d[1] = $d[0];
              $d[0] = $tmp;
            }            
            $sheet['cells'][$x][2] = $d[2]."-".$d[1]."-".$d[0];
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$sheet['cells'][$x][2]))
            {
              //ok
            }
            else
            {
              $sheet['cells'][$x][2] = "2016-01-01";
            }
            if(strlen($billRef) < 1) {
              $billRef = rand(1,5);
            }
            if(strlen($amount) > 0) {
            $json.='"'.$sheet['cells'][$x][1].'":{"date":"'.$sheet['cells'][$x][2].'","type":"'.$type.'","amount":"'.$amount.'","billRef":"'.$billRef.'"},'; }
            }
          }

          
      $re .= "</tr>\n";
      $x++;
    }
  
  $json.='"-":{}}}';
  return $json;
  //return $re .'</table>';     // ends and returns the html table
}

$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet

// traverses the number of sheets and sets html table with each sheet data in $excel_data
for($i=0; $i<$nr_sheets; $i++) {
  $final_bal = 0;
  echo $excel->boundsheets[$i]['name']."<br>";
  //if($excel->boundsheets[$i]['name'] !== $SheetName) continue;
  $excel_data = '{"name":"'. $excel->boundsheets[$i]['name'] .'",'. sheetData($excel->sheets[$i]);
  $json = json_decode($excel_data);
  $qry = "INSERT INTO `customers`(`id`, `name`, `contact`, `address`, `opening_balance`, `saleRep`, `rateBy`, `paymentMethod`) VALUES (NULL,'".$json->{'name'}."','--','--','".$json->{'Opening_Balanace'}."','0','0','0')";
  echo $qry."<br>";
  $final_bal += intval(ceil($json->{'Opening_Balanace'}));
  echo $final_bal."<br>";
  mysqli_query($con,$qry) or die(mysqli_error($con));
  $qry = "SELECT * FROM `customers` WHERE `name` = '".$json->{'name'}."' order by `id` DESC LIMIT 1";
  echo $qry."<br>";
  $run = mysqli_query($con,$qry) or die(mysqli_error($con));
  $data = mysqli_fetch_array($run);
  $customer_id = $data['id'];
  //$customer_id = 99;

  foreach ($json->{'data'} as $key => $value) {
    if($json->{'data'}->{$key}->{'type'} === "Invoice")
    {
     $qry = "INSERT INTO `invoice`(`no`, `id`, `customer`, `salerep`, `date`, `rateby`, `paymentTime`, `ldRate`, `hdRate`) VALUES (NULL,'".$json->{'data'}->{$key}->{'billRef'}."','".$customer_id."','1','".changeDateformat($json->{'data'}->{$key}->{'date'})."','0','0','0','0')";
     echo $qry."<br>";
     mysqli_query($con,$qry) or die(mysqli_error($con));

     $qry = "SELECT * FROM `invoice` WHERE 1 order by no DESC lIMIT 1";
     $run = mysqli_query($con,$qry) or die(mysqli_error($con));
     $data = mysqli_fetch_array($run);
     $inv_no = $data['no'];

     $qry = "INSERT INTO `invoice_detail`(`id`, `ref`, `size`, `material`, `exp_name`, `charges`, `weices`, `rate`, `bag`) VALUES (NULL,'".$inv_no."','--','--','Total Bill','".$json->{'data'}->{$key}->{'amount'}."','0','0','0')";
     mysqli_query($con,$qry) or die(mysqli_error($con));
     echo $qry."<br>";
     $final_bal += intval(ceil($json->{'data'}->{$key}->{'amount'}));
     echo $final_bal."<br>";
   }
    if($json->{'data'}->{$key}->{'type'} === "Payment") { $qry = "INSERT INTO `payments_recv`(`id`, `customer`, `receiver`, `inv_no`, `ref_no`, `amount`, `entry_date`, `rec_date`, `advance`) VALUES (NULL,'".$customer_id."','0','0','0','".$json->{'data'}->{$key}->{'amount'}."','".date("Y-m-d")."','".changeDateformat($json->{'data'}->{$key}->{'date'})."','0')";
  echo $qry."<br>";
  $final_bal -= intval(ceil($json->{'data'}->{$key}->{'amount'}));
  echo $final_bal."<br>";

      mysqli_query($con,$qry) or die(mysqli_error($con));
    }
  }
  //var_dump($json);
 echo "<br><br>".$final_bal."<hr><br><br>";

}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Example PHP Excel Reader</title>
<style type="text/css">
table {
 border-collapse: collapse;
}
td {
 border: 1px solid black;
 padding: 0 0.5em;
}
</style>
</head>
<body>

<?php
// displays tables with excel file data
//echo $excel_data;
?>

</body>
</html>
