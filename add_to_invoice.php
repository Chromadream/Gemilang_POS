<!doctype html>
<html lang="en">
  <head>
    <title>Tambah item ke Invoice</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" rel="stylesheet">
    <script src="js/add_prod.js"></script>
  </head>
  <body>
    <?php
    session_start();
    if(!isset($_SESSION["level"]) || ($_SESSION["level"] != "B" && $_SESSION["level"] != "T"))
    {
      header("location: login.php?redirposition=invoice.php?mode=".$_GET["tid"]);
    }
    include_once("database_class.php");
    include_once("DAO/product_DAO.php");
    $connection = new Database();
    $product_DAO = new Product_DAO($connection->getConnection());
    $id = $_GET["tid"];
    if(!empty($_POST["search"]))
    {
        $product_List = $product_DAO->find_product_by_name($_POST["search"]);
    }
    else
    {
        $product_List = $product_DAO->list_all_product();
    }?>
    <div class="container">
        <h1>Tambah Produk ke Invoice</h1>
        <form action="add_to_invoice.php?tid=<?php echo $id;?>" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="search" id="searchBar" aria-describedby="helpId" placeholder="Cari produk">
            </div>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari produk</button> 
        </form>
        <form method="post" action="products.php">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga jual</th>
                    <th>Deskripsi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>        
        <?php
        for ($i = 0; $i<$product_List->rowCount();$i++)
        {
            $currentRow = $product_List->getNext(new Product_DAO($connection->getConnection()),$i);?>
            <tr>
              <td scope="row"><?php echo $currentRow->product_id; ?></td>
              <td><?php echo $currentRow->product_name; ?></td>
              <td><?php echo $currentRow->product_sale_price;?></td>
              <td><?php echo $currentRow->product_description;?></td>
              <td><button type="button" class="btn btn-dark" onclick="add_prod(<?php echo $currentRow->product_id;?>,<?php echo $id;?>,<?php echo $currentRow->product_sale_price;?>)"><i class="fas fa-check-square"></i></button></td>
            </tr>
        <?php } ?>
          </tbody>
        </table>
        </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>