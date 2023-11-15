<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>PayPal Integration in CodeIgniter</title>
  <meta charset="utf-8">

  <!-- Include bootstrap library -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <!-- Include custom css -->
  <link href="<?= BASE_URL . 'assets/css/style.css' ?>" rel="stylesheet">
</head>

<body>
  <div class="container">
    <!-- List all products -->
    <?php if (!empty($products)) { foreach ($products as $row) { ?>
    <div class="pro-box">
      <div class="info">
        <h4><?php echo $row['name']; ?></h4>
        <h5>Price: <?php echo '$' . $row['price'] . ' ' . $row['currency']; ?></h5>
      </div>
      <div class="action">
        <a href="<?= BASE_URL . 'index.php/products/purchase' . $row['id']; ?>">Purchase</a>
      </div>
    </div>
    <?php } } else { ?>
    <p>Product(s) not found...</p>
    <a href="<?= BASE_URL . 'index.php/products/purchase'; ?>">Purchase</a>
    <?php } ?>
</body>

</html>