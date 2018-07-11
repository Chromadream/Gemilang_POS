<!doctype html>
<html lang="en">
  <head>
    <title>Sistem IT Gemilang Copy Center</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" rel="stylesheet">
  </head>
  <body>
        <div class="container">
        <h1>Menu Utama</h1>
      <?php
        session_start();
        if(!isset($_SESSION["level"]))
        {
          header("location: login.php?redirposition=index.php");
        }
        if($_SESSION["level"]=="B" || $_SESSION["level"]=="T")
        {?>
            <a name="invoice" id="invoice" class="btn btn-link" href="invoice.php?mode=new" role="button"><i class="fas fa-exchange-alt"></i> Kasir</a>
            <br/>
        <?php }
        if($_SESSION["level"]=="S")
        {?>
            <a name="inventory" id="inventory" class="btn btn-link" href="inventory.php" role="button"><i class="fas fa-archive"></i> Stock</a>
            <br/>
        <?php }
        if($_SESSION["level"]=="B")
        {?>
            <a name="product" id="product" class="btn btn-link" href="products.php" role="button"><i class="fas fa-archive"></i> Produk</a><br/>
            <a name="order" id="order" class="btn btn-link" href="orders.php" role="button"><i class="fas fa-credit-card"></i> Transaksi</a><br/>
            <a name="reporting" id="reporting" class="btn btn-link" href="reporting.php" role="button"><i class="fas fa-chart-line"></i> Laporan</a><br/>
            <a name="end_of_day" id="end_of_day" class="btn btn-link" href="end_of_day.php" role="button"><i class="fas fa-file-invoice-dollar"></i> Tutup buku harian</a><br/>
            <a name="cust" id="cust" class="btn btn-link" href="customers.php" role="button"><i class="fas fa-user"></i> Pelanggan</a><br/>
            <a name="disc" id="disc" class="btn btn-link" href="discount_cards.php" role="button"><i class="fas fa-id-card"></i> Kartu diskon</a><br/>
        <?php }
        ?>
            <a name="logout" id="logout" class="btn btn-link" href="logout.php" role="button"><i class="fas fa-sign-out-alt"></i> Keluar</a><br/>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>