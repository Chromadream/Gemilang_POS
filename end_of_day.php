<!doctype html>
<html lang="en">
  <head>
    <title>Tutup Transaksi Harian</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  </head>
  <body>
      <?php
      session_start();
      if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
      {
        header("location: login.php?redirposition=end_of_day.php");
      }
      if(empty($_POST["daily_transaction"]))
      {?>
        <div class="container">
            <h1>Input total eceran tanpa invoice</h1>
            <form action="end_of_day.php" method="post">
            <div class="form-group">
              <label for="daily_transaction">Total</label>
              <input type="text" class="form-control" name="daily_transaction">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></i>Tutup Transaksi Hari Ini!</button>
            </form>
        </div>  
      <?php }
      else
      {
        include_once("database_class.php");
        include_once("DAO/transaction_DAO.php");
        include_once("DAO/transaction_line_DAO.php");
        $connection = new Database();
        $transaction_DAO = new transaction_DAO($connection->getConnection());
        $line_DAO = new transaction_line_DAO($connection->getConnection());
        $id = $transaction_DAO->init_transaction();
        $value = $_POST["daily_transaction"];
        $transact = $line_DAO->add_new_item_to_line($id,30000001,$value);
        header("location: reporting.php");
      }?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>