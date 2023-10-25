<!DOCTYPE html>
<html lang="en-US">
<head>
<title>PayPal Integration in CodeIgniter</title>
<meta charset="utf-8">

<!-- Include bootstrap library -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

<!-- Include custom css -->
<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
</head>
<body>
<div class="container">
	<h2>Payment Failure</h2>
    <div class="row">
        <div class="col-lg-12">
			<h4 class="error">We are sorry! Your transaction was canceled.</h4>
			
			<a href="<?php echo base_url('products'); ?>">Back to Products</a>
		</div>
	</div>
</div>
</body>
</html>