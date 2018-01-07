<!doctype html>
<html lang="en">
  <head>
    <title>Produk baru</title>
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
        if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
        {
          header("location: login.php?redirposition=new_customer.php");
        }
        if(!empty($_POST["product_name"]))
        {
           include_once("database_class.php");
            include_once("DAO/product_DAO.php");
            $connection = new Database();
            $productDAO = new product_DAO($connection->getConnection());
            $product_name = $_POST["product_name"];
            if(!empty($_POST["product_purchase_price"]))
            {
                $product_purchase_price = (int) $_POST["product_purchase_price"];
            }
            else
            {
                $product_purchase_price = 0;
            }
            $product_sale_price = (int) $_POST["product_sale_price"];
            if(!empty($_POST["product_stock_quantity"]))
            {
                $product_stock_quantity = (int) $_POST["product_stock_quantity"];
            }
            else
            {
                $product_stock_quantity = NULL;
            }
            $product_stock_unit = $_POST["product_stock_unit"];
            $new_id = $productDAO->add_new_product($product_name,$product_purchase_price,$product_sale_price,$product_stock_quantity,$product_stock_unit);
            echo "Produk sudah ditambahkan. ID: ".$new_id; 
            echo '<br/><a name="home" id="home" class="btn btn-primary" href="index.php" role="button"><i class="fa fa-home" aria-hidden="true"></i> Kembali ke menu awal</a>';
        }
        else
        {?>
            <div class="container">
              <h1>Produk Baru</h1>
              <form method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="product_name" aria-describedby="helpId" placeholder="Nama Produk Baru" required>
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="product_purchase_price" aria-describedby="helpId" placeholder="Modal Produk">
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="product_sale_price" aria-describedby="helpId" placeholder="Harga Jual Produk" required>
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="product_stock_quantity" aria-describedby="helpId" placeholder="Stock awal">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="product_stock_unit" aria-describedby="helpId" placeholder="Satuan produk" required>
              </div>
              <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Produk</button>
              </form>
            </div>
        <?php }?>      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>