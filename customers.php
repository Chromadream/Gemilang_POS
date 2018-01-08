<!doctype html>
<html lang="en">
  <head>
    <title>Customers</title>
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
    include("vendor/autoload.php");
    krumo::disable();
    if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
    {
      header("location: login.php?redirposition=customers.php");
    }
    include_once("database_class.php");
    include_once("DAO/customer_DAO.php");
    $connection = new Database();
    $customer_DAO = new customer_DAO($connection->getConnection());
    $result =  $customer_DAO->list_all_customer();
    krumo($result);?>
    <div class="container">
        <h1>Daftar Customer</h1>
        <a name="new_cust" id="new_cust" class="btn btn-primary" href="new_customer.php" role="button"><i class="fa fa-address-book" aria-hidden="true"></i>Tambah Customer Baru</a>
        <a name="home" id="home" class="btn btn-secondary" href="index.php" role="button"><i class="fa fa-home" aria-hidden="true"></i> Kembali ke menu awal</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Nomor telepon</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    <?php
        for($i = 0;$i <$result->rowCount();$i++)
        {
            $currentRow = $result->getNext(new customer_DAO($connection->getConnection()),$i);
            krumo($currentRow);
        ?>
            <tr>
                <td scope="row"><?php echo $currentRow->customer_id;?></td>
                <td><?php echo $currentRow->customer_name;?></td>
                <td><?php echo $currentRow->customer_phone;?></td>
                <td><a name="<?php echo $currentRow->customer_id;?>" class="btn btn-dark" href="orders.php?cust_id=<?php echo $currentRow->customer_id;?>&cust_name=<?php echo $currentRow->customer_name;?>" role="button">List semua order</a>
            </tr>
        <?php };?>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>