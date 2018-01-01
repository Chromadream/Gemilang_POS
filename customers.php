<!doctype html>
<html lang="en">
  <head>
    <title>Customers</title>
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
      header("location: login.php?redirposition=new_discount_card.php");
    }
    include_once("database_class.php");
    include_once("customer_DAO.php");
    $connection = new Database();
    $customer_DAO = new customer_DAO($connection);
    $result =  $customer_DAO->list_all_customer();?>
    <div class="container">
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
            $currentRow = $result->getNext(new customer_DAO($connection),$i);
        ?>
            <tr>
                <td scope="row"><?php echo $currentRow->customer_ID;?></td>
                <td><?php echo $currentRow->customer_name;?></td>
                <td><?php echo $currentRow->customer_phone;?></td>
                <td><a name="<?php echo $currentRow->customer_ID;?>" class="btn btn-primary" href="orders.php?cust_id=<?php echo $currentRow->customer_ID;?>&cust_name=<?php echo $currentRow->customer_name;?>" role="button">List semua order</a>
            </tr>
        <?php };?>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" btn-lg btn-block><a href="new_customer.php">Tambah customer baru</a></button>
        <button type="button" class="btn btn-secondary" btn-lg btn-block><a href="index.php">Kembali ke menu awal</a></button>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>