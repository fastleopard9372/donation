<!DOCTYPE html>
<html lang="en-US">
<head>
<title>PayPal Integration in CodeIgniter</title>
<meta charset="utf-8">

<!-- Include bootstrap library -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

<!-- Include custom css -->
<link href="http://localhost/PayPal/assets/css/style.css'); ?>" rel="stylesheet">
</head>
<body>
<div class="container">
	<h2>Payment Success</h2>
    <div class="row">
        <div class="col-lg-12">
			<h4 class="success">Thank you! Your payment was successful.</h4>
			<p>Item Name : <span><?php echo $item_name; ?></span></p>
			<p>Item Number : <span><?php echo $item_number; ?></span></p>
			<p>TXN ID : <span><?php echo $txn_id; ?></span></p>
			<p>Amount Paid : <span>$<?php echo $payment_amt.' '.$currency_code; ?></span></p>
			<p>Payment Status : <span><?php echo $status; ?></span></p>
			
			<a href="http://localhost/PayPal/index.php/products">Back to Products</a>
		</div>
	</div>
</div>
</body>
</html>