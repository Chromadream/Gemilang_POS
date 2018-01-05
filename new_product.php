<!doctype html>
<html lang="en">
  <head>
    <title>Produk baru</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
    <?php
        if(!empty($_POST["product_name"]))
        {
           include_once("database_class.php");
            include_once("product_DAO.php");
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
        }
        else
        {?>
            <div class="container">
              <h1>Produk Baru</h1>
              <form method="post">
              <div class="form-group">
                <label for="product_name"></label>
                <input type="text" class="form-control" name="product_name" aria-describedby="helpId" placeholder="Nama Produk Baru" required>
                <small id="helpId" class="form-text text-muted">Nama produk baru</small>
              </div>
              <div class="form-group">
                <label for="product_purchase_price"></label>
                <input type="number" class="form-control" name="product_purchase_price" aria-describedby="helpId" placeholder="Modal Produk">
                <small id="helpId" class="form-text text-muted">Modal dasar produk</small>
              </div>
              <div class="form-group">
                <label for="product_sale_price"></label>
                <input type="number" class="form-control" name="product_sale_price" aria-describedby="helpId" placeholder="Harga Jual Produk" required>
                <small id="helpId" class="form-text text-muted">Harga jual produk</small>
              </div>
              <div class="form-group">
                <label for="product_stock_quantity"></label>
                <input type="number" class="form-control" name="product_stock_quantity" aria-describedby="helpId" placeholder="Stock awal">
                <small id="helpId" class="form-text text-muted">Stock yang tersedia di awal pengisian data</small>
              </div>
              <div class="form-group">
                <label for="product_stock_unit"></label>
                <input type="text" class="form-control" name="product_stock_unit" aria-describedby="helpId" placeholder="Satuan produk" required>
                <small id="helpId" class="form-text text-muted">Satuan stock produk</small>
              </div>
              <button type="submit" class="btn btn-primary">Tambah Produk</button>
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