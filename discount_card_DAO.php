<?php
class discount_card_DAO
{
    public $discount_id;
    public $discount_phone;
    private $_connection;

    function __construct($connection)
    {
        $this->_connection = $construct;
    }

    public function new_discount_card($phone)
    {
        $query = "INSERT INTO DISCOUNT_CARD (discount_phone) VALUES (?)";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('s',$phone);
        $prepared_query->execute();
        return mysqli_insert_id($this->_connection);
    }

    public function search_from_phone($phone)
    {
        $query = "SELECT discount_id FROM DISCOUNT_CARD WHERE DISCOUNT_PHONE = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('s',$phone);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows > 0)
        {
            return $result["discount_id"];
        }
        return NULL;
    }

    public function search_from_id($id)
    {
        $query = "SELECT discount_id FROM DISCOUNT_CARD WHERE discount_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i',$id);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows > 0)
        {
            return $id;
        }
        return NULL;
    }
}
?>