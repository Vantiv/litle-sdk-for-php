<link rel="stylesheet" type="text/css" media="screen" href="stylesheet.php">
<html>
<head>
   <title>PHP DEMO</title>
      <div class="wrapper">
          <h1 class="logo"><a href="http://www.Litle.com"></a></h1>
          <h2 class="subtitle"><span class="separator"></span> Demo PHP App</h2>
      </div>
</head>

<form action="form.php" method="post">
<div id="content">
<header>
  <h4>Here are the six examples to using Litle_Online payments!!!</h4>
</header>
<h4>Authorization</h4>
<p>The Authorization transaction enables you to confirm that a customer has submitted a valid payment method with their order and has sufficient funds to purchase the goods or services they ordered.</p>

<h4>Authotization Reversal</h4>
<p>The Authorization Reversal transaction enables you to remove the hold on any funds being held by an Authorization. The original Authorization transaction must have been processed within the Litle system.</p>

<h4>Capture</h4>
<p>The Capture transaction transfers funds from the customer to the merchant. The Capture references the associated Authorization by means of the litleTxnId element returned in the Authorization response.</p>

<h4>Credit</h4>
<p>The Credit transaction enables you to refund money to a customer, even if the original transaction occurred outside of the Litle & Co. system.</p>

<h4>Sale</h4>
<p>The Sale transaction enables you to both authorize fund availability and deposit those funds by means of a single transaction. The Sale transaction is also known as a conditional deposit, because the deposit takes place only if the authorization succeeds. If the authorization is declined, the deposit will not be processed.</p>

<h4>Void</h4>
<p>You use a Void transaction to cancel a transaction that occurred during the same business day. You can void Capture, Credit, and Sale transactions.</p>
</div>
<table>
<td colspan="2" align="center">
<input type="submit" value="Getting Start">
</td>
</table>
</form>
</html>
