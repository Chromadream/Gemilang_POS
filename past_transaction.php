<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
    <?php
    session_start();
    if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
    {
      header("location: login.php?redirposition=orders.php");
    }
    if(!isset($_GET["id"]))
    {
        header("orders.php");
    }
    include_once("database_class.php");
    include_once("transaction_DAO.php");
    include_once("transaction_line_DAO.php");
    $connection = new Database();
    $transact_DAO = new transaction_DAO($connection->getConnection());
    $transactitem_DAO = new transaction_line_DAO($connection->getConnection());
    $price_percentage = 1;
    $subtotal_price = 0;
    $discount_presence = $transact_DAO->check_discount($_GET["id"]);
    if($discount_presence)
    {
        $price_percentage = 0.98;
    }
    $transact_DAO->get_transaction_detail($_GET["id"]);
    $items = $transactitem_DAO->list_all_items_from_order($_GET["id"]);?>
    <div class="container">
        <h1>Invoice</h1>
        <ul class="list-group">
            <li class="list-group-item">Nomor Transaksi: <?php $transact_DAO->transact_id;?></li>
            <li class="list-group-item">Tanggal: <?php $transact_DAO->transact_date;?></li>
            <li class="list-group-item">Customer: <?php $transact_DAO->customer_name;?></li>
            <li class="list-group-item">Discount ID: <?php $transact_DAO->discount_id;?></li>
        </ul>
        <table class="table table-striped">
            <thead class="thead-inverse">
                <tr>
                    <th>Qty</th>
                    <th>Nama</th>
                    <th>Harga satuan</th>
                    <th>Harga akhir item</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for($i=0;$i<$items->rowCount();$i++)
                {
                    $current_item = $items->getNext(new transaction_line_DAO($connection->getConnection()),$i);?>
                    <tr>
                    <td scope="row"><?php $multiplier = (int)$current_item->transact_item_quantity;echo $multiplier;?></td>
                    <td><?php echo $current_item->product_name;?></td>
                    <td><?php $current_price = (int)$current_item->product_sale_price;echo $current_price;?></td>
                    <td><?php $subtotal = $multiplier*$current_price;echo $subtotal;$subtotal_price+=$subtotal;?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Subtotal</td>
                    <td><?php echo $subtotal_price;?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total akhir</td>
                    <td><?php echo $subtotal_price*$price_percentage;?></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" btn-lg btn-block><a href="printmode.php?id="<?php echo $_GET["id"];?>""><i class="fa fa-print" aria-hidden="true"></i> Print Invoice</a></button>
        <button type="button" class="btn btn-secondary" btn-lg btn-block><a href="index.php">Kembali ke menu awal</a></button>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>