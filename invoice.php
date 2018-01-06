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
  </head>
  <body>
    <?php
    session_start();
    include_once("vendor/autoload.php");
    krumo::disable();
    if(!isset($_SESSION["level"]) || ($_SESSION["level"] != "B" && $_SESSION["level"] != "T"))
    {
      header("location: login.php?redirposition=invoice.php");
    }
    include_once("database_class.php");
    include_once("transaction_DAO.php");
    include_once("transaction_line_DAO.php");
    include_once("customer_DAO.php");
    include_once("selected.php");
    krumo::includes();
    $connection = new Database();
    krumo($connection);
    $transaction_DAO = new transaction_DAO($connection->getConnection());
    krumo($transaction_DAO);
    $item_DAO = new transaction_line_DAO($connection->getConnection());
    krumo($item_DAO);
    $customer_DAO = new customer_DAO($connection->getConnection());
    krumo($customer_DAO);
    krumo($_GET);
    if($_GET["mode"]=="new")
    {
        $transID = $transaction_DAO->init_transaction();
        krumo($transID);
        header("location: invoice.php?mode=".$transID);
    }   
    else
    {
        krumo::enable();
        $id = $_GET["mode"];
        krumo($id);
        $trans = $transaction_DAO->get_transaction_detail($id);
        $details = $trans->getNext(new transaction_DAO($connection->getConnection()),0);
        krumo($details);
        $items = $item_DAO->list_all_items_from_order($id);
        krumo($items);
        $customer_id = $details->customer_id;
        $customers = $customer_DAO->list_all_customers();
        krumo($customers);
        $price_percentage = 1;
        $subtotal_price = 0;
        $discount_presence = $transact_DAO->check_discount($_GET["id"]);
        krumo($discount_presence);
        if($discount_presence)
        {
            $price_percentage = 0.98;
        }
    ?>
    <div class="container"> 
        <h1>Invoice</h1>
        <table class="table">
                <tbody>
                    <tr>
                        <td scope="row">Nomor Transaksi</td>
                        <td><?php $details->transact_id;?></td>
                    </tr>
                    <tr>
                        <td scope="row">Tanggal</td>
                        <td><?php $details->transact_date;?></td>
                    </tr>
                    <tr>
                        <td scope="row">Customer</td>
                        <td><select name="customer" onchange="update_customer(<?php echo $id;?>)">
                            <?php
                            for($i=0;$i<$customers->rowCount();$i++)
                            {
                                $current = $customers->getNext(new customer_DAO($connection->getConnection()),$i);?>
                                <option value="<?php $currentID = $current->$customer_id; echo $currentID;?>" <?php echo selected($currentID,$customer_id);?>>
                                    <?php echo $current->$customer_name;?>
                                </option>
                            <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                        <td scope="row">Discount ID</td>
                        <td><a href="use_discount_card.php?tid=<?php echo $id;?>"><?php $current->discount_id;?></a></td>
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
                    <th>Harga akhir item</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for($i=0;$i<$items->rowCount();$i++)
                {
                    $current_item = $items->getNext(new transaction_items_DAO($connection->getConnection()),$i);
                    $multiplier = (int)$current_item->transact_item_quantity;?>
                    <tr>
                    <td scope="row"><div class="form-group">
                      <input type="text" class="form-control" id="<?php echo $current_item->product_id;?>" value="<?php echo $multiplier;?>" onblur="change_qty(<?php echo $current_item->product_id;?>,<?php echo $id;?>)">
                    </div></td>
                    <td><?php echo $current_item->product_name;?></td>
                    <td><button type="button" class="btn btn-link" onclick="remove_prod(<?php echo $id;?>,<?php echo $current_item->product_id;?>)"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                    <td><?php $current_price = (int)$current_item->product_sale_price;echo $current_price;?></td>
                    <td><?php $subtotal = $multiplier*$current_price;echo $subtotal;$subtotal_price+=$subtotal;?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Subtotal</td>
                    <td><?php echo $subtotal_price;?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total akhir</td>
                    <td><?php $total = $subtotal_price*$price_percentage;echo $total;?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>

    <!-- Optional JavaScript -->
    <script src="update_customer.js"/>
    <script src="change_quantity.js"/>
    <script src="remove_prod.js"/>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>