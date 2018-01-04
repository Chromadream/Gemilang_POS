<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <?php
    session_start();
    if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B" || $_SESSION["level"] != "T")
    {
      header("location: login.php?redirposition=invoice.php");
    }
    include_once("database_class.php");
    include_once("transaction_DAO.php");
    include_once("transaction_items_DAO.php");
    include_once("customer_DAO.php");
    $connection = new Database();
    $transaction_DAO = new transaction_DAO($connection);
    $item_DAO = new transaction_items_DAO($connection);
    $customer_DAO = new customer_DAO($connection);
    if(!isset($_GET["mode"]))
    {
        $transID = $transaction_DAO->init_transaction();
        header("invoice.php?mode=".$transID);
    }
    else
    {
        $id = $_GET["mode"];
        $trans = $transaction_DAO->get_transaction_detail($id);
        $details = $trans->getNext(new transaction_DAO($connection),0);
    }?>
    <div class="container">
        <h1>Invoice</h1>
        <ul class="list-group">
            <li class="list-group-item">Nomor Transaksi: <?php $current->transact_id;?></li>
            <li class="list-group-item">Tanggal: <?php $current->transact_date;?></li>
            <li class="list-group-item"><a href="change_customer.php?tid=<?php echo $id;?>">Customer: <?php $current->customer_name;?></a></li>
            <li class="list-group-item"><a href="use_discount_card.php?tid=<?php echo $id;?>">Discount ID: <?php $current->discount_id;?></a></li>
        </ul>
        <a class="btn btn-primary" href="new_product.php" role="button"><i class="fa fa-plus" aria-hidden="true"></i>Tambah item ke invoice</a>
    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>