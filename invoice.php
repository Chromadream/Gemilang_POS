<!doctype html>
<html lang="en">
  <head>
    <title>Invoice</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/update_customer.js"></script>
    <script src="js/change_quantity.js"></script>
    <script src="js/remove_prod.js"></script>
  </head>
  <body>
    <?php
    session_start();
    include_once("vendor/autoload.php");
    krumo::disable();
    if(!isset($_SESSION["level"]) || ($_SESSION["level"] != "B" && $_SESSION["level"] != "T"))
    {
      header("location: login.php?redirposition=invoice.php?mode=".$_GET["mode"]);
    }
    include_once("database_class.php");
    include_once("DAO/transaction_DAO.php");
    include_once("DAO/transaction_line_DAO.php");
    include_once("DAO/customer_DAO.php");
    include_once("func/selected.php");
    include_once("func/format_wrapper.php");
    //krumo::includes();
    $connection = new Database();
    //krumo($connection);
    $transaction_DAO = new transaction_DAO($connection->getConnection());
    krumo($transaction_DAO);
    $item_DAO = new transaction_line_DAO($connection->getConnection());
    krumo($item_DAO);
    $customer_DAO = new customer_DAO($connection->getConnection());
    krumo($customer_DAO);
    //krumo($_GET);
    if($_GET["mode"]=="new")
    {
        $transID = $transaction_DAO->init_transaction();
        krumo($transID);
        header("location: invoice.php?mode=".$transID);
    }   
    else
    {
        krumo::disable();
        $id = $_GET["mode"];
        krumo($id);
        $transaction_DAO->get_transaction_detail($id);
        krumo($transaction_DAO);
        $items = $item_DAO->list_all_items_from_order($id);
        krumo($items);
        $customer_id = $transaction_DAO->customer_id;
        krumo($customer_id);
        $customers = $customer_DAO->list_all_customer();
        krumo($customers);
        $price_percentage = 1;
        $subtotal_price = 0;
        $discount_presence = $transaction_DAO->check_discount($id);
        krumo($discount_presence);
        if($discount_presence)
        {
            $price_percentage = 0.98;
        }
        krumo($price_percentage);
    }
    ?>
    <div class="container"> 
        <h1>Invoice</h1>
        <table class="table">
                <tbody>
                    <tr>
                        <td scope="row">Nomor Transaksi</td>
                        <td><?php echo $transaction_DAO->transact_id;?></td>
                    </tr>
                    <tr>
                        <td scope="row">Tanggal</td>
                        <td><?php echo $transaction_DAO->transact_date;?></td>
                    </tr>
                    <tr>
                        <td scope="row">Customer</td>
                        <td><select name="customer" id="customer" onchange="update_customer(<?php echo $id;?>)">
                            <?php
                            for ($i=0; $i<$customers->rowCount(); $i++)
                            {
                                $current = $customers->getNext(new customer_DAO($connection->getConnection()),$i);
                                ?>
                                <option value="<?php echo $current->customer_id;?>" <?php echo selected($current->customer_id,$customer_id);?>>
                                    <?php echo $current->customer_name;?>
                                </option>
                            <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                        <td scope="row"><a href="use_discount_card.php?tid=<?php echo $id;?>">Discount ID</a></td>
                        <td><?php echo $transaction_DAO->discount_id;?></td>
                </tbody>
        </table>
        <a class="btn btn-primary" href="add_to_invoice.php?tid=<?php echo $id;?>" role="button"><i class="fa fa-plus" aria-hidden="true"></i> Tambah item ke invoice</a>
        <a name="printmode" id="printmode" class="btn btn-success" href="printmode.php?id=<?php echo $id;?>" role="button"><i class="fa fa-print" aria-hidden="true"></i> Print invoice</a>
        <table class="table table-striped">
            <thead class="thead-inverse">
                <tr>
                    <th>Qty</th>
                    <th>Nama</th>
                    <th></th>
                    <th>Harga satuan</th>
                    <th>Satuan</th>
                    <th>Harga akhir item</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for($i=0;$i<$items->rowCount();$i++)
                {
                    $current_item = $items->getNext(new transaction_line_DAO($connection->getConnection()),$i);
                    $multiplier = (int)$current_item->transact_item_quantity;?>
                    <tr>
                    <td scope="row"><div class="form-group">
                      <input type="number" class="form-control" id="<?php echo $current_item->product_id;?>" value="<?php echo $multiplier;?>" onchange="change_qty(<?php echo $current_item->product_id;?>,<?php echo $id;?>)">
                    </div></td>
                    <td><?php echo $current_item->product_name;?></td>
                    <td><button type="button" class="btn btn-link" onclick="remove_prod(<?php echo $id;?>,<?php echo $current_item->product_id;?>)"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                    <td><?php $current_price = (int)$current_item->product_sale_price;echo formatting($current_price);?></td>
                    <td><?php echo $current_item->product_stock_unit;?></td>
                    <td><?php $subtotal = $multiplier*$current_price;echo formatting($subtotal);$subtotal_price+=$subtotal;?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Subtotal</td>
                    <td><?php echo formatting($subtotal_price);?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total akhir</td>
                    <td><?php $total = $subtotal_price*$price_percentage;echo formatting($total);?></td>
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