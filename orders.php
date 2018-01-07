<!doctype html>
<html lang="en">
  <head>
    <title>Transaksi</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
    <?php
    session_start();
    include("vendor/autoload.php");
    if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
    {
      header("location: login.php?redirposition=orders.php");
    }
    include_once("database_class.php");
    include_once("transaction_DAO.php");
    $connection = new Database();
    $transact_DAO = new transaction_DAO($connection->getConnection());
    if(!empty($_GET["cust_id"]))
    {
        $result = $transact_DAO->list_all_transactions_from_customer($_GET["cust_id"]);
        $title = "Transaksi dari ".$_GET["cust_name"];
    }
    else
    {
        $result = $transact_DAO->list_all_transactions();
        $title = "Semua transaksi";
    }?>
    <div class="container">
        <h1><?php echo $title;?></h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Kartu Diskon</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    <?php
    for($i = 0;$i<$result->rowCount();$i++)
    {
        $currentRow = $result->getNext(new transaction_DAO($connection->getConnection()),$i);
    ?>
            <tr>
                <td scope="row"><?php echo $currentRow->transact_id;?></td>
                <td><?php echo $currentRow->transact_date;?></td>
                <td><a href="orders.php?cust_id=<?php echo $currentRow->customer_id;?>&cust_name=<?php echo $currentRow->customer_name;?>"><?php echo $currentRow->customer_name;?></td>
                <td><?php echo $currentRow->discount_id;?></td>
                <td><a name="<?php echo $currentRow->transact_id;?>" class="btn btn-dark" href="past_transaction.php?id=<?php echo $currentRow->transact_id;?>" role="button">Lihat transaksi</a>
            </tr>
    <?php } ?>
            </tbody>
        </table>
    <button type="button" class="btn btn-secondary" btn-lg btn-block><a href="index.php">Kembali ke menu awal</a></button>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>