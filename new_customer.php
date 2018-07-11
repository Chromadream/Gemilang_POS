<!doctype html>
<html lang="en">
  <head>
    <title>Customer baru</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" rel="stylesheet">
  </head>
  <body>
      <?php
      session_start();
      if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
      {
        header("location: login.php?redirposition=new_customer.php");
      }
      if(empty($_POST["customer_name"]))
      {?>
        <div class="container">
            <h1>Customer baru</h1>
            <form action="new_customer.php" method="post">
            <div class="form-group">
              <label for="customer_name">Nama customer</label>
              <input type="text" class="form-control" name="customer_name" required>
            </div>
            <div class="form-group">
              <label for="customer_phone">Nomor handphone customer</label>
              <input type="text" class="form-control" name="customer_phone">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></i> Tambah customer</button>
            </form>
        </div>  
      <?php }
      else
      {
        include_once("database_class.php");
        include_once("DAO/customer_DAO.php");
        $connection = new Database();
        $customer_DAO = new customer_DAO($connection->getConnection());
        $customer_name = $_POST["customer_name"];
        $customer_phone = $_POST["customer_phone"];
        $id = $customer_DAO->add_new_customer($customer_name,$customer_phone);
        echo "Customer telah berhasil ditambahkan. ID: ".$id;
        echo '<br/><a name="home" id="home" class="btn btn-primary" href="index.php" role="button"><i class="fas fa-home"></i> Kembali ke menu awal</a>';
      }?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>