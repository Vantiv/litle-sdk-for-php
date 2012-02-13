<html>
<head>
</head>
<body>
<form method="post" action="config.php" enctype="multipart/form-data">
  <table width="300" border="0" align="center" bgcolor="#CCFFCC">
    <tr>
	<td colspan="2"><div align="center"><h4>Configuration</h4></div></td>
    </tr>
    <tr>
	<td width="300">User</td>
	<td><input name="user" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Password</td>
	<td><input name="password" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Version</td>
	<td><input name="version" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">URL</td>
	<td><select name="url">
	<option>https://cert.litle.com/vap/communicator/online</option>
	<option>https://precert.litle.com/vap/communicator/online</option>
	<option>https://payment.litle.com/vap/communicator/online</option>
	<option>https://payment2.litle.com/vap/communicator/online</option>
	</select>
	</td>
    </tr>
    <tr>
	<td width="300">Proxy_Address</td>
	<td><input name="proxy_address" type="text" value=""></td>
    </tr>
    <tr>
	<td width="300">Proxy_port</td>
	<td><input name="proxy_port" type="text" value=""></td>
    </tr>
    <tr>
	<td colspan="2" align="center">
	<input type="submit" name="save" value="Save File">
        <input type="reset" name="reset" value="reset">
	</td>
    </tr>
  </table>
</form>
</body>
</html>
