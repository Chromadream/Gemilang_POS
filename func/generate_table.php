<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/database_class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/DAO/transaction_DAO.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/DAO/transaction_line_DAO.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/func/terbilang.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/func/format_wrapper.php");

function generate_table($id){
    $connection = new Database();
    $transact_DAO = new transaction_DAO($connection->getConnection());
    $transactitem_DAO = new transaction_line_DAO($connection->getConnection());
    $table = '';
    $price_percentage = 1;
    $subtotal_price = 0;
    $transact_DAO->get_transaction_detail($id);
    $discount_presence = $transact_DAO->check_discount($id);
    if($discount_presence)
    {
        $price_percentage = 0.98;
    }
    $items = $transactitem_DAO->list_all_items_from_order($id);
    $table.=<<<EOD
    <table>
        <tbody>
            <tr>
                <td scope="row">Nomor Transaksi</td>
                <td>$transact_DAO->transact_id</td>
            </tr>
            <tr>
                <td scope="row">Tanggal</td>
                <td>$transact_DAO->transact_date</td>
            </tr>
            <tr>
                <td scope="row">Customer</td>
                <td>$transact_DAO->customer_name</td>
            </tr>
EOD;
    if($transact_DAO->discount_id!=NULL){
        $table.= "<tr>
            <td scope='row'>Discount ID</td>
            <td><?php echo $transact_DAO->discount_id;?></td>
        </tr>
        ";
    }
    $table.="</tbody></table>";
    $table.=<<<EOD
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Harga satuan</th>
                <th>Harga akhir item</th>
            </tr>
        </thead>
        <tbody>
EOD;
    for($i=0;$i<$items->rowCount();$i++)
    {
        $current_item = $items->getNext(new transaction_line_DAO($connection->getConnection()),$i);
        $multiplier = (int)$current_item->transact_item_quantity;
        $current_price = (int)$current_item->transact_item_price;
        $current_price = formatting($current_price);
        $subtotal = (int)$multiplier*$current_price;$subtotal_price+=$subtotal;
        $formatted_sub = formatting($subtotal);
        $table .= <<<EOD
        <tr>
        <td>$current_item->product_name</td>
        <td>$multiplier</td>
        <td>$current_item->product_stock_unit</td>
        <td>$current_price</td>
        <td>$formatted_sub</td>
        </tr>
EOD;
    }
    $formatted_sub = formatting((int)$subtotal_price);
    $formatted_total = formatting((int)$subtotal_price*$price_percentage);
    $table .= <<<EOD
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Subtotal (Rp)</td>
                    <td>$formatted_sub</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total akhir (Rp)</td>
                    <td>$formatted_total</td>
                </tr>
            </tbody>
        </table>
EOD;
    $terbilang = Terbilang($subtotal_price*$price_percentage);
    $table .= <<<EOD
    <table class="table">
    <tbody>
        <tr>
            <td>Terbilang: </td>
            <td>$terbilang Rupiah</td>
            <td></td>
        </tr>
    </tbody>
</table>
EOD;
return $table;
}
?>