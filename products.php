<!doctype html>
<html lang="en">
  <head>
    <title>Products</title>
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
        header("location: login.php?redirposition=inventory.php");
      }
      include_once("database_class.php");
      include_once("DAO/product_DAO.php");
      $connection = new Database();
      $product_DAO = new Product_DAO($connection->getConnection());
      if(empty($_POST["check"]))
      {
        if(empty($_POST["search"]))
        {
            $product_List = $product_DAO->list_all_product();
        }
        else
        {
            $product_List = $product_DAO->find_product_by_name($_POST["search"]);
        }?>
        <div class="container">
        <h1>List Produk</h1>
        <a class="btn btn-primary" href="new_product.php" role="button"><i class="fas fa-plus"></i> Produk baru</a>
        <a name="home" id="home" class="btn btn-dark" href="index.php" role="button"><i class="fas fa-home"></i> Kembali ke menu awal</a>
        <br />
        <br />
        <form action="products.php" method="post">
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
                    <th>Modal</th>
                    <th>Harga jual</th>
                    <th>Stock tersedia</th>
                    <th>Satuan</th>
                    <th>Deskripsi</th>
                    <th>Edit?</th>
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
              <td><div class="form-group">
                <input type="text" class="form-control" name="<?php echo "purchase".$currentRow->product_id; ?>" value="<?php echo $currentRow->product_purchase_price;?>">
              </div></td>
              <td><div class="form-group">
                <input type="text" class="form-control" name="<?php echo "sale".$currentRow->product_id; ?>" value="<?php echo $currentRow->product_sale_price;?>">
              </div></td>
              <td><div class="form-group">
                <input type="text" class="form-control" name="<?php echo "stock".$currentRow->product_id; ?>" value="<?php echo $currentRow->product_stock_quantity;?>">
              </div></td>
              <td><?php echo $currentRow->product_stock_unit;?></td>
              <td><?php echo $currentRow->product_description;?></td>
              <td><div class="form-check">
                  <input type="checkbox" class="form-check-input" name="check[]" value="<?php echo $currentRow->product_id; ?>">
              </div></td>
            </tr>
        <?php } ?>
          </tbody>
        </table>
        <button type="submit" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Update stock produk</button> 
        </form>
        </div>   
    <?php }
    else
    {
        foreach($_POST["check"] as $id)
        {
            $product_DAO->update_product_prices($id,$_POST["purchase".$id],$_POST["sale".$id]);
            $product_DAO->update_product_stock($id,$_POST["stock".$id]);
            echo "Produk ".$id." telah terupdate dengan sukses<br/>";
        }?>
        <a name="home" id="home" class="btn btn-secondary" href="index.php" role="button"><i class="fas fa-home"></i> Kembali ke menu awal</a>
        
    <?php }?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>