<link rel="stylesheet" type="text/css" media="screen" href="stylesheet.php">
<html>
<head>
	<title>Litle Payment</title>
</head>
<body>
<form method="post" action="show.php">
  <table width="600" border="0" align="center" bgcolor="#CCFFCC">
    <tr>
	<td colspan="2" align="center" bgcolor="#FF0000">
	<select name="method">
	<option>authorization</option>
	<option>authReversal</option>
	<option>credit</option>
	<option>capture</option>
	<option>sale</option>
	<option>void</option>
	</select></td>
    </tr>
    <tr>
	<td colspan="2"><div align="center"><h4>Order Information</h4></div></td>
    </tr>
    <tr>
	<td width="300">ID</td>
	<td><input name="id" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Merchant ID</td>
	<td><input name="merchantId" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Lilte Transaction ID (if necessary)<br>(*authReversal, credit, capture and void*)</td>
	<td><input name="litleTxnId" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Order ID</td>
	<td><input name="orderId" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Amount</td>
	<td><input name="amount" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Order Source</td>
	<td><input name="orderSource" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Report Group</td>
	<td><input name="reportGroup" type="text" value=""></td>
    </tr>
    <tr>
	<td colspan="2"><div align="center"><h4>Billing Information</h4></div></td>
    </tr>
    <tr>
	<td width="300">Name</td>
	<td><input name="name" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Address Line1</td>
	<td><input name="addressLine1" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Address Line2</td>
	<td><input name="AddressLine2" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">City</td>
	<td><input name="city" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">State</td>
	<td><select name="state">
	<option>AL</option><option>AK</option><option>AZ</option><option>AR</option><option>CA</option><option>CO</option><option>CT</option><option>DE</option><option>DC</option><option>FL</option><option>GA</option><option>HI</option><option>ID</option><option>IL</option><option>IN</option><option>IA</option><option>KS</option><option>KY</option><option>LA</option><option>ME</option><option>MD</option><option>MA</option><option>MI</option><option>MN</option><option>MS</option><option>MO</option><option>MT</option><option>NE</option><option>NV</option><option>NH</option><option>NJ</option><option>NM</option><option>NY</option><option>NC</option><option>ND</option><option>OH</option><option>OK</option><option>OR</option><option>PA</option><option>RI</option><option>SC</option><option>SD</option><option>TN</option><option>TX</option><option>UT</option><option>VT</option><option>VA</option><option>WA</option><option>WV</option><option>WI</option><option>WY</option>
	</select></td>
    </tr>
    <tr>
	<td width="300">Country</td>
	<td><select name="country">
	<option>US</option>
	</select></td>
    </tr>
    <tr>
	<td width="300">Zip</td>
	<td><input name="zip" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Email</td>
	<td><input name="email" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Phone</td>
	<td><input name="phone" type="text" value=""></td>
    </tr>
    <tr>
	<td colspan="2"><div align="center"><h4>Creditcard Information</h4></div></td>
    </tr>
    <tr>
	<td width="300">Card Type</td>
	<td><select name="type">
	<option>VI</option>
	<option>MS</option>
	<option>AX</option>
	<option>DI</option>
	<option>DC</option>
	</select></td>
    </tr>
    <tr>
	<td width="300">Card Number</td>
	<td><input name="number" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Expdate</td>
	<td><select name="expmonth">
	<?php foreach (range(1, 12) as $expmonth): ?>
	<option value="<?php echo sprintf('%02d', $expmonth) ?>"><?php echo sprintf('%02d', $expmonth) ?>
	</option>
	<?php endforeach; ?>
	</select>
	<select name="expyear">
	<?php foreach (range(2012, 2017) as $expyear): ?>
	<option value="<?php echo $expyear ?>"><?php echo $expyear ?>
	</option>
	<?php endforeach; ?>
	</select></td>
    </tr>
    <tr>
	<td width="300">CVV</td>
	<td><input name="cardValidationNum" type="text" value=""></td>
    </tr>
    <tr>
	<td colspan="2" align="center">
	<input type="submit" name="BUTTON1" value="submit">
        <input type="reset" name="BUTTON2" value="reset">
	</td>
    </tr>
  </table>
</form>
</body>
</html>
