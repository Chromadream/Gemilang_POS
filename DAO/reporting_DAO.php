<?php
include_once($_SERVER["DOCUMENT_ROOT"]."vendor/autoload.php");
class reporting_DAO
{
    private $_monthly_sum;
    private $_daily_sum;
    private $_yearly_sum;
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
        $prepared_query->bind_result($this->_monthly_sum);
        $prepared_query->fetch();
        return $this->_monthly_sum;
    }

    public function yearly_sum($year)
    {
        $query = "SELECT SUM(transact_total) FROM TRANSACT WHERE YEAR(transact_date) = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i',$year);
        $prepared_query->execute();
        $prepared_query->bind_result($this->_yearly_sum);
        $prepared_query->fetch();
        return $this->_yearly_sum;
    }

    public function daily_sum($day,$month,$year)
    {
        $query = "SELECT SUM(transact_total) FROM TRANSACT WHERE DAY(transact_date) = ? AND MONTH(transact_date) = ? AND YEAR(transact_date) = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('iii',$day,$month,$year);
        $prepared_query->execute();
        $prepared_query->bind_result($this->_daily_sum);
        $prepared_query->fetch();
        return $this->_daily_sum;
    }

    public function batch_daily_sum($end_date,$month,$year)
    {
        $results = array();
        for ($i=1; $i <= $end_date; $i++) { 
            $results[] = $this->daily_sum($i,$month,$year) ?: 0;
        }
        return json_encode($results);
    }
}
?>