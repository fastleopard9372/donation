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
	<h2>Products</h2>
    <div class="row">
        <div class="col-lg-12">
		<!-- List all products -->
		<?php if(!empty($products)){ foreach($products as $row){ ?>
			<div class="col-sm-4 col-lg-4 col-md-4">
				<div class="thumbnail">
					<img src="<?php echo base_url('assets/images/'.$row['image']); ?>" />
					<div class="caption">
						<h4 class="pull-right">$<?php echo $row['price']; ?> USD</h4>
						<h4><a href="javascript:void(0);"><?php echo $row['name']; ?></a></h4>
						
					</div>
					<div class="ratings">
						<a href="<?php echo base_url('products/buy/'.$row['id']); ?>">
							<img src="<?php echo base_url('assets/images/x-click-but01.gif'); ?>" />
						</a>
						<p class="pull-right">15 reviews</p>
						<p>
							<span class="glyphicon glyphicon-star"></span>
							<span class="glyphicon glyphicon-star"></span>
							<span class="glyphicon glyphicon-star"></span>
							<span class="glyphicon glyphicon-star"></span>
							<span class="glyphicon glyphicon-star"></span>
						</p>
					</div>
				</div>
			</div>
		<?php } }else{ ?>
			<p>Product(s) not found...</p>
		<?php } ?>
        </div>
    </div>
</div>
</body>
</html>