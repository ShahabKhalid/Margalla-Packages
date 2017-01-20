<br><br>
<br><br><br><br>
<div class="container addBox">
<div class="inBox">
<h1>Add Admin Account</h1>
<form id="accountForm">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-4 text-center"><label>Login Name</label></div>
		<div class="col-sm-4 text-left"><input id="unameEle" style="width:200px;height:40px;border:1px solid gray;padding-left:5px;" type="text" name="name" placeholder="Login Name"></div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row" style="padding-top:10px;">
		<div class="col-sm-2"></div>
		<div class="col-sm-4 text-center"><label>First Name</label></div>
		<div class="col-sm-4 text-left"><input style="width:200px;height:40px;border:1px solid gray;padding-left:5px;" type="text" name="name" placeholder="First Name"></div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row" style="padding-top:10px;">
		<div class="col-sm-2"></div>
		<div class="col-sm-4 text-center"><label>Last Name</label></div>
		<div class="col-sm-4 text-left"><input style="width:200px;height:40px;border:1px solid gray;padding-left:5px;" type="text" name="name" placeholder="First Name"></div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row" style="padding-top:10px;">
		<div class="col-sm-2"></div>
		<div class="col-sm-4 text-center"><label>Password</label></div>
		<div class="col-sm-4 text-left"><input style="width:200px;height:40px;border:1px solid gray;" type="password" name="name" placeholder="Password"></div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-4 text-center"><label>Pincode</label></div>
		<div class="col-sm-4 text-left"><input style="width:200px;height:40px;border:1px solid gray;" type="password" name="name" placeholder="Pincode"></div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-4 text-center"><label>Post</label></div>
		<div class="col-sm-4 text-left">
			<select name="post" style="width:200px;height:40px;border:1px solid gray;">
				<option value="2">CEO</option>
				<option value="1">Accounts Officer</option>
				<option value="3" selected>Sale Representer</option>				
			</select>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<br><br>
	<h1>Account Access</h1>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-10" style="border:1px solid black;font-weight:bold;">Customers</div>
		<div class="col-sm-1"></div>
	</div>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Customers</div>
		<div class="col-sm-2" style="border:1px solid black;">
			<input type="checkbox" value="customers/list.php" checked> List
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="customers/add.php"> Add
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="customers/edit.php"> Edit
		</div>		
	</div>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Invoices</div>
		<div class="col-sm-2" style="border:1px solid black;">
			<input type="checkbox" value="customers/invoices.php" checked> List
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="customers/invoice_add.php"> Add
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="customers/invoice_update.php"> Edit
		</div>	
	</div>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Payments</div>
		<div class="col-sm-2" style="border:1px solid black;">
			<input type="checkbox" value="customers/payments_list.php" checked> List
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="customers/recv_payment.php"> Add
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="customers/payment_update.php"> Edit
		</div>	
	</div>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-10" style="border:1px solid black;font-weight:bold;">Vendors</div>
		<div class="col-sm-1"></div>
	</div>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Vendors</div>
		<div class="col-sm-2" style="border:1px solid black;">
			<input type="checkbox" value="vendors/list.php" checked> List
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="vendors/add.php"> Add
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="vendors/edit.php"> Edit
		</div>	
	</div>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Bills</div>
		<div class="col-sm-2" style="border:1px solid black;">
			<input type="checkbox" value="vendors/bills.php" checked> List
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="vendors/bill_add.php"> Add
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="vendors/bill_update.php"> Edit
		</div>	
	</div>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Payments</div>
		<div class="col-sm-2" style="border:1px solid black;">
			<input type="checkbox" value="vendors/payments_list.php" checked> List
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="vendors/pay_payment.php"> Add
		</div>
		<div class="col-sm-3" style="border:1px solid black;">
			<input type="checkbox" value="vendors/payment_update.php"> Edit
		</div>	
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12 text-center"><input style="width:200px;height:40px;border:1px solid gray;" type="button" name="name" value="Add Account" onclick="AddAccount()"></div>
	</div>
</form>
<br><br>
<div class="row" id="r1"><p id="not">Admin successfully added!</p></div>
</div>
</div>
<br><br><br><br>
<br><br><br><br>
<script>
function onPageLoad()
{
	$("#not").slideUp();
	$("#unameEle").focus();
}
function AddAccount()
{
	var addform = document.getElementById("accountForm");
	var uname = addform[0].value;
	var fname = addform[1].value;
	var lname = addform[2].value;
	var pass = addform[3].value;
	var pin = addform[4].value;
	var post = addform[5].value;
	var access = "";
	for(var i = 6;i < addform.length;i++)
	{
		if(addform[i].checked)
		{
			access += addform[i].value + ",";
		}
	}
	
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {
            $("#not").hide();
            $("#not").text("Error while adding!");
            $("#not").css({color:'red'});
            $("#not").slideDown();
        }
        else if(xhttp.responseText === "1")
        {
            $("#not").slideUp();
            $("#not").text("Account Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            addForm.reset();
            $("#nameEle").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=addadmin", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("uname="+uname+"&fname="+fname+"&lname="+lname+"&pass="+pass+"&pin="+pin+"&post="+post+"&access="+access+"&ajax");
}
</script>
