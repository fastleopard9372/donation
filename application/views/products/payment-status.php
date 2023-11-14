<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>PayPal Integration in CodeIgniter</title>
  <meta charset="utf-8">

  <!-- Include bootstrap library -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <!-- Include custom css -->
  <link href="<?= BASE_URL . 'assets/css/style.css'; ?>" rel="stylesheet">
</head>

<body>
  <div class="container">
    <!-- List all products -->
    <?php if (!empty($order)) { ?>
    <!-- Display transaction status -->
    <?php if ($order['payment_status'] == 'succeeded') { ?>
    <h1 class="success">Your Payment has been Successful!</h1>
    <?php } else { ?>
    <h1 class="error">The transaction was successful! But your payment has been failed!</h1>
    <?php } ?>

    <h4>Payment Information</h4>
    <p><b>Reference Number:</b> <?php echo $order['id']; ?></p>
    <p><b>Transaction ID:</b> <?php echo $order['txn_id']; ?></p>
    <p><b>Paid Amount:</b> <?php echo $order['paid_amount'] . ' ' . $order['paid_amount_currency']; ?></p>
    <p><b>Payment Status:</b> <?php echo $order['payment_status']; ?></p>

    <h4>Product Information</h4>
    <p><b>Name:</b> <?php echo $order['product_name']; ?></p>
    <p><b>Price:</b> <?php echo $order['product_price'] . ' ' . $order['product_price_currency']; ?></p>
    <?php } else { ?>
    <h1 class="error">The transaction has failed</h1>
    <?php } ?>
</body>

</html>