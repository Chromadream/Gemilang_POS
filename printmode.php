<!doctype html>
<html lang="en">
  <head>
    <title>Print invoice</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/printmode.css">
    <script src="js/printmode.js"></script>
  </head>
  <body onload="printmode()">
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
    include_once("DAO/transaction_DAO.php");
    include_once("DAO/transaction_line_DAO.php");
    include_once("func/terbilang.php");
    include_once("func/format_wrapper.php");
    $connection = new Database();
    $transact_DAO = new transaction_DAO($connection->getConnection());
    $transactitem_DAO = new transaction_line_DAO($connection->getConnection());
    $price_percentage = 1;
    $subtotal_price = 0;
    $transact_DAO->get_transaction_detail($_GET["id"]);
    $discount_presence = $transact_DAO->check_discount($_GET["id"]);
    if($discount_presence)
    {
        $price_percentage = 0.98;
    }
    $items = $transactitem_DAO->list_all_items_from_order($_GET["id"]);?>
    <div class="container-fluid">
        <img src="img/logo.jpg">
        <h4>Invoice</h4>
        <table class="table table-sm">
                <tbody>
                    <tr>
                        <td scope="row">Nomor Transaksi</td>
                        <td><?php echo $transact_DAO->transact_id;?></td>
                    </tr>
                    <tr>
                        <td scope="row">Tanggal</td>
                        <td><?php echo $transact_DAO->transact_date;?></td>
                    </tr>
                    <tr>
                        <td scope="row">Customer</td>
                        <td><?php echo $transact_DAO->customer_name;?> </td>
                    </tr>
                    <tr>
                        <td scope="row">Discount ID</td>
                        <td><?php echo $transact_DAO->discount_id;?></td>
                    </tr>
                </tbody>
        </table>
        <table class="table table-bordered table-sm">
            <thead class="thead-inverse">
                <tr>
                    <th>Qty</th>
                    <th>Nama</th>
                    <th>Harga satuan</th>
                    <th>Satuan</th>
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
                    <td><?php $current_price = (int)$current_item->product_sale_price;echo formatting($current_price);?></td>
                    <td><?php echo $current_item->product_stock_unit;?></td>
                    <td><?php $subtotal = $multiplier*$current_price;echo formatting($subtotal);$subtotal_price+=$subtotal;?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Subtotal (Rp)</td>
                    <td><?php echo formatting($subtotal_price);?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total akhir (Rp)</td>
                    <td><?php echo formatting($subtotal_price*$price_percentage);?></td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <tbody>
                <tr>
                    <td>Terbilang: </td>
                    <td><?php echo Terbilang($subtotal_price*$price_percentage)." Rupiah";?></td>
                    <td></td>
                </tr>
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