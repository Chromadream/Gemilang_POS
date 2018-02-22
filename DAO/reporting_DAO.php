<?php
include_once($_SERVER["DOCUMENT_ROOT"]."vendor/autoload.php");
class reporting_DAO
{
    public $sum_at_given_time;
    private $_connection;

    function __construct($connection)
    {
        $this->_connection = $connection;
    }

    public function monthly_sum($month,$year)
    {
        $query = "SELECT SUM(transact_total) FROM TRANSACT WHERE MONTH(transact_date) = ? AND YEAR(transact_date) = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ii',$month,$year);
        $prepared_query->execute();
        $prepared_query->bind_result($this->sum_at_given_time);
        $prepared_query->fetch();
        return $this->sum_at_given_time;
    }

    public function yearly_sum($year)
    {
        $query = "SELECT SUM(transact_total) FROM TRANSACT WHERE YEAR(transact_date) = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i',$year);
        $prepared_query->execute();
        $prepared_query->bind_result($this->sum_at_given_time);
        $prepared_query->fetch();
        return $this->sum_at_given_time;
    }

    public function daily_sum($day,$month,$year)
    {
        $query = "SELECT SUM(transact_total) FROM TRANSACT WHERE DAY(transact_date) = ? AND MONTH(transact_date) = ? AND YEAR(transact_date) = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('iii',$day,$month,$year);
        $prepared_query->execute();
        $prepared_query->bind_result($this->sum_at_given_time);
        $prepared_query->fetch();
        echo($this->sum_at_given_time);
        return $this->sum_at_given_time;
    }
}
?>)